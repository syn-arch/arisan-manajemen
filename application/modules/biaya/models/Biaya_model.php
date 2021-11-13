<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class biaya_model extends CI_Model {

	public function get_biaya_json()
	{
		$this->datatables->select('id_biaya, tgl, nama_petugas,total_bayar,keterangan_biaya, keterangan, nama_outlet, status');
		$this->datatables->join('petugas', 'id_petugas');
		$this->datatables->join('outlet', 'biaya.id_outlet = outlet.id_outlet');
		$this->datatables->from('biaya');
		$this->db->order_by('tgl', 'desc');
		return $this->datatables->generate();
	}

	public function get_biaya($id = '')
	{
		if ($id == '') {
			$this->db->select('*,biaya.id_outlet');
			$this->db->join('outlet', 'biaya.id_outlet = outlet.id_outlet');
			$this->db->join('petugas', 'id_petugas');
			return $this->db->get('biaya')->result_array();
		}else {
			$this->db->select('*,biaya.id_outlet');
			$this->db->join('outlet', 'biaya.id_outlet = outlet.id_outlet');
			$this->db->join('petugas', 'id_petugas');
			$this->db->where('id_biaya', $id);
			return $this->db->get('biaya')->row_array();
		}
	}


	public function delete($id)
	{
		$this->db->delete('biaya', ['id_biaya' => $id]);
		
	}

	public function insert($post)
	{
		$this->db->trans_start();

		$total_bayar = str_replace('.', '', $post['total_bayar']);

		$data = [
			'id_biaya' => $post['id_biaya'],
			'id_petugas' => $post['id_petugas'],
			'id_outlet' => $post['id_outlet'],
			'tgl' => $post['tgl'],
			'total_bayar' => $total_bayar,
			'keterangan_biaya' => $post['keterangan_biaya'],
			'status' => $post['status'],
			'keterangan' => $post['keterangan']
		];

		$this->db->insert('biaya', $data);

		$this->db->trans_complete();
	}

	public function update($id_biaya, $post)
	{
		$this->db->trans_start();
		$total_bayar = str_replace('.', '', $post['total_bayar']);

		$data = [
			'id_petugas' => $post['id_petugas'],
			'id_outlet' => $post['id_outlet'],
			'tgl' => $post['tgl'],
			'total_bayar' => $total_bayar,
			'keterangan_biaya' => $post['keterangan_biaya'],
			'status' => $post['status'],
			'keterangan' => $post['keterangan']
		];

		$this->db->where('id_biaya', $id_biaya);
		$this->db->update('biaya', $data);

		$this->db->trans_complete();
	}

}

/* End of file biaya_model.php */
/* Location: ./application/modules/biaya/models/biaya_model.php */ ?>