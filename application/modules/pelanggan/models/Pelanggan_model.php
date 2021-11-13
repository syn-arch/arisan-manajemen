<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pelanggan_model extends CI_Model {

	public function get_pelanggan_json()
	{
		$this->datatables->select('id_pelanggan, nama_pelanggan, jk, alamat, telepon, jenis');
		$this->datatables->from('pelanggan');
		return $this->datatables->generate();
	}

	public function get_pelanggan($id = '')
	{
		if ($id == '') {
			return $this->db->get('pelanggan')->result_array();
		}else {
			$this->db->where('id_pelanggan', $id);
			$this->db->or_where('barcode', $id);
			return $this->db->get('pelanggan')->row_array();
		}
	}

	public function delete($id)
	{
		$this->db->delete('pelanggan', ['id_pelanggan' => $id]);
	}

	public function insert($post)
	{
		$data = [
			'id_pelanggan' => htmlspecialchars($post['id_pelanggan']),
			'barcode' => htmlspecialchars($post['barcode']),
			'nama_pelanggan' => htmlspecialchars($post['nama_pelanggan']),
			'jk' => htmlspecialchars($post['jk']),
			'alamat' => htmlspecialchars($post['alamat']),
			'telepon' => htmlspecialchars($post['telepon']),
			'jenis' => htmlspecialchars($post['jenis'])
		];

		$this->db->insert('pelanggan', $data);
	}

	public function update($id, $post)
	{
		$data = [
			'barcode' => htmlspecialchars($post['barcode']),
			'nama_pelanggan' => htmlspecialchars($post['nama_pelanggan']),
			'jk' => htmlspecialchars($post['jk']),
			'alamat' => htmlspecialchars($post['alamat']),
			'telepon' => htmlspecialchars($post['telepon']),
			'jenis' => htmlspecialchars($post['jenis'])
		];

		$this->db->where('id_pelanggan', $id);
		$this->db->update('pelanggan', $data);
	}

}

/* End of file pelanggan_model.php */
/* Location: ./application/modules/pelanggan/models/pelanggan_model.php */ ?>