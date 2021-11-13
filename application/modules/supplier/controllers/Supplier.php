<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class supplier extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('supplier/supplier_model');
	}

	public function get_supplier_json()
	{
		header('Content-Type: application/json');
		echo $this->supplier_model->get_supplier_json();
	}

	public function hapus($id)
	{
		$this->supplier_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('master/supplier','refresh');
	}

	public function index()
	{
		$data['judul'] = "Data Supplier";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('supplier/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah()
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_supplier', 'nama supplier', 'required');
		$valid->set_rules('alamat', 'alamat', 'required');
		$valid->set_rules('id_supplier', 'ID supplier', 'required');

		if ($valid->run()) {
			$this->supplier_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('master/supplier','refresh');
		}

		$data['judul'] = "Tambah supplier";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('supplier/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah($id)
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_supplier', 'nama supplier', 'required');
		$valid->set_rules('alamat', 'alamat', 'required');

		if ($valid->run()) {
			$this->supplier_model->update($id, $this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('master/supplier','refresh');
		}

		$data['judul'] = "Ubah supplier";
		$data['supplier'] = $this->supplier_model->get_supplier($id);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('supplier/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function export()
	{
		$supplier = $this->supplier_model->get_supplier();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode supplier')
		->setCellValue('B1', 'Nama supplier')
		->setCellValue('C1', 'Alamat')
		->setCellValue('D1', 'Telepon')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($supplier as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_supplier'])
			->setCellValue('B' . $i, $row['nama_supplier'])
			->setCellValue('C' . $i, $row['alamat'])
			->setCellValue('D' . $i, $row['telepon']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data supplier.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function template()
	{
		$supplier = $this->supplier_model->get_supplier();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode supplier')
		->setCellValue('B1', 'Nama supplier')
		->setCellValue('C1', 'Alamat')
		->setCellValue('D1', 'Telepon')
		;                      

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data supplier.xlsx"');
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
					'id_supplier' => $sheetData[$i]['0'],
					'nama_supplier' => $sheetData[$i]['1'],
					'alamat' => $sheetData[$i]['2'],
					'telepon' => $sheetData[$i]['3']
				];

				$this->db->insert('supplier', $data);
			}
		}

		$this->session->set_flashdata('success', 'Di import');
		redirect('master/supplier','refresh');
	}

}

/* End of file supplier.php */
/* Location: ./application/modules/supplier/controllers/supplier.php */ ?>