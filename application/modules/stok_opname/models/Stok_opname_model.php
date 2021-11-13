<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class stok_opname_model extends CI_Model {

	public function get_stok_opname($id = '')
	{
		if ($id == '') {
			$this->db->join('petugas', 'id_petugas');
			$this->db->join('outlet', 'stok_opname.id_outlet=outlet.id_outlet');
			return $this->db->get('stok_opname')->result_array();
		}else {
			$this->db->join('petugas', 'id_petugas');
			$this->db->join('outlet', 'stok_opname.id_outlet=outlet.id_outlet');
			$this->db->where('id_stok_opname', $id);
			return $this->db->get('stok_opname')->row_array();
		}
	}

	public function delete($id)
	{
		$this->db->delete('stok_opname', ['id_stok_opname' => $id]);
		$this->db->delete('detail_stok_opname', ['id_stok_opname' => $id]);
	}

	public function insert($post)
	{
		$this->db->trans_start();

		for ($i=0; $i < count($post['id_barang']); $i++) { 
			$this->db->select('*,' . $post['golongan'] . ' AS harga_jual');
			$harga_jual = $this->db->get_where('barang', ['id_barang' => $post['id_barang'][$i]])->row()->harga_jual;
			$data_detail = [
				'id_stok_opname' => $post['id_stok_opname'],
				'id_barang' => $post['id_barang'][$i],
				'stok_komputer' => $post['stok_komputer'][$i],
				'stok_fisik' => $post['stok_fisik'][$i],
				'selisih' => $post['stok_komputer'][$i] - $post['stok_fisik'][$i],
				'kerugian' => ($post['stok_komputer'][$i] - $post['stok_fisik'][$i]) * $harga_jual
			];
			$this->db->insert('detail_stok_opname', $data_detail);
		}

		$this->db->select_sum('kerugian', 'total_kerugian');
		$this->db->where('id_stok_opname', $post['id_stok_opname']);
		$total_kerugian = $this->db->get('detail_stok_opname')->row()->total_kerugian;

		$data = [
			'id_stok_opname' => $post['id_stok_opname'],
			'id_petugas' => $post['id_petugas'],
			'golongan' => $post['golongan'],
			'id_outlet' => $post['id_outlet'],
			'keterangan' => $post['keterangan'],
			'total_kerugian' => $total_kerugian
		];

		$this->db->insert('stok_opname', $data);

		$this->db->trans_complete();
	}

	public function update($post)
	{
		$this->db->trans_start();

		for ($i=0; $i < count($post['id_barang']); $i++) { 
			$this->db->select('*,' . $post['golongan'] . ' AS harga_jual');
			$harga_jual = $this->db->get_where('barang', ['id_barang' => $post['id_barang'][$i]])->row()->harga_jual;
			$det = $this->db->get_where('detail_stok_opname', ['id_barang' => $post['id_barang'][$i], 'id_stok_opname' => $post['id_stok_opname']])->row_array();

			if ($det) {
				$data_detail = [
					'stok_komputer' => $post['stok_komputer'][$i],
					'stok_fisik' => $post['stok_fisik'][$i],
					'selisih' => $post['stok_komputer'][$i] - $post['stok_fisik'][$i],
					'kerugian' => ($post['stok_komputer'][$i] - $post['stok_fisik'][$i]) * $harga_jual
				];
				$this->db->where('id_barang', $post['id_barang'][$i]);
				$this->db->where('id_stok_opname', $post['id_stok_opname']);
				$this->db->update('detail_stok_opname', $data_detail);	
			}else{
				$data_detail = [
					'id_stok_opname' => $post['id_stok_opname'],
					'id_barang' => $post['id_barang'][$i],
					'stok_komputer' => $post['stok_komputer'][$i],
					'stok_fisik' => $post['stok_fisik'][$i],
					'selisih' => $post['stok_komputer'][$i] - $post['stok_fisik'][$i],
					'kerugian' => ($post['stok_komputer'][$i] - $post['stok_fisik'][$i]) * $harga_jual
				];
				$this->db->insert('detail_stok_opname', $data_detail);
			}
		}

		$detail = $this->db->get_where('detail_stok_opname', ['id_stok_opname' => $post['id_stok_opname']])->result_array();

		foreach ($detail as $row) {
			if (!in_array($row['id_barang'], $post['id_barang'])) {
				$this->db->where('id_stok_opname', $post['id_stok_opname']);
				$this->db->where('id_barang', $row['id_barang']);
				$this->db->delete('detail_stok_opname');
			}
		}

		$this->db->select_sum('kerugian', 'total_kerugian');
		$this->db->where('id_stok_opname', $post['id_stok_opname']);
		$total_kerugian = $this->db->get('detail_stok_opname')->row()->total_kerugian;

		$data = [
			'id_petugas' => $post['id_petugas'],
			'id_outlet' => $post['id_outlet'],
			'keterangan' => $post['keterangan'],
			'tgl' => $post['tgl'],
			'total_kerugian' => $total_kerugian
		];

		$this->db->where('id_stok_opname', $post['id_stok_opname']);
		$this->db->update('stok_opname', $data);
		
		$this->db->trans_complete();
	}

}

/* End of file stok_opname_model.php */
/* Location: ./application/modules/stok_opname/models/stok_opname_model.php */ ?>
