<?php
/**
*	App Name	: Antrian	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2022
*/

namespace App\Models;

class AntrianPanggilModel extends \App\Models\BaseModel
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
	
	public function getSettingLayar() {

		$sql = 'SELECT *
				FROM setting_layar';
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
	
	public function getAntrianDetailByIdKategori($id) {
		$sql = 'SELECT antrian_detail.*, nama_antrian_tujuan FROM antrian_detail 
				LEFT JOIN antrian_kategori USING(id_antrian_kategori) 
				LEFT JOIN antrian_tujuan USING(id_antrian_tujuan) 
				WHERE id_antrian_kategori = ?';
		$result = $this->db->query($sql, trim($id))->getResultArray();
		return $result;
	}
	
	public function getAntrianDetailById($id) {
		$sql = 'SELECT * FROM antrian_detail
				WHERE id_antrian_detail = ?';
		$result = $this->db->query($sql, trim($id))->getRowArray();
		return $result;
	}
		
	public function panggilAntrian($id_antrian_kategori, $id_antrian_detail) 
	{
		$tanggal = date('Y-m-d');
		$sql = 'SELECT * FROM antrian_panggil WHERE id_antrian_kategori = ? AND tanggal = "' . $tanggal . '"';
		$antrian_panggil = $this->db->query($sql, (int) $id_antrian_kategori)->getRowArray();
		
		if ($antrian_panggil) {
			$next = $antrian_panggil['jml_dipanggil'] + 1;
			$data_db['jml_dipanggil'] = $next;
			$data_db['time_dipanggil'] = date('H:i:s');
			
			$this->db->transStart();
			$this->db->table('antrian_panggil')->update($data_db, ['id_antrian_kategori' => $id_antrian_kategori, 'tanggal' => $tanggal]);
			
			// Insert Antrian Detail
			$sql = 'SELECT * FROM antrian_kategori WHERE id_antrian_kategori = ?';
			$antrian_kategori = $this->db->query($sql, (int) $id_antrian_kategori)->getRowArray();
			
			$data_db = [];
			$data_db['id_antrian_panggil'] = $antrian_panggil['id_antrian_panggil'];
			$data_db['id_antrian_detail'] = $id_antrian_detail;
			$data_db['awalan_panggil'] = $antrian_kategori['awalan'];
			$data_db['nomor_panggil'] = $next;
			$data_db['waktu_panggil'] = date('H:i:s');
			$this->db->table('antrian_panggil_detail')->insert($data_db);
			
			$this->db->transComplete();
			if ($this->db->transStatus()) 
			{
				$result = $this->getAntrianUrutByIdKategori($id_antrian_kategori);
				$sql = 'SELECT COUNT(*) AS jml FROM antrian_panggil
						LEFT JOIN antrian_panggil_detail USING(id_antrian_panggil)
						WHERE id_antrian_kategori = ? AND id_antrian_detail = ? AND tanggal = ?';
				
				$jml_dipanggil = $this->db->query($sql, [$id_antrian_kategori, $id_antrian_detail, $tanggal])->getRowArray();
				$result['jml_dipanggil_by_loket'] = $jml_dipanggil['jml'];
				
				return $result;
			}
		}
		
		return false;
	}
	
	// Dipanggil group by loket
	public function getDipanggil($id_antrian_kategori) {
		$tanggal = date('Y-m-d');
		$sql = 'SELECT id_antrian_detail, COUNT(*) AS jml_dipanggil, MAX(nomor_panggil) AS no_terakhir
				FROM antrian_panggil
				LEFT JOIN antrian_panggil_detail USING(id_antrian_panggil)
				WHERE id_antrian_kategori = ? AND tanggal = ?
				GROUP BY id_antrian_detail';
		
		$data = $this->db->query($sql, [$id_antrian_kategori, $tanggal])->getResultArray();
		$result = [];
		foreach ($data as $val) {
			$result[$val['id_antrian_detail']] = $val;
		}
		
		return $result;
	}
	
	public function getAntrianUrut()
	{
		$tgl_awal = date('Y-m-d');
		$tgl_akhir = date('Y-m-d');
		$sql = 'SELECT * 
				FROM antrian_panggil
				WHERE tanggal >= "' . $tgl_awal . '" 
					AND tanggal <= "' . $tgl_akhir . '"';
		// echo $sql; die;
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAntrianUrutByIdKategori($id)
	{
		$tgl_awal = date('Y-m-d');
		$tgl_akhir = date('Y-m-d');
		$sql = 'SELECT * 
				FROM antrian_panggil 
				LEFT JOIN antrian_kategori USING(id_antrian_kategori)
				WHERE tanggal >= "' . $tgl_awal . '" 
					AND tanggal <= "' . $tgl_akhir . '" 
					AND id_antrian_kategori = ?';
		$result = $this->db->query($sql, (int) $id)->getRowArray();
		return $result;
	}
	
	public function savePanggilUlangAntrian($id)
	{
		/* $sql = 'SELECT * FROM antrian_panggil_detail 
				LEFT JOIN antrian_panggil USING(id_antrian_panggil)
				WHERE nomor_panggil = (SELECT MAX(nomor_panggil) 
										FROM antrian_panggil_detail 
										LEFT JOIN antrian_panggil USING(id_antrian_panggil)
										WHERE id_antrian_detail = ? AND tanggal = ?
										)
						AND id_antrian_detail = ? AND tanggal = ?';
		$result = $this->db->query($sql, [$id, date('Y-m-d')->getRowArray();
						
						 */
		/* $sql = 'INSERT antrian_panggil_detail SET waktu_panggil_ulang = ? 
				WHERE id_antrian_panggil_detail = (SELECT id_antrian_panggil_detail FROM antrian_panggil_detail 
													LEFT JOIN antrian_panggil USING(id_antrian_panggil)
													WHERE id_antrian_detail = ? AND tanggal = ?
													ORDER BY waktu_panggil DESC LIMIT 1)'; */
													
		$sql = 'SELECT id_antrian_panggil_detail, id_setting_layar FROM antrian_panggil_detail 
				LEFT JOIN antrian_panggil USING(id_antrian_panggil)
				LEFT JOIN setting_layar_detail USING(id_antrian_kategori)
				WHERE id_antrian_detail = ? AND tanggal = ?
				ORDER BY waktu_panggil DESC LIMIT 1';
		
		$data = $this->db->query($sql, [$id, date('Y-m-d')])->getRowArray();
		if ($data) {
			$data_db['id_setting_layar'] = $data['id_setting_layar'];
			$data_db['id_antrian_panggil_detail'] = $data['id_antrian_panggil_detail'];
			$data_db['tanggal_panggil_ulang'] = date('Y-m-d');
			$data_db['waktu_panggil_ulang'] = date('H:i:s');
			return $this->db->table('antrian_panggil_ulang')->insert($data_db);
		}
		return false;
	}
}
?>