<?php
/**
*	App Name	: Aplikasi Antrian Professional
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2022
*/

namespace App\Models;

class AntrianRekapModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
	}
	
	public function getAntrianKategori() {

		$sql = 'SELECT * 
				FROM antrian_kategori';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAntrianRekap() 
	{
		list($d, $m, $y) = explode('-', $_GET['tgl_awal']);
		$tgl_awal = $y . '-' . $m . '-' . $d;
		
		list($d, $m, $y) = explode('-', $_GET['tgl_akhir']);
		$tgl_akhir = $y . '-' . $m . '-' . $d;
		
		$where = '';
		if ($_GET['id_antrian_kategori']) {
			$where = ' WHERE id_antrian_kategori = ' . $_GET['id_antrian_kategori'];
		}
		
		$sql = 'SELECT * 
				FROM antrian_kategori
				LEFT JOIN antrian_panggil USING(id_antrian_kategori)
				LEFT JOIN (
					SELECT id_antrian_kategori, COUNT(*) AS jml_tujuan FROM antrian_detail 
					GROUP BY id_antrian_kategori
				) AS antrian_detail USING(id_antrian_kategori)
				WHERE tanggal >= "' . $tgl_awal . '" 
				AND tanggal <= "' . $tgl_akhir . '"' . $where;
				
		$result = $this->db->query($sql)->getResultArray();
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
}
?>