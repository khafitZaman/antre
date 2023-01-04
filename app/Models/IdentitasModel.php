<?php
/**
*	App Name	: Antrian	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2022
*/

namespace App\Models;

class IdentitasModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
	}
	
	public function getIdentitas() {
		$sql = 'SELECT * FROM identitas';
		$result = $this->db->query($sql)->getRowArray();
		return $result;
	}
	
	public function saveData() {

		helper('upload_file');
		
		$data_db['nama'] = $_POST['nama'];
		$data_db['alamat'] = $_POST['alamat'];
		$data_db['no_hp'] = $_POST['no_hp'];
		$data_db['email'] = $_POST['email'];
		$data_db['website'] = $_POST['website'];

		$sql = 'SELECT file_logo FROM identitas';
		$img_db = $this->db->query($sql)->getRowArray();
		$new_name = $img_db['file_logo'];
		
		$path = ROOTPATH . '/public/images/';
		if ($_FILES['file_logo']['name']) 
		{
			//old file
			if ($img_db['file_logo']) {
				
				if (file_exists($path . $img_db['file_logo'])) {
					$unlink = unlink($path . $img_db['file_logo']);
					if (!$unlink) {
						$result['message']['status'] = 'error';
						$result['message']['content'] = 'Gagal menghapus gambar lama';
						return $result;
					}
				}
			}
			
			$new_name = upload_image($path, $_FILES['file_logo'], 300,300);
			if (!$new_name) {
				$result['message']['status'] = 'error';
				$result['message']['content'] = 'Error saat memperoses gambar';
				return $result;
			}
		}
		
		$data_db['file_logo'] = $new_name;
		
		$query = $this->db->table('identitas')->update($data_db);
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