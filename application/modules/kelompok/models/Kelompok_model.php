<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kelompok_model extends CI_Model {

	public function get_kelompok_json()
	{
		$this->datatables->select('id_kelompok, nama_kelompok');
		$this->datatables->from('kelompok');
		return $this->datatables->generate();
	}

	public function get_kelompok($id = '')
	{
		if ($id == '') {
			return $this->db->get('kelompok')->result_array();
		}else {
			$this->db->where('id_kelompok', $id);
			return $this->db->get('kelompok')->row_array();
		}
	}

	public function delete($id)
	{
		$this->db->delete('kelompok', ['id_kelompok' => $id]);
	}

	public function insert($post)
	{
		$data = [
			'id_kelompok' => htmlspecialchars($post['id_kelompok']),
			'nama_kelompok' => htmlspecialchars($post['nama_kelompok'])
		];

		$this->db->insert('kelompok', $data);
	}

	public function update($id, $post)
	{
		$data = [
			'nama_kelompok' => htmlspecialchars($post['nama_kelompok'])
		];

		$this->db->where('id_kelompok', $id);
		$this->db->update('kelompok', $data);
	}

}

/* End of file kelompok_model.php */
/* Location: ./application/modules/kelompok/models/kelompok_model.php */ ?>