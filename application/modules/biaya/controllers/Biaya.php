<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class biaya extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('biaya/biaya_model');
		$this->load->model('outlet/outlet_model');
	}

	public function get_biaya_json()
	{
		header('Content-Type: application/json');
		echo $this->biaya_model->get_biaya_json();
	}
	
	public function index()
	{
		$data['judul'] = "Riwayat Transaksi";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('biaya/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah()
	{
		$valid = $this->form_validation;
		$valid->set_rules('id_biaya', 'id biaya', 'required');
		$valid->set_rules('id_petugas', 'petugas', 'required');
		$valid->set_rules('tgl', 'tanggal', 'required');

		if ($valid->run()) {
			$this->biaya_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('biaya','refresh');
		}

		$data['judul'] = "Transaksi Baru";
		$data['outlet'] = $this->outlet_model->get_outlet();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('biaya/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah($id_biaya)
	{
		$valid = $this->form_validation;
		$valid->set_rules('id_biaya', 'id biaya', 'required');
		$valid->set_rules('id_petugas', 'petugas', 'required');
		$valid->set_rules('tgl', 'tanggal', 'required');

		if ($valid->run()) {
			$this->biaya_model->update($id_biaya, $this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('biaya','refresh');
		}

		$data['judul'] = "Ubah biaya";
		$data['biaya'] = $this->biaya_model->get_biaya($id_biaya);
		$data['outlet'] = $this->outlet_model->get_outlet();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('biaya/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function hapus($id = '')
	{
		$this->biaya_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('biaya','refresh');
	}

	public function export()
	{
		$biaya = $this->biaya_model->get_biaya();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode biaya')
		->setCellValue('B1', 'Tanggal')
		->setCellValue('C1', 'Petugas')
		->setCellValue('D1', 'Total Bayar')
		->setCellValue('E1', 'Cash')
		->setCellValue('F1', 'Keterangan')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($biaya as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_biaya'])
			->setCellValue('B' . $i, $row['tgl'])
			->setCellValue('C' . $i, $row['nama_petugas'])
			->setCellValue('D' . $i, $row['total_bayar'])
			->setCellValue('E' . $i, $row['cash'])
			->setCellValue('F' . $i, $row['keterangan'])
			;
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data Penyesuaian biaya.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function export_biaya_outlet($id_outlet)
	{
		$biaya = $this->biaya_model->get_biaya_barang($id_outlet);

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode Barang')
		->setCellValue('B1', 'Kode Outlet')
		->setCellValue('C1', 'Nama Barang')
		->setCellValue('D1', 'biaya')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($biaya as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_barang'])
			->setCellValue('B' . $i, $row['id_outlet'])
			->setCellValue('C' . $i, $row['nama_barang'])
			->setCellValue('D' . $i, $row['biaya'])
			;
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data biaya ' . $biaya[0]['nama_outlet'] . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function import_biaya()
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
				$this->db->set('biaya', $sheetData[$i]['3']);
				$this->db->where('id_barang', $sheetData[$i]['0']);
				$this->db->where('id_outlet', $sheetData[$i]['1']);
				$this->db->update('biaya_outlet');
			}

		}

		$this->session->set_flashdata('success', 'Di import');
		redirect('biaya/barang?id_outlet=' . $sheetData[1]['1'],'refresh');
	}

}

/* End of file biaya.php */
/* Location: ./application/modules/biaya/controllers/biaya.php */ ?>