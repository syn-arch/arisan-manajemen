<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class karyawan extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('karyawan/karyawan_model');
	}

	public function get_karyawan_json()
	{
		header('Content-Type: application/json');
		echo $this->karyawan_model->get_karyawan_json();
	}

	public function hapus($id)
	{
		$this->karyawan_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('master/karyawan','refresh');
	}

	public function index()
	{
		$data['judul'] = "Data Karyawan";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('karyawan/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah()
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_karyawan', 'nama karyawan', 'required');
		$valid->set_rules('jk', 'jenis kelamin', 'required');
		$valid->set_rules('id_karyawan', 'ID karyawan', 'required');
		$valid->set_rules('alamat', 'alamat', 'required');
		$valid->set_rules('telepon', 'telepon', 'required');
		$valid->set_rules('email', 'email', 'required');
		$valid->set_rules('id_outlet', 'outlet', 'required');
		$valid->set_rules('jabatan', 'jabatan', 'required');
		if (empty($_FILES['gambar']['name'])) {
			$valid->set_rules('gambar', 'gambar', 'required');
		}

		if ($valid->run()) {
			$this->karyawan_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('master/karyawan','refresh');
		}

		$data['judul'] = "Tambah karyawan";
		$data['outlet'] = $this->db->get('outlet')->result_array();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('karyawan/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah($id)
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_karyawan', 'nama karyawan', 'required');
		$valid->set_rules('jk', 'jenis kelamin', 'required');
		$valid->set_rules('id_karyawan', 'ID karyawan', 'required');
		$valid->set_rules('alamat', 'alamat', 'required');
		$valid->set_rules('telepon', 'telepon', 'required');
		$valid->set_rules('email', 'email', 'required');
		$valid->set_rules('jabatan', 'jabatan', 'required');
		$valid->set_rules('id_outlet', 'outlet', 'required');

		if ($valid->run()) {
			$this->karyawan_model->update($id, $this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('master/karyawan','refresh');
		}

		$data['judul'] = "Ubah karyawan";
		$data['karyawan'] = $this->karyawan_model->get_karyawan($id);
		$data['outlet'] = $this->db->get('outlet')->result_array();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('karyawan/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function export()
	{
		$karyawan = $this->karyawan_model->get_karyawan();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode Karyawan')
		->setCellValue('B1', 'Nama Outlet')
		->setCellValue('C1', 'Nama Karyawan')
		->setCellValue('D1', 'Alamat')
		->setCellValue('E1', 'Jenis Kelamin')
		->setCellValue('F1', 'Telepon')
		->setCellValue('G1', 'Email')
		->setCellValue('H1', 'Jabatan')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($karyawan as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_karyawan'])
			->setCellValue('B' . $i, $row['id_outlet'])
			->setCellValue('C' . $i, $row['nama_karyawan'])
			->setCellValue('D' . $i, $row['alamat'])
			->setCellValue('E' . $i, $row['jk'])
			->setCellValue('F' . $i, $row['telepon'])
			->setCellValue('G' . $i, $row['email'])
			->setCellValue('H' . $i, $row['jabatan']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data karyawan.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function template()
	{
		$karyawan = $this->karyawan_model->get_karyawan();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode karyawan')
		->setCellValue('B1', 'Nama Outlet')
		->setCellValue('C1', 'Nama Karyawan')
		->setCellValue('D1', 'Alamat')
		->setCellValue('E1', 'Jenis Kelamin')
		->setCellValue('F1', 'Telepon')
		->setCellValue('G1', 'Email')
		->setCellValue('H1', 'Jabatan')
		;                      

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data karyawan.xlsx"');
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
					'id_karyawan' => $sheetData[$i]['0'],
					'id_outlet' => $sheetData[$i]['1'],
					'nama_karyawan' => $sheetData[$i]['2'],
					'alamat' => $sheetData[$i]['3'],
					'jk' => $sheetData[$i]['4'],
					'telepon' => $sheetData[$i]['5'],
					'email' => $sheetData[$i]['6'],
					'jabatan' => $sheetData[$i]['7']
				];

				$this->db->insert('karyawan', $data);
			}
			
		}

		$this->session->set_flashdata('success', 'Di import');
		redirect('master/karyawan','refresh');
	}

}

/* End of file karyawan.php */
/* Location: ./application/modules/karyawan/controllers/karyawan.php */ ?>
