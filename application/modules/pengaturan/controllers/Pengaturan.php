<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pengaturan extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('pengaturan/pengaturan_model');
	}


	public function index()
	{
		$data['judul'] = "Pengaturan";
		$data['pengaturan'] = $this->pengaturan_model->get_pengaturan();

		$valid = $this->form_validation;

		$valid->set_rules('keterangan_invoice', 'keterangan_invoice', 'required');
		$valid->set_rules('nama_printer', 'nama printer', 'required');
		$valid->set_rules('smtp_host', 'smtp host', 'required');
		$valid->set_rules('smtp_port', 'smtp port', 'required');
		$valid->set_rules('smtp_email', 'smtp email', 'required');
		$valid->set_rules('smtp_username', 'smtp username', 'required');
		$valid->set_rules('smtp_password', 'smtp password', 'required');
		$valid->set_rules('peringatan_stok', 'peringatan stok', 'required');

		if ($valid->run()) {
			$this->pengaturan_model->update($this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('pengaturan','refresh');
		}

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('pengaturan/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function get_pengaturan()
	{
		echo json_encode($this->db->get('pengaturan')->row_array());
	}

	
}

/* End of file pengaturan.php */
/* Location: ./application/modules/pengaturan/controllers/pengaturan.php */ ?>