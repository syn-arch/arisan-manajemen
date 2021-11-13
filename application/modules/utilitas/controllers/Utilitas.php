<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require ('./vendor/autoload.php');

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class utilitas extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('barang/barang_model');
		cek_login();
	}

	public function backup()
	{
		$data['judul'] = "Backup Database";
		$data['db'] = $this->db->get('backup')->result_array();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('utilitas/backup', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function backup_db()
	{
		//load helpers
		$this->load->helper('file');

		//load database
		$this->load->dbutil();

		$dbname = 'db-backup-on-' . date("Y-m-d-H-i-s");
		$this->db->insert('backup', ['file' => $dbname]);
		
		$prefs = array(
			'format' => 'txt',
			'filename' => 'epos_db_backup.sql'
		);
		$back = $this->dbutil->backup($prefs);
		$backup =& $back;
		$save='./assets/db_backup/'.$dbname.'.txt';
		$this->load->helper('file');
		write_file($save, $backup);

		// redirect
		$this->session->set_flashdata('success', 'dibackup');
		redirect('utilitas/backup','refresh');
	}

	public function hapus($id)
	{
		$backup = $this->db->get_where('backup', ['id_backup' => $id])->row_array()['file'];
		unlink(FCPATH . 'assets/db_backup/' . $backup . '.txt');
		$this->db->delete('backup',['id_backup' => $id]);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('utilitas/backup','refresh');
	}

	public function download_db($name)
	{
		$this->load->helper('download');
		force_download($name . '.txt', file_get_contents(base_url('assets/db_backup/' .  $name . '.txt')));
	}

	public function buka_laci()
	{
		$pengaturan = $this->db->get('pengaturan')->row_array();

		$connector = new WindowsPrintConnector($pengaturan['nama_printer']);
		$printer = new Printer($connector);
		$printer -> pulse();
		$printer -> close();
	}

	function restore_db($db) {

		$file = file_get_contents(base_url('assets/db_backup/' .  $db . '.txt'));
		$this->db->conn_id->multi_query($file);
		$this->db->conn_id->close();

		$this->session->set_flashdata('success', 'direstore');
		redirect('auth/logout');
	}

	public function sinkronisasi_database()
	{
		$data['judul'] = "Sinkronisasi Database";
		$data['url_server'] = $this->db->get('pengaturan')->row()->url_server;

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('utilitas/sinkronisasi_database', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function update_url()
	{
		$this->db->set('url_server', $this->input->post('url_server'));
		$this->db->update('pengaturan');

		$this->session->set_flashdata('success', 'diubah');
		redirect('utilitas/sinkronisasi_database','refresh');
	}

	public function cetak_label()
	{
		$data['judul'] = "Cetak Label";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('utilitas/cetak_label', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function print_label1()
	{
		if (!$this->input->post()) {
			redirect('utilitas/cetak_label','refresh');
		}
		$data['barcode'] = $this->input->post();

		$this->load->view('utilitas/cetak_label_print', $data, FALSE);
	}

	public function print_semua()
	{
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Barcode')
		->setCellValue('B1', 'Nama Barang')
		->setCellValue('C1', 'Harga')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($this->db->get('barang')->result_array() as $row) {
		    
		    
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['barcode'])
			->setCellValue('B' . $i, $row['nama_barang'])
			->setCellValue('C' . $i, "Rp. " . number_format($row['golongan_1']) );
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data barang.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	

	
	public function print_label()
	{
	    $barcode = $this->input->post('barcode');
	    
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Barcode')
		->setCellValue('B1', 'Nama Barang')
		->setCellValue('C1', 'Harga')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($barcode as $row) {
		    
		    $barang = $this->db->get_where('barang', ['barcode' => $row] )->row_array();
		    
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $barang['barcode'])
			->setCellValue('B' . $i, $barang['nama_barang'])
			->setCellValue('C' . $i, "Rp. " . number_format($barang['golongan_1']) );
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data barang.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	

}

/* End of file utilitas.php */
/* Location: ./application/modules/utilitas/controllers/utilitas.php */ ?>