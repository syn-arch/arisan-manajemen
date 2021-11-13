<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class barang_model extends CI_Model {

	public function get_barang_json()
	{
		$petugas = $this->session->userdata('id_outlet');

		if ($petugas) {
			$id_outlet = $petugas;
		}else{
			$id_outlet = $this->db->get('outlet')->row()->id_outlet;
		}

		$this->datatables->select('id_barang, barcode,nama_barang, diskon, harga_pokok, nama_kategori, nama_supplier,golongan_1, satuan,barang.stok AS stok,diskon, stok_outlet.stok AS stok_q');
		$this->datatables->from('stok_outlet');
		$this->datatables->join('barang', 'id_barang');
		$this->datatables->join('kategori', 'barang.id_kategori=kategori.id_kategori', 'left');
		$this->datatables->join('supplier', 'barang.id_supplier=supplier.id_supplier', 'left');
		$this->datatables->where('id_outlet', $id_outlet);
		return $this->datatables->generate();
	}

	public function get_harga_barang_json()
	{
		$petugas = $this->session->userdata('id_outlet');

		if ($petugas) {
			$id_outlet = $petugas;
		}else{
			$id_outlet = $this->db->get('outlet')->row()->id_outlet;
		}

		$this->datatables->select('id_barang, barcode,nama_barang, diskon, harga_pokok , nama_kategori,golongan_1,golongan_2,golongan_3,golongan_4, nama_supplier, satuan, diskon, stok_outlet.stok AS stok_q');
		$this->datatables->from('stok_outlet');
		$this->datatables->join('barang', 'id_barang', 'left');
		$this->datatables->join('kategori', 'barang.id_kategori=kategori.id_kategori', 'left');
		$this->datatables->join('supplier', 'barang.id_supplier=supplier.id_supplier', 'left');
		$this->datatables->where('id_outlet', $id_outlet);
		return $this->datatables->generate();
	}

	public function get_barang_by_outlet_json($id_outlet)
	{
		$this->datatables->select('id_stok_outlet,id_barang, barcode, nama_barang, stok_outlet.stok AS stok_outlet');
		$this->datatables->from('stok_outlet');
		$this->datatables->join('outlet', 'id_outlet');
		$this->datatables->join('barang', 'id_barang');
		$this->datatables->where('id_outlet', $id_outlet);
		return $this->datatables->generate();
	}

	public function get_barang($id = '', $golongan= 'golongan_1')
	{
		if ($id == '') {
			$this->db->select('* ,'. $golongan .' AS harga_jual, barang.stok AS stok, stok_outlet.stok AS stok_outlet');
			$this->db->join('kategori', 'id_kategori', 'left');
            $this->db->join('supplier', 'id_supplier', 'left');
            $this->db->join('stok_outlet', 'id_barang');
			return $this->db->get('barang')->result_array();
		}else {
			if ($golongan != '') {
				$this->db->select('* ,'. $golongan .' AS harga_jual');
			}
			$this->db->join('kategori', 'id_kategori', 'left');
			$this->db->join('supplier', 'id_supplier', 'left');
			$this->db->where('id_barang', $id);
			$this->db->or_where('barcode', $id);
			return $this->db->get('barang')->row_array();
		}
	}

	public function delete($id)
	{
		$brg = $this->db->get_where('barang', ['id_barang' => $id])->row_array();

		if ($brg['gambar'] != '') {
			delImage('barang', $id);	
		}
		
		$this->db->delete('barang', ['id_barang' => $id]);
		$this->db->delete('stok_outlet', ['id_barang' => $id]);
	}

	public function insert($post)
	{   
		if ($post['golongan_1'] < $post['harga_pokok']) {
			$this->session->set_flashdata('error', 'golongan 1 kurang dari harga pokok');
			redirect('master/barang','refresh');
		}

		if ($post['golongan_2'] < $post['harga_pokok'] && $post['golongan_2'] != 0) {
			$this->session->set_flashdata('error', 'golongan 2 kurang dari harga pokok');
			redirect('master/barang','refresh');
		}

		if ($post['golongan_3'] < $post['harga_pokok'] && $post['golongan_3'] != 0) {
			$this->session->set_flashdata('error', 'golongan 3 kurang dari harga pokok');
			redirect('master/barang','refresh');
		}

		if ($post['golongan_4'] < $post['harga_pokok'] && $post['golongan_4'] != 0) {
			$this->session->set_flashdata('error', 'golongan 4 kurang dari harga pokok');
			redirect('master/barang','refresh');
		}

		$data = [
			'id_barang' => htmlspecialchars($post['id_barang']),
			'nama_barang' => htmlspecialchars($post['nama_barang']),
			'id_kategori' => htmlspecialchars($post['id_kategori']),
			'id_supplier' => htmlspecialchars($post['id_supplier']),
			'satuan' => htmlspecialchars($post['satuan']),
			'barcode' => htmlspecialchars($post['barcode']),
			'harga_pokok' => htmlspecialchars($post['harga_pokok']),
			'golongan_1' => htmlspecialchars($post['golongan_1']),
			'golongan_2' => htmlspecialchars($post['golongan_2']),
			'golongan_3' => htmlspecialchars($post['golongan_3']),
			'golongan_4' => htmlspecialchars($post['golongan_4']),
			'diskon' => htmlspecialchars($post['diskon']),
			'nama_pendek' => htmlspecialchars($post['nama_pendek']),
			'profit_1' => htmlspecialchars($post['profit_1']),
			'profit_2' => htmlspecialchars($post['profit_2']),
			'profit_3' => htmlspecialchars($post['profit_3']),
			'profit_4' => htmlspecialchars($post['profit_4'])
		];

		$multi_outlet = $this->db->get('pengaturan')->row()->multi_outlet;
		$outlet = $this->db->get('outlet')->result_array();

		if ($multi_outlet == 0) {

			$petugas = $this->session->userdata('id_outlet');

			if ($petugas) {
				$id_outlet = $petugas;
			}else{
				$id_outlet = $this->db->get('outlet')->row()->id_outlet;
			}

			$data_stok_outlet = [
				'id_outlet' => $id_outlet,
				'id_barang' => $post['id_barang'],
				'stok' => $post['stok']
			];

			$this->db->insert('stok_outlet', $data_stok_outlet);			

			$data['stok'] = 0;
		}else{

			foreach ($outlet as $row) {
				$data_stok_outlet = [
					'id_outlet' => $row['id_outlet'],
					'id_barang' => $post['id_barang'],
					'stok' => 0
				];

				$this->db->insert('stok_outlet', $data_stok_outlet);	
			}		

			$data['stok'] = $post['stok'];
		}

		if ($_FILES['gambar']['name']) {
			$data['gambar'] = _upload('gambar', 'master/tambah_barang', 'barang');
		}

		$this->db->insert('barang', $data);
	}

	public function update($id, $post)
	{
		if ($post['golongan_1'] < $post['harga_pokok']) {
			$this->session->set_flashdata('error', 'golongan 1 kurang dari harga pokok');
			redirect('master/barang','refresh');
		}

		if ($post['golongan_2'] < $post['harga_pokok'] && $post['golongan_2'] != 0) {
			$this->session->set_flashdata('error', 'golongan 2 kurang dari harga pokok');
			redirect('master/barang','refresh');
		}

		if ($post['golongan_3'] < $post['harga_pokok'] && $post['golongan_3'] != 0) {
			$this->session->set_flashdata('error', 'golongan 3 kurang dari harga pokok');
			redirect('master/barang','refresh');
		}

		if ($post['golongan_4'] < $post['harga_pokok'] && $post['golongan_4'] != 0) {
			$this->session->set_flashdata('error', 'golongan 4 kurang dari harga pokok');
			redirect('master/barang','refresh');
		}

		$data = [
			'nama_barang' => htmlspecialchars($post['nama_barang']),
			'id_kategori' => htmlspecialchars($post['id_kategori']),
			'id_supplier' => htmlspecialchars($post['id_supplier']),
			'satuan' => htmlspecialchars($post['satuan']),
			'diskon' => htmlspecialchars($post['diskon']),
			'barcode' => htmlspecialchars($post['barcode']),
			'harga_pokok' => htmlspecialchars($post['harga_pokok']),
			'golongan_1' => htmlspecialchars($post['golongan_1']),
			'golongan_2' => htmlspecialchars($post['golongan_2']),
			'golongan_3' => htmlspecialchars($post['golongan_3']),
			'golongan_4' => htmlspecialchars($post['golongan_4']),
			'diskon' => htmlspecialchars($post['diskon']),
			'stok' => htmlspecialchars($post['stok']),
			'nama_pendek' => htmlspecialchars($post['nama_pendek']),
			'profit_1' => htmlspecialchars($post['profit_1']),
			'profit_2' => htmlspecialchars($post['profit_2']),
			'profit_3' => htmlspecialchars($post['profit_3']),
			'profit_4' => htmlspecialchars($post['profit_4'])
		];

		if ($_FILES['gambar']['name']) {
			$data['gambar'] = _upload('gambar', 'master/ubah_barang/' . $id, 'barang');
			delImage('barang', $id);
		}

		$this->db->where('id_barang', $id);
		$this->db->update('barang', $data);
	}

}

/* End of file barang_model.php */
/* Location: ./application/modules/barang/models/barang_model.php */ ?>
