<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class barang extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->library('Pdf');
		$this->load->model('barang/barang_model');
		$this->load->model('kategori/kategori_model');
		$this->load->model('supplier/supplier_model');
    }
    
    public function get_all_qty($id_barang)
    {
        $this->db->select("qty_1, qty_2, qty_3, qty_4");
		$this->db->where('id_barang', $id_barang);
		$this->db->or_where('barcode', $id_barang);
        $qty = $this->db->get('barang')->row();

        echo json_encode($qty);
    }
    
    public function get_all_golongan($id_barang, $golongan)
    {
        $this->db->select($golongan);
		$this->db->where('id_barang', $id_barang);
		$this->db->or_where('barcode', $id_barang);
        $golongan = $this->db->get('barang')->row()->$golongan;

        echo json_encode($golongan);
    }

    public function get_brg($id_barang = '')
    {
    	if ($id_barang == '') {
    		echo "null";
    		die;
    	}
    	
        $this->db->where('id_barang', $id_barang);
        $this->db->or_where('barcode', $id_barang);
        $brg = $this->db->get('barang')->row_array();

        echo json_encode($brg);
    }

	public function get_barang_json()
	{
		header('Content-Type: application/json');
		echo $this->barang_model->get_barang_json();
	}

	public function get_harga_barang_json()
	{
		header('Content-Type: application/json');
		echo $this->barang_model->get_harga_barang_json();
	}

	public function get_barang_by_id($id_barang = '', $id_outlet = '')
	{
		$this->db->select('id_barang,nama_barang,barcode,stok_outlet.stok AS stok_komputer');
		$this->db->join('barang', 'id_barang');
		$this->db->join('outlet', 'id_outlet');
		if ($id_outlet != '') {
			$this->db->where('id_outlet', $id_outlet);
		}
		$this->db->where('id_barang', $id_barang);
		$this->db->or_where('barcode', $id_barang);
		echo json_encode($this->db->get('stok_outlet')->row_array());
	}

	public function get_barang_by_outlet_json($id_outlet)
	{
		header('Content-Type: application/json');
		echo $this->barang_model->get_barang_by_outlet_json($id_outlet);
	}

	public function get_barang($id, $golongan = 'golongan_1')
	{
		echo json_encode($this->barang_model->get_barang($id, $golongan));
	}

	public function get_barang_by_kategori($id = 'SEMUA', $golongan)
	{
		if ($id == 'SEMUA') {
			$this->db->select('gambar,nama_pendek,id_barang, ' . $golongan . ' AS harga_jual');
			$result = $this->db->get('barang')->result_array();
		}else{
			$this->db->select('gambar,nama_pendek,id_barang, ' . $golongan . ' AS harga_jual');
			$result = $this->db->get_where('barang', ['id_kategori' => $id])->result_array();
		}

		echo json_encode($result);
	}

	public function get_barang_by_name($name = '#####', $golongan = '')
	{
		$this->db->select('gambar,nama_pendek,id_barang, ' . $golongan . ' AS harga_jual');
		$this->db->like('nama_barang', urldecode($name));
		$this->db->or_like('nama_pendek', urldecode($name));
		$result = $this->db->get_where('barang')->result_array();

		echo json_encode($result);
	}

	public function get_barang_by_barcode($barcode = '#####', $golongan = '')
	{
		if ($golongan != '') {
			$this->db->select('gambar,nama_pendek,id_barang,' . $golongan . ' AS harga_jual');
		}
		$this->db->where('barcode', urldecode($barcode));
		$this->db->or_where('id_barang', urldecode($barcode));
		$result = $this->db->get_where('barang')->result_array();

		echo json_encode($result);
	}

	public function hapus($id)
	{
		$this->barang_model->delete($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('master/barang','refresh');
	}

	public function index()
	{
		$data['judul'] = "Data Barang";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('barang/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah()
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_barang', 'nama barang', 'required');
		$valid->set_rules('satuan', 'satuan', 'required');
		$valid->set_rules('id_kategori', 'kategori', 'required');
		$valid->set_rules('id_supplier', 'supplier', 'required');
		$valid->set_rules('harga_pokok', 'harga pokok', 'required');
		$valid->set_rules('id_barang', 'id barang', 'required');
		$valid->set_rules('nama_pendek', 'nama pendek', 'required');

		if ($valid->run()) {

			if ($this->db->get_where('barang', ['id_barang' => $this->input->post('id_barang')])->row_array()) {
				$this->session->set_flashdata('error', 'ID Barang Sudah Ada');
				redirect('master/tambah_barang','refresh');
			}

			$this->barang_model->insert($this->input->post());
			$this->session->set_flashdata('success', 'ditambah');
			redirect('master/barang','refresh');
		}

		$data['judul'] = "Tambah barang";
		$data['kategori'] = $this->kategori_model->get_kategori();
		$data['supplier'] = $this->supplier_model->get_supplier();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('barang/tambah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah($id)
	{
		$valid = $this->form_validation;
		$valid->set_rules('nama_barang', 'nama barang', 'required');
		$valid->set_rules('satuan', 'satuan', 'required');
		$valid->set_rules('id_kategori', 'kategori', 'required');
		$valid->set_rules('id_supplier', 'supplier', 'required');
		$valid->set_rules('harga_pokok', 'harga pokok', 'required');
		$valid->set_rules('id_barang', 'id_barang', 'required');
		$valid->set_rules('nama_pendek', 'nama pendek', 'required');

		if ($valid->run()) {
			$this->barang_model->update($id, $this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('master/barang','refresh');
		}

		$data['judul'] = "Ubah barang";
		$data['barang'] = $this->barang_model->get_barang($id);
		$data['kategori'] = $this->kategori_model->get_kategori();
		$data['supplier'] = $this->supplier_model->get_supplier();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('barang/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function export()
	{
        $barang = $this->barang_model->get_barang();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode barang')
		->setCellValue('B1', 'Kode Kategori')
		->setCellValue('C1', 'Kode Supplier')
		->setCellValue('D1', 'Satuan')
		->setCellValue('E1', 'Barcode')
		->setCellValue('F1', 'Nama Barang')
		->setCellValue('G1', 'Nama Pendek')
		->setCellValue('H1', 'Harga Pokok')
		->setCellValue('I1', 'Diskon')
		->setCellValue('J1', 'Stok')
		->setCellValue('K1', 'Golongan 1')
		->setCellValue('L1', 'Golongan 2')
		->setCellValue('M1', 'Golongan 3')
		->setCellValue('N1', 'Golongan 4')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($barang as $row) {

            $multi_outlet = $this->db->get('pengaturan')->row()->multi_outlet;
            if($multi_outlet == true) {
                $stok = $row['stok'];
            }else{
                $stok = $row['stok_outlet'];
            }

			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_barang'])
			->setCellValue('B' . $i, $row['id_kategori'])
			->setCellValue('C' . $i, $row['id_supplier'])
			->setCellValue('D' . $i, $row['satuan'])
			->setCellValue('E' . $i, $row['barcode'])
			->setCellValue('F' . $i, $row['nama_barang'])
			->setCellValue('G' . $i, $row['nama_pendek'])
			->setCellValue('H' . $i, $row['harga_pokok'])
			->setCellValue('I' . $i, $row['diskon'])
			->setCellValue('J' . $i, $stok)
			->setCellValue('K' . $i, $row['golongan_1'])
			->setCellValue('L' . $i, $row['golongan_2'])
			->setCellValue('M' . $i, $row['golongan_3'])
			->setCellValue('N' . $i, $row['golongan_4']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data barang.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function template()
	{
		$barang = $this->barang_model->get_barang();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode barang')
		->setCellValue('B1', 'Kode Kategori')
		->setCellValue('C1', 'Kode Supplier')
		->setCellValue('D1', 'Satuan')
		->setCellValue('E1', 'Barcode')
		->setCellValue('F1', 'Nama Barang')
		->setCellValue('G1', 'Nama Pendek')
		->setCellValue('H1', 'Harga Pokok')
		->setCellValue('I1', 'Diskon')
		->setCellValue('J1', 'Stok')
		->setCellValue('K1', 'Golongan 1')
		->setCellValue('L1', 'Golongan 2')
		->setCellValue('M1', 'Golongan 3')
		->setCellValue('N1', 'Golongan 4')
		->setCellValue('O1', 'Qty 1')
		->setCellValue('P1', 'Qty 2')
		->setCellValue('Q1', 'Qty 3')
		->setCellValue('R1', 'Qty 4')
		;                      

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data barang.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
    }

    public function autoNumber()
	{
		$barang = $this->barang_model->get_barang();
		$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'Kode barang');                      

        for ($i=1; $i < 32194; $i++) { 
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $i, 'BRG' . sprintf("%05s", $i));
        }

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Kode Barang.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
    }
    
    private function clean_rp($str)
    {
        $str = str_replace('Rp', '', $str);

        return $str;
    }

	public function import()
	{
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        set_time_limit(300);

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

                $gol_1 = (int) $this->clean_rp($sheetData[$i]['10']);
                $gol_2 = (int) $this->clean_rp($sheetData[$i]['11']);
                $gol_3 = (int) $this->clean_rp($sheetData[$i]['12']);
                $gol_4 = (int) $this->clean_rp($sheetData[$i]['13']);

                $harga_pokok = (int) $this->clean_rp($sheetData[$i]['7']) != '' ? $this->clean_rp($sheetData[$i]['7']) :  $this->clean_rp($sheetData[$i]['10']);

				$profit_1 = $gol_1 - $harga_pokok;
                $profit_2 = $gol_2 != 0 ? $gol_2 - $harga_pokok : 0;
				$profit_3 = $gol_3 != 0 ? $gol_3 - $harga_pokok : 0;
                $profit_4 = $gol_4 != 0 ? $gol_4 - $harga_pokok : 0;
                
                $qty_1 = $sheetData[$i]['14'];
                $qty_2 = $sheetData[$i]['15'] != '' ? $sheetData[$i]['15'] : 0;
                $qty_3 = $sheetData[$i]['16'] != '' ? $sheetData[$i]['16'] : 0;
                $qty_4 = $sheetData[$i]['17'] != '' ? $sheetData[$i]['17'] : 0;

				$data = [
					'id_barang' => $sheetData[$i]['0'],
					'id_kategori' => $sheetData[$i]['1'],
					'id_supplier' => $sheetData[$i]['2'],
					'satuan' => $sheetData[$i]['3'],
					'barcode' => $sheetData[$i]['4'],
					'nama_barang' => $sheetData[$i]['5'],
					'nama_pendek' => $sheetData[$i]['6'],
					'harga_pokok' => $harga_pokok,
					'diskon' => $sheetData[$i]['8'],
					'stok' => $sheetData[$i]['9'],
					'golongan_1' => $gol_1,
					'golongan_2' => $gol_2,
					'golongan_3' => $gol_3,
					'golongan_4' => $gol_4,
					'profit_1' => $profit_1,
					'profit_2' => $profit_2,
					'profit_3' => $profit_3,
					'profit_4' => $profit_4,
					'qty_1' => $qty_1,
					'qty_2' => $qty_2,
					'qty_3' => $qty_3,
					'qty_4' => $qty_4
				];

				$this->db->trans_start();

				$petugas = $this->session->userdata('id_outlet');

				if ($petugas) {
					$id_outlet = $petugas;
				}else{
					$id_outlet = $this->db->get('outlet')->row()->id_outlet;
				}

				$multi_outlet = $this->db->get('pengaturan')->row()->multi_outlet;
				$outlet = $this->db->get('outlet')->result_array();

				if ($multi_outlet == 0) {

					$petugas = $this->session->userdata('id_outlet');

					if ($petugas) {
						$id_outlet = $petugas;
					}else{
						$id_outlet = $this->db->get('outlet')->row()->id_outlet;
					}

					$datstok = [
						'id_barang' => $sheetData[$i]['0'],
						'id_outlet' => $id_outlet,
						'stok' => $sheetData[$i]['9']
					];

					$this->db->where('id_barang', $sheetData[$i]['0']);
					$this->db->where('id_outlet', $id_outlet);
					$cek_outlet = $this->db->get('stok_outlet')->row_array();

					if ($cek_outlet) {
						$this->db->set('stok', $sheetData[$i]['9']);
						$this->db->where('id_barang', $sheetData[$i]['0']);
						$this->db->where('id_outlet', $id_outlet);
						$this->db->update('stok_outlet');
					}else{
						$this->db->insert('stok_outlet', $datstok);
					}
					
					$data['stok'] = 0;
				}else{

					foreach ($outlet as $row) {

						$this->db->where('id_barang', $sheetData[$i]['0']);
						$this->db->where('id_outlet', $row['id_outlet']);
						$cek_outlet = $this->db->get('stok_outlet')->row_array();

						if (!$cek_outlet) {
							$datstok = [
								'id_barang' => $sheetData[$i]['0'],
								'id_outlet' => $row['id_outlet'],
								'stok' => 0
							];
							$this->db->insert('stok_outlet', $datstok);
						}
					}

					$data['stok'] = $sheetData[$i]['9'];
				}

				if ($this->db->get_where('barang', ['id_barang' => $sheetData[$i]['0']])->row_array()) {
					$this->db->where('id_barang', $sheetData[$i]['0']);
					$this->db->update('barang', $data);
				}else{
					$this->db->insert('barang', $data);
				}

				$this->db->trans_complete();
			}
		}
		$this->session->set_flashdata('success', 'Di import');
		redirect('master/barang','refresh');
	}

	public function hapus_semua()
	{
		$this->db->query('DELETE FROM barang');
		$this->db->query('DELETE FROM stok_outlet');
		$this->session->set_flashdata('success', 'Di dihapus');
		redirect('master/barang','refresh');
	}

	public function get_barcode($id_barang)
	{
		$data['barang'] = $this->barang_model->get_barang($id_barang);
        $this->load->library('pdf');

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "barcode.pdf";
        
		$this->load->view('barang/get_barcode', $data);
	}

	public function generate_barcode()
	{
		$barang = $this->barang_model->get_barang();
		$data['barcode'] = [];
		
		$counter = 1;
		foreach ($barang as $row) {
			$data['barcode'][$counter]['nama'] = $row['nama_barang'];
			$data['barcode'][$counter]['barcode'] = $row['barcode'];
			$counter++;
		}

		$this->load->view('barang/generate_barcode', $data);
	}

}

/* End of file barang.php */
/* Location: ./application/modules/barang/controllers/barang.php */ ?>
