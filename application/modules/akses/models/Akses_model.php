<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class akses_model extends CI_Model {

	public function get_akses($id = '')
	{
		if ($id == '') {
			return $this->db->get('role')->result_array();
		}else {
			$this->db->where('id_role', $id);
			return $this->db->get('role')->row_array();
		}
	}

	public function get_akses_role($id)
	{
		return $this->db->get_where('akses_role', ['id_role' => $id])->result_array();
	}

	public function delete($id)
	{
		$this->db->delete('role', ['id_role' => $id]);
		$this->db->delete('akses_role', ['id_role' => $id]);
	}

	public function insert($post)
	{
		$this->db->insert('role', ['nama_role' => $post['nama_role']]);
	}

	public function update($id, $post)
	{
		$data = [
			'id_role' => $id,
			'id_menu' => $post['id_menu']
		];

		$this->db->where('id_role', $id);
		$this->db->update('akses_role', $data);
	}

	public function delete_akses($id, $post)
	{
		$data = [
			'id_role' => $id,
			'id_menu' => $post['id_menu']
		];

		$this->db->where($data);
		$this->db->delete('akses_role');
	}

}

/* End of file akses_model.php */
/* Location: ./application/modules/akses/models/akses_model.php */ ?>