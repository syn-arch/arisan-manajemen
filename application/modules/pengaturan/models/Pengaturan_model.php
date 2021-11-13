<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pengaturan_model extends CI_Model {

	public function get_pengaturan()
	{
		return $this->db->get('pengaturan')->row_array();
	}

	public function update($post)
	{

		$data = [
			'multi_outlet' => $post['multi_outlet'],
			'keterangan_invoice' => $post['keterangan_invoice'],
			'nama_printer' => $post['nama_printer'],
			'print_otomatis' => $post['print_otomatis'],
			'peringatan_stok' => $post['peringatan_stok'],
			'tampilkan_pendapatan_dashboard' => $post['tampilkan_pendapatan_dashboard'],
			'smtp_host' => $post['smtp_host'],
			'smtp_port' => $post['smtp_port'],
			'smtp_username' => $post['smtp_username'],
			'smtp_email' => $post['smtp_email'],
			'smtp_password' => $post['smtp_password'],
			'hapus_riwayat_penjualan_otomatis' => $post['hapus_riwayat_penjualan_otomatis'],
			'lama_hari_penjualan' => $post['lama_hari_penjualan'],
			'sesuaikan_hari_penjualan' => $post['sesuaikan_hari_penjualan'],
			'hapus_riwayat_pembelian_otomatis' => $post['hapus_riwayat_pembelian_otomatis'],
			'lama_hari_pembelian' => $post['lama_hari_pembelian'],
			'sesuaikan_hari_pembelian' => $post['sesuaikan_hari_pembelian'],
			'kunci_penjualan' => $post['kunci_penjualan'],
			'password_penjualan' => $post['password_penjualan']
		];

		if ($_FILES['logo']['name']) {
			$data['logo'] = _upload('logo', 'pengaturan', 'pengaturan');
			delImage('pengaturan', 1, 'logo');
		}

		$this->db->update('pengaturan', $data);
	}

}

/* End of file pengaturan_model.php */
/* Location: ./application/modules/pengaturan/models/pengaturan_model.php */ ?>