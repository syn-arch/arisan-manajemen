<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class kategori extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('kategori/kategori_model');
	}

	public function get_kategori_json()
	{
		header('Content-Type: application/json');
		echo $this->kategori_model->get_kategori_json();
	}

	public function hapus($id)
	{
		$this->kategori_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('master/kategori','refresh');
	}

	public function index()
	{
		$data['judul'] = "Data Kategori";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('kategori/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah()
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_kategori', 'nama kategori', 'required');
		$valid->set_rules('id_kategori', 'ID kategori', 'required');

		if ($valid->run()) {
			$this->kategori_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('master/kategori','refresh');
		}

		$data['judul'] = "Tambah kategori";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('kategori/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah($id)
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_kategori', 'nama kategori', 'required');

		if ($valid->run()) {
			$this->kategori_model->update($id, $this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('master/kategori','refresh');
		}

		$data['judul'] = "Ubah kategori";
		$data['kategori'] = $this->kategori_model->get_kategori($id);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('kategori/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function export()
	{
		$kategori = $this->kategori_model->get_kategori();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode kategori')
		->setCellValue('B1', 'Nama kategori')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($kategori as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_kategori'])
			->setCellValue('B' . $i, $row['nama_kategori']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data kategori.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function template()
	{
		$kategori = $this->kategori_model->get_kategori();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode kategori')
		->setCellValue('B1', 'Nama kategori')
		;                      

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data kategori.xlsx"');
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
					'id_kategori' => $sheetData[$i]['0'],
					'nama_kategori' => $sheetData[$i]['1']
				];

				$this->db->insert('kategori', $data);
			}
		}

		$this->session->set_flashdata('success', 'Di import');
		redirect('master/kategori','refresh');
	}

}

/* End of file kategori.php */
/* Location: ./application/modules/kategori/controllers/kategori.php */ ?>