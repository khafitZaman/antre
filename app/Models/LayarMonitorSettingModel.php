<?php
namespace App\Models;

class LayarMonitorSettingModel extends \App\Models\BaseModel
{
	public function getSettings() {
		$sql = 'SELECT setting_layar.*, COUNT(id_antrian_kategori) AS jml_kategori, SUM(jml_tujuan) AS jml_tujuan FROM setting_layar
				LEFT JOIN setting_layar_detail USING(id_setting_layar)
				LEFT JOIN antrian_kategori USING(id_antrian_kategori)
				LEFT JOIN (
					SELECT id_antrian_kategori, COUNT(*) AS jml_tujuan FROM antrian_detail GROUP BY id_antrian_kategori
				) AS tabel USING(id_antrian_kategori)
				GROUP BY id_setting_layar';
				
		$data = $this->db->query($sql)->getResultArray();
		return $data;
	}
	
	public function deleteLayarAntrian($id) 
	{
		$this->db->transStart();
		$this->db->table('setting_layar')->delete(['id_setting_layar' => $id]);
		$this->db->table('setting_layar_detail')->delete(['id_setting_layar' => $id]);
		$this->db->transComplete();
		
		return $this->db->transStatus();
	}
	
	public function getSettingById($id) {
		$sql = 'SELECT * FROM setting_layar WHERE id_setting_layar = ?';
		$result = $this->db->query($sql, $id)->getRowArray();
		return $result;
	}
	
	public function getSettingDetailById($id) {
		$sql = 'SELECT * FROM setting_layar_detail LEFT JOIN antrian_kategori USING(id_antrian_kategori) WHERE id_setting_layar = ?';
		$result = $this->db->query($sql, $id)->getResultArray();
		return $result;
	}
	
	public function getListKategori() {
		$sql = 'SELECT * FROM antrian_kategori';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function ajaxUpdateKategori() {
		
		$this->db->transStart();
		$this->db->table('setting_layar_detail')->delete(['id_setting_layar' => $_POST['id_setting_layar']]);
		
		$index = 1;
		$list_id_kategori = json_decode($_POST['list_id_kategori'], true);
		if ($list_id_kategori) {
			foreach ($list_id_kategori as $id_kategori) {
				$data_db[] = ['id_setting_layar' => $_POST['id_setting_layar'], 'id_antrian_kategori' => $id_kategori, 'urut' => $index];
				$index++;
			}
			$this->db->table('setting_layar_detail')->insertBatch($data_db);
		}
		$this->db->transComplete();
		
		return $this->db->transStatus();
	}
	
	public function saveSetting() 
	{
		if (empty($_POST['id'])) {
			$save = $this->db->table('setting_layar')->insert(['nama_setting' => $_POST['nama_setting']]);
		} else {
			$save = $this->db->table('setting_layar')->update(['nama_setting' => $_POST['nama_setting']], ['id_setting_layar' => $_POST['id']]);
			
		}
		return $save;
	}
	
	public function saveData($user_permission) 
	{
		$query = false;
		$sql = 'SELECT * FROM setting_layar_layout';
		$query = $this->db->query($sql)->getResultArray();
		
		foreach($query as $val) {
			$curr_db[$val['param']] = $val['value'];
		}
					
		$params = ['color_scheme' => 'Color Scheme'
			, 'font_family' => 'Font Family'
			, 'font_size' => 'Font Size'
			, 'text_footer' => 'Text Footer'
			, 'link_video' => 'Link Video'
			, 'jenis_video' => 'Jenis Video'
		];
		
		foreach ($params as $param => $title) {
			$data_db[] = ['param' => $param, 'value' => $_POST[$param]];
			$arr[$param] = $_POST[$param];
		}
				
		if (key_exists('update_all', $user_permission))
		{
			$this->db->transStart();
			$this->db->query('DELETE FROM setting_layar_layout');
			$result = $this->db->table('setting_layar_layout')->insertBatch($data_db);
			$this->db->transComplete();
			$result = $this->db->transStatus();
			
			if ($this->db->transStatus()) {
				$font_size = str_replace('px', '', $_POST['font_size']);
				$line_height = $font_size + ($font_size * (50/100));
				$font_size_large = $font_size + ($font_size * (30/100));
				
				$file_name = ROOTPATH . 'public/themes/modern/css/layar-monitor-show-font.css';
				$content = 'html, body {font-family: "' . $_POST['font_family'] . '", "segoe ui", arial, verdana}
.box-antrian-body { font-size: ' . $_POST['font_size'] . 'px; line-height: ' . $line_height . 'px }
.current-antrian-number { font-size: ' . $font_size_large . 'px}	';
					
				file_put_contents($file_name, $content);					
			}
		}
		return $result;
	}
}
?>