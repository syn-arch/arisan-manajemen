<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petugas_model extends CI_Model {

	public function get_petugas_json()
	{
		$this->datatables->select('id_petugas, nama_petugas, jk, alamat, telepon, email, gambar, nama_role');
		$this->datatables->from('petugas');
		$this->datatables->join('role', 'id_role', 'left');
		$this->datatables->where('nama_petugas !=', 'SUPERADMIN');
		return $this->datatables->generate();
	}

	public function get_petugas($id = '')
	{
		if ($id == '') {
			$this->db->join('role', 'id_role', 'left');
			return $this->db->get('petugas')->result_array();
		}else {
			$this->db->join('role', 'id_role', 'left');
			$this->db->where('id_petugas', $id);
			return $this->db->get('petugas')->row_array();
		}
	}

	public function delete($id)
	{
		delImage('petugas', $id);
		$this->db->delete('petugas', ['id_petugas' => $id]);
	}

	public function insert($post)
	{
		$data = [
			'id_petugas' => htmlspecialchars($post['id_petugas']),
			'nama_petugas' => htmlspecialchars($post['nama_petugas']),
			'jk' => htmlspecialchars($post['jk']),
			'alamat' => htmlspecialchars($post['alamat']),
			'telepon' => htmlspecialchars($post['telepon']),
			'email' => htmlspecialchars($post['email']),
			'password' => password_hash(htmlspecialchars($post['pw1']), PASSWORD_DEFAULT),
			'gambar' => _upload('gambar', 'petugas/tambah', 'petugas'),
			'id_role' => htmlspecialchars($post['id_role']),
			'id_outlet' => htmlspecialchars($post['id_outlet'])
		];

		$this->db->insert('petugas', $data);
	}

	public function update($id, $post)
	{
		$data = [
			'nama_petugas' => htmlspecialchars($post['nama_petugas']),
			'jk' => htmlspecialchars($post['jk']),
			'alamat' => htmlspecialchars($post['alamat']),
			'email' => htmlspecialchars($post['email']),
			'telepon' => htmlspecialchars($post['telepon']),
			'id_role' => htmlspecialchars($post['id_role']),
			'id_outlet' => htmlspecialchars($post['id_outlet'])
		];

		if ($_FILES['gambar']['name']) {
			$data['gambar'] = _upload('gambar', 'petugas/ubah/' . $id, 'petugas');
			delImage('petugas', $id);
		}

		$this->db->where('id_petugas', $id);
		$this->db->update('petugas', $data);
	}

}

/* End of file petugas_model.php */
/* Location: ./application/modules/petugas/models/petugas_model.php */ ?>