<?php
/**
*	App Name	: jMedik	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2021
*/

namespace App\Controllers;
use App\Models\LayarMonitorSettingLayoutModel;

class Layar_monitor_setting_layout extends \App\Controllers\BaseController
{
	public function __construct() {
		
		parent::__construct();
		
		$this->model = new LayarMonitorSettingLayoutModel;	
		$this->data['title'] = 'Setting Tampilan Layar Monitor Antrian';
		
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/layar-monitor-setting-layout.js?r=' . time());
		$this->addStyle ( $this->config->baseURL . 'public/themes/modern/builtin/css/setting.css');
		
		helper(['cookie', 'form']);
	}
	
	public function index() 
	{
		$data = $this->data;
		if (!empty($_POST['submit'])) 
		{
			
			if ($this->hasPermission('update_all')
				|| $this->hasPermission('update_own')
			) {
				$save = $this->model->saveData($this->userPermission);
				
				if ($save) {
					$data['status'] = 'ok';
					$data['message'] = 'Data berhasil disimpan';
				} else {
					$data['status'] = 'error';
					$data['message'] = 'Data gagal disimpan';
				}
			} else {
				$data['status'] = 'error';
				$data['message'] = 'Role anda tidak diperbolehkan melakukan perubahan';
			}
			
			if (!empty($_POST['ajax'])) {
				echo json_encode($data); die;
			}
		}
		
		
		$query = $this->model->getSettings();
		foreach($query as $val) {
			$data[$val['param']] = $val['value'];
		}

		$this->view('layar-monitor-setting-layout-form.php', $data);
	}
}
