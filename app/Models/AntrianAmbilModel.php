<?php
/**
*	App Name	: Antrian	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2022
*/

namespace App\Models;

class AntrianAmbilModel extends \App\Models\BaseModel
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
	
	public function getAllTujuan() {
		$sql = 'SELECT * FROM antrian_detail 
				LEFT JOIN antrian_tujuan USING(id_antrian_tujuan)
				LEFT JOIN antrian_kategori USING(id_antrian_kategori)
				LEFT JOIN setting_layar_detail USING(id_antrian_kategori)
				LEFT JOIN setting_layar USING(id_setting_layar)';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAntrianKategoriAktif() {

		$sql = 'SELECT * 
				FROM antrian_kategori
				WHERE aktif = 1';
		$result = $this->db->query($sql)->getResultArray();
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
	
	public function getAntrianKategoriById($id) {
		$sql = 'SELECT * FROM antrian_kategori WHERE id_antrian_kategori = ?';
		$result = $this->db->query($sql, trim($id))->getRowArray();
		return $result;
	}
	
	/* public function getAntrianDetailByIdKategori($id) {
		$sql = 'SELECT antrian_detail.*, nama_antrian_tujuan FROM antrian_detail 
				LEFT JOIN antrian_kategori USING(id_antrian_kategori) 
				LEFT JOIN antrian_tujuan USING(id_antrian_tujuan) 
				WHERE id_antrian_kategori = ?';
		$result = $this->db->query($sql, trim($id))->getResultArray();
		return $result;
	} */
	
	/* public function getAntrianDetailById($id) {
		$sql = 'SELECT * FROM antrian_detail
				WHERE id_antrian_detail = ?';
		$result = $this->db->query($sql, trim($id))->getRowArray();
		return $result;
	} */
	
	public function getIdentitas() {
		$sql = 'SELECT * FROM identitas';
		$result = $this->db->query($sql)->getRowArray();
		return $result;
	}
	
	/* public function getSettingPrinterByNama($nama) {
		$sql = 'SELECT * FROM setting_printer WHERE nama_setting_printer = ?';
		$result = $this->db->query($sql, $nama)->getRowArray();
		return $result;
	} */
	
	public function getAktifPrinter() {
		$sql = 'SELECT * FROM setting_printer WHERE aktif = ?';
		$result = $this->db->query($sql, 1)->getResultArray();
		return $result;
	}
	
	public function ambilAntrian($id_antrian_kategori) 
	{
		$tanggal = date('Y-m-d');
		$sql = 'SELECT * FROM antrian_panggil 
				LEFT JOIN antrian_kategori USING(id_antrian_kategori) 
				WHERE id_antrian_kategori = ? AND tanggal = "' . $tanggal . '"';
		$result = $this->db->query($sql, (int) $id_antrian_kategori)->getRowArray();
		
		// Jika hari ini sudah ada antrian
		if ($result) {
			$next = $result['jml_antrian'] + 1;
			$result['jml_antrian'] = $next;
			$data_db['jml_antrian'] = $next;
			$data_db['time_ambil'] = date('H:i:s');
			$update = $this->db->table('antrian_panggil')->update($data_db, ['id_antrian_kategori' => $id_antrian_kategori, 'tanggal' => $tanggal]);
			if ($update)
				return $result;
			
		} else {
			
			// Ambil antrian mulai dari nol	
			$data_db['id_antrian_kategori'] = $id_antrian_kategori;
			$data_db['jml_antrian'] = 1;
			$data_db['tanggal'] = $tanggal;
			$data_db['time_ambil'] = date('H:i:s');
		
			$insert = $this->db->table('antrian_panggil')->insert($data_db);
			if ($insert) {
				$sql = 'SELECT * FROM antrian_kategori
				WHERE id_antrian_kategori = ?';
				$result = $this->db->query($sql, (int) $id_antrian_kategori)->getRowArray();
				$result['jml_antrian'] = 1;
				return $result;
			}		
		}
		
		return false;
	}
	
	public function getAntrianUrut() 
	{
		$tgl_awal = date('Y-m-d');
		$tgl_akhir = date('Y-m-d');
		$sql = 'SELECT * 
				FROM antrian_panggil
				LEFT JOIN setting_layar_detail USING(id_antrian_kategori) 
				WHERE tanggal >= "' . $tgl_awal . '" 
					AND tanggal <= "' . $tgl_akhir . '"';
		// echo $sql; die;
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
}
?>