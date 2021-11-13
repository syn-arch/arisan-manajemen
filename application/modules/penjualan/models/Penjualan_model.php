<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class penjualan_model extends CI_Model {

	private function updateStatus($faktur_penjualan){

		$total = $this->db->get_where('penjualan', ['faktur_penjualan' => $faktur_penjualan])->row_array();

		$this->db->select_sum('nominal', 'total_pembayaran');
		$this->db->where('faktur_penjualan', $faktur_penjualan);
		$total_pembayaran = $this->db->get('pembayaran')->row_array()['total_pembayaran'];

		if ($total_pembayaran >= $total['total_bayar']) {
			if ($total['piutang'] != 1) {
				$this->db->set('piutang', 0);
			}
			$this->db->set('status', 'Lunas');
			$this->db->where('faktur_penjualan', $faktur_penjualan);
			$this->db->update('penjualan');
		}else{
			if ($total['status'] == 'Hold') {
				$this->db->set('piutang', 0);
			}else{
				$this->db->set('piutang', 1);
			}
			$this->db->set('status', 'Belum Lunas');
			$this->db->where('faktur_penjualan', $faktur_penjualan);
			$this->db->update('penjualan');
		}
	}


	public function get_hold($id = '')
	{
		if ($id == '') {
			$this->db->join('karyawan', 'id_karyawan', 'left');
			$this->db->join('pelanggan', 'id_pelanggan', 'left');
			$this->db->where('status', 'Hold');
			return $this->db->get('penjualan')->result_array();
		}	else{
			$this->db->where('faktur_penjualan', $id);
			return $this->db->get('penjualan')->row_array();
		}
	}

	public function get_pembayaran($id = '', $single = false)
	{
		if ($single == true) {
			return $this->db->get_where('pembayaran', ['id_pembayaran' => $id])->row_array();
		}

		if ($id == '') {
			return $this->db->get('pembayaran')->result_array();
		}else{
			return $this->db->get_where('pembayaran', ['faktur_penjualan' => $id])->result_array();
		}
	}

	public function tambah_pembayaran($post)
	{
		$id = 'PB-' . acak(10);

		$pembayaran = [
			'id_pembayaran' => $id,
			'faktur_penjualan' => $post['faktur_penjualan'],
			'dibayar_dengan' => $post['metode_pembayaran'],
			'nominal' => $post['nominal'],
			'no_debit' => $post['no_debit'],
			'no_kredit' => $post['no_kredit']
		];

		if ($_FILES['lampiran']['name']) {
			$pembayaran['lampiran'] = _upload('lampiran', 'penjualan/tambah_pembayaran/' . $post['faktur_penjualan'], 'penjualan');
		}

		$this->db->insert('pembayaran', $pembayaran);

		$this->updateStatus($post['faktur_penjualan']);
	}

	public function ubah_pembayaran($id, $post)
	{
		$pembayaran = [
			'faktur_penjualan' => $post['faktur_penjualan'],
			'dibayar_dengan' => $post['metode_pembayaran'],
			'nominal' => $post['nominal'],
			'no_debit' => $post['no_debit'],
			'no_kredit' => $post['no_kredit']
		];

		if ($_FILES['lampiran']['name']) {
			$gambar_lama = $this->db->get_where('pembayaran', ['id_pembayaran' => $id])->row_array()['lampiran'];
			$path = 'assets/img/penjualan/' . $gambar_lama;
			unlink(FCPATH . $path);
			$pembayaran['lampiran'] = _upload('lampiran', 'penjualan/ubah_pembayaran/' . $id . $post['faktur_penjualan'], 'penjualan');
		}

		$this->db->where('id_pembayaran', $id);
		$this->db->update('pembayaran', $pembayaran);

		$this->updateStatus($post['faktur_penjualan']);
	}

	public function hapus_pembayaran($id, $faktur_penjualan)
	{
		$gambar_lama = $this->db->get_where('pembayaran', ['id_pembayaran' => $id])->row_array()['lampiran'];
		$path = 'assets/img/penjualan/' . $gambar_lama;
		unlink(FCPATH . $path);
		$this->db->delete('pembayaran', ['id_pembayaran' => $id]);
		
		$this->updateStatus($faktur_penjualan);
	}

	public function proses($post, $hold = false)
	{

		$jumlah = str_replace('Rp. ', '', $post['jumlah_bayar']);
		$jumlah1 = str_replace('.', '', $jumlah);
		$jumlah2 = str_replace('.', '', $jumlah1);

		$this->db->trans_start();

		for ($i=0; $i < count($post['id_barang']); $i++) { 

			$this->db->select('*, ' . $post['type_golongan'][$i] . ' AS harga_jual');
			$brg = $this->db->get_where('barang', ['id_barang' => $post['id_barang'][$i]])->row_array();

			$diskon = ($brg['diskon'] / 100) * $brg['harga_jual'];
			$harga_brg = $brg['harga_jual'] - $diskon;

			$harga = $harga_brg;
			$total_harga = $harga * $post['jumlah'][$i];

			$id_outlet = $this->session->userdata('id_outlet');
			if (!$id_outlet) {
				$id_outlet = $this->db->get('outlet')->row_array()['id_outlet'];
			}

			$this->db->insert('detail_penjualan', [
				'faktur_penjualan' => $post['faktur_penjualan'],
				'id_barang' => $post['id_barang'][$i],
				'type_golongan' => $post['type_golongan'][$i],
				'jumlah' => $post['jumlah'][$i],
				'total_harga' => $total_harga
			]);

				// kurangi stok barang
			$stok_barang = $this->db->get_where('stok_outlet', ['id_outlet' => $id_outlet ,'id_barang' => $post['id_barang'][$i]])->row_array()['stok'];
			$stok_barang -= $post['jumlah'][$i];

			$this->db->set('stok', $stok_barang);
			$this->db->where('id_barang', $post['id_barang'][$i]);
			$this->db->where('id_outlet', $id_outlet);
			$this->db->update('stok_outlet');
		}

		$pengaturan = $this->db->get('pengaturan')->row_array();

		$tot = $jumlah2;

		if (str_replace('.', '', $post['cash']) >= $tot) {
			$status = 'Lunas';
			$piutang = 0;
		}else{
			$status = 'Belum Lunas';
			if ($hold == true) {
				$piutang = 0;
			}else{
				$piutang = 1;
			}
		}

		$periode = $this->db->get_where('agen', ['id_agen' => $post['id_agen']])->row()->periode_arisan;

		$angsuran = $tot / $periode;

		$dat =  [
			'faktur_penjualan' => $post['faktur_penjualan'],
			'id_outlet' => $id_outlet,
			'id_petugas' => $post['id_petugas'],
			'id_pelanggan' => $post['id_pelanggan'],
			'id_agen' => $post['id_agen'],
			'tgl_jatuh_tempo' => $post['tgl_jatuh_tempo'],
			'nama_pengiriman' => $post['nama_pengiriman'],
			'alamat_pengiriman' => $post['alamat_pengiriman'],
			'total_bayar' => $tot,
			'piutang' => $piutang,
			'diskon' => $post['diskon'],
			'keterangan' => $post['keterangan'],
			'angsuran' => $angsuran,
			'total_item' => str_replace(',', '.', $post['total_item']),
			'potongan' => str_replace('.', '' ,$post['potongan']),
			'status' => 'Belum Lunas'
		];

		$this->db->insert('penjualan', $dat);

		$this->db->trans_complete();
	}

	public function proses_update($post)
	{	
		$jumlah = str_replace('Rp. ', '', $post['jumlah_bayar']);
		$jumlah1 = str_replace('.', '', $jumlah);
		$jumlah2 = str_replace('.', '', $jumlah1);
		$jumlah2 = str_replace(',', '', $jumlah1);

		$this->db->trans_start();

		$this->db->select('*');
		$this->db->join('barang', 'id_barang');
		$this->db->where('faktur_penjualan', $post['faktur_penjualan']);
		$barang = $this->db->get('detail_penjualan')->result_array();

		$id_outlet = $post['id_outlet'];
		foreach ($barang as $row) {
			$stok_barang = $this->db->get_where('stok_outlet', ['id_outlet' => $id_outlet ,'id_barang' => $row['id_barang']])->row_array()['stok'];
			$stok_barang += $row['jumlah'];

			$this->db->set('stok', $stok_barang);
			$this->db->where('id_barang', $row['id_barang']);
			$this->db->where('id_outlet', $id_outlet);
			$this->db->update('stok_outlet');
		}

		$this->db->delete('detail_penjualan', ['faktur_penjualan' => $post['faktur_penjualan']]);

		for ($i=0; $i < count($post['id_barang']); $i++) { 

			$this->db->select('* ,'. $post['type_golongan'][$i] .' AS harga_jual');
			$brg = $this->db->get_where('barang', ['id_barang' => $post['id_barang'][$i]])->row_array();

			$diskon = ($brg['diskon'] / 100) * $brg['harga_jual'];
			$harga_brg = $brg['harga_jual'] - $diskon;

			$harga = $harga_brg;

			$total_harga = $harga * $post['jumlah'][$i];

			$id_outlet = $post['id_outlet'];

			$det = $this->db->get_where('detail_penjualan', ['faktur_penjualan' => $post['faktur_penjualan'], 'id_barang' => $post['id_barang'][$i]])->row_array();

			if ($det) {
					// update detail
				$this->db->set('jumlah',$post['jumlah'][$i]);
				$this->db->set('total_harga',$total_harga);
				$this->db->where('id_barang',$post['id_barang'][$i]);
				$this->db->where('faktur_penjualan', $post['faktur_penjualan']);
				$this->db->update('detail_penjualan');
			}else{
					// tambah detail
				$this->db->insert('detail_penjualan', [
					'faktur_penjualan' => $post['faktur_penjualan'],
					'id_barang' => $post['id_barang'][$i],
					'id_barang' => $post['id_barang'][$i],
					'type_golongan' => $post['type_golongan'][$i],
					'jumlah' => $post['jumlah'][$i],
					'total_harga' => $total_harga
				]);
			}

			// hapus detail
			$cek_detail = $this->db->get_where('detail_penjualan', ['faktur_penjualan' => $post['faktur_penjualan']])->result_array();

			foreach ($cek_detail as $row) {
				if (!in_array($row['id_barang'], $post['id_barang'])) {
					$this->db->where('id_barang',$row['id_barang']);
					$this->db->where('faktur_penjualan', $post['faktur_penjualan']);
					$this->db->delete('detail_penjualan');
				}
			}

			// kurangi stok barang
			$stok_barang = $this->db->get_where('stok_outlet', ['id_outlet' => $id_outlet ,'id_barang' => $post['id_barang'][$i]])->row_array()['stok'];
			$stok_barang -= $post['jumlah'][$i];

			$this->db->set('stok', $stok_barang);
			$this->db->where('id_barang', $post['id_barang'][$i]);
			$this->db->where('id_outlet', $id_outlet);
			$this->db->update('stok_outlet');
		}

		$pengaturan = $this->db->get('pengaturan')->row_array();
		
		$tot = $jumlah2;

		$periode = $this->db->get_where('agen', ['id_agen' => $post['id_agen']])->row()->periode_arisan;

		$angsuran = $tot / $periode;

		$data_penjualan = [
			'id_outlet' => $id_outlet,
			'id_petugas' => $post['id_petugas'],
			'id_pelanggan' => $post['id_pelanggan'],
			'id_agen' => $post['id_agen'],
			'tgl_jatuh_tempo' => $post['tgl_jatuh_tempo'],
			'nama_pengiriman' => $post['nama_pengiriman'],
			'alamat_pengiriman' => $post['alamat_pengiriman'],
			'total_item' => str_replace(',', '.', $post['total_item']),
			'total_bayar' => $tot,
			'angsuran' => $angsuran,
			'keterangan' => $post['keterangan'],
			'diskon' => $post['diskon'],
			'potongan' => $post['potongan'],
		];

		$this->db->where('faktur_penjualan', $post['faktur_penjualan']);
		$this->db->update('penjualan', $data_penjualan);

		$this->updateStatus($post['faktur_penjualan']);

		$this->db->trans_complete();
	}

	public function get_penjualan($id = '')
	{
		if ($id == '') {
			$this->db->order_by('faktur_penjualan', 'desc');
			$this->db->join('petugas', 'id_petugas', 'left');
			$this->db->join('pelanggan', 'id_pelanggan', 'left');
			$this->db->join('agen', 'id_agen', 'left');
			return $this->db->get('penjualan')->result_array();	
		}else{	
			$this->db->select('*, penjualan.id_outlet,pelanggan.alamat,penjualan.tgl, penjualan.keterangan');
			$this->db->join('petugas', 'id_petugas', 'left');
			$this->db->join('pelanggan', 'id_pelanggan', 'left');
			$this->db->join('agen', 'id_agen', 'left');
			return $this->db->get_where('penjualan', ['faktur_penjualan' => $id])->row_array();
		}
	}

	public function get_penjualan_by_pelanggan($id = '')
	{
		return $this->db->get_where('penjualan', ['id_pelanggan' => $id, 'status' => 'Belum Lunas'])->row_array();
	}

	public function get_limit_pelanggan($id = '')
	{
		return $this->db->get_where('penjualan', ['id_pelanggan' => $id, 'status' => 'Belum Lunas'])->num_rows();
	}

	public function get_detail_penjualan($id)
	{
		$this->db->select('*');
		$this->db->join('barang', 'id_barang');
		$this->db->where('faktur_penjualan', $id);
		return $this->db->get('detail_penjualan')->result_array();
	}

	public function get_penjualan_by_outlet($id_outlet)
	{
		$this->db->order_by('faktur_penjualan', 'desc');
		$this->db->join('petugas', 'id_petugas', 'left');
		$this->db->join('pelanggan', 'id_pelanggan', 'left');
		$this->db->where('penjualan.id_outlet', $id_outlet);
		return $this->db->get('penjualan')->result_array();	
	}

	public function set_register($post)
	{
		$petugas = $this->session->userdata('id_outlet');

		if ($petugas) {
			$id_outlet = $petugas;
		}else{
			$id_outlet = $this->db->get('outlet')->row()->id_outlet;
		}

		$data = [
			'id_petugas' => $this->session->userdata('id_petugas'),
			'id_outlet' => $id_outlet,
			'uang_awal' => $post['uang_awal'],
			'status' => 'open '
		];

		$this->db->insert('register', $data);
	}

	public function close_register()
	{
		$this->db->where('status', 'open');
		$this->db->where('id_petugas', $this->session->userdata('id_petugas'));
		$register =  $this->db->get('register')->row_array();

		$id_petugas = $this->session->userdata('id_petugas');

		$this->db->select_sum('total_bayar', 'total');
		$this->db->where('piutang', 0);
		$this->db->where('status !=', 'Hold');
		$this->db->where('DATE(penjualan.tgl)', date('Y-m-d'));
		$penjualan = $this->db->get('penjualan')->row_array()['total'];

		$this->db->select_sum('nominal', 'total');
		$this->db->where('DATE(pembayaran.tgl)', date('Y-m-d'));
		$this->db->where('piutang', 1);
		$this->db->join('penjualan', 'faktur_penjualan');
		$this->db->where('status !=', 'Hold');
		$piutang = $this->db->get('pembayaran')->row_array()['total'];

		$this->db->select_sum('total_bayar', 'total');
		$pemasukan = $this->db->get_where('biaya', ['DATE(tgl)' => date('Y-m-d'), 'status' => 'PEMASUKAN'])->row()->total;

		$this->db->select_sum('total_bayar', 'total');
		$pengeluaran = $this->db->get_where('biaya', ['DATE(tgl)' => date('Y-m-d'), 'status' => 'PENGELUARAN'])->row()->total;

		$q1 = "SELECT SUM(total_uang) AS 'total' FROM `register` WHERE DATE(mulai) = DATE(NOW()) AND status = 'close' AND id_petugas = '$id_petugas' ";
		$total_uang = $this->db->query($q1)->row()->total ?? 0;

		$q2 = "SELECT SUM(uang_awal) AS 'uang_awal' FROM `register` WHERE DATE(mulai) = DATE(NOW()) AND status = 'close' AND id_petugas = '$id_petugas' ";
		$uang_awal = $this->db->query($q2)->row()->uang_awal ?? 0;

		$total_tarik = $total_uang - $uang_awal;

		$total_uang = $register['uang_awal'] + ($penjualan - $total_tarik) + $piutang + $pemasukan - $pengeluaran;

		$data = [
			'status' => 'close',
			'berakhir' => date('Y-m-d H:i:s'),
			'total_uang' => $total_uang,
			'penjualan' => $penjualan,
			'pemasukan' => $pemasukan,
			'pengeluaran' => $pengeluaran,
			'piutang' => $piutang
		];

		$this->db->where('status', 'open');
		$this->db->where('id_petugas', $this->session->userdata('id_petugas'));
		$this->db->update('register', $data);
	}

	public function get_total_belanja($id)
	{
		// 			$this->db->join('pelanggan', 'id_pelanggan');
		// 			$this->db->where('faktur_penjualan', $id);
		// $jenis = $this->db->get('penjualan')->row_array()['jenis'];

		// if ($jenis = "member") {
		// 	$query = " SELECT SUM(harga_jual) AS total_belanja
		// 	FROM(
		// 	SELECT 
		// 	(`barang`.`harga_jual` - `barang`.`potongan_member`) * `detail_penjualan`.`jumlah` AS 'harga_jual'
		// 	FROM detail_penjualan 
		// 	JOIN penjualan USING(faktur_penjualan) 
		// 	JOIN barang USING(id_barang) 
		// 	WHERE faktur_penjualan = '$id'
		// 	) t
		// 	";
		// }else{
		// 	$query = " SELECT SUM(harga_jual) AS total_belanja
		// FROM(
		// SELECT 
		// `barang`.`harga_jual` * `detail_penjualan`.`jumlah` AS 'harga_jual'
		// FROM detail_penjualan 
		// JOIN penjualan USING(faktur_penjualan) 
		// JOIN barang USING(id_barang) 
		// WHERE faktur_penjualan = '$id'
		// ) t
		// ";
		// }

		$query = "SELECT SUM(total_harga) AS total_belanja FROM detail_penjualan WHERE faktur_penjualan = '$id' ";

		return $this->db->query($query)->row_array()['total_belanja'];
	}

	public function get_total_bayar($id)
	{
		$this->db->select_sum('nominal', 'total_bayar');
		$this->db->join('pembayaran', 'faktur_penjualan');
		$this->db->where('faktur_penjualan', $id);
		return $this->db->get('penjualan')->row()->total_bayar;
	}

}

/* End of file penjualan_model.php */
/* Location: ./application/modules/penjualan/models/penjualan_model.php */ ?>
