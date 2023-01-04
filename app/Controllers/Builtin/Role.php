<?php
/**
*	App Name	: Admin Template Dashboard Codeigniter 4	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2020
*/

namespace App\Controllers\Builtin;
use App\Models\Builtin\RoleModel;

class Role extends \App\Controllers\BaseController
{
	protected $model;
	private $formValidation;
	
	public function __construct() {
		
		parent::__construct();
		// $this->mustLoggedIn();
		
		$this->model = new RoleModel;	
		$this->data['site_title'] = 'Halaman Role';
		
		helper(['cookie', 'form']);
	}
	
	public function index()
	{
		$this->hasPermissionPrefix('read');
		$this->setData();
		
		if ($this->request->getPost('delete')) 
		{
			$this->hasPermissionPrefix('delete');
			$result = $this->model->deleteData();
			if ($result) {
				$this->data['status'] = 'ok';
				$this->data['message'] = 'Data berhasil dihapus';
			} else {
				$this->data['status'] = 'warning';
				$this->data['message'] = 'Tidak ada data yang dihapus';
			}
		}
		
		$this->data['module'] = $this->model->getAllModules();
		$this->data['result'] = $this->model->getAllRole();
		
		$this->view('builtin/role-result.php', $this->data);
	}
	
	public function add() 
	{
		$this->hasPermissionPrefix('create');
		
		$id_role = '';
		if ($this->request->getPost('submit'))
		{
			$this->data['message'] = $this->saveData();
			if ($this->data['message']['status'] == 'ok') {
				$id_role = $this->data['message']['id_role'];
			}
		}
		
		$this->setData($id_role);
		
		$breadcrumb['Add'] = '';
		$this->data['title'] = 'Tambah ' . $this->currentModule['judul_module'];
		
		$this->view('builtin/role-form.php', $this->data);
	}
	
	public function edit()
	{
		$this->hasPermissionPrefix('update');
		
		if (!$this->request->getGet('id')) {
			$this->printError(['status' => 'error', 'message' => 'Parameter tidak lengkap']);
		}
		
		$this->setData($_GET['id']);
		$data = $this->data;
		$data['title'] = 'Edit ' . $this->currentModule['judul_module'];
		$breadcrumb['Edit'] = '';
	
		// Submit
		if ($this->request->getPost('submit')) 
		{
			$save = $this->saveData();
			$data = array_merge($data, $save);
		}

		$this->view('builtin/role-form.php', $data);
	}
	
	public function setData($id_role = null) 
	{
		$this->data['module_role'] = $this->model->listModuleRole();
		$list = $this->model->listModulePermission();
		foreach ($list as $val) {
			$module_permission[$val['id_role']][$val['id_module']] = $val['judul_module'] . ' (' . $val['nama_module'] . ')';
		}
		$this->data['module_permission']= $module_permission;
		$this->data['module_status'] = $this->model->getModuleStatus();
		$this->data['role'] = $this->model->getRole($id_role);
	}
	
	private function saveData() 
	{
		$form_errors = $this->validateForm();
	
		if ($form_errors) {
			$data['status'] = 'error';
			$data['form_errors'] = $form_errors;
			$data['message'] = $form_errors;
		} else {
			$save = $this->model->saveData();
			if ($save['status'] == 'ok') {
				$data['status'] = 'ok';
				$data['message'] = 'Data berhasil disimpan';
				$data['id_role'] = $save['id_role'];
			} else {
				$data['status'] = 'error';
				$data['message'] = $save['message'];
			}
		}
		
		return $data;
	}
	
	private function validateForm() {

		$validation =  \Config\Services::validation();
		if ($this->request->getPost('id_role') == '') {
			$validation->setRule('nama_role', 'Nama Role', 'trim|required');
		}
		$validation->setRule('judul_role', 'Judul Role', 'trim|required');
		$validation->setRule('keterangan', 'keterangan', 'trim|required');
		$validation->withRequest($this->request)->run();
		$form_errors = $validation->getErrors();
		
		if (!$this->auth->validateFormToken('form_role')) {
			$form_errors['token'] = 'Token tidak ditemukan, submit ulang form dengan mengklik tombol submit';
		}
		
		return $form_errors;
	}
	
}
