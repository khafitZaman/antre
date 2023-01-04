<?php
/**
*	App Name	: Antrian	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2022
*/

namespace App\Controllers;
use App\Models\SettingPrinterModel;

class Setting_printer extends \App\Controllers\BaseController
{
	public function __construct() {
		
		parent::__construct();
		
		$this->model = new SettingPrinterModel;	
		$this->data['site_title'] = 'Setting Printer';
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/setting-printer.js?r=' . time());
	}
	
	public function index()
	{
		$this->hasPermissionPrefix('read');
		$this->data['title'] = 'Setting Printer';
		
		if ($this->request->getPost('delete')) 
		{
			$this->hasPermission('delete_all');
			
			$delete = $this->model->deleteData($_POST['id']);
			if ($delete) {
				$data['message'] = ['status' => 'ok', 'message' => 'Data produk berhasil dihapus'];
			} else {
				$data['message'] = ['status' => 'warning', 'message' => 'Tidak ada data yang dihapus'];
			}
		}
		
		$this->data['result'] = $this->model->getSettingPrinter();
		if (!$this->data['result']) {
			$this->data['message'] = ['status' => 'error', 'message' => 'Data tidak ditemukan'];
		}

		$this->view('setting-printer-result.php', $this->data);
	}
	
	public function add() {
		
		$this->data['title'] = 'Tambah Printer';
		if (isset($_POST['submit'])) 
		{
			$form_errors = $this->validateForm();

			if ($form_errors) {
				$this->data['message']['status'] = 'error';
				$this->data['message']['content'] = $form_errors;
			} else {
				
				$message = $this->model->saveData();
				$this->data = array_merge($this->data, $message);
			}
		}

		$this->view('setting-printer-form.php', $this->data);
	}
	
	public function edit() 
	{
		$this->data['title'] = 'Edit Setting Printer';
		
		if (empty($_GET['id'])) {
			$this->errorDataNotFound();
		}
		
		$this->data['result'] = $this->model->getSettingPrinterById($_GET['id']);
		if (!$this->data['result']) {
			$this->errorDataNotFound();
		}
		
		if (isset($_POST['submit'])) 
		{
			$this->saveData();
		}
		
		if (!empty($_POST['id'])) {
			$this->data['id'] = $_POST['id'];
		} else {
			$this->data['id'] = $_GET['id'];
		}

		$this->view('setting-printer-form.php', $this->data);
	}
	
	public function ajaxSetAktif() {
		$result = $this->model->setAktif($_POST['id'], $_POST['status']);
		if ($result) {
			$message['status'] = 'ok';
		} else {
			$message['status'] = 'error';
		}
		echo json_encode($message);
	}
	
	private function saveData() 
	{
		$form_errors = $this->validateForm();
	
		if ($form_errors) {
			$this->data['message']['status'] = 'error';
			$this->data['message']['content'] = $form_errors;
		} else {
			
			$message = $this->model->saveData();
			$this->data = array_merge($this->data, $message);
		}
	}
	
	private function validateForm() {
	
		$validation =  \Config\Services::validation();
		$validation->setRule('nama_setting_printer', 'Nama Setting Printer', 'trim|required');
		$validation->setRule('alamat_server', 'Alamat Server Printer', 'trim|required');
		$validation->withRequest($this->request)->run();
		$form_errors = $validation->getErrors();
		
		return $form_errors;
	}
}
