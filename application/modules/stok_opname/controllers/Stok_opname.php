<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class stok_opname extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('stok_opname/stok_opname_model');
		$this->load->model('outlet/outlet_model');
		$this->load->model('barang/barang_model');
	}
	
	public function index()
	{
		$data['judul'] = "Stok Opname";
		$data['stok_opname'] = $this->stok_opname_model->get_stok_opname();
		$data['outlet'] = $this->db->get_where('outlet')->row_array();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('stok_opname/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah_stok_opname()
	{
		$valid = $this->form_validation;
		$valid->set_rules('id_stok_opname', 'id stok_opname', 'required');
		$valid->set_rules('id_outlet', 'outlet', 'required');
		$valid->set_rules('id_petugas', 'petugas', 'required');

		if ($valid->run()) {
			$this->stok_opname_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('stok_opname','refresh');
		}

		$data['judul'] = "Tambah Stok Opname";
		$data['nama_outlet'] = $this->db->get_where('outlet', ['id_outlet' => $this->input->get('id_outlet')])->row_array()['nama_outlet'];
		$data['outlet'] = $this->outlet_model->get_outlet();

		if ($id_outlet = $this->input->get('id_outlet')) {
			$id_itl =  $id_outlet;
		}else{
			$id_itl = $this->db->get('outlet')->row()->id_outlet;
		}

		$this->db->select('*, stok_outlet.stok');
		$this->db->join('barang', 'id_barang');
		$this->db->where('id_outlet', $id_itl);
		$data['stok'] = $this->db->get('stok_outlet')->result_array();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('stok_opname/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function hapus($id = '')
	{
		$this->stok_opname_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('stok_opname','refresh');
	}

	public function ubah($id)
	{
		$valid = $this->form_validation;
		$valid->set_rules('id_stok_opname', 'id stok_opname', 'required');
		$valid->set_rules('id_outlet', 'outlet', 'required');
		$valid->set_rules('id_petugas', 'petugas', 'required');

		if ($valid->run() == true) {
			$this->stok_opname_model->update($this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('stok_opname','refresh');
		}

		$data['judul'] = "Ubah Stok Opname";
		$data['stok_opname'] = $this->stok_opname_model->get_stok_opname($id);

						$this->db->join('detail_stok_opname', 'id_stok_opname', 'left');
						$this->db->join('barang', 'id_barang');
						$this->db->where('id_outlet', $data['stok_opname']['id_outlet']);
						$this->db->where('id_stok_opname', $data['stok_opname']['id_stok_opname']);
		$data['stok'] = $this->db->get('stok_opname')->result_array();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('stok_opname/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function export()
	{
		$stok_opname = $this->stok_opname_model->get_stok_opname();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode SO')
		->setCellValue('B1', 'Tanggal')
		->setCellValue('C1', 'Petugas')
		->setCellValue('D1', 'Outet')
		->setCellValue('E1', 'Keterangan')
		->setCellValue('F1', 'Total Kerugian')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($stok_opname as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_stok_opname'])
			->setCellValue('B' . $i, $row['tgl'])
			->setCellValue('C' . $i, $row['nama_petugas'])
			->setCellValue('D' . $i, $row['nama_outlet'])
			->setCellValue('E' . $i, $row['keterangan'])
			->setCellValue('F' . $i, $row['total_kerugian']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Stock Opname.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
    }
    
	public function export_excel($id)
	{
		$stok_opname = $this->stok_opname_model->get_stok_opname($id);

						$this->db->select('*,' . $stok_opname['golongan'] . ' AS harga_jual');
						$this->db->join('detail_stok_opname', 'id_stok_opname');
						$this->db->join('barang', 'id_barang');
						$this->db->where('id_outlet', $stok_opname['id_outlet']);
						$this->db->where('id_stok_opname', $id);
		$stok = $this->db->get('stok_opname')->result_array();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode Barang')
		->setCellValue('B1', 'Nama Barang')
		->setCellValue('C1', 'Harga Jual')
		->setCellValue('D1', 'Stok Komputer')
		->setCellValue('E1', 'Stok Fisik')
		->setCellValue('F1', 'Selisih')
		->setCellValue('G1', 'Kerugian')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($stok as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_barang'])
			->setCellValue('B' . $i, $row['nama_barang'])
			->setCellValue('C' . $i, $row['harga_jual'])
			->setCellValue('D' . $i, $row['stok_komputer'])
			->setCellValue('E' . $i, $row['stok_fisik'])
			->setCellValue('F' . $i, $row['selisih'])
			->setCellValue('G' . $i, $row['kerugian']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Stock Opname ' . $stok_opname['tgl'] . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}


}

/* End of file stok_opname.php */
/* Location: ./application/modules/stok_opname/controllers/stok_opname.php */ ?>
