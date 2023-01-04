<?php
/**
*	App Name	: Aplikasi Antrian Professional
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2022
*/

namespace App\Models;

class AntrianResetModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
	}
	
	/* public function getAntrianKategori() {

		$sql = 'SELECT * 
				FROM antrian_kategori';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	} */
	
	public function getAntrianKategori() 
	{
		$tgl_awal = date('Y-m-d');
		$tgl_akhir = date('Y-m-d');
				
		$sql = 'SELECT * 
				FROM antrian_panggil
				LEFT JOIN antrian_kategori USING(id_antrian_kategori)
				WHERE tanggal >= "' . $tgl_awal . '" 
					AND tanggal <= "' . $tgl_akhir . '"';
				
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function resetDipanggilByIdKategori($id) {
		
		$tanggal = date('Y-m-d');
		$sql = 'SELECT * FROM antrian_panggil WHERE id_antrian_kategori = ? AND tanggal = ?';
		$data = $this->db->query($sql, [$id, $tanggal])->getRowArray();
		if ($data) {
			$this->db->transStart();
			$this->db->table('antrian_panggil_detail')->delete(['id_antrian_panggil' => $data['id_antrian_panggil']]);
			$this->db->table('antrian_panggil')->update(['jml_dipanggil' => 0], ['tanggal' => $tanggal, 'id_antrian_kategori' => $id]);
			$this->db->transComplete();
			return $this->db->transStatus();
		}
		return false;
	}
	
	public function resetAllByIdKategori($id) 
	{
		$tanggal = date('Y-m-d');
		$sql = 'SELECT * FROM antrian_panggil WHERE id_antrian_kategori = ? AND tanggal = ?';
		$data = $this->db->query($sql, [$id, $tanggal])->getRowArray();
		if ($data) {
			$this->db->transStart();
			$this->db->table('antrian_panggil_detail')->delete(['id_antrian_panggil' => $data['id_antrian_panggil']]);
			$this->db->table('antrian_panggil')->update(['jml_antrian' => 0, 'jml_dipanggil' => 0], ['tanggal' => $tanggal, 'id_antrian_kategori' => $id]);
			$this->db->transComplete();
			return $this->db->transStatus();
		}
		return false;
	}
	
	public function resetAllDipanggil() {
		
		$tanggal = date('Y-m-d');
		$sql = 'SELECT * FROM antrian_panggil WHERE tanggal = ?';
		$data = $this->db->query($sql, $tanggal)->getResultArray();
		if ($data) {
			$this->db->transStart();
			$this->db->table('antrian_panggil')->update(['jml_dipanggil' => 0], ['tanggal' => $tanggal]);
			foreach ($data as $val) {
				$this->db->table('antrian_panggil_detail')->delete(['id_antrian_panggil' => $val['id_antrian_panggil']]);
			}
			$this->db->transComplete();
			return $this->db->transStatus();
		}
		return false;
	}
	
	public function resetAll() {
		
		$tanggal = date('Y-m-d');
		$sql = 'SELECT * FROM antrian_panggil WHERE tanggal = ?';
		$data = $this->db->query($sql, $tanggal)->getResultArray();
		if ($data) {
			$this->db->transStart();
			$this->db->table('antrian_panggil')->update(['jml_antrian' => 0, 'jml_dipanggil' => 0], ['tanggal' => $tanggal]);
			foreach ($data as $val) {
				$this->db->table('antrian_panggil_detail')->delete(['id_antrian_panggil' => $val['id_antrian_panggil']]);
			}
			$this->db->transComplete();
			return $this->db->transStatus();
		}
		return false;
	}
	
	
	public function resetDipanggilByIdDetail($id) {
		$sql = 'UPDATE antrian_panggil SET jml_dipanggil = 0 
					WHERE tanggal = "' . date('Y-m-d') . '" AND id_antrian_detail = ?';
		$query = $this->db->query($sql, $id);
		return $query;
	}
	
	public function resetAllByIdDetail($id) {
		$sql = 'UPDATE antrian_panggil SET jml_antrian = 0, jml_dipanggil = 0 
					WHERE tanggal = "' . date('Y-m-d') . '" AND id_antrian_detail = ?';
		$query = $this->db->query($sql, $id);
		return $query;
	}
}
?>