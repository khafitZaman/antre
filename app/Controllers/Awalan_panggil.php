<?php
/**
*	App Name	: jAntrian	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2021
*/

namespace App\Controllers;
use App\Models\AwalanPanggilModel;

class Awalan_panggil extends \App\Controllers\BaseController
{
	public function __construct() {
		
		parent::__construct();
		
		$this->model = new AwalanPanggilModel;	
		$this->data['site_title'] = 'Awalan Panggil';
		
		$this->addJs ( $this->config->baseURL . 'public/vendors/jwdmodal/jwdmodal.js');
		$this->addStyle ( $this->config->baseURL . 'public/vendors/jwdmodal/jwdmodal.css');
		$this->addStyle ( $this->config->baseURL . 'public/vendors/jwdmodal/jwdmodal-loader.css');
		$this->addStyle ( $this->config->baseURL . 'public/vendors/jwdmodal/jwdmodal-fapicker.css');
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/tujuan.js');
	}
	
	public function index()
	{
		$this->hasPermissionPrefix('update');
		$this->data['title'] = 'Edit Suara Awalan Panggil Antrian';
				
		// Submit
		$this->data['message'] = [];
		if (isset($_POST['submit'])) 
		{
			$this->saveData();
		}
		
		$this->data['breadcrumb']['Edit'] = '';
		$this->data['result'] = $this->model->getAwalanPanggil();
		if (empty($this->data['result'])) {
			$this->errorDataNotFound();
		}
		
		$this->view('awalan-panggil-form.php', $this->data);
	}
	
	public function ajaxListAudio() {
		$files = scandir(ROOTPATH . '/public/files/audio');
		$this->data['files'] = $files;
		echo view('themes/modern/tujuan-list-audio.php', $this->data);
	}
	
	private function setEdit() {
		$this->data['title'] = 'Edit Data Tujuan Antrian';
		$this->data['breadcrumb']['Edit'] = '';
		unset($this->data['breadcrumb']['Add']);
		if (!empty($_POST['id'])) {
			$this->data['id'] = $_POST['id'];
		}
	}
	
	public function add() 
	{
		if (!empty($_POST['id'])) {
			$this->setEdit();
		} else {
			$this->data['breadcrumb']['Add'] = '';
			$this->data['title'] = 'Tambah Data Tujuan Antrian';
		}

		$data['message'] = [];
		if (isset($_POST['submit'])) 
		{
			$this->saveData();
			if ($this->data['message']['status'] == 'ok') {
				$this->setEdit();
				$this->data['result'] = $this->model->getTujuanById($this->data['id']);
			}
		}
		
		$this->view('tujuan-form.php', $this->data);
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
	
	public function edit()
	{
		$this->hasPermissionPrefix('update');
	
		$this->data['title'] = 'Edit Data Tujuan';
		
		if (empty($_GET['id'])) {
			$this->errorDataNotFound();
		}
		
		$id = !empty($_POST['id']) ? $_POST['id'] : $_GET['id'];
		
		// Submit
		$this->data['message'] = [];
		if (isset($_POST['submit'])) 
		{
			$this->saveData();
		}
		
		$this->data['breadcrumb']['Edit'] = '';
		$this->data['id'] = $id;
		$this->data['result'] = $this->model->getTujuanById($id);
		if (empty($this->data['result'])) {
			$this->errorDataNotFound();
		}
		
		$this->view('tujuan-form.php', $this->data);
	}
	
	private function validateForm() {
	
		$form_errors = [];
		
		if (empty($_POST['nama_file'])) {
			$form_errors['nama_file'] = 'File harus dipilih';
		}
		
		return $form_errors;
	}
}
