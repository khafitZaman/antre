<?php
namespace App\Models;

class LayarMonitorSettingLayoutModel extends \App\Models\BaseModel
{
	public function getSettings() {
		$sql = 'SELECT * FROM setting_layar_layout';
		$data = $this->db->query($sql)->getResultArray();
		return $data;
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
			, 'text_footer_mode' => 'Text Footer Mode'
			, 'text_footer_speed' => 'Text Footer Speed'
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