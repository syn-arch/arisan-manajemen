<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class jadwal_kocokan extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('jadwal_kocokan/jadwal_kocokan_model');
		$this->load->model('agen/agen_model');
		$this->load->model('kelompok/kelompok_model');
	}

	public function get_jadwal_kocokan_json()
	{
		header('Content-Type: application/json');
		echo $this->jadwal_kocokan_model->get_jadwal_kocokan_json();
	}

	public function hapus($id)
	{
		$this->jadwal_kocokan_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('master/jadwal_kocokan','refresh');
	}

	public function index()
	{
		$data['judul'] = "Data Jadwal Kocokan";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('jadwal_kocokan/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah()
	{
		$valid = $this->form_validation;
		$valid->set_rules('id_agen', 'id agen', 'required');
		$valid->set_rules('id_jadwal_kocokan', 'ID jadwal_kocokan', 'required');

		if ($valid->run()) {
			$this->jadwal_kocokan_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('master/jadwal_kocokan','refresh');
		}

		$data['judul'] = "Tambah Jadwal Kocokan";
		$data['agen'] = $this->agen_model->get_agen();
		$data['kelompok'] = $this->kelompok_model->get_kelompok();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('jadwal_kocokan/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah($id)
	{
		$valid = $this->form_validation;
		$valid->set_rules('id_agen', 'id agen', 'required');

		if ($valid->run()) {
			$this->jadwal_kocokan_model->update($id, $this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('master/jadwal_kocokan','refresh');
		}

		$data['judul'] = "Ubah Jadwal Kocokan";
		$data['jadwal_kocokan'] = $this->jadwal_kocokan_model->get_jadwal_kocokan($id);
		$data['agen'] = $this->agen_model->get_agen();
		$data['kelompok'] = $this->kelompok_model->get_kelompok();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('jadwal_kocokan/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function export()
	{
		$jadwal_kocokan = $this->jadwal_kocokan_model->get_jadwal_kocokan();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode jadwal_kocokan')
		->setCellValue('B1', 'id agen')
		->setCellValue('C1', 'id kelompok')
		->setCellValue('D1', 'nominal')
		->setCellValue('E1', 'tanggal')
		->setCellValue('F1', 'keterangan')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($jadwal_kocokan as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_jadwal_kocokan'])
			->setCellValue('B' . $i, $row['id_agen'])
			->setCellValue('C' . $i, $row['id_kelompok'])
			->setCellValue('D' . $i, $row['nominal'])
			->setCellValue('E' . $i, $row['tanggal'])
			->setCellValue('F' . $i, $row['keterangan']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data jadwal_kocokan.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function template()
	{
		$jadwal_kocokan = $this->jadwal_kocokan_model->get_jadwal_kocokan();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode jadwal_kocokan')
		->setCellValue('B1', 'id agen')
		->setCellValue('C1', 'id kelompok')
		->setCellValue('D1', 'nominal')
		->setCellValue('E1', 'tanggal')
		->setCellValue('F1', 'keterangan')
		;                      

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data jadwal_kocokan.xlsx"');
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
					'id_jadwal_kocokan' => $sheetData[$i]['0'],
					'id_agen' => $sheetData[$i]['1'],
					'id_kelompok' => $sheetData[$i]['1'],
					'nominal' => $sheetData[$i]['1'],
					'tanggal' => $sheetData[$i]['1'],
					'keterangan' => $sheetData[$i]['1'],
				];

				$this->db->insert('jadwal_kocokan', $data);
			}
		}

		$this->session->set_flashdata('success', 'Di import');
		redirect('master/jadwal_kocokan','refresh');
	}

}

/* End of file jadwal_kocokan.php */
/* Location: ./application/modules/jadwal_kocokan/controllers/jadwal_kocokan.php */ ?>