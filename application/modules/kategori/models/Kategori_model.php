<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kategori_model extends CI_Model {

	public function get_kategori_json()
	{
		$this->datatables->select('id_kategori, nama_kategori');
		$this->datatables->from('kategori');
		return $this->datatables->generate();
	}

	public function get_kategori($id = '')
	{
		if ($id == '') {
			return $this->db->get('kategori')->result_array();
		}else {
			$this->db->where('id_kategori', $id);
			return $this->db->get('kategori')->row_array();
		}
	}

	public function delete($id)
	{
		$this->db->delete('kategori', ['id_kategori' => $id]);
	}

	public function insert($post)
	{
		$data = [
			'id_kategori' => htmlspecialchars($post['id_kategori']),
			'nama_kategori' => htmlspecialchars($post['nama_kategori'])
		];

		$this->db->insert('kategori', $data);
	}

	public function update($id, $post)
	{
		$data = [
			'nama_kategori' => htmlspecialchars($post['nama_kategori'])
		];

		$this->db->where('id_kategori', $id);
		$this->db->update('kategori', $data);
	}

}

/* End of file kategori_model.php */
/* Location: ./application/modules/kategori/models/kategori_model.php */ ?>