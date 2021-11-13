<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class agen extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('agen/agen_model');
		$this->load->model('kelompok/kelompok_model');
	}

	public function get_agen_json()
	{
		header('Content-Type: application/json');
		echo $this->agen_model->get_agen_json();
	}

	public function hapus($id)
	{
		$this->agen_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('master/agen','refresh');
	}

	public function index()
	{
		$data['judul'] = "Data Agen";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('agen/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah()
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_agen', 'nama agen', 'required');
		$valid->set_rules('id_kelompok', 'id_kelompok', 'required');
		$valid->set_rules('nominal_kocokan', 'nominal_kocokan', 'required');
		$valid->set_rules('periode_arisan', 'periode_arisan', 'required');

		if ($valid->run()) {
			$this->agen_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('master/agen','refresh');
		}

		$data['judul'] = "Tambah agen";
		$data['outlet'] = $this->db->get('outlet')->result_array();
		$data['kelompok'] =  $this->kelompok_model->get_kelompok();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('agen/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah($id)
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_agen', 'nama agen', 'required');
		$valid->set_rules('id_kelompok', 'id_kelompok', 'required');
		$valid->set_rules('nominal_kocokan', 'nominal_kocokan', 'required');
		$valid->set_rules('periode_arisan', 'periode_arisan', 'required');

		if ($valid->run()) {
			$this->agen_model->update($id, $this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('master/agen','refresh');
		}

		$data['judul'] = "Ubah agen";
		$data['agen'] = $this->agen_model->get_agen($id);
		$data['outlet'] = $this->db->get('outlet')->result_array();
		$data['kelompok'] =  $this->kelompok_model->get_kelompok();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('agen/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function export()
	{
		$agen = $this->agen_model->get_agen();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode agen')
		->setCellValue('B1', 'Nama agen')
		->setCellValue('C1', 'Kelompok')
		->setCellValue('D1', 'Nominal Kocokan')
		->setCellValue('E1', 'Periode Arisan')
		->setCellValue('F1', 'Keterangan')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($agen as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_agen'])
			->setCellValue('B' . $i, $row['nama_agen'])
			->setCellValue('C' . $i, $row['nama_kelompok'])
			->setCellValue('D' . $i, $row['nominal_kocokan'])
			->setCellValue('E' . $i, $row['periode_arisan'])
			->setCellValue('F' . $i, $row['keterangan']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data agen.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function template()
	{
		$agen = $this->agen_model->get_agen();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode agen')
		->setCellValue('B1', 'Nama agen')
		->setCellValue('C1', 'ID Kelompok')
		->setCellValue('D1', 'Nominal Kocokan')
		->setCellValue('E1', 'Periode Arisan')
		->setCellValue('F1', 'Keterangan')
		;                      

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data agen.xlsx"');
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
			if ($sheetData[$i] != '') {
				
				$data = [
					'id_agen' => $sheetData[$i]['0'],
					'nama_agen' => $sheetData[$i]['1'],
					'id_kelompok' => $sheetData[$i]['2'],
					'nominal_kocokan' => $sheetData[$i]['3'],
					'periode_arisan' => $sheetData[$i]['4'],
					'keterangan' => $sheetData[$i]['5'],
				];

				$this->db->insert('agen', $data);
			}
			
		}

		$this->session->set_flashdata('success', 'Di import');
		redirect('master/agen','refresh');
	}

}

/* End of file agen.php */
/* Location: ./application/modules/agen/controllers/agen.php */ ?>
