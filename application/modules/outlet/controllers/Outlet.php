<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class outlet extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('outlet/outlet_model');
	}

	public function get_outlet_json()
	{
		header('Content-Type: application/json');
		echo $this->outlet_model->get_outlet_json();
	}

	public function hapus($id)
	{
		$this->outlet_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('master/outlet','refresh');
	}

	public function index()
	{
		$data['judul'] = "Data Outlet";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('outlet/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah()
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_outlet', 'nama outlet', 'required');
		$valid->set_rules('id_outlet', 'ID outlet', 'required');
		$valid->set_rules('alamat', 'alamat', 'required');
		$valid->set_rules('telepon', 'telepon', 'required');
		
		if ($valid->run()) {
			$this->outlet_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('master/outlet','refresh');
		}

		$data['judul'] = "Tambah Outlet";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('outlet/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah($id)
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_outlet', 'nama outlet', 'required');
		$valid->set_rules('alamat', 'alamat', 'required');
		$valid->set_rules('telepon', 'telepon', 'required');

		if ($valid->run()) {
			$this->outlet_model->update($id, $this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('master/outlet','refresh');
		}

		$data['judul'] = "Ubah outlet";
		$data['outlet'] = $this->outlet_model->get_outlet($id);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('outlet/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function export()
	{
		$outlet = $this->outlet_model->get_outlet();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode Outlet')
		->setCellValue('B1', 'Nama Outlet')
		->setCellValue('C1', 'Alamat')
		->setCellValue('D1', 'Telepon')
		->setCellValue('E1', 'E-mail')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($outlet as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_outlet'])
			->setCellValue('B' . $i, $row['nama_outlet'])
			->setCellValue('C' . $i, $row['alamat'])
			->setCellValue('D' . $i, $row['telepon'])
			->setCellValue('E' . $i, $row['email']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data Outlet.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function template()
	{
		$outlet = $this->outlet_model->get_outlet();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode Outlet')
		->setCellValue('B1', 'Nama Outlet')
		->setCellValue('C1', 'Alamat')
		->setCellValue('D1', 'Telepon')
		->setCellValue('E1', 'E-mail')
		;                      

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data Outlet.xlsx"');
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
					'id_outlet' => $sheetData[$i]['0'],
					'nama_outlet' => $sheetData[$i]['1'],
					'alamat' => $sheetData[$i]['2'],
					'telepon' => $sheetData[$i]['3'],
					'email' => $sheetData[$i]['4']
				];

				$this->db->insert('outlet', $data);
			}
			
		}

		$this->session->set_flashdata('success', 'Di import');
		redirect('master/outlet','refresh');
	}

}

/* End of file outlet.php */
/* Location: ./application/modules/outlet/controllers/outlet.php */ ?>