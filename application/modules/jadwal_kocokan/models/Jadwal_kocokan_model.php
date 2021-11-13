<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jadwal_kocokan_model extends CI_Model {

	public function get_jadwal_kocokan_json()
	{
		$this->datatables->select('id_jadwal_kocokan, nama_agen, nama_kelompok, nominal, tanggal, jadwal_kocokan.keterangan');
		$this->datatables->from('jadwal_kocokan');
		$this->datatables->join('agen', 'id_agen', 'left');
		$this->datatables->join('kelompok', 'jadwal_kocokan.id_kelompok = kelompok.id_kelompok', 'left');
		return $this->datatables->generate();
	}

	public function get_jadwal_kocokan($id = '')
	{
		if ($id == '') {
			$this->db->select('*, jadwal_kocokan.keterangan');
			$this->db->join('agen', 'id_agen', 'left');
			$this->db->join('kelompok', 'jadwal_kocokan.id_kelompok = kelompok.id_kelompok', 'left');
			return $this->db->get('jadwal_kocokan')->result_array();
		}else {
			$this->db->select('*, jadwal_kocokan.keterangan');
			$this->db->where('id_jadwal_kocokan', $id);
			$this->db->join('agen', 'id_agen', 'left');
			$this->db->join('kelompok', 'jadwal_kocokan.id_kelompok = kelompok.id_kelompok', 'left');
			return $this->db->get('jadwal_kocokan')->row_array();
		}
	}

	public function delete($id)
	{
		$this->db->delete('jadwal_kocokan', ['id_jadwal_kocokan' => $id]);
	}

	public function insert($post)
	{
		$data = [
			'id_jadwal_kocokan' => htmlspecialchars($post['id_jadwal_kocokan']),
			'id_agen' => htmlspecialchars($post['id_agen']),
			'id_kelompok' => htmlspecialchars($post['id_kelompok']),
			'nominal' => htmlspecialchars($post['nominal']),
			'tanggal' => htmlspecialchars($post['tanggal']),
			'keterangan' => htmlspecialchars($post['keterangan']),
		];

		$this->db->insert('jadwal_kocokan', $data);
	}

	public function update($id, $post)
	{
		$data = [
			'id_agen' => htmlspecialchars($post['id_agen']),
			'id_kelompok' => htmlspecialchars($post['id_kelompok']),
			'nominal' => htmlspecialchars($post['nominal']),
			'tanggal' => htmlspecialchars($post['tanggal']),
			'keterangan' => htmlspecialchars($post['keterangan']),
		];

		$this->db->where('id_jadwal_kocokan', $id);
		$this->db->update('jadwal_kocokan', $data);
	}

}

/* End of file jadwal_kocokan_model.php */
/* Location: ./application/modules/jadwal_kocokan/models/jadwal_kocokan_model.php */ ?>