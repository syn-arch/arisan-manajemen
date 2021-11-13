<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class stok_model extends CI_Model {

	public function get_stok_json()
	{
		$this->datatables->select('id_stok, nama_petugas,tgl,keterangan, b1.nama_outlet As dari, b2.nama_outlet AS ke ');
		$this->datatables->from('stok a');
		$this->datatables->join('petugas', 'id_petugas');
		$this->datatables->join('outlet b1', 'a.dari=b1.id_outlet', 'left');
		$this->datatables->join('outlet b2', 'a.ke=b2.id_outlet', 'left');
		return $this->datatables->generate();
	}

	public function get_aset_persediaan()
	{
		$this->db->select('*, stok_outlet.stok');
		$this->db->join('stok_outlet', 'id_barang');
		return $this->db->get('barang')->result_array();
	}

	public function get_total_aset()
	{
		$this->db->select('SUM(stok_outlet.stok * barang.harga_pokok) as total');
		$this->db->join('stok_outlet', 'id_barang');
		return $this->db->get('barang')->row()->total;
	}

	public function get_stok_barang_outlet($id_stok_outlet)
	{
		return $this->db->get_where('stok_outlet', ['id_stok_outlet' => $id_stok_outlet])->row_array();
	}

	public function get_stok_barang($id_outlet)
	{
		$this->db->select('id_barang,nama_barang,stok_outlet.stok,id_outlet,nama_outlet');
		$this->db->join('barang', 'id_barang');
		$this->db->join('outlet', 'id_outlet');
		$this->db->where('stok_outlet.id_outlet', $id_outlet);
		return $this->db->get('stok_outlet')->result_array();
	}

	public function update_stok_barang($id_stok_outlet,$post)
	{
		$this->db->set('stok', $post['stok']);
		$this->db->where('id_stok_outlet', $id_stok_outlet);
		$this->db->update('stok_outlet');
	}

	public function get_stok($id = '')
	{
		if ($id == '') {
			$this->db->join('petugas', 'id_petugas');
			return $this->db->get('stok')->result_array();
		}else {
			$this->db->select('*,dari.nama_outlet as dari,ke.nama_outlet as ke');
			$this->db->join('petugas', 'id_petugas');
			$this->db->join('outlet dari', 'stok.dari = dari.id_outlet', 'left');
			$this->db->join('outlet ke', 'ke.id_outlet = stok.ke');
			$this->db->where('id_stok', $id);
			return $this->db->get('stok')->row_array();
		}
	}

	public function get_detail_stok($id_stok)
	{
		$this->db->join('detail_stok', 'id_stok');
		$this->db->join('barang', 'detail_stok.id_barang = barang.id_barang');
		$this->db->join('petugas', 'id_petugas');
		$this->db->where('id_stok', $id_stok);
		return $this->db->get('stok')->result_array();
	}

	public function delete($id)
	{
		$this->db->join('stok', 'id_stok');
		$barang = $this->db->get_where('detail_stok', ['id_stok' => $id])->result_array();

		$stok = $this->db->get_where('stok', ['id_stok' => $id])->row_array();

		foreach ($barang as $row) {

			$multi_outlet = $this->db->get('pengaturan')->row()->multi_outlet;

			if ($multi_outlet == 1) {
				if ($stok['dari'] == 'Gudang') {
					$stok_barang = $this->db->get_where('barang', ['id_barang' => $row['id_barang']])->row_array()['stok'];
					$stok_barang += $row['jumlah'];

					$this->db->set('stok', $stok_barang);
					$this->db->where('id_barang', $row['id_barang']);
					$this->db->update('barang');	
				}else{
					$stok_barang = $this->db->get_where('stok_outlet', ['id_barang' => $row['id_barang'], 'id_outlet' => $stok['dari']])->row_array()['stok'];
					$stok_barang += $row['jumlah'];

					$this->db->set('stok', $stok_barang);
					$this->db->where('id_barang', $row['id_barang']);
					$this->db->where('id_outlet', $stok['dari']);
					$this->db->update('stok_outlet');
				}
			}

			$stok_outlet_barang = $this->db->get_where('stok_outlet', ['id_barang' => $row['id_barang'],'id_outlet' => $row['ke']])->row_array()['stok'];
			$stok_outlet_barang -= $row['jumlah'];

			$this->db->set('stok', $stok_outlet_barang);
			$this->db->where('id_barang', $row['id_barang']);
			$this->db->where('id_outlet', $row['ke']);
			$this->db->update('stok_outlet');
		}

		$this->db->delete('stok', ['id_stok' => $id]);
		$this->db->delete('detail_stok', ['id_stok' => $id]);
	}

	public function insert($post)
	{
		$this->db->trans_start();
		for ($i=0; $i < count($post['id_barang']); $i++) { 
			if ($post['jumlah'][$i] != '') {
				$data_detail = [
					'id_stok' => $post['id_stok'],
					'id_barang' => $post['id_barang'][$i],
					'jumlah' => $post['jumlah'][$i]
				];
				$this->db->insert('detail_stok', $data_detail);

				$multi_outlet = $this->db->get('pengaturan')->row()->multi_outlet;

				if ($multi_outlet == 1) {
				// kurangi tabel barang

					if ($post['dari'] == 'Gudang') {
						$stok_barang = $this->db->get_where('barang', ['id_barang' => $post['id_barang'][$i]])->row_array()['stok'];
						$stok_barang -= $post['jumlah'][$i];

						$this->db->set('stok', $stok_barang);
						$this->db->where('id_barang', $post['id_barang'][$i]);
						$this->db->update('barang');
					}else{
						$stok_barang = $this->db->get_where('stok_outlet', ['id_barang' => $post['id_barang'][$i], 'id_outlet' => $post['dari']])->row_array()['stok'];
						$stok_barang -= $post['jumlah'][$i];

						$this->db->set('stok', $stok_barang);
						$this->db->where('id_barang', $post['id_barang'][$i]);
						$this->db->where('id_outlet', $post['dari']);
						$this->db->update('stok_outlet');
					}
				}

				// tambah tabel stok outlet
				$this->db->where('id_barang', $post['id_barang'][$i]);
				$this->db->where('id_outlet', $post['ke']);
				$stok_baru = $this->db->get('stok_outlet')->row_array()['stok'];
				$stok_baru += $post['jumlah'][$i];

				$this->db->set('stok', $stok_baru);
				$this->db->where('id_barang', $post['id_barang'][$i]);
				$this->db->where('id_outlet', $post['ke']);
				$this->db->update('stok_outlet');
			}
		}

		$data = [
			'id_stok' => $post['id_stok'],
			'id_petugas' => $post['id_petugas'],
			'dari' => $post['dari'],
			'ke' => $post['ke'],
			'keterangan' => $post['keterangan']
		];

		$this->db->insert('stok', $data);

		$this->db->trans_complete();
	}

	public function update($post)
	{

		$this->db->trans_start();

		$this->db->join('stok', 'id_stok');
		$barang = $this->db->get_where('detail_stok', ['id_stok' => $post['id_stok']])->result_array();

		foreach ($barang as $row) {

			$multi_outlet = $this->db->get('pengaturan')->row()->multi_outlet;

			if ($multi_outlet == 1) {
				if ($post['dari'] == 'Gudang') {
					$stok_barang = $this->db->get_where('barang', ['id_barang' => $row['id_barang']])->row_array()['stok'];
					$stok_barang += $row['jumlah'];

					$this->db->set('stok', $stok_barang);
					$this->db->where('id_barang', $row['id_barang']);
					$this->db->update('barang');
				}else{
					$stok_barang = $this->db->get_where('stok_outlet', ['id_barang' => $row['id_barang'], 'id_outlet' => $post['dari']])->row_array()['stok'];
					$stok_barang += $row['jumlah'];

					$this->db->set('stok', $stok_barang);
					$this->db->where('id_barang', $row['id_barang']);
					$this->db->where('id_outlet', $post['dari']);
					$this->db->update('stok_outlet');
				}
			}

			$stok_outlet_barang = $this->db->get_where('stok_outlet', ['id_barang' => $row['id_barang'],'id_outlet' => $row['ke']])->row_array()['stok'];
			$stok_outlet_barang -= $row['jumlah'];

			$this->db->set('stok', $stok_outlet_barang);
			$this->db->where('id_barang', $row['id_barang']);
			$this->db->where('id_outlet', $row['ke']);
			$this->db->update('stok_outlet');
		}

		for ($i=0; $i < count($post['id_barang']); $i++) { 

			if ($post['jumlah'][$i] != '') {
				$det = $this->db->get_where('detail_stok', ['id_stok' => $post['id_stok'], 'id_barang' => $post['id_barang'][$i]])->row_array();

				if ($det) {
					// update detail
					$this->db->set('jumlah',$post['jumlah'][$i]);
					$this->db->where('id_barang',$post['id_barang'][$i]);
					$this->db->where('id_stok', $post['id_stok']);
					$this->db->update('detail_stok');
				}else{
					// tambah detail
					$data_detail = [
						'id_stok' => $post['id_stok'],
						'id_barang' => $post['id_barang'][$i],
						'jumlah' => $post['jumlah'][$i]
					];
					$this->db->insert('detail_stok', $data_detail);
				}

				$multi_outlet = $this->db->get('pengaturan')->row()->multi_outlet;

				if ($multi_outlet == 1) {
					if ($post['dari'] == 'Gudang') {
						$stok_barang = $this->db->get_where('barang', ['id_barang' => $post['id_barang'][$i]])->row_array()['stok'];
						$stok_barang -= $post['jumlah'][$i];

						$this->db->set('stok', $stok_barang);
						$this->db->where('id_barang', $post['id_barang'][$i]);
						$this->db->update('barang');
					}else{
						$stok_barang = $this->db->get_where('stok_outlet', ['id_barang' => $post['id_barang'][$i], 'id_outlet' => $post['dari']])->row_array()['stok'];
						$stok_barang -= $post['jumlah'][$i];

						$this->db->set('stok', $stok_barang);
						$this->db->where('id_barang', $post['id_barang'][$i]);
						$this->db->where('id_outlet', $post['dari']);
						$this->db->update('stok_outlet');
					}
				}

				// tambah tabel stok outlet
				$this->db->where('id_barang', $post['id_barang'][$i]);
				$this->db->where('id_outlet', $post['ke']);
				$stok_baru = $this->db->get('stok_outlet')->row_array()['stok'];
				$stok_baru += $post['jumlah'][$i];

				$this->db->set('stok', $stok_baru);
				$this->db->where('id_barang', $post['id_barang'][$i]);
				$this->db->where('id_outlet', $post['ke']);
				$this->db->update('stok_outlet');
			}
		}

		// hapus detail
		$cek_detail = $this->db->get_where('detail_stok', ['id_stok' => $post['id_stok']])->result_array();

		$num = 0;
		foreach ($cek_detail as $row) {
			if (!in_array($row['id_barang'], $post['id_barang'])) {
				$this->db->where('id_barang',$row['id_barang']);
				$this->db->where('id_stok', $post['id_stok']);
				$this->db->delete('detail_stok');
			}
		}

		$data = [
			'id_petugas' => $post['id_petugas'],
			'dari' => $post['dari'],
			'ke' => $post['ke'],
			'tgl' => $post['tgl'],
			'keterangan' => $post['keterangan']
		];

		$this->db->where('id_stok', $post['id_stok']);
		$this->db->update('stok', $data);

		$this->db->trans_complete();
	}

}

/* End of file stok_model.php */
/* Location: ./application/modules/stok/models/stok_model.php */ ?>
