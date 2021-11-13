<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil_model extends CI_Model {

	public function ubah_profil($post)
	{
		$data = [
			'nama_petugas' => $post['nama_petugas'],
			'jk' => $post['jk'],
			'alamat' => $post['alamat'],
			'telepon' => $post['telepon'],
			'email' => $post['email'],
			'telepon' => $post['telepon']
		];

		$this->db->where('id_petugas', $this->session->userdata('id_petugas'));
		$this->db->update('petugas', $data);
	}
}

/* End of file petugas_model.php */
/* Location: ./application/modules/petugas/models/petugas_model.php */ ?>