<?php
/**
*	App Name	: Antrian	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2021
*/

namespace App\Models;

class SettingPrinterModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
	}
	
	public function deleteData($id) {
		$delete = $this->db->table('setting_printer')->delete(['id_setting_printer' => $id]);
		return $delete;
	}
	
	public function getSettingPrinter() {
		$sql = 'SELECT * FROM setting_printer';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getSettingPrinterById($id) {
		$sql = 'SELECT * FROM setting_printer WHERE id_setting_printer = ?';
		$result = $this->db->query($sql, (int) $id)->getRowArray();
		return $result;
	}
	
	public function setAktif($id, $status) {
		$this->db->table('setting_printer')->update(['aktif' => $status], ['id_setting_printer' => $id]);
		$result = $this->db->affectedRows();
		return $result;
	}
	
	public function saveData() {

		helper('upload_file');
		
		$data_db['nama_setting_printer'] = trim($_POST['nama_setting_printer']);
		$data_db['alamat_server'] = trim($_POST['alamat_server']);
		$data_db['aktif'] = trim($_POST['aktif']);
		
		if (!empty($_POST['id'])) {
			$query = $this->db->table('setting_printer')->update($data_db, ['id_setting_printer' => $_POST['id']]);
			if ($query) {
				$result['id'] = $this->db->insertID();
			}
		} else {
			$query = $this->db->table('setting_printer')->insert($data_db);
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