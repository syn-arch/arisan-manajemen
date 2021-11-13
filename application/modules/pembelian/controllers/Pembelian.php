<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pembelian extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('pembelian/pembelian_model');
		$this->load->model('barang/barang_model');
		$this->load->model('supplier/supplier_model');
		$this->load->model('kategori/kategori_model');
	}

	public function index()
	{
		$data['judul'] = "Pembelian";
		$data['supplier'] = $this->supplier_model->get_supplier();
		$data['kategori'] = $this->kategori_model->get_kategori();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('pembelian/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah($id)
	{
		$data['judul'] = "Ubah Pembelian";
		$data['barang'] = $this->barang_model->get_barang();
		$data['supplier'] = $this->supplier_model->get_supplier();
		$data['kategori'] = $this->kategori_model->get_kategori();
		$data['pembelian'] = $this->pembelian_model->get_pembelian($id);
		$data['detail_pembelian'] = $this->pembelian_model->get_detail_pembelian($id);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('pembelian/ubah', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function proses()
	{
		$this->pembelian_model->proses($this->input->post());

					$this->db->select_max('faktur_pembelian');
					$this->db->limit(1);
		$faktur = $this->db->get('pembelian')->row_array()['faktur_pembelian'];
		redirect('pembelian/invoice/' . $faktur,'refresh');
	}

	public function proses_update()
	{
		$this->pembelian_model->proses_update($this->input->post());
		redirect('pembelian/invoice/' . $this->input->post('faktur_pembelian'),'refresh');
	}

	public function invoice($id)
	{
		$data['judul'] = "Invoice " . $id;
		$data['pembelian'] = $this->pembelian_model->get_pembelian($id);
		$data['total_bayar'] = $this->pembelian_model->get_total_bayar($id);

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('pembelian/invoice', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function invoice_cetak($id)
	{
		$data['judul'] = "Invoice " . $id;
		$data['pembelian'] = $this->pembelian_model->get_pembelian($id);

		$this->load->view('pembelian/invoice_cetak', $data, FALSE);
	}

	public function pembayaran($id)
	{
		$data['judul'] = "Data Pembayaran";
		$data['pembayaran'] = $this->pembelian_model->get_pembayaran($id);
		$data['faktur_pembelian'] = $id;

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('pembelian/pembayaran', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function tambah_pembayaran($id)
	{
		$data['judul'] = "Tambah Pembayaran";
		$data['pembayaran'] = $this->pembelian_model->get_pembayaran($id);
		$data['faktur_pembelian'] = $id;

		$this->db->select_sum('nominal');
		$this->db->where('faktur_pembelian', $id);
		$telah_dibayar =  $this->db->get('pembayaran_pembelian')->row()->nominal;

		$this->db->select('total_bayar');
		$total_bayar = $this->db->get_where('pembelian', ['faktur_pembelian' => $id])->row()->total_bayar;

		$data['nominal'] = $total_bayar - $telah_dibayar;


		$this->form_validation->set_rules('nominal', 'nominal', 'required');

		if ($this->form_validation->run()) {
			$this->pembelian_model->tambah_pembayaran($this->input->post());
		$this->session->set_flashdata('success', 'Ditambah');
			redirect('pembelian/pembayaran/' . $id,'refresh');
		}

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('pembelian/tambah_pembayaran', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah_pembayaran($id)
	{
		$data['judul'] = "Ubah Pembayaran";
		$data['pembayaran'] = $this->pembelian_model->get_pembayaran($id, true);
		$data['faktur_pembelian'] = $this->pembelian_model->get_pembayaran($id, true)['faktur_pembelian'];

		$this->form_validation->set_rules('nominal', 'nominal', 'required');

		if ($this->form_validation->run()) {
			$this->pembelian_model->ubah_pembayaran($this->input->post('id_pembayaran'), $this->input->post());
			$this->session->set_flashdata('success', 'Diubah');
			redirect('pembelian/pembayaran/' . $data['faktur_pembelian'],'refresh');
		}

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('pembelian/ubah_pembayaran', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function hapus_pembayaran($id, $faktur_pembelian)
	{
		$this->pembelian_model->hapus_pembayaran($id, $faktur_pembelian);
		$this->session->set_flashdata('success', 'Dihapus');
		redirect('pembelian/pembayaran/' . $faktur_pembelian,'refresh');
	}

}

/* End of file pembelian.php */
/* Location: ./application/modules/pembelian/controllers/pembelian.php */ ?>