<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class agen_model extends CI_Model {

	public function get_agen_json()
	{
		$this->datatables->select('id_agen, nama_agen,alamat, telepon, nama_kelompok, nominal_kocokan, periode_arisan, keterangan');
		$this->datatables->from('agen');
		$this->datatables->join('kelompok', 'id_kelompok', 'left');
		return $this->datatables->generate();
	}

	public function get_agen($id = '')
	{
		if ($id == '') {
			$this->db->select('*');
			$this->db->join('kelompok', 'id_kelompok', 'left');
			return $this->db->get('agen')->result_array();
		}else {
			$this->db->select('*');
			$this->db->join('kelompok', 'id_kelompok', 'left');
			$this->db->where('id_agen', $id);
			return $this->db->get('agen')->row_array();
		}
	}

	public function delete($id)
	{
		$this->db->delete('agen', ['id_agen' => $id]);
	}

	public function insert($post)
	{
		$data = [
			'id_agen' => htmlspecialchars($post['id_agen']),
			'nama_agen' => htmlspecialchars($post['nama_agen']),
			'id_kelompok' => htmlspecialchars($post['id_kelompok']),
			'nominal_kocokan' => htmlspecialchars($post['nominal_kocokan']),
			'periode_arisan' => htmlspecialchars($post['periode_arisan']),
			'keterangan' => htmlspecialchars($post['keterangan']),
			'alamat' => htmlspecialchars($post['alamat']),
			'telepon' => htmlspecialchars($post['telepon']),
		];

		$this->db->insert('agen', $data);
	}

	public function update($id, $post)
	{
		$data = [
			'nama_agen' => htmlspecialchars($post['nama_agen']),
			'id_kelompok' => htmlspecialchars($post['id_kelompok']),
			'nominal_kocokan' => htmlspecialchars($post['nominal_kocokan']),
			'periode_arisan' => htmlspecialchars($post['periode_arisan']),
			'keterangan' => htmlspecialchars($post['keterangan']),
			'alamat' => htmlspecialchars($post['alamat']),
			'telepon' => htmlspecialchars($post['telepon']),
		];

		$this->db->where('id_agen', $id);
		$this->db->update('agen', $data);
	}

}

/* End of file agen_model.php */
/* Location: ./application/modules/agen/models/agen_model.php */ ?>