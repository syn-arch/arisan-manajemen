<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class pelanggan extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('pelanggan/pelanggan_model');
		$this->load->library('Pdf');
	}

	public function get_pelanggan_json()
	{
		header('Content-Type: application/json');
		echo $this->pelanggan_model->get_pelanggan_json();
	}

	public function get_pelanggan($id = '')
	{
		echo json_encode($this->pelanggan_model->get_pelanggan($id));
	}

	public function hapus($id)
	{
		$this->pelanggan_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('master/pelanggan','refresh');
	}

	public function index()
	{
		$data['judul'] = "Data Pelanggan";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('pelanggan/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah()
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_pelanggan', 'nama pelanggan', 'required');
		$valid->set_rules('jk', 'jenis kelamin', 'required');
		$valid->set_rules('id_pelanggan', 'ID pelanggan', 'required');
		$valid->set_rules('alamat', 'alamat', 'required');
		$valid->set_rules('jenis', 'jenis', 'required');

		if ($valid->run()) {
			$this->pelanggan_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('master/pelanggan','refresh');
		}

		$data['judul'] = "Tambah pelanggan";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('pelanggan/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function cetak_kartu($id)
	{
		$data['judul'] = "Cetak Kartu Member";
		$data['pelanggan'] = $this->pelanggan_model->get_pelanggan($id);

		// $this->pdf->setPaper('A4', 'potrait');
		// $this->pdf->filename = $data['pelanggan']['nama_pelanggan'] . ".pdf";
		// $this->pdf->load_view('pelanggan/cetak_kartu', $data);

		$this->load->view('pelanggan/cetak_kartu', $data, FALSE);
	}

	public function ubah($id)
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_pelanggan', 'nama pelanggan', 'required');
		$valid->set_rules('jk', 'jenis kelamin', 'required');
		$valid->set_rules('id_pelanggan', 'ID pelanggan', 'required');
		$valid->set_rules('alamat', 'alamat', 'required');
		$valid->set_rules('jenis', 'jenis', 'required');

		if ($valid->run()) {
			$this->pelanggan_model->update($id, $this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('master/pelanggan','refresh');
		}

		$data['judul'] = "Ubah pelanggan";
		$data['pelanggan'] = $this->pelanggan_model->get_pelanggan($id);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('pelanggan/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function export()
	{
		$pelanggan = $this->pelanggan_model->get_pelanggan();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode pelanggan')
		->setCellValue('B1', 'Nama Pelanggan')
		->setCellValue('C1', 'Alamat')
		->setCellValue('D1', 'Telepon')
		->setCellValue('E1', 'Jenis Kelamin')
		->setCellValue('F1', 'Jenis')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($pelanggan as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_pelanggan'])
			->setCellValue('B' . $i, $row['nama_pelanggan'])
			->setCellValue('C' . $i, $row['alamat'])
			->setCellValue('D' . $i, $row['telepon'])
			->setCellValue('E' . $i, $row['jk'])
			->setCellValue('F' . $i, $row['jenis']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data pelanggan.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function template()
	{
		$pelanggan = $this->pelanggan_model->get_pelanggan();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode pelanggan')
		->setCellValue('B1', 'Nama pelanggan')
		->setCellValue('C1', 'Alamat')
		->setCellValue('D1', 'Telepon')
		->setCellValue('E1', 'Jenis Kelamin')
		->setCellValue('F1', 'Jenis')
		;                      

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data pelanggan.xlsx"');
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
					'id_pelanggan' => $sheetData[$i]['0'],
					'nama_pelanggan' => $sheetData[$i]['1'],
					'alamat' => $sheetData[$i]['2'],
					'telepon' => $sheetData[$i]['3'],
					'jk' => $sheetData[$i]['4'],
					'jenis' => $sheetData[$i]['5']
				];

				$this->db->insert('pelanggan', $data);
			}
		}

		$this->session->set_flashdata('success', 'Di import');
		redirect('master/pelanggan','refresh');
	}

}

/* End of file pelanggan.php */
/* Location: ./application/modules/pelanggan/controllers/pelanggan.php */ ?>