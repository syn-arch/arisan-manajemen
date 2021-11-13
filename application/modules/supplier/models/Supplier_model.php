<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class supplier_model extends CI_Model {

	public function get_supplier_json()
	{
		$this->datatables->select('id_supplier, nama_supplier, alamat, telepon');
		$this->datatables->from('supplier');
		return $this->datatables->generate();
	}

	public function get_supplier($id = '')
	{
		if ($id == '') {
			return $this->db->get('supplier')->result_array();
		}else {
			$this->db->where('id_supplier', $id);
			return $this->db->get('supplier')->row_array();
		}
	}

	public function delete($id)
	{
		$this->db->delete('supplier', ['id_supplier' => $id]);
	}

	public function insert($post)
	{
		$data = [
			'id_supplier' => htmlspecialchars($post['id_supplier']),
			'nama_supplier' => htmlspecialchars($post['nama_supplier']),
			'alamat' => htmlspecialchars($post['alamat']),
			'telepon' => htmlspecialchars($post['telepon'])
		];

		$this->db->insert('supplier', $data);
	}

	public function update($id, $post)
	{
		$data = [
			'nama_supplier' => htmlspecialchars($post['nama_supplier']),
			'alamat' => htmlspecialchars($post['alamat']),
			'telepon' => htmlspecialchars($post['telepon'])
		];

		$this->db->where('id_supplier', $id);
		$this->db->update('supplier', $data);
	}

}

/* End of file supplier_model.php */
/* Location: ./application/modules/supplier/models/supplier_model.php */ ?>