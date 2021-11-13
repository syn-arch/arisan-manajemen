<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class outlet_model extends CI_Model {

	public function get_outlet_json()
	{
		$this->datatables->select('id_outlet, nama_outlet, alamat, telepon, email');
		$this->datatables->from('outlet');
		return $this->datatables->generate();
	}

	public function get_outlet($id = '')
	{
		if ($id == '') {
			return $this->db->get('outlet')->result_array();
		}else {
			$this->db->where('id_outlet', $id);
			return $this->db->get('outlet')->row_array();
		}
	}

	public function delete($id)
	{
		$this->db->delete('outlet', ['id_outlet' => $id]);
		$this->db->delete('stok_outlet', ['id_outlet' => $id]);
	}

	public function insert($post)
	{
		$data = [
			'id_outlet' => htmlspecialchars($post['id_outlet']),
			'nama_outlet' => htmlspecialchars($post['nama_outlet']),
			'alamat' => htmlspecialchars($post['alamat']),
			'telepon' => htmlspecialchars($post['telepon']),
			'email' => htmlspecialchars($post['email'])
		];

		$this->db->insert('outlet', $data);
	}

	public function update($id, $post)
	{
		$data = [
			'nama_outlet' => htmlspecialchars($post['nama_outlet']),
			'alamat' => htmlspecialchars($post['alamat']),
			'telepon' => htmlspecialchars($post['telepon']),
			'email' => htmlspecialchars($post['email'])
		];

		$this->db->where('id_outlet', $id);
		$this->db->update('outlet', $data);
	}

}

/* End of file outlet_model.php */
/* Location: ./application/modules/outlet/models/outlet_model.php */ ?>