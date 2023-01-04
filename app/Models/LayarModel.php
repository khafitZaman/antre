<?php
/**
*	App Name	: Antrian	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2021
*/

namespace App\Models;

class LayarModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
	}
	
	public function getAllSettingLayar() {
		$sql = 'SELECT setting_layar.*, GROUP_CONCAT(nama_antrian_kategori) AS nama_kategori FROM setting_layar
				LEFT JOIN setting_layar_detail USING(id_setting_layar)
				LEFT JOIN antrian_kategori USING(id_antrian_kategori)
				GROUP BY id_setting_layar';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getTujuanByIdLayarSetting($id) {
		$sql = 'SELECT *, antrian_kategori.aktif AS kategori_aktif, antrian_detail.aktif AS tujuan_aktif
				FROM antrian_kategori
				LEFT JOIN antrian_detail USING(id_antrian_kategori)
				LEFT JOIN antrian_tujuan USING(id_antrian_tujuan)
				LEFT JOIN setting_layar_detail USING(id_antrian_kategori)
				WHERE id_setting_layar = ?';
				
		/* $sql = 'SELECT id_antrian_detail, COUNT(*) AS jml_dipanggil FROM antrian_panggil_detail 
				LEFT JOIN antrian_panggil USING(id_antrian_panggil)
				WHERE tgl_panggil = "2022-07-11"
				GROUP BY id_antrian_detail'; */
		$result = $this->db->query($sql, $id)->getResultArray();
		return $result;
	}
	
	public function getAwalanPanggil() {
		$sql = 'SELECT nama_file FROM antrian_panggil_awalan';
		$result = $this->db->query($sql)->getRowArray();
		return $result;
	}
	
	public function getAntrianKategori() {

		$sql = 'SELECT antrian_kategori.*, jml_tujuan 
				FROM antrian_kategori
				LEFT JOIN (SELECT id_antrian_kategori, COUNT(id_antrian_detail) AS jml_tujuan 
							FROM antrian_detail GROUP BY id_antrian_kategori) AS tabel USING(id_antrian_kategori)';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAntrianKategoriByIdLayar($id) {
		$sql = 'SELECT * FROM setting_layar_detail
				LEFT JOIN antrian_kategori USING(id_antrian_kategori)
				WHERE id_setting_layar = ?';
		$result = $this->db->query($sql, $id)->getResultArray();
		return $result;
	}
	
	public function getAntrianKategoriAktif() {

		$sql = 'SELECT * 
				FROM antrian_kategori
				WHERE aktif = 1';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAllTujuan() {
		$sql = 'SELECT * FROM setting_layar
				LEFT JOIN setting_layar_detail USING(id_setting_layar)
				LEFT JOIN antrian_detail USING(id_antrian_kategori)
				LEFT JOIN antrian_tujuan USING(id_antrian_tujuan)
				LEFT JOIN antrian_kategori USING(id_antrian_kategori)';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getIdentitas() {
		$sql = 'SELECT * FROM identitas';
		$result = $this->db->query($sql)->getRowArray();
		return $result;
	}
	
	public function getAntrianDetailByIdKategori($id) {
		$sql = 'SELECT *
				FROM antrian_detail
				LEFT JOIN antrian_kategori USING(id_antrian_kategori)
				LEFT JOIN antrian_tujuan USING(id_antrian_tujuan)
				WHERE id_antrian_kategori = ? AND antrian_detail.aktif = 1';
		$result = $this->db->query($sql, (int) $id)->getResultArray();
		return $result;
	}
	
	public function getSettingLayarMonitor() {
		$sql = 'SELECT * FROM setting_layar_layout';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAntrian() {
		$sql = 'SELECT * FROM setting_layar_layout';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAntrianDipanggilTerakhir($id) {
		
		$sql = 'SELECT *
				FROM antrian_panggil_detail
				LEFT JOIN antrian_panggil USING(id_antrian_panggil)
				LEFT JOIN antrian_kategori USING(id_antrian_kategori)
				LEFT JOIN setting_layar_detail USING(id_antrian_kategori)
				LEFT JOIN antrian_detail USING(id_antrian_detail)
				LEFT JOIN antrian_tujuan USING(id_antrian_tujuan)
				WHERE id_setting_layar = ? AND tanggal = ? AND antrian_kategori.aktif = "Y" AND antrian_detail.aktif = "Y"
				ORDER BY waktu_panggil DESC LIMIT 1';
		
		/* $sql = 'SELECT *, antrian_detail.aktif AS tujuan_aktif 
				FROM antrian_panggil_detail
				LEFT JOIN antrian_panggil USING(id_antrian_panggil)
				LEFT JOIN antrian_detail USING(id_antrian_detail)
				LEFT JOIN antrian_tujuan USING(id_antrian_tujuan)
				LEFT JOIN antrian_kategori ON antrian_detail.id_antrian_kategori = antrian_kategori.id_antrian_kategori
				LEFT JOIN setting_layar_detail ON antrian_panggil.id_antrian_kategori AND setting_layar_detail.id_antrian_kategori
				WHERE id_setting_layar = ? AND tanggal = ? AND antrian_kategori.aktif = "Y" AND antrian_detail.aktif = "Y"
				ORDER BY waktu_panggil DESC LIMIT 1'; */
		
		$result = $this->db->query($sql, [$id, date('Y-m-d')])->getRowArray();
		/* $result['kategori']['antrian_terakhir'] = $antrian_terakhir;
			
			
		$sql = 'SELECT *, COUNT(*) AS count_dipanggil, MAX(waktu_panggil) AS waktu_panggil FROM antrian_panggil_detail 
				LEFT JOIN antrian_panggil USING(id_antrian_panggil)
				LEFT JOIN setting_layar_detail USING(id_antrian_kategori)
				WHERE tanggal = "' . date('Y-m-d') . '" AND id_setting_layar = ?
				GROUP BY antrian_panggil_detail.id_antrian_detail
				ORDER BY waktu_panggil DESC';
				
		$result = $this->db->query($sql, (int) $id)->getResultArray(); */
		return $result;
	}
	
	public function getAntrianDipanggilByTujuan($id) {
		/* $sql = 'SELECT *
				FROM antrian_panggil_detail
				LEFT JOIN antrian_detail USING(id_antrian_detail)
				LEFT JOIN setting_layar_detail USING(id_antrian_kategori)
				LEFT JOIN antrian_kategori USING(id_antrian_kategori)
				LEFT JOIN antrian_tujuan USING(id_antrian_tujuan)
				LEFT JOIN antrian_panggil USING(id_antrian_panggil)
				WHERE tgl_panggil = "' . date('Y-m-d') . '" AND id_setting_layar = ? ORDER BY waktu_panggil DESC LIMIT 1 '; */
		
		$sql = 'SELECT *, COUNT(*) AS count_dipanggil, MAX(waktu_panggil) AS waktu_panggil, MAX(nomor_panggil) AS nomor_panggil_terakhir 
				FROM antrian_panggil_detail 
				LEFT JOIN antrian_panggil USING(id_antrian_panggil)
				LEFT JOIN setting_layar_detail USING(id_antrian_kategori)
				WHERE tanggal = "' . date('Y-m-d') . '" AND id_setting_layar = ?
				GROUP BY antrian_panggil_detail.id_antrian_detail
				ORDER BY waktu_panggil DESC';
				
		$result = $this->db->query($sql, (int) $id)->getResultArray();
		return $result;
	}
}
?>