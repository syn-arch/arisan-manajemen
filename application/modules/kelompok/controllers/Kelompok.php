<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class kelompok extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('kelompok/kelompok_model');
	}

	public function get_kelompok_json()
	{
		header('Content-Type: application/json');
		echo $this->kelompok_model->get_kelompok_json();
	}

	public function hapus($id)
	{
		$this->kelompok_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('master/kelompok','refresh');
	}

	public function index()
	{
		$data['judul'] = "Data Kelompok";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('kelompok/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah()
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_kelompok', 'nama kelompok', 'required');
		$valid->set_rules('id_kelompok', 'ID kelompok', 'required');

		if ($valid->run()) {
			$this->kelompok_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('master/kelompok','refresh');
		}

		$data['judul'] = "Tambah kelompok";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('kelompok/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah($id)
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_kelompok', 'nama kelompok', 'required');

		if ($valid->run()) {
			$this->kelompok_model->update($id, $this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('master/kelompok','refresh');
		}

		$data['judul'] = "Ubah kelompok";
		$data['kelompok'] = $this->kelompok_model->get_kelompok($id);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('kelompok/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function export()
	{
		$kelompok = $this->kelompok_model->get_kelompok();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode kelompok')
		->setCellValue('B1', 'Nama kelompok')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($kelompok as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_kelompok'])
			->setCellValue('B' . $i, $row['nama_kelompok']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data kelompok.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function template()
	{
		$kelompok = $this->kelompok_model->get_kelompok();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode kelompok')
		->setCellValue('B1', 'Nama kelompok')
		;                      

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data kelompok.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function import()
	{
		$file = explode('.', $_FILES['excel']['name']);
		$extension = end($file);

		if($extension == 'csv') {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		} else {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}

		$spreadsheet = $reader->load($_FILES['excel']['tmp_name']);
		$sheetData = $spreadsheet->getActiveSheet()->toArray();
		for($i = 1;$i < count($sheetData); $i++)
		{
			if ($sheetData[$i]['0'] != '') {
				$data = [
					'id_kelompok' => $sheetData[$i]['0'],
					'nama_kelompok' => $sheetData[$i]['1']
				];

				$this->db->insert('kelompok', $data);
			}
		}

		$this->session->set_flashdata('success', 'Di import');
		redirect('master/kelompok','refresh');
	}

}

/* End of file kelompok.php */
/* Location: ./application/modules/kelompok/controllers/kelompok.php */ ?>