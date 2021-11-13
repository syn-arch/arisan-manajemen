<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class laporan extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('laporan/laporan_model');
		$this->load->model('outlet/outlet_model');
		$this->load->model('kelompok/kelompok_model');
		$this->load->model('agen/agen_model');
		$this->load->library('Pdf');

		$pengaturan = $this->db->get('pengaturan')->row();

		if ($pengaturan->hapus_riwayat_penjualan_otomatis == 1) {
			if ($sesuaikan_penjualan = $pengaturan->lama_hari_penjualan != 'Sesuaikan') {
				$hari_penjualan = $sesuaikan_penjualan;
			}else{
				$hari_penjualan = $pengaturan->sesuaikan_hari_penjualan;
			}
			$penjualan = $this->db->query("SELECT * FROM penjualan WHERE DATEDIFF(CURDATE(), DATE(tgl)) >= '$hari_penjualan' ")->result_array();

			if ($penjualan) {
				foreach ($penjualan as $row) {
					$this->db->delete('penjualan', ['faktur_penjualan' => $row['faktur_penjualan']]);
					$this->db->delete('detail_penjualan', ['faktur_penjualan' => $row['faktur_penjualan']]);
					$this->db->delete('pembayaran', ['faktur_penjualan' => $row['faktur_penjualan']]);
				}		
			}
		}

		if ($pengaturan->hapus_riwayat_pembelian_otomatis == 1) {
			if ($sesuaikan_pembelian = $pengaturan->lama_hari_pembelian != 'Sesuaikan') {
				$hari_pembelian = $sesuaikan_pembelian;
			}else{
				$hari_pembelian = $pengaturan->sesuaikan_hari_pembelian;
			}
			$pembelian = $this->db->query("SELECT * FROM pembelian WHERE DATEDIFF(CURDATE(), DATE(tgl)) >= '$hari_pembelian' ")->result_array();

			if ($pembelian) {
				foreach ($pembelian as $row) {
					$this->db->delete('pembelian', ['faktur_pembelian' => $row['faktur_pembelian']]);
					$this->db->delete('detail_pembelian', ['faktur_pembelian' => $row['faktur_pembelian']]);
					$this->db->delete('pembayaran_pembelian', ['faktur_pembelian' => $row['faktur_pembelian']]);
				}		
			}
		}

	}

	public function hapus_bulk_riwayat_penjualan()
	{
		foreach($_POST["faktur_penjualan"] as $id)
		{
			$this->db->delete('detail_penjualan', ['faktur_penjualan' => $id]);
			$this->db->delete('penjualan', ['faktur_penjualan' => $id]);
			$this->db->delete('pembayaran', ['faktur_penjualan' => $id]);
		}
	}

	public function hapus_bulk_riwayat_pembelian()
	{
		foreach($_POST["faktur_pembelian"] as $id)
		{
			$this->db->delete('detail_pembelian', ['faktur_pembelian' => $id]);
			$this->db->delete('pembayaran_pembelian', ['faktur_pembelian' => $id]);
			$this->db->delete('pembelian', ['faktur_pembelian' => $id]);
		}
	}

	public function get_riwayat_penjualan_json($dari = '', $sampai = '', $id_outlet = '')
	{
		header('Content-Type: application/json');
		echo $this->laporan_model->get_laporan_penjualan_json($dari, $sampai, $id_outlet);
	}

	public function get_riwayat_pembelian_json()
	{
		header('Content-Type: application/json');
		echo $this->laporan_model->get_laporan_pembelian_json();
	}

	public function get_riwayat_pengembalian_json()
	{
		header('Content-Type: application/json');
		echo $this->laporan_model->get_riwayat_pengembalian_json();
	}

	public function ubah_status_pengembalian()
	{
		$status = $this->input->post('status');
		$faktur_pengembalian = $this->input->post('faktur_pengembalian');

		$this->db->set('status', $status);
		$this->db->where('faktur_pengembalian', $faktur_pengembalian);
		$this->db->update('pengembalian');

	}

	public function riwayat_penjualan()
	{
		$data['judul'] = "Riwayat Penjualan";
		$data['outlet'] = $this->outlet_model->get_outlet();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/riwayat_penjualan', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function riwayat_pengembalian()
	{
		$data['judul'] = "Riwayat Pengembalian";
		$data['total_kerugian'] = $this->laporan_model->total_kerugian();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/riwayat_pengembalian', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function hapus_penjualan($id)
	{
		$this->laporan_model->delete_penjualan($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('penjualan/riwayat_penjualan','refresh');
	}

	public function hapus_pengembalian($id)
	{
		$this->laporan_model->delete_pengembalian($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('laporan/riwayat_pengembalian','refresh');
	}

	public function riwayat_pembelian()
	{
		$data['judul'] = "Riwayat Pembelian";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/riwayat_pembelian', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function hapus_pembelian($id)
	{
		$this->laporan_model->delete_pembelian($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('laporan/riwayat_pembelian','refresh');
	}

	public function penjualan()
	{
		$data['judul'] = "Laporan Penjualan";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/penjualan', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function pengembalian()
	{
		$data['judul'] = "Laporan Pengembalian";
		$data['laporan'] = $this->laporan_model->get_all_pengembalian();
		$data['total_pengembalian'] = $this->laporan_model->get_total_pengembalian();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/pengembalian', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function per_barang()
	{

		$dari = $this->input->get('dari');

		if ($dari != '') {
			$sampai = $this->input->get('sampai');
			$id_outlet = $this->input->get('id_outlet');
			$golongan = $this->input->get('golongan');
			$data['golongan'] = $golongan;
			$data['judul'] = "Laporan Per Barang Barang " . str_replace('_', ' ', $golongan);
			$data['laporan'] = $this->laporan_model->get_penjualan_per_barang($golongan, $dari, $sampai, $id_outlet);

			$data['pendapatan_1'] = $this->laporan_model->get_total_pendapatan('golongan_1', $dari, $sampai, $id_outlet);
			$data['laba_1'] = $this->laporan_model->get_total_laba('golongan_1', $dari, $sampai, $id_outlet);
			$data['pendapatan_2'] = $this->laporan_model->get_total_pendapatan('golongan_2', $dari, $sampai, $id_outlet);
			$data['laba_2'] = $this->laporan_model->get_total_laba('golongan_2', $dari, $sampai, $id_outlet);
			$data['pendapatan_3'] = $this->laporan_model->get_total_pendapatan('golongan_3', $dari, $sampai, $id_outlet);
			$data['laba_3'] = $this->laporan_model->get_total_laba('golongan_3', $dari, $sampai, $id_outlet);
			$data['pendapatan_4'] = $this->laporan_model->get_total_pendapatan('golongan_4', $dari, $sampai, $id_outlet);
			$data['laba_4'] = $this->laporan_model->get_total_laba('golongan_4', $dari, $sampai, $id_outlet);

			$data['pengeluaran'] = $this->laporan_model->get_pengeluaran($dari, $sampai, $id_outlet);
			$data['pemasukan'] = $this->laporan_model->get_pemasukan($dari, $sampai, $id_outlet);

			$data['dari'] = $dari;
			$data['sampai'] = $sampai;
			$data['id_outlet'] = $id_outlet;
		}else{
			$golongan = 'golongan_1';
			$data['golongan'] = $golongan;
			$data['judul'] = "Laporan Per Barang Barang golongan 1";
			$data['laporan'] = $this->laporan_model->get_penjualan_per_barang($golongan);

			$data['pendapatan_1'] = $this->laporan_model->get_total_pendapatan('golongan_1');
			$data['laba_1'] = $this->laporan_model->get_total_laba('golongan_1');
			$data['pendapatan_2'] = $this->laporan_model->get_total_pendapatan('golongan_2');
			$data['laba_2'] = $this->laporan_model->get_total_laba('golongan_2');
			$data['pendapatan_3'] = $this->laporan_model->get_total_pendapatan('golongan_3');
			$data['laba_3'] = $this->laporan_model->get_total_laba('golongan_3');
			$data['pendapatan_4'] = $this->laporan_model->get_total_pendapatan('golongan_4');
			$data['laba_4'] = $this->laporan_model->get_total_laba('golongan_4');

			$data['dari'] = '';
			$data['sampai'] = '';
			$data['id_outlet'] = '';
		}

		$data['outlet'] = $this->outlet_model->get_outlet();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/per_barang', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function paling_banyak_dijual()
	{
		$dari = $this->input->get('dari');
		$sampai = $this->input->get('sampai');
		$id_outlet = $this->input->get('id_outlet');
		$data['outlet'] = $this->outlet_model->get_outlet();

		if ($dari != '') {
			$data['laporan'] = $this->laporan_model->get_paling_banyak_dijual($dari,$sampai,$id_outlet);
		}else{
			$data['laporan'] = $this->laporan_model->get_paling_banyak_dijual();
		}

		$data['judul'] = "Laporan Barang Paling Banyak Dijual";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/paling_banyak_dijual', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function paling_sering_dijual()
	{
		$dari = $this->input->get('dari');
		$sampai = $this->input->get('sampai');
		$id_outlet = $this->input->get('id_outlet');
		$data['outlet'] = $this->outlet_model->get_outlet();

		if ($dari != '') {
			$data['laporan'] = $this->laporan_model->get_paling_sering_dijual($dari,$sampai,$id_outlet);
		}else{
			$data['laporan'] = $this->laporan_model->get_paling_sering_dijual();
		}

		$data['judul'] = "Laporan Barang Paling Sering Dijual";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/paling_sering_dijual', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function per_kasir()
	{
		$dari = $this->input->get('dari');
		$sampai = $this->input->get('sampai');

		if ($dari != '') {
			$data['laporan'] = $this->laporan_model->get_per_kasir($dari,$sampai,$id_outlet);
		}else{
			$data['laporan'] = $this->laporan_model->get_per_kasir();
		}

		$data['judul'] = "Laporan Per kasir";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/per_kasir', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function per_karyawan()
	{
		$dari = $this->input->get('dari');
		$sampai = $this->input->get('sampai');

		if ($dari != '') {
			$data['laporan'] = $this->laporan_model->get_per_karyawan($dari,$sampai);
		}else{
			$data['laporan'] = $this->laporan_model->get_per_karyawan();
		}

		$data['judul'] = "Laporan Per karyawan";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/per_karyawan', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function per_kategori()
	{
		$dari = $this->input->get('dari');
		$sampai = $this->input->get('sampai');
		$id_outlet = $this->input->get('id_outlet');
		$data['outlet'] = $this->outlet_model->get_outlet();

		if ($dari != '') {
			$data['laporan'] = $this->laporan_model->get_per_kategori($dari,$sampai,$id_outlet);
		}else{
			$data['laporan'] = $this->laporan_model->get_per_kategori();
		}

		$data['judul'] = "Laporan Per kategori";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/per_kategori', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function per_pelanggan()
	{
		$dari = $this->input->get('dari');
		$sampai = $this->input->get('sampai');
		$id_outlet = $this->input->get('id_outlet');
		$data['outlet'] = $this->outlet_model->get_outlet();

		if ($dari != '') {
			$data['laporan'] = $this->laporan_model->get_per_pelanggan($dari,$sampai,$id_outlet);
		}else{
			$data['laporan'] = $this->laporan_model->get_per_pelanggan();
		}

		$data['judul'] = "Laporan Per Pelanggan";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/per_pelanggan', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function per_jenis_pelanggan()
	{
		$dari = $this->input->get('dari');
		$sampai = $this->input->get('sampai');
		$id_outlet = $this->input->get('id_outlet');
		$data['outlet'] = $this->outlet_model->get_outlet();

		if ($dari != '') {
			$data['laporan'] = $this->laporan_model->get_per_jenis_pelanggan($dari,$sampai,$id_outlet);
		}else{
			$data['laporan'] = $this->laporan_model->get_per_jenis_pelanggan();
		}

		$data['judul'] = "Laporan Per jenis pelanggan";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/per_jenis_pelanggan', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function per_supplier()
	{
		$dari = $this->input->get('dari');
		$sampai = $this->input->get('sampai');
		$id_outlet = $this->input->get('id_outlet');
		$data['outlet'] = $this->outlet_model->get_outlet();

		if ($dari != '') {
			$data['laporan'] = $this->laporan_model->get_per_supplier($dari,$sampai,$id_outlet);
		}else{
			$data['laporan'] = $this->laporan_model->get_per_supplier();
		}

		$data['judul'] = "Laporan Per Supplier";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/per_supplier', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function pembelian()
	{
		$dari = $this->input->get('dari');
		$sampai = $this->input->get('sampai');

		if ($dari != '') {
			$data['laporan'] = $this->laporan_model->get_all_pembelian($dari,$sampai);
			$data['total_pembelian'] = $this->laporan_model->get_total_pembelian($dari,$sampai);
		}else{
			$data['laporan'] = $this->laporan_model->get_all_pembelian();
			$data['total_pembelian'] = $this->laporan_model->get_total_pembelian();
		}

		$data['judul'] = "Laporan Pembelian";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/pembelian', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function hutang()
	{
		$data['judul'] = "Laporan Hutang";
		$data['laporan'] = $this->laporan_model->get_all_hutang();
		$data['total_hutang'] = $this->laporan_model->get_total_hutang();
		$data['telah_dibayar'] = $this->laporan_model->get_telah_dibayar();
		$data['sisa_hutang'] = $this->laporan_model->get_sisa_hutang();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/hutang', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function piutang()
	{
		$data['judul'] = "Laporan Piutang";
		$data['laporan'] = $this->laporan_model->get_all_piutang();
		$data['total_piutang'] = $this->laporan_model->get_total_piutang();
		$data['telah_dibayar'] = $this->laporan_model->get_telah_dibayar_piutang();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/piutang', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function register()
	{
		$data['judul'] = "Laporan Register";
		$data['laporan'] = $this->laporan_model->get_register();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/register', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function cetak_register($id = '')
	{
		$data['judul'] = "Cetak Register";
		if ($id == '') {
			$id_petugas = $this->session->userdata('id_petugas');
			$id = $this->db->get_where('register', ['status' => 'open', 'id_petugas' => $id_petugas])->row_array()['id_register'];
		}
		$data['register'] = $this->laporan_model->get_register($id);
		$data['keuangan'] = $this->laporan_model->get_total_keuangan();

		$this->load->view('laporan/cetak_register', $data, FALSE);
	}

	public function cetak_thermal_pemasukan($id = '')
	{
		$data['judul'] = "Cetak Pemasukan";

		$this->load->view('laporan/cetak_thermal_pemasukan', $data, FALSE);
	}

	public function cetak_thermal_pengeluaran($id = '')
	{
		$data['judul'] = "Cetak Pengeluaran";

		$this->load->view('laporan/cetak_thermal_pengeluaran', $data, FALSE);
	}

	public function hapus_register($id)
	{
		$this->laporan_model->delete_register($id);
		$this->session->set_flashdata('success', 'dihapus');
		redirect('laporan/register','refresh');
	}

	public function omset()
	{
		$dari = $this->input->get('dari');
		$sampai = $this->input->get('sampai');
		$id_outlet = $this->input->get('id_outlet');
		
		$data['omset'] = $this->laporan_model->get_omset($dari,$sampai,$id_outlet);
		$data['qty'] = $this->laporan_model->get_qty_beli($dari,$sampai,$id_outlet);

		$data['judul'] = "Laporan Omset";
		$data['outlet'] = $this->outlet_model->get_outlet();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/omset', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function laba_rugi()
	{
		$dari = $this->input->get('dari');
		$sampai = $this->input->get('sampai');
		$id_outlet = $this->input->get('id_outlet');

		if ($dari != '') {
			$data['laba_rugi'] = $this->laporan_model->get_laba_rugi($dari,$sampai,$id_outlet);
			$data['pendapatan'] = $this->laporan_model->get_pendapatan($dari,$sampai,$id_outlet);
			$data['potongan'] = $this->laporan_model->get_potongan($dari,$sampai,$id_outlet);
			$data['pendapatan_bersih'] = $this->laporan_model->get_pendapatan($dari,$sampai,$id_outlet, true);
			$data['harga_pokok'] = $this->laporan_model->get_pendapatan_bersih($dari,$sampai,$id_outlet);
			$data['pemasukan'] = $this->laporan_model->get_pemasukan($dari,$sampai,$id_outlet);
			$data['pengeluaran'] = $this->laporan_model->get_pengeluaran($dari,$sampai,$id_outlet);
			$data['detail_pengeluaran'] = $this->laporan_model->get_detail_pengeluaran($dari,$sampai,$id_outlet);
			$data['detail_pemasukan'] = $this->laporan_model->get_detail_pemasukan($dari,$sampai,$id_outlet);
		}
		
		$data['judul'] = "Laporan Laba Rugi";
		$data['outlet'] = $this->outlet_model->get_outlet();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/laba_rugi', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function cetak_laba_rugi($dari, $sampai, $id_outlet = '')
	{

		if ($dari != '') {
			$data['laba_rugi'] = $this->laporan_model->get_laba_rugi($dari,$sampai,$id_outlet);
			$data['pendapatan'] = $this->laporan_model->get_pendapatan($dari,$sampai,$id_outlet);
			$data['potongan'] = $this->laporan_model->get_potongan($dari,$sampai,$id_outlet);
			$data['pendapatan_bersih'] = $this->laporan_model->get_pendapatan($dari,$sampai,$id_outlet, true);
			$data['harga_pokok'] = $this->laporan_model->get_pendapatan_bersih($dari,$sampai,$id_outlet);
			$data['pemasukan'] = $this->laporan_model->get_pemasukan($dari,$sampai,$id_outlet);
			$data['pengeluaran'] = $this->laporan_model->get_pengeluaran($dari,$sampai,$id_outlet);
			$data['detail_pengeluaran'] = $this->laporan_model->get_detail_pengeluaran($dari,$sampai,$id_outlet);
			$data['detail_pemasukan'] = $this->laporan_model->get_detail_pemasukan($dari,$sampai,$id_outlet);
		}
		
		$data['judul'] = "Laporan Laba Rugi";

		if ($id_outlet != '') {
			$data['outlet'] = $this->outlet_model->get_outlet($id_outlet);
		}


		$this->load->view('laporan/cetak_laba_rugi', $data, FALSE);
	}

	public function kelompok()
	{
		$id_agen = $this->input->get('id_agen');

		if ($id_agen != '') {
			$data['kelompok'] = $this->laporan_model->get_kelompok($id_agen);
		}
		
		$data['judul'] = "Laporan Kelompok";
		$data['agen'] = $this->agen_model->get_agen();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('laporan/kelompok', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function cetak_thermal_register($id = '')
	{
		$data['judul'] = "Laporan Register";

		if ($id == '') {
			$id_petugas = $this->session->userdata('id_petugas');
			$this->db->order_by('id_register', 'desc');
			$id_regist = $this->db->get_where('register', ['status' => 'open', 'id_petugas' => $id_petugas])->row_array()['id_register'];
		}else{
			$id_regist = $id;
		}

		$this->db->join('petugas', 'id_petugas');
		$this->db->join('outlet', 'register.id_outlet=outlet.id_outlet', 'left');
		$this->db->where('id_register', $id_regist);
		$register =$this->db->get('register')->row_array();

		$pengaturan = $this->db->get('pengaturan')->row_array();

		$this->db->select_sum('total_uang', 'total');
		$this->db->where('DAY(mulai)', date('d'));
		$this->db->where('status', 'close');
		$tarik = $this->db->get('register')->row()->total;

		$this->db->select_sum('total_bayar', 'total');
		$this->db->where('piutang', 0);
		$this->db->where('status !=', 'Hold');
		$this->db->where('DATE(penjualan.tgl)', date('Y-m-d'));
		$penjualan = $this->db->get('penjualan')->row_array()['total'];

		$this->db->select_sum('nominal', 'total');
		$this->db->where('DATE(pembayaran.tgl)', date('Y-m-d'));
		$this->db->where('piutang', 1);
		$this->db->join('penjualan', 'faktur_penjualan');
		$this->db->where('status !=', 'Hold');
		$piutang = $this->db->get('pembayaran')->row_array()['total'];

		$this->db->select_sum('total_bayar', 'total');
		$pemasukan = $this->db->get_where('biaya', ['DATE(tgl)' => date('Y-m-d'), 'status' => 'PEMASUKAN'])->row()->total;

		$this->db->select_sum('total_bayar', 'total');
		$pengeluaran = $this->db->get_where('biaya', ['DATE(tgl)' => date('Y-m-d'), 'status' => 'PENGELUARAN'])->row()->total;

		$saldo_akhir = $register['uang_awal'] + $penjualan + $piutang + $pemasukan - $pengeluaran;

		if ($id_outlet = $this->session->userdata('id_outlet')) {
			$outlet = $this->db->get_where('outlet', ['id_outlet' => $id_outlet])->row_array();
		}else{
			$outlet = $this->db->get('outlet')->row_array();
		}	

		try {

			$connector = new WindowsPrintConnector($pengaturan['nama_printer']);

			$printer = new Printer($connector);
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> text($outlet['nama_outlet'] ."\n");
			$printer -> text($outlet['alamat'] . "\n");
			$printer -> text("---------------------------------------\n");
			$printer -> text("LAPORAN REGISTER\n");
			$printer -> text("---------------------------------------\n");
			$printer -> setJustification(Printer::JUSTIFY_LEFT);
			$printer -> text("Nama Petugas    : " . $register['nama_petugas'] ."\n");
			$printer -> text("Nama Outlet     : " . $register['nama_outlet'] ."\n");
			$printer -> text("Tgl Mulai       : " . date('d-m-Y H:i:s', strtotime($register['mulai'])) ."\n");
			if ($register['total_uang'] == 0) {
				$printer -> text("Tgl Selesai     : \n");
			}else{
				$printer -> text("Tgl Selesai     : " . date('d-m-Y H:i:s', strtotime($register['berakhir'])) ."\n");
			}
			$printer -> text("Saldo Awal      : " . number_format($register['uang_awal']) ."\n");
			if ($register['total_uang'] == 0) {
				$printer -> text("Penjualan       : " . number_format($penjualan) ."\n");
				$printer -> text("Pemasukan       : " . number_format($pemasukan) ."\n");
				$printer -> text("Piutang         : " . number_format($piutang) ."\n");
				$printer -> text("Pengeluaran     : " . number_format($pengeluaran) ."\n");
				$printer -> text("Saldo Akhir     : " . number_format($saldo_akhir) ."\n");
			}else{
				$printer -> text("Penjualan       : " . number_format($register['penjualan']) ."\n");
				$printer -> text("Pemasukan       : " . number_format($register['pemasukan']) ."\n");
				$printer -> text("Piutang         : " . number_format($register['piutang']) ."\n");
				$printer -> text("Pengeluaran     : " . number_format($register['pengeluaran']) ."\n");
				$printer -> text("Saldo Akhir     : " . number_format($register['total_uang']) ."\n");
			}
			$printer -> text("---------------------------------------\n");
			$printer -> cut();
			$printer -> close();

			redirect('laporan/register','refresh');

		} catch (Exception $e) {
			echo "Error: " . $e -> getMessage() . "\n";
		}
	}

	public function thermal_pengeluaran($id = '')
	{
		$pengeluaran = $this->db->get_where('biaya', ['DATE(tgl)' => date('Y-m-d'), 'status' => 'PENGELUARAN'])->result_array();

		if ($id_outlet = $this->session->userdata('id_outlet')) {
			$outlet = $this->db->get_where('outlet', ['id_outlet' => $id_outlet])->row_array();
		}else{
			$outlet = $this->db->get('outlet')->row_array();
		}	

		$pengaturan = $this->db->get('pengaturan')->row_array();

		try {

			$connector = new WindowsPrintConnector($pengaturan['nama_printer']);

			$printer = new Printer($connector);
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> text($outlet['nama_outlet'] ."\n");
			$printer -> text($outlet['alamat'] . "\n");
			$printer -> text("----------------------------------------\n");
			$printer -> text("LAPORAN PENGELUARAN HARI INI\n");
			$printer -> text("----------------------------------------\n");
			$printer -> setJustification(Printer::JUSTIFY_LEFT);
			$printer -> text("No   Keterangan         Jumlah\n");
			foreach ($pengeluaran as $index => $row) {
				$no = $index += 1;
				$ket = $row['keterangan_biaya'];
				$total = number_format($row['total_bayar']);
				$printer -> text("{$no}    {$ket}         {$total}\n");
			}
			$printer -> text("----------------------------------------\n");
			$printer -> cut();
			$printer -> close();

			redirect('penjualan/cetak_register','refresh');

		} catch (Exception $e) {
			echo "Error: " . $e -> getMessage() . "\n";
		}
	}

	public function thermal_pemasukan($id = '')
	{
		$pengaturan = $this->db->get('pengaturan')->row_array();

		$pemasukan = $this->db->get_where('biaya', ['DATE(tgl)' => date('Y-m-d'), 'status' => 'PEMASUKAN'])->result_array();

		$this->db->select_sum('total_bayar', 'total');
		$this->db->where('piutang', 0);
		$this->db->where('status !=', 'Hold');
		$this->db->where('DATE(penjualan.tgl)', date('Y-m-d'));
		$penjualan = number_format($this->db->get('penjualan')->row_array()['total']);

		$this->db->where('DATE(pembayaran.tgl)', date('Y-m-d'));
		$this->db->where('piutang', 1);
		$this->db->join('penjualan', 'faktur_penjualan');
		$this->db->where('status !=', 'Hold');
		$piutang = $this->db->get('pembayaran')->result_array();

		if ($id_outlet = $this->session->userdata('id_outlet')) {
			$outlet = $this->db->get_where('outlet', ['id_outlet' => $id_outlet])->row_array();
		}else{
			$outlet = $this->db->get('outlet')->row_array();
		}	

		try {

			$connector = new WindowsPrintConnector($pengaturan['nama_printer']);

			$printer = new Printer($connector);
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> text($outlet['nama_outlet'] ."\n");
			$printer -> text($outlet['alamat'] . "\n");
			$printer -> text("----------------------------------------\n");
			$printer -> text("LAPORAN PEMASUKAN HARI INI\n");
			$printer -> text("----------------------------------------\n");
			$printer -> setJustification(Printer::JUSTIFY_LEFT);
			$printer -> text("Penjualan\n");
			$printer -> text("No   Keterangan          Jumlah\n");
			$printer -> text("1    Penjualan           {$penjualan}\n");
			$printer -> text("----------------------------------------\n");
			$printer -> text("Transaksi Biaya\n");
			$printer -> text("No   Keterangan          Jumlah\n");
			foreach ($pemasukan as $index => $row) {
				$no = $index += 1;
				$ket = $row['keterangan_biaya'];
				$total = number_format($row['total_bayar']);
				$printer -> text("{$no}    {$ket}          {$total}\n");
			}
			$printer -> text("----------------------------------------\n");
			$printer -> text("Piutang Pelanggan\n");
			$printer -> text("No   Pelanggan         Jumlah\n");
			foreach ($piutang as $index => $row) {
				$no = $index += 1;
				$ket = $row['pelanggan_umum'];
				$total = number_format($row['nominal']);
				$printer -> text("{$no}    {$ket}         {$total}\n");
			}
			$printer -> feed(1);
			$printer -> text("----------------------------------------\n");
			$printer -> cut();
			$printer -> close();

			redirect('penjualan/cetak_register','refresh');

		} catch (Exception $e) {
			echo "Error: " . $e -> getMessage() . "\n";
		}
	}

	// Laporan
	public function export_per_barang($golongan = '', $dari = '', $sampai = '', $id_outlet = '')
	{
		if ($dari != '') {
			$per_barang = $this->laporan_model->get_penjualan_per_barang($golongan, $dari, $sampai, $id_outlet);
		}else{
			$per_barang = $this->laporan_model->get_penjualan_per_barang($golongan);
		}

		$golongan_a = str_replace('_', '', $golongan);
		
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode Barang')
		->setCellValue('B1', 'Barcode')
		->setCellValue('C1', 'Nama Barang')
		->setCellValue('D1', 'Barang Terjual')
		->setCellValue('E1', 'Harga Beli')
		->setCellValue('F1', 'Harga Jual')
		->setCellValue('G1', 'Profit')
		->setCellValue('H1', 'Total')
		->setCellValue('I1', 'Laba')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($per_barang as $row) {

			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_barang'])
			->setCellValue('B' . $i, $row['barcode'])
			->setCellValue('C' . $i, $row['nama_barang'])
			->setCellValue('D' . $i, $row['barang_terjual'])
			->setCellValue('E' . $i, $row['harga_pokok'])
			->setCellValue('F' . $i, $row['harga_jual'])
			->setCellValue('G' . $i, $row['profit'])
			->setCellValue('H' . $i, $row['total'])
			->setCellValue('I' . $i, $row['laba']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Laporan Penjualan Per Barang '. $golongan_a . date('d-m-Y') .'.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function export_riwayat_penjualan()
	{
		$this->db->select('*, SUM(nominal) AS cash, (total_bayar - SUM(nominal)) AS sisa_bayar');
		$this->db->join('petugas', 'id_petugas');
		$this->db->join('outlet', 'penjualan.id_outlet=outlet.id_outlet');
		$this->db->join('pelanggan', 'id_pelanggan');
		$this->db->join('pembayaran', 'faktur_penjualan');
		$this->db->group_by('faktur_penjualan');
		$riwayat = $this->db->get('penjualan')->result_array();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Faktur')
		->setCellValue('B1', 'Tanggal')
		->setCellValue('C1', 'Petugas')
		->setCellValue('D1', 'Pelanggan')
		->setCellValue('E1', 'Outlet')
		->setCellValue('F1', 'Total Bayar')
		->setCellValue('G1', 'Potongan')
		->setCellValue('H1', 'Diskon')
		->setCellValue('I1', 'Cash')
		->setCellValue('J1', 'Sisa Bayar')
		->setCellValue('K1', 'Status')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($riwayat as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['faktur_penjualan'])
			->setCellValue('B' . $i, $row['tgl'])
			->setCellValue('C' . $i, $row['nama_petugas'])
			->setCellValue('D' . $i, $row['nama_pelanggan'])
			->setCellValue('E' . $i, $row['nama_outlet'])
			->setCellValue('F' . $i, $row['total_bayar'])
			->setCellValue('G' . $i, $row['potongan'])
			->setCellValue('H' . $i, $row['diskon'])
			->setCellValue('I' . $i, $row['cash'])
			->setCellValue('J' . $i, $row['sisa_bayar'] > 0 ? $row['sisa_bayar'] : '0')
			->setCellValue('K' . $i, $row['status']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Riwayat Penjualan.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function export_riwayat_pembelian()
	{
		$this->db->select('*, SUM(nominal) AS cash, (total_bayar - SUM(nominal)) AS sisa_bayar');
		$this->db->join('pembayaran_pembelian', 'faktur_pembelian');
		$this->db->join('petugas', 'id_petugas');
		$this->db->join('supplier', 'id_supplier');
		$this->db->group_by('faktur_pembelian');
		$riwayat = $this->db->get('pembelian')->result_array();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Faktur')
		->setCellValue('B1', 'Tanggal')
		->setCellValue('C1', 'Supplier')
		->setCellValue('D1', 'Petugas')
		->setCellValue('E1', 'Total Bayar')
		->setCellValue('F1', 'Cash')
		->setCellValue('G1', 'Sisa Bayar')
		->setCellValue('H1', 'Status')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($riwayat as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['faktur_pembelian'])
			->setCellValue('B' . $i, $row['tgl'])
			->setCellValue('C' . $i, $row['nama_supplier'])
			->setCellValue('D' . $i, $row['nama_petugas'])
			->setCellValue('E' . $i, $row['total_bayar'])
			->setCellValue('F' . $i, $row['cash'])
			->setCellValue('G' . $i, $row['sisa_bayar'] > 0 ? $row['sisa_bayar'] : '0')
			->setCellValue('H' . $i, $row['status'])
			;
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Riwayat Pembelian.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function export_riwayat_pengembalian()
	{
		$this->db->join('pelanggan', 'id_pelanggan');
		$this->db->join('petugas', 'id_petugas');
		$this->db->join('outlet', 'pengembalian.id_outlet=outlet.id_outlet');
		$riwayat_pengembalian = $this->db->get('pengembalian')->result_array();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Faktur')
		->setCellValue('B1', 'Tanggal')
		->setCellValue('C1', 'Petugas')
		->setCellValue('D1', 'Pelanggan')
		->setCellValue('E1', 'Outlet')
		->setCellValue('F1', 'Total Bayar')
		->setCellValue('G1', 'Status')
		->setCellValue('H1', 'Alasan')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($riwayat_pengembalian as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['faktur_pengembalian'])
			->setCellValue('B' . $i, $row['tgl'])
			->setCellValue('C' . $i, $row['nama_petugas'])
			->setCellValue('D' . $i, $row['nama_pelanggan'])
			->setCellValue('E' . $i, $row['nama_outlet'])
			->setCellValue('F' . $i, $row['total_bayar'])
			->setCellValue('G' . $i, $row['status'])
			->setCellValue('H' . $i, $row['alasan']);
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Riwayat Pengembalian.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function export_pembelian($dari = '', $sampai = '')
	{
		if ($dari != '') {
			$pembelian = $this->laporan_model->get_all_pembelian($dari, $sampai);
		}else{
			$pembelian = $this->laporan_model->get_all_pembelian();
		}

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode Barang')
		->setCellValue('B1', 'Nama Barang')
		->setCellValue('C1', 'Supplier')
		->setCellValue('D1', 'Qty')
		->setCellValue('E1', 'Harga Beli')
		->setCellValue('F1', 'Harga Jual 1')
		->setCellValue('G1', 'Harga Jual 2')
		->setCellValue('H1', 'Harga Jual 3')
		->setCellValue('I1', 'Harga Jual 4')
		->setCellValue('J1', 'Harga Total')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($pembelian as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_barang'])
			->setCellValue('B' . $i, $row['nama_barang'])
			->setCellValue('C' . $i, $row['nama_supplier'])
			->setCellValue('D' . $i, $row['barang_terbeli'])
			->setCellValue('E' . $i, $row['harga_pokok'])
			->setCellValue('F' . $i, $row['golongan_1'])
			->setCellValue('G' . $i, $row['golongan_2'])
			->setCellValue('H' . $i, $row['golongan_3'])
			->setCellValue('I' . $i, $row['golongan_4'])
			->setCellValue('J' . $i, $row['total'])
			;
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Laporan Pembelian.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function export_pengembalian()
	{
		$pengembalian = $this->laporan_model->get_all_pengembalian();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Kode Barang')
		->setCellValue('B1', 'Barcode')
		->setCellValue('C1', 'Nama Barang')
		->setCellValue('D1', 'Harga')
		->setCellValue('E1', 'Jumlah')
		->setCellValue('F1', 'Total')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($pengembalian as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['id_barang'])
			->setCellValue('B' . $i, $row['barcode'])
			->setCellValue('C' . $i, $row['nama_barang'])
			->setCellValue('D' . $i, $row['harga_pokok'])
			->setCellValue('E' . $i, $row['barang_kembali'])
			->setCellValue('F' . $i, $row['total'])
			;
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Laporan pengembalian.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function export_register()
	{
		$register = $this->laporan_model->get_register();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Nama Petugas')
		->setCellValue('B1', 'Nama Outlet')
		->setCellValue('C1', 'Saldo Awal')
		->setCellValue('D1', 'Saldo Akhir')
		->setCellValue('E1', 'Mulai')
		->setCellValue('F1', 'Berakhir')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($register as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['nama_petugas'])
			->setCellValue('B' . $i, $row['nama_outlet'])
			->setCellValue('C' . $i, $row['uang_awal'])
			->setCellValue('D' . $i, $row['total_uang'])
			->setCellValue('E' . $i, $row['mulai'])
			->setCellValue('F' . $i, $row['berakhir'])
			;
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Laporan Register.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function export_hutang()
	{
		$laporan = $this->laporan_model->get_all_hutang();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Nama Supplier')
		->setCellValue('B1', 'Jatuh Tempo')
		->setCellValue('C1', 'Jumlah Hutang')
		->setCellValue('D1', 'Telah Dibayar')
		->setCellValue('E1', 'Sisa Hutang')
		->setCellValue('F1', 'Status')
		->setCellValue('G1', 'Faktur')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($laporan as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['nama_supplier'])
			->setCellValue('B' . $i, $row['tgl_jatuh_tempo'])
			->setCellValue('C' . $i, $row['jumlah_hutang'])
			->setCellValue('D' . $i, $row['telah_dibayar'])
			->setCellValue('E' . $i, $row['jumlah_hutang'] - $row['telah_dibayar'])
			->setCellValue('F' . $i, strtotime(date('Y-m-d')) > strtotime($row['tgl_jatuh_tempo']) ? 'TERLEWAT' : 'BELUM TERLEWAT' )
			->setCellValue('G' . $i, $row['faktur_pembelian'])
			;
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Laporan Hutang.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function export_piutang()
	{
		$laporan = $this->laporan_model->get_all_piutang();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'Nama Pelanggan')
		->setCellValue('B1', 'Umum')
		->setCellValue('C1', 'Jatuh Tempo')
		->setCellValue('D1', 'Jumlah piutang')
		->setCellValue('E1', 'Telah Dibayar')
		->setCellValue('F1', 'Sisa piutang')
		->setCellValue('G1', 'Status')
		->setCellValue('H1', 'Faktur')
		;
		// Miscellaneous glyphs, UTF-8
		$i=2; 
		foreach($laporan as $row) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $row['nama_pelanggan'])
			->setCellValue('B' . $i, $row['pelanggan_umum'])
			->setCellValue('C' . $i, $row['tgl_jatuh_tempo'])
			->setCellValue('D' . $i, $row['jumlah_piutang'])
			->setCellValue('E' . $i, $row['telah_dibayar'])
			->setCellValue('F' . $i, $row['jumlah_piutang'] - $row['telah_dibayar'])
			->setCellValue('G' . $i, strtotime(date('Y-m-d')) > strtotime($row['tgl_jatuh_tempo']) ? 'TERLEWAT' : 'BELUM TERLEWAT' )
			->setCellValue('H' . $i, $row['faktur_penjualan'])
			;
			$i++;
		}                           

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Laporan Piutang.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function cetak_per_barang($golongan = '', $dari = '', $sampai = '', $id_outlet = '')
	{

		if ($dari != '') {
			$data['golongan'] = $golongan;
			$data['judul'] = "Laporan Per Barang Barang " . str_replace('_', ' ', $golongan);
			$data['laporan'] = $this->laporan_model->get_penjualan_per_barang($golongan, $dari, $sampai, $id_outlet);
			$data['pendapatan_1'] = $this->laporan_model->get_total_pendapatan('golongan_1', $dari, $sampai, $id_outlet);
			$data['laba_1'] = $this->laporan_model->get_total_laba('golongan_1', $dari, $sampai, $id_outlet);
			$data['pendapatan_2'] = $this->laporan_model->get_total_pendapatan('golongan_2', $dari, $sampai, $id_outlet);
			$data['laba_2'] = $this->laporan_model->get_total_laba('golongan_2', $dari, $sampai, $id_outlet);
			$data['pendapatan_3'] = $this->laporan_model->get_total_pendapatan('golongan_3', $dari, $sampai, $id_outlet);
			$data['laba_3'] = $this->laporan_model->get_total_laba('golongan_3', $dari, $sampai, $id_outlet);
			$data['pendapatan_4'] = $this->laporan_model->get_total_pendapatan('golongan_4', $dari, $sampai, $id_outlet);
			$data['laba_4'] = $this->laporan_model->get_total_laba('golongan_4', $dari, $sampai, $id_outlet);
		}else{
			$golongan = 'golongan_1';
			$data['golongan'] = $golongan;
			$data['judul'] = "Laporan Per Barang Barang golongan 1";
			$data['laporan'] = $this->laporan_model->get_penjualan_per_barang($golongan);
			
			$data['pendapatan_1'] = $this->laporan_model->get_total_pendapatan('golongan_1');
			$data['laba_1'] = $this->laporan_model->get_total_laba('golongan_1');
			$data['pendapatan_2'] = $this->laporan_model->get_total_pendapatan('golongan_2');
			$data['laba_2'] = $this->laporan_model->get_total_laba('golongan_2');
			$data['pendapatan_3'] = $this->laporan_model->get_total_pendapatan('golongan_3');
			$data['laba_3'] = $this->laporan_model->get_total_laba('golongan_3');
			$data['pendapatan_4'] = $this->laporan_model->get_total_pendapatan('golongan_4');
			$data['laba_4'] = $this->laporan_model->get_total_laba('golongan_4');
		}

		$this->load->view('laporan/cetak/per_barang', $data);
	}
}

/* End of file laporan.php */
/* Location: ./application/modules/laporan/controllers/laporan.php */ ?>
