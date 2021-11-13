<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class karyawan_model extends CI_Model {

	public function get_karyawan_json()
	{
		$this->datatables->select('id_karyawan, nama_karyawan, jk, karyawan.alamat, karyawan.telepon, karyawan.email, gambar, nama_outlet, jabatan');
		$this->datatables->from('karyawan');
		$this->datatables->join('outlet', 'id_outlet', 'left');
		return $this->datatables->generate();
	}

	public function get_karyawan($id = '')
	{
		if ($id == '') {
			$this->db->select('*, karyawan.email,karyawan.alamat,karyawan.telepon');
			$this->db->join('outlet', 'id_outlet', 'left');
			return $this->db->get('karyawan')->result_array();
		}else {
			$this->db->select('*, karyawan.email,karyawan.alamat,karyawan.telepon');
			$this->db->join('outlet', 'id_outlet', 'left');
			$this->db->where('id_karyawan', $id);
			return $this->db->get('karyawan')->row_array();
		}
	}

	public function delete($id)
	{
		delImage('karyawan', $id);
		$this->db->delete('karyawan', ['id_karyawan' => $id]);
	}

	public function insert($post)
	{
		$data = [
			'id_karyawan' => htmlspecialchars($post['id_karyawan']),
			'nama_karyawan' => htmlspecialchars($post['nama_karyawan']),
			'jk' => htmlspecialchars($post['jk']),
			'alamat' => htmlspecialchars($post['alamat']),
			'telepon' => htmlspecialchars($post['telepon']),
			'email' => htmlspecialchars($post['email']),
			'jabatan' => htmlspecialchars($post['jabatan']),
			'gambar' => _upload('gambar', 'karyawan/tambah', 'karyawan'),
			'id_outlet' => htmlspecialchars($post['id_outlet'])
		];

		$this->db->insert('karyawan', $data);
	}

	public function update($id, $post)
	{
		$data = [
			'nama_karyawan' => htmlspecialchars($post['nama_karyawan']),
			'jk' => htmlspecialchars($post['jk']),
			'alamat' => htmlspecialchars($post['alamat']),
			'telepon' => htmlspecialchars($post['telepon']),
			'email' => htmlspecialchars($post['email']),
			'jabatan' => htmlspecialchars($post['jabatan']),
			'id_outlet' => htmlspecialchars($post['id_outlet'])
		];

		if ($_FILES['gambar']['name']) {
			$data['gambar'] = _upload('gambar', 'karyawan/ubah/' . $id, 'karyawan');
			delImage('karyawan', $id);
		}

		$this->db->where('id_karyawan', $id);
		$this->db->update('karyawan', $data);
	}

}

/* End of file karyawan_model.php */
/* Location: ./application/modules/karyawan/models/karyawan_model.php */ ?>