<?php
/**
*	App Name	: jMedik	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2021
*/

namespace App\Controllers;
use App\Models\LayarMonitorSettingModel;

class Layar_monitor_setting extends \App\Controllers\BaseController
{
	public function __construct() {
		
		parent::__construct();
		
		$this->model = new LayarMonitorSettingModel;	
		$this->data['title'] = 'Setting Tampilan Layar Monitor Antrian';
		
		// $this->addJs ( $this->config->baseURL . 'public/themes/modern/js/layar-monitor-setting.js?r=' . time());
		// $this->addStyle ( $this->config->baseURL . 'public/themes/modern/builtin/css/setting.css');
		
		helper(['cookie', 'form']);
	}
	
	public function edit() {
		
		if (!empty($_POST['submit'])) {
			$error = $this->validateFormSetting();
			if ($error) {
				$this->data['message'] = ['status' => 'error', 'message' => $error];
			} else {
				$save = $this->model->saveSetting();
				if ($save) {
					$message = ['status' => 'ok', 'message' => 'Data berhasil disimpan'];
				} else {
					$message = ['status' => 'error', 'message' => 'Data gagal disimpan'];
				}
				$this->data['message'] = $message;
			}
		}
		$setting = $this->model->getSettingById($_GET['id']);
		$this->data['setting'] = $setting;
		$this->view('layar-monitor-setting-form.php', $this->data);
	}
	
	public function add() {
		
		if (!empty($_POST['submit'])) {
			$error = $this->validateFormSetting();
			if ($error) {
				$this->data['message'] = ['status' => 'error', 'message' => $error];
			} else {
				$save = $this->model->saveSetting();
				if ($save) {
					$message = ['status' => 'ok', 'message' => 'Data berhasil disimpan'];
				} else {
					$message = ['status' => 'error', 'message' => 'Data gagal disimpan'];
				}
				$this->data['message'] = $message;
			}
		}
		$this->view('layar-monitor-setting-form.php', $this->data);
	}
	
	public function edit_kategori() {
		
		$this->addStyle ( $this->config->baseURL . 'public/themes/modern/css/layar-monitor-setting-kategori.css');
		$this->addJs($this->config->baseURL . 'public/vendors/dragula/dragula.min.js');
		$this->addStyle($this->config->baseURL . 'public/vendors/dragula/dragula.min.css');
		$this->addJs($this->config->baseURL . 'public/themes/modern/js/layar-monitor-setting.js');
		
		if (!empty($_POST['submit'])) {
			$error = $this->validateFormSetting();
			if ($error) {
				$this->data['message'] = ['status' => 'error', 'message' => $error];
			} else {
				$save = $this->model->saveSetting();
				if ($save) {
					$message = ['status' => 'ok', 'message' => 'Data berhasil disimpan'];
				} else {
					$message = ['status' => 'error', 'message' => 'Data gagal disimpan'];
				}
				$this->data['message'] = $message;
			}
		}
		
		$this->data['selected_kategori'] = $this->model->getSettingDetailById($_GET['id']);
		$this->data['list_kategori'] = $this->model->getListKategori();
		$this->view('layar-monitor-setting-kategori-form.php', $this->data);
	}
	
	public function ajaxUpdateKategori() 
	{
		$save = $this->model->ajaxUpdateKategori();
		if ($save) {
			$message = ['status' => 'ok', 'message' => 'Data berhasil disimpan'];
		} else {
			$message = ['status' => 'error', 'message' => 'Data gagal disimpan'];
		}
		
		echo json_encode($message);
	}
	
	public function index() 
	{
		if (!empty($_POST['delete'])) 
		{ 
			$this->hasPermission('delete_all', true);
			
			$result = $this->model->deleteLayarAntrian($_POST['id']);
				
			if ($result) {
				$this->data['message'] = ['status' => 'ok', 'message' => 'Data layar antrian berhasil dihapus'];
			} else {
				$this->data['message'] = ['status' => 'error', 'message' => 'Data layar antrian gagal dihapus'];
			}
		}
		$this->data['result'] = $this->model->getSettings();
		$this->view('layar-monitor-setting-result.php', $this->data);
	}
	
	private function validateFormSetting() {
	
		$validation =  \Config\Services::validation();
		$validation->setRule('nama_setting', 'Nama Setting', 'trim|required');
		$validation->withRequest($this->request)->run();
		$form_errors = $validation->getErrors();
		
		return $form_errors;
	}
}
