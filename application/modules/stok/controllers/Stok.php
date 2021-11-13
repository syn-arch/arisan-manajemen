<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class stok extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('stok/stok_model');
		$this->load->model('outlet/outlet_model');
		$this->load->model('barang/barang_model');
	}

	public function get_stok_json()
	{
		header('Content-Type: application/json');
		echo $this->stok_model->get_stok_json();
	}

	public function get_stok_barang_json()
	{
		header('Content-Type: application/json');
		echo $this->stok_model->get_stok_barang_json();
	}
	
	public function index()
	{
		$data['judul'] = "Penyesuaian Stok";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('stok/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function aset_persediaan()
	{
		$data['judul'] = "Aset Persediaan";
		$data['laporan'] = $this->stok_model->get_aset_persediaan();
		$data['total'] = $this->stok_model->get_total_aset();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('stok/aset_persediaan', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah_stok()
	{
		$valid = $this->form_validation;
		$valid->set_rules('id_stok', 'id stok', 'required');
		$valid->set_rules('id_petugas', 'petugas', 'required');
		$valid->set_rules('tgl', 'tanggal', 'required');

		if ($valid->run()) {
			$this->stok_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('stok','refresh');
		}

		$data['judul'] = "Tambah Stok";
		$data['outlet'] = $this->outlet_model->get_outlet();
		$data['barang'] = $this->barang_model->get_barang();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('stok/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah_stok($id_stok)
	{
		$valid = $this->form_validation;
		$valid->set_rules('id_stok', 'id stok', 'required');
		$valid->set_rules('id_petugas', 'petugas', 'required');
		$valid->set_rules('tgl', 'tanggal', 'required');

		if ($valid->run()) {
			$this->stok_model->update($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('stok','refresh');
		}

		$data['judul'] = "Ubah Stok";
		$data['outlet'] = $this->outlet_model->get_outlet();
		$data['barang'] = $this->barang_model->get_barang();
		$data['stok'] = $this->stok_model->get_stok($id_stok);
		$data['detail_stok'] = $this->stok_model->get_detail_stok($id_stok);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('stok/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function hapus_stok($id = '')
	{
		$this->stok_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('stok','refresh');
	}

	public function detail_stok($id)
	{
		$data['judul'] = "Detail Stok";
		$data['stok'] = $this->stok_model->get_stok($id);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('stok/detail_stok', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function barang()
	{
		$id = $this->session->userdata('id_outlet');

		if ($id && !$this->input->get('redirect')) {
			redirect("stok/barang?id_outlet={$id}&redirect=false",'refresh');
		}

		if ($this->db->get('pengaturan')->row()->multi_outlet == 0 && !$this->input->get('redirect')) {
			$id_outlet = $this->db->get('outlet')->row()->id_outlet;
			redirect("stok/barang?id_outlet={$id_outlet}&redirect=false",'refresh');
		}

		$id_outlet = $this->input->get('id_outlet');

		$data['judul'] = "Stok Barang";
		$data['outlet'] = $this->outlet_model->get_outlet();
		$data['stok'] = $this->stok_model->get_stok_barang($id_outlet);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('stok/barang', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah_stok_barang($id_stok_outlet)
	{
		$valid = $this->form_validation;
		$valid->set_rules('stok', 'stok', 'required');

		if ($valid->run()) {
			$this->stok_model->update_stok_barang($id_stok_outlet, $this->input->post());
			$id_outlet = $this->db->get_where('stok_outlet', ['id_stok_outlet' => $id_stok_outlet])->row()->id_outlet;
			$this->session->set_flashdata('success', 'ditambah');
			redirect('stok/barang?id_outlet=' . $id_outlet,'refresh');
		}

		$data['judul'] = "Ubah Stok";
		$data['stok'] = $this->stok_model->get_stok_barang_outlet($id_stok_outlet);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('stok/ubah_stok_barang', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function export()
	{
		$stok = $this->stok_model->get_stok();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode Stok')
		->setCellValue('B1', 'Tanggal')
		->setCellValue('C1', 'Petugas')
		->setCellValue('D1', 'Outlet')
		->setCellValue('E1', 'Keterangan')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($stok as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_stok'])
			->setCellValue('B' . $i, $row['tgl'])
			->setCellValue('C' . $i, $row['nama_petugas'])
			->setCellValue('D' . $i, $row['nama_outlet'])
			->setCellValue('E' . $i, $row['keterangan'])
			;
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data Penyesuaian Stok.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function export_aset_persediaan()
	{
		$laporan = $this->stok_model->get_aset_persediaan();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode Barang')
		->setCellValue('B1', 'Nama Barang')
		->setCellValue('C1', 'Stok')
		->setCellValue('D1', 'Harga Pokok')
		->setCellValue('E1', 'Aset')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($laporan as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_barang'])
			->setCellValue('B' . $i, $row['nama_barang'])
			->setCellValue('C' . $i, $row['stok'])
			->setCellValue('D' . $i, $row['harga_pokok'])
			->setCellValue('E' . $i, $row['harga_pokok'] * $row['stok'])
			;
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data Aset Persediaan.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function export_stok_outlet($id_outlet)
	{
		$stok = $this->stok_model->get_stok_barang($id_outlet);

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode Barang')
		->setCellValue('B1', 'Kode Outlet')
		->setCellValue('C1', 'Nama Barang')
		->setCellValue('D1', 'Stok')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($stok as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_barang'])
			->setCellValue('B' . $i, $row['id_outlet'])
			->setCellValue('C' . $i, $row['nama_barang'])
			->setCellValue('D' . $i, $row['stok'])
			;
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data Stok ' . $stok[0]['nama_outlet'] . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function import_stok()
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
				$this->db->set('stok', $sheetData[$i]['3']);
				$this->db->where('id_barang', $sheetData[$i]['0']);
				$this->db->where('id_outlet', $sheetData[$i]['1']);
				$this->db->update('stok_outlet');
			}

		}

		$this->session->set_flashdata('success', 'Di import');
		redirect('stok/barang?id_outlet=' . $sheetData[1]['1'],'refresh');
	}

}

/* End of file stok.php */
/* Location: ./application/modules/stok/controllers/stok.php */ ?>