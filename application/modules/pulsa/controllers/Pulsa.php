<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class pulsa extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('pulsa/pulsa_model');
		$this->load->model('outlet/outlet_model');
		$this->load->model('barang/barang_model');
	}

	public function get_pulsa_json()
	{
		header('Content-Type: application/json');
		echo $this->pulsa_model->get_pulsa_json();
	}

	public function get_riwayat_tambah_saldo_json()
	{
		header('Content-Type: application/json');
		echo $this->pulsa_model->get_riwayat_tambah_saldo_json();
	}

	public function riwayat()
	{
		$data['judul'] = "History Transaksi";
		$data['pulsa'] = $this->pulsa_model->get_pulsa();
		$data['outlet'] = $this->db->get_where('outlet')->row_array();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('pulsa/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function index()
	{
		$valid = $this->form_validation;
		$valid->set_rules('id_pulsa', 'id pulsa', 'required');
		$valid->set_rules('tgl', 'tgl', 'required');
		$valid->set_rules('id_outlet', 'outlet', 'required');
		$valid->set_rules('id_petugas', 'petugas', 'required');
		$valid->set_rules('saldo_awal', 'saldo awal', 'required');
		$valid->set_rules('harga_pulsa', 'harga pulsa', 'required');
		$valid->set_rules('saldo_akhir', 'saldo akhir', 'required');

		if ($valid->run()) {
			$this->pulsa_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('pulsa/riwayat','refresh');
		}

		$data['judul'] = "Transaksi Pulsa";

		$this->db->select('saldo_akhir');
		$this->db->order_by('tgl', 'desc');
		$saldo= $this->db->get('pulsa')->row();

		if ($saldo) {
			$data['saldo_awal'] = $saldo->saldo_akhir;
		}else{
			$data['saldo_awal'] = '';
		}

		$petugas = $this->session->userdata('id_outlet');

		if ($petugas) {
			$data['id_outlet'] = $petugas;
		}else{
			$data['id_outlet'] = $this->db->get('outlet')->row()->id_outlet;
		}

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('pulsa/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function hapus($id = '')
	{
		$this->pulsa_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('pulsa/riwayat','refresh');
	}

	public function ubah($id)
	{
		$valid = $this->form_validation;
		$valid->set_rules('id_pulsa', 'id pulsa', 'required');
		$valid->set_rules('tgl', 'tgl', 'required');
		$valid->set_rules('id_outlet', 'outlet', 'required');
		$valid->set_rules('id_petugas', 'petugas', 'required');
		$valid->set_rules('saldo_awal', 'saldo awal', 'required');
		$valid->set_rules('harga_pulsa', 'harga pulsa', 'required');
		$valid->set_rules('saldo_akhir', 'saldo akhir', 'required');

		if ($valid->run() == true) {
			$this->pulsa_model->update($this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('pulsa/riwayat','refresh');
		}

		$data['judul'] = "Ubah Transaksi Pulsa";
		$data['pulsa'] = $this->pulsa_model->get_pulsa($id);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('pulsa/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah_saldo()
	{
		$this->pulsa_model->tambah_saldo($this->input->post());
		$this->session->set_flashdata('success', 'diubah');
		redirect('pulsa/riwayat','refresh');
	}

	public function export()
	{
		$pulsa = $this->pulsa_model->get_pulsa();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode Transaksi')
		->setCellValue('B1', 'Tanggal')
		->setCellValue('C1', 'Nama Petugas')
		->setCellValue('D1', 'Nama Outlet')
		->setCellValue('E1', 'No Telepon')
		->setCellValue('F1', 'Saldo Awal')
		->setCellValue('G1', 'Harga Pulsa')
		->setCellValue('H1', 'Saldo Akhir')
		->setCellValue('I1', 'Keterangan')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($pulsa as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_pulsa'])
			->setCellValue('B' . $i, $row['tgl'])
			->setCellValue('C' . $i, $row['nama_petugas'])
			->setCellValue('D' . $i, $row['nama_outlet'])
			->setCellValue('E' . $i, $row['no_telepon'])
			->setCellValue('F' . $i, $row['saldo_awal'])
			->setCellValue('G' . $i, $row['harga_pulsa'])
			->setCellValue('H' . $i, $row['saldo_akhir'])
			->setCellValue('I' . $i, $row['keterangan']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Transakasi Pulsa.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}


}

/* End of file pulsa.php */
/* Location: ./application/modules/pulsa/controllers/pulsa.php */ ?>
