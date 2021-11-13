<?php

function cek_login()
{
	$ci = get_instance();
	if (!$ci->session->userdata('login')) {
		redirect('login');
	} else {

		$id_role = $ci->session->userdata('id_role');
		$menu = $ci->db->get_where('menu', ['url' => $ci->uri->segment(1) ])->row_array();
		$submenu = $ci->db->get_where('menu', ['url' => $ci->uri->segment(1) . '/' . $ci->uri->segment(2) ])->row_array();

		if ($menu) {

			$userAccessMenu = $ci->db->get_where('akses_role', [
				'id_role' => $id_role,
				'id_menu' => $menu['id_menu']
			])->row_array();

			if ($userAccessMenu){

				if ($submenu) {
					$userAccessSubmenu = $ci->db->get_where('akses_role', [
						'id_role' => $id_role,
						'id_menu' => $submenu['id_menu']
					])->row_array();

					if (!$userAccessSubmenu) die('401 Unauthorized');	
				}

			} else{
				die('401 Unauthorized');
			}
		}
	}
}


function check_menu($id_menu, $id_role)
{
	$ci =& get_instance();

	$ci->db->where('id_menu', $id_menu);
	$ci->db->where('id_role', $id_role);
	$result = $ci->db->get('akses_role')->row_array();

	if ($result) return "checked='checked'";
}

function _upload($name, $url, $path)
{
	$ci =& get_instance();
	$config['upload_path'] = './assets/img/' . $path . '/';
	$config['allowed_types'] = 'pdf|jpg|png|jpeg';
	$config['max_size']  = '4048';

	$ci->load->library('upload', $config);

	if ( ! $ci->upload->do_upload($name)){
		$ci->session->set_flashdata('error', $ci->upload->display_errors());
		redirect($url,'refresh');
	}
	return $ci->upload->data('file_name');
}

function delImage($table, $id, $column = 'gambar')
{
	$ci =& get_instance();
	$gambar_lama = $ci->db->get_where($table, ['id_'.$table => $id])->row_array()[$column];
	$path = 'assets/img/' . $table . '/' . $gambar_lama;
	if (file_exists(FCPATH . $path)) {
		unlink(FCPATH . $path);
	}
}

function autoID($str, $table)
{
	// PLG00001
	$ci =& get_instance();
	$kode = $ci->db->query("SELECT MAX(id_" . $table . ") as kode from $table")->row()->kode;
	$kode_baru = substr($kode, 3, 5) + 1;
	return $str . sprintf("%05s", $kode_baru);
}

function autoIDBiaya()
{
	// OTL0000100001
	$ci =& get_instance();

	if ($idtl = $ci->session->userdata('id_outlet')) {
		$id_outlet = $idtl;
	}else{
		$id_outlet = $ci->db->get('outlet')->row()->id_outlet;
	}

	$kode = $ci->db->query("SELECT MAX(id_biaya) as kode from biaya")->row()->kode;
	$kode_baru = substr($kode, 8, 5) + 1;
	return $id_outlet . sprintf("%05s", $kode_baru);
}

function autoIDPelanggan()
{
	// OTL00001PLG00001
	$ci =& get_instance();

	if ($idtl = $ci->session->userdata('id_outlet')) {
		$id_outlet = $idtl;
	}else{
		$id_outlet = $ci->db->get('outlet')->row()->id_outlet;
	}

	$kode = $ci->db->query("SELECT MAX(id_pelanggan) as kode from pelanggan")->row()->kode;
	$kode_baru = substr($kode, 11, 5) + 1;
	return $id_outlet . 'PLG' . sprintf("%05s", $kode_baru);
}

function get_barcode_pelanggan()
{
	// 2020091500001
	$ci =& get_instance();
	$kode = $ci->db->query("SELECT MAX(barcode) as kode from pelanggan")->row()->kode;
	$kode_baru = substr($kode, 8, 5) + 1;
	return date('Ymd'). sprintf("%05s", $kode_baru);
}

function faktur_no()
{
	$ci =& get_instance();

	$id_outlet = $ci->session->userdata('id_outlet');

	if (!$id_outlet) {
		$id_outlet = $ci->db->get('outlet')->row()->id_outlet;
	}

	//P-210100001
	$kode = $ci->db->query("SELECT MAX(faktur_pembelian) as kode from pembelian")->row()->kode;
	$kode_baru = substr($kode, 6, 5) + 1;
	$str = 'P-';
	return $str . date('ym') . sprintf("%05s", $kode_baru);
}

function acak($length)
{
	$random= "";
	srand((double)microtime()*1000000);
	$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
	$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
	$data .= "0FGH45OP89";
	for($i = 0; $i < $length; $i++)
	{
		$random .= substr($data, (rand()%(strlen($data))), 1);
	}
	return strtoupper($random);
}
