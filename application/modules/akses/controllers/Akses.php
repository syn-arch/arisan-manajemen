<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class akses extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('akses/akses_model');
	}

	public function hapus($id)
	{
		$this->akses_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('akses','refresh');
	}

	public function index()
	{
		$data['judul'] = "Akses Menu Petugas";
		$data['role'] = $this->akses_model->get_akses();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('akses/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah()
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_role', 'nama_role', 'required');

		if ($valid->run()) {
			$this->akses_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('petugas/akses','refresh');
		}

		$data['judul'] = "Tambah Role";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('akses/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah($id)
	{
		$data['judul'] = "Ubah akses";
		$data['role'] = $this->akses_model->get_akses($id);
		$data['akses'] = $this->akses_model->get_akses_role($id);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('akses/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah_akses($id_menu, $id_role)
	{
		$data = [
			'id_menu' => $id_menu,
			'id_role' => $id_role
		];

		$akses = $this->db->get_where('akses_role', $data)->row_array();

		if ($akses) {
			$this->db->delete('akses_role', $data);
		}else{
			$this->db->insert('akses_role', $data);
		}
	}

}

/* End of file akses.php */
/* Location: ./application/modules/akses/controllers/akses.php */ ?>