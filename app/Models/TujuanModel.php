<?php
/**
*	App Name	: Antrian	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2021
*/

namespace App\Models;

class TujuanModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
	}
	
	public function deleteData() {
		$result = $this->db->table('antrian_tujuan')->delete(['id_antrian_tujuan' => $_POST['id']]);
		return $result;
	}
	
	public function getAllTujuan() {
		$sql = 'SELECT * FROM antrian_tujuan';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getTujuanById($id) {
		$sql = 'SELECT * FROM antrian_tujuan WHERE id_antrian_tujuan = ?';
		$result = $this->db->query($sql, (int) $id)->getRowArray();
		return $result;
	}
	
	public function saveData() {

		$data_db['nama_antrian_tujuan'] = $_POST['nama_antrian_tujuan'];
		$data_db['nama_file'] = json_encode($_POST['nama_file']);
		
		if ($_POST['id']) 
		{
			$query = $this->db->table('antrian_tujuan')->update($data_db, ['id_antrian_tujuan' => $_POST['id']]);

		} else {
			$query = $this->db->table('antrian_tujuan')->insert($data_db);
			$result['id_antrian_tujuan'] = '';
			if ($query) {
				$result['id'] = $this->db->insertID();
			}
		}
		
		if ($query) {
			$result['message']['status'] = 'ok';
			$result['message']['content'] = 'Data berhasil disimpan';
		} else {
			$result['message']['status'] = 'error';
			$result['message']['content'] = 'Data gagal disimpan';
		}
		
		return $result;
	}
}
?>