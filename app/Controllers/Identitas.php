<?php
/**
*	App Name	: jMedik	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2021
*/

namespace App\Controllers;
use App\Models\IdentitasModel;

class Identitas extends \App\Controllers\BaseController
{
	public function __construct() {
		
		parent::__construct();
		
		$this->model = new IdentitasModel;	
		$this->data['site_title'] = 'Data Identitas';
		$this->addJs(base_url() . '/public/themes/modern/js/image-upload.js');
	}
	
	public function index()
	{
		$this->hasPermissionPrefix('read');
		$this->data['title'] = 'Data Identitas';
		
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

		$this->data['result'] = $this->model->getIdentitas();
		if (!$this->data['result']) {
			$this->errorDataNotFound();
		}

		$this->view('identitas-form.php', $this->data);
	}
	
	private function validateForm() {
	
		$validation =  \Config\Services::validation();
		$validation->setRule('nama', 'Nama', 'trim|required');
		$validation->setRule('alamat', 'Alamat', 'trim|required');
		$validation->setRule('no_hp', 'No. HP', 'trim|required');
		$validation->setRule('email', 'Email', 'trim|required');
		$validation->setRule('website', 'Website', 'trim|required');
		$validation->withRequest($this->request)->run();
		$form_errors = $validation->getErrors();
		
		return $form_errors;
	}
}
