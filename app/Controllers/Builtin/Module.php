<?php
/**
*	App Name	: Admin Template Dashboard Codeigniter 4	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2020
*/

namespace App\Controllers\Builtin;
use App\Models\Builtin\ModuleModel;

class Module extends \App\Controllers\BaseController
{
	protected $model;
	private $formValidation;
	
	public function __construct() {
		
		parent::__construct();
		// $this->mustLoggedIn();
		
		$this->model = new ModuleModel;	
		$this->data['site_title'] = 'Halaman Module';
		
		$this->addStyle ( $this->config->baseURL . 'public/vendors/bulma-switch/bulma-switch.min.css?r=' . time());
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/builtin/js/module.js');
		
		helper(['cookie', 'form']);
	}
	
	public function index()
	{
		$this->hasPermissionPrefix('read');
		
		$data = $this->data;
		$data['module'] = $this->model->getAllModules();
		$roles = $this->model->getAllRoles();
		foreach ($roles as $val) {
			$data['role'][$val['id_role']] = $val;
		}

		// Delete
		if (!empty($_POST['delete'])) 
		{
			$this->hasPermission('delete_all', true);
			$result = $this->model->deleteData();
			// $result = false;
			if ($result) {
				$data['msg'] = ['status' => 'ok', 'message' => 'Data module berhasil dihapus'];
			} else {
				$data['msg'] = ['status' => 'error', 'message' => 'Data module gagal dihapus'];
			}
		}
		
		// Module Aktif/Nonaktif/Login
		if (!empty($_POST['change_module_attr'])) 
		{
			$update_status = $this->model->updateStatus();
					
			if (!empty($_POST['ajax'])) {
				if ($update_status) {
					echo 'ok';
				} else {
					echo 'error';
				}
				die();
			}
		}
		
		
		$data['result'] = $this->model->getModules();
		
		// Cek file module
		$files = \list_files('app/Controllers');
		$files = array_map('strtolower', $files);
		
		$data['file_module'] = $files;
		
		$this->view('builtin/module-data.php', $data);
	}
	
	public function add() 
	{
		$this->hasPermissionPrefix('create');
		
		$save = [];
		if ($this->request->getPost('submit'))
		{
			$save = $this->saveData();
			
		}
		
		$id_module = key_exists('id_module', $save) ? $save['id_module'] : '';
		$this->setData($id_module);
		$this->data['module_status'] = $this->model->getAllModuleStatus();
		$data = $this->data;
		$data = array_merge( $data, ['msg' => $save]);
				
		$breadcrumb['Add'] = '';
		$data['title'] = 'Tambah Module';

		$this->view('builtin/module-form.php', $data);
	}
	
	public function edit()
	{
		$this->hasPermissionPrefix('update');
		
		$save = [];
		if ($this->request->getPost('submit'))
		{
			$save = $this->saveData();
		}
		
		$this->setData($_GET['id']);
		$data = $this->data;
		$data = array_merge( $data, ['msg' => $save]);
		
		$data['title'] = 'Edit Data Module';
		
		$module = $this->model->getModule($_GET['id']);
		$data = array_merge($data, $module);

		$data['module_status'] = $this->model->getAllModuleStatus();
		$breadcrumb['Edit'] = '';
		$this->view('builtin/module-form.php', $data);
	}
	
	private function setData($id_module = null) 
	{
		$this->data['id'] = $id_module;
		$this->data['role_permission_module'] = [];
		$this->data['module_permission'] = [];
		if ($id_module){
			$this->data['module'] = $this->model->getModule($id_module);
			$this->data['role_permission_module'] = $this->model->getRolePermissionByModule($id_module);
			$this->data['module_permission'] = $this->model->getModulePermission($id_module);
		}
		$list_role = $this->model->getAllRoles();
		foreach ($list_role as $val) {
			$roles[$val['id_role']] = $val;
		}
		$this->data['roles'] = $roles;
		
	}
	
	private function saveData() 
	{
		$unique = false;
		if ($_POST['nama_module'] != $_POST['nama_module_old']) {
			$unique = true;
		}
		
		$form_errors = $this->validateForm($unique);
	
		if ($form_errors) {
			$data['status'] = 'error';
			$data['form_errors'] = $form_errors;
			$data['message'] = $form_errors;
		} else {
			$data = $this->model->saveData();
		}
		
		return $data;
	}

	private function validateForm($check_unique = false) {
	
		$validation =  \Config\Services::validation();
		$unique = '';
		if ($check_unique) {
			$unique = '|is_unique[module.nama_module]';
		}
		$validation->setRule('nama_module', 'Nama Module', 'trim|required' . $unique);
		$validation->setRule('judul_module', 'Judul Module', 'trim|required');
		$validation->setRule('deskripsi', 'Deskripsi Module', 'trim|required');
		$validation->setRule('id_module_status', 'ID Module Status', 'trim|required');
		$validation->withRequest($this->request)->run();
		$form_errors = $validation->getErrors();
		
		return $form_errors;
	}
}