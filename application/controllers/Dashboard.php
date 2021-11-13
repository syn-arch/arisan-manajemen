<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
	}

	public function index()
	{
		$data['judul'] = "Dashboard";

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('dashboard', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function get_stok_tipis_json()
	{
		$pengaturan = $this->db->get('pengaturan')->row_array();

		$petugas = $this->session->userdata('id_outlet');

		if ($petugas) {
			$id_outlet = $petugas;
		}else{
			$id_outlet = $this->db->get('outlet')->row()->id_outlet;
		}

		$outlet = $this->db->get_where('outlet', ['id_outlet' => $id_outlet])->row_array();

		header('Content-Type: application/json');
		$this->datatables->select('id_barang,nama_barang,stok_outlet.stok,barcode');
		$this->datatables->from('stok_outlet');
		$this->datatables->where('stok_outlet.stok <=', $pengaturan['peringatan_stok']);
		$this->datatables->where('stok_outlet.stok >', 0);
		$this->datatables->where('id_outlet', $id_outlet);
		$this->datatables->join('barang', 'id_barang');
		$this->datatables->join('outlet', 'id_outlet');
		$stok_tipis = $this->datatables->generate();
		echo $stok_tipis;
	}

	public function get_stok_habis_json()
	{
		$pengaturan = $this->db->get('pengaturan')->row_array();

		$petugas = $this->session->userdata('id_outlet');

		if ($petugas) {
			$id_outlet = $petugas;
		}else{
			$id_outlet = $this->db->get('outlet')->row()->id_outlet;
		}

		$outlet = $this->db->get_where('outlet', ['id_outlet' => $id_outlet])->row_array();

		header('Content-Type: application/json');
		$this->datatables->select('id_barang,nama_barang,stok_outlet.stok,barcode');
		$this->datatables->from('stok_outlet');
		$this->datatables->where('stok_outlet.stok <=', 0);
		$this->datatables->where('id_outlet', $id_outlet);
		$this->datatables->join('barang', 'id_barang');
		$this->datatables->join('outlet', 'id_outlet');
		$stok_habis = $this->datatables->generate();

		echo $stok_habis;
	}

	public function bot_telegram()
	{
		$recepit = "
		============================
		Invoice LKAJSD12320200001
		============================
		Kasir: Adiatna Sukmana
		Tgl: 20 Desember 2001
		============================
		Barang  Disc Qty Harga Subtotal
		Komputer Dewa 19-9999k 
		0    1 X 10.000.000  10.000.000
		Komputer Dewa 19-9999k 
		0    1 X 10.000.000  10.000.000
		Komputer Dewa 19-9999k 
		0    1 X 10.000.000  10.000.000
		Komputer Dewa 19-9999k 
		0    1 X 10.000.000  10.000.000
		============================
		Total Belanja: 40.000.000
		Diskon:0
		Potongan:0
		Grand Total:40.000.000
		Cash:50.000.000
		Kembalian:10.000
		";

		$fields = [
			'chat_id' => '-462661782',
			'text' => $recepit
		];

		$fields_string = http_build_query($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot1140123802:AAFA5tDYkHosvvQbLfbW3rBy_j-8KcA2ufk/sendMessage?parse_mode=Markdown");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		// Receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		curl_close($ch);

		echo $server_output;
	}
}
