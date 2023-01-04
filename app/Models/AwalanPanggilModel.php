<?php
/**
*	App Name	: Antrian	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2021
*/

namespace App\Models;

class AwalanPanggilModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
	}
	
	public function deleteData() {
		$result = $this->db->table('antrian_tujuan')->delete(['id_antrian_tujuan' => $_POST['id']]);
		return $result;
	}
	
	public function getAwalanPanggil() {
		$sql = 'SELECT * FROM antrian_panggil_awalan';
		$result = $this->db->query($sql)->getRowArray();
		return $result;
	}
		
	public function saveData() {

		$data_db['nama_file'] = json_encode($_POST['nama_file']);
		$query = $this->db->table('antrian_panggil_awalan')->update($data_db);

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