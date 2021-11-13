<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Petugas extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('petugas/petugas_model');
	}

	public function get_petugas_json()
	{
		header('Content-Type: application/json');
		echo $this->petugas_model->get_petugas_json();
	}

	public function hapus($id)
	{
		$this->petugas_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('petugas','refresh');
	}

	public function index()
	{
		$data['judul'] = "Data Petugas";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('petugas/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah()
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_petugas', 'nama petugas', 'required');
		$valid->set_rules('jk', 'jenis kelamin', 'required');
		$valid->set_rules('id_petugas', 'ID petugas', 'required');
		$valid->set_rules('alamat', 'alamat', 'required');
		$valid->set_rules('telepon', 'telepon', 'required');
		$valid->set_rules('email', 'email', 'required');
		$valid->set_rules('pw1', 'password', 'required|matches[pw2]');
		$valid->set_rules('pw2', 'konfirmasi password', 'required|matches[pw1]');
		$valid->set_rules('id_role', 'level', 'required');
		if (empty($_FILES['gambar']['name'])) {
			$valid->set_rules('gambar', 'gambar', 'required');
		}

		if ($valid->run()) {
			$this->petugas_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('petugas','refresh');
		}

		$data['judul'] = "Tambah Petugas";
		$data['role'] = $this->db->get('role')->result_array();
		$data['outlet'] = $this->db->get('outlet')->result_array();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('petugas/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah($id)
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_petugas', 'nama petugas', 'required');
		$valid->set_rules('jk', 'jenis kelamin', 'required');
		$valid->set_rules('id_petugas', 'ID petugas', 'required');
		$valid->set_rules('alamat', 'alamat', 'required');
		$valid->set_rules('telepon', 'telepon', 'required');
		$valid->set_rules('email', 'email', 'required');
		$valid->set_rules('id_role', 'level', 'required');

		if ($valid->run()) {
			$this->petugas_model->update($id, $this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('petugas','refresh');
		}

		$data['judul'] = "Ubah Petugas";
		$data['role'] = $this->db->get('role')->result_array();
		$data['outlet'] = $this->db->get('outlet')->result_array();
		$data['petugas'] = $this->petugas_model->get_petugas($id);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('petugas/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function export()
	{
		$petugas = $this->petugas_model->get_petugas();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode petugas')
		->setCellValue('B1', 'Kode Outlet')
		->setCellValue('C1', 'Nama Petugas')
		->setCellValue('D1', 'Alamat')
		->setCellValue('E1', 'Jenis Kelamin')
		->setCellValue('F1', 'Telepon')
		->setCellValue('G1', 'Email')
		->setCellValue('H1', 'Level')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($petugas as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_petugas'])
			->setCellValue('B' . $i, $row['id_outlet'])
			->setCellValue('C' . $i, $row['nama_petugas'])
			->setCellValue('D' . $i, $row['alamat'])
			->setCellValue('E' . $i, $row['jk'])
			->setCellValue('F' . $i, $row['telepon'])
			->setCellValue('G' . $i, $row['email'])
			->setCellValue('H' . $i, $row['nama_role']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data petugas.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	

}

/* End of file Petugas.php */
/* Location: ./application/modules/petugas/controllers/Petugas.php */ ?>