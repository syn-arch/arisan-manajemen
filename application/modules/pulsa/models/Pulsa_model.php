<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pulsa_model extends CI_Model {

	public function get_pulsa_json()
	{
		$this->datatables->select('id_pulsa,no_telepon,tgl,nama_outlet,nama_petugas,saldo_awal,harga_pulsa,saldo_akhir,keterangan');
		$this->datatables->from('pulsa');
		$this->datatables->join('outlet', 'id_outlet');
		$this->datatables->join('petugas', 'id_petugas');
		$this->datatables->where('type', 'transaksi pulsa');
		return $this->datatables->generate();
	}


	public function get_riwayat_tambah_saldo_json()
	{
		$this->datatables->select('tgl, tambah_saldo, saldo_akhir,saldo_awal');
		$this->datatables->where('type', 'tambah saldo');
		$this->datatables->from('pulsa');
		return $this->datatables->generate();
	}

	public function get_pulsa($id = '')
	{
		if ($id == '') {
			$this->db->join('petugas', 'id_petugas');
			$this->db->join('outlet', 'pulsa.id_outlet=outlet.id_outlet');
			return $this->db->get('pulsa')->result_array();
		}else {
			$this->db->join('petugas', 'id_petugas');
			$this->db->join('outlet', 'pulsa.id_outlet=outlet.id_outlet');
			$this->db->where('id_pulsa', $id);
			return $this->db->get('pulsa')->row_array();
		}
	}

	public function delete($id)
	{
		$this->db->delete('pulsa', ['id_pulsa' => $id]);
	}

	public function insert($post)
	{
		$this->db->trans_start();

		$data = [
			'id_pulsa' => $post['id_pulsa'],
			'id_petugas' => $post['id_petugas'],
			'id_outlet' => $post['id_outlet'],
			'saldo_awal' => $post['saldo_awal'],
			'harga_pulsa' => $post['harga_pulsa'],
			'saldo_akhir' => $post['saldo_akhir'],
			'no_telepon' => $post['no_telepon'],
			'keterangan' => $post['keterangan'],
			'type' => 'transaksi pulsa'
		];

		$this->db->insert('pulsa', $data);

		$this->db->trans_complete();
	}

	public function update($post)
	{
		$this->db->trans_start();

		$data = [
			'id_petugas' => $post['id_petugas'],
			'id_outlet' => $post['id_outlet'],
			'saldo_awal' => $post['saldo_awal'],
			'harga_pulsa' => $post['harga_pulsa'],
			'saldo_akhir' => $post['saldo_akhir'],
			'no_telepon' => $post['no_telepon'],
			'keterangan' => $post['keterangan'],
		];

		$this->db->where('id_pulsa', $post['id_pulsa']);
		$this->db->update('pulsa', $data);
		
		$this->db->trans_complete();
	}

	public function tambah_saldo($post)
	{
		$this->db->select('saldo_akhir,saldo_awal');
		$this->db->order_by('tgl', 'desc');
		$saldo = $this->db->get('pulsa')->row();

		$petugas = $this->session->userdata('id_outlet');

		if ($petugas) {
			$id_outlet = $petugas;
		}else{
			$id_outlet = $this->db->get('outlet')->row()->id_outlet;
		}

		$this->db->insert('pulsa', [
			'id_petugas' => $this->session->userdata('id_petugas'),
			'id_pulsa' => 'PS-'.acak(10),
			'id_outlet' => $id_outlet,
			'saldo_awal' => $saldo->saldo_akhir ?? 0,
			'tambah_saldo' => $post['tambah_saldo'],
			'saldo_akhir' => ( $saldo->saldo_akhir ?? 0 )+ $post['tambah_saldo'],
			'type' => 'tambah saldo'
		]);
	}

}

/* End of file pulsa_model.php */
/* Location: ./application/modules/pulsa/models/pulsa_model.php */ ?>