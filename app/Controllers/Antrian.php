<?php
/**
*	App Name	: Antrian	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2022
*/

namespace App\Controllers;
use App\Models\AntrianModel;

require APPPATH . 'ThirdParty/Escpos/vendor/autoload.php';

class Antrian extends \App\Controllers\BaseController
{
	public function __construct() {
		
		parent::__construct();
		
		$this->model = new AntrianModel;	
		$this->data['site_title'] = 'Data Antrian';

		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/antrian.js');
	}
	
	public function index()
	{
		$this->hasPermissionPrefix('read');
		$this->addStyle(base_url() . '/public/vendors/bulma-switch/bulma-switch.min.css');
		
		if (!empty($_POST['delete'])) 
		{ 
			$this->hasPermission('delete_all', true);
			$jml_tujuan = $this->model->getAntrianDetailByIdKategori($_POST['id']);
			if ($jml_tujuan) {
				$this->data['message'] = ['status' => 'error', 'message' => 'Antrian ini sudah memiliki tujuan, silakan hapus tujuan terlebih dahulu'];
			} else {
				$result = $this->model->deleteDataKategori();
				
				if ($result) {
					$this->data['message'] = ['status' => 'ok', 'message' => 'Data kategori antrian berhasil dihapus'];
				} else {
					$this->data['message'] = ['status' => 'error', 'message' => 'Data kategori antrian gagal dihapus'];
				}
			}
		}
		
		// $this->data['setting_layar'] = $this->model->getAllSettingLayar();
		
		$data = $this->model->getAllTujuan();
		foreach ($data as $val) {
			
			if (!$val['nama_antrian_tujuan'])
				continue;
			
			$this->data['tujuan'][$val['id_antrian_kategori']][] = $val;
		}
		
		$this->data['antrian_kategori'] = $this->model->getAntrianKategori();
		
	
		// echo '<pre>'; print_r($data); die;
		/* foreach ($data as $val) 
		{
			if ($val['id_setting_layar']) {
				$tujuan[$val['id_setting_layar']][$val['id_antrian_kategori']]['data'] = $val;
				if ($val['nama_antrian_tujuan']) {
					$tujuan[$val['id_setting_layar']][$val['id_antrian_kategori']]['tujuan'][] = $val;
				}
			} else {
				$tujuan['undefined'][$val['id_antrian_kategori']]['data'] = $val;
				if ($val['nama_antrian_tujuan']) {
					$tujuan['undefined'][$val['id_antrian_kategori']]['tujuan'][] = $val;
				}
			}
		} */
		
		
		// echo '<pre>'; print_r($tujuan); die;
				
		
		
		$this->data['title'] = 'Antrian Kategori';
		// $this->data['result'] = $this->model->getAntrianKategori();
		
		$this->view('antrian-kategori-result.php', $this->data);
	}
	
	private function setKategori() {
		
		$antrian_kategori = $this->model->getAntrianKategoriAktif();
		if (count($antrian_kategori) == 1) {
			$_GET['kategori'] = $antrian_kategori[0]['id_antrian_kategori'];
		}
	}
	
	public function detail() {
		
		$this->addStyle(base_url() . '/public/vendors/bulma-switch/bulma-switch.min.css');
		$action = $this->request->uri->getSegment(3);
		
		if (!empty($_POST['delete'])) 
		{ 
			$this->hasPermission('delete_all', true);
			
			$result = $this->model->deleteDataDetailAntrian();
				
			if ($result) {
				$this->data['message'] = ['status' => 'ok', 'message' => 'Data antrian berhasil dihapus'];
			} else {
				$this->data['message'] = ['status' => 'error', 'message' => 'Data antrian gagal dihapus'];
			}
		}
		
		if ( $action == 'add')
			return $this->detailAdd();
		
		if (empty($_GET['id'])) {
			$this->errorDataNotFound();
		}
	
		if ( $action == 'edit')
			return $this->detailEdit();
		
		$id = $_GET['id'];
		$this->data['title'] = 'Antrian Spesifik';
		$this->data['result'] = $this->model->getAntrianDetailByIdKategori($id);
		$this->data['antrian_kategori'] = $this->model->getAntrianKategoriById($id);

		$this->view('antrian-detail-result.php', $this->data);
		
	}
	
	public function ajaxStatusKategori() 
	{
		$result = $this->model->updateStatusKategori($_POST);
		if ($result) {
			echo json_encode(['status' => 'ok']);
			exit;
		}
		
		echo json_encode(['status' => 'error', 'message' => 'Status gagal diupdate']);
	}
	
	public function ajaxStatusAntrianDetail() 
	{
		$result = $this->model->statusAntrianDetail($_POST);
		if ($result) {
			echo json_encode(['status' => 'ok']);
			exit;
		}
		
		echo json_encode(['status' => 'error', 'message' => 'Status gagal diupdate']);
	}
	
	private function detailAdd() 
	{
		if (empty($_GET['id'])) {
			$this->errorDataNotFound();
		}
		
		$id = $_GET['id'];
		$antrian_kategori = $this->model->getAntrianKategoriById($id);		
		if (!$antrian_kategori) {
			$this->errorDataNotFound();
		}
		
		$this->data['antrian_kategori'] = $antrian_kategori;
		$this->data['id_antrian_detail'] = '';
		if (!empty($_POST['submit'])) 
		{
			$form_errors = $this->validateFormAntrianDetail($_POST , $antrian_kategori['id_antrian_kategori']);
							
			if ($form_errors) {
				$message['message']['status'] = 'error';
				$message['message']['content'] = $form_errors;
			} else {
				
				$id = $_POST['id_antrian_kategori'];
				$message = $this->model->saveAntrianDetail();
				if ($message['id_antrian_detail']) {
					$this->data['id_antrian_detail'] = $message['id_antrian_detail'];
				}
				
			}
			$this->data = array_merge($this->data, $message);
		}
		
		$this->setData();
		$this->data['title'] = 'Tambah Tujuan Spesifik';
		$this->data['id_antrian_kategori'] = $id;
		$this->view('antrian-detail-form.php', $this->data);
	}
	
	private function setData() {
		$this->data['antrian_tujuan'] = $this->model->getAntrianTujuan();
	}
	
	private function detailEdit() 
	{
		if (empty($_GET['id'])) {
			$this->errorDataNotFound();
		}
		
		$id = $_GET['id'];
		$antrian_detail = $this->model->getAntrianDetailById($id);		
		if (!$antrian_detail) {
			$this->errorDataNotFound();
		}
		
		$antrian_kategori = $this->model->getAntrianKategoriById($antrian_detail['id_antrian_kategori']);
		
		if (!empty($_POST['submit'])) {
			$form_errors = $this->validateFormAntrianDetail($_POST , $antrian_kategori['id_antrian_kategori']);
							
			if ($form_errors) {
				$message['message']['status'] = 'error';
				$message['message']['content'] = $form_errors;
			} else {
				$message = $this->model->saveAntrianDetail();
				$id = $_POST['id'];
			}
			
			$this->data = array_merge($this->data, $message);
		}
		
		$this->setData();
		$this->data['antrian_detail'] = $antrian_detail;
		$this->data['id_antrian_detail'] = $id;
		$this->data['title'] = 'Edit Tujuan Antrian';
		$this->data['antrian_kategori'] = $antrian_kategori;
		
		$this->view('antrian-detail-form.php', $this->data);
	}
	
	public function add() 
	{
		$this->setData();
		$data = $this->data;
		$data['title'] = 'Tambah Data Kategori Antrian';
		$data['breadcrumb']['Add'] = '';

		$data['message'] = [];
		if (isset($_POST['submit'])) 
		{
			$form_errors = $this->validateForm();
							
			if ($form_errors) {
				$data['message']['status'] = 'error';
				$data['message']['content'] = $form_errors;
			} else {
				
				$message = $this->model->saveData();
				
				$data = array_merge($data, $message);
				$data['breadcrumb']['Edit'] = '';
			}
		}
	
		$this->view('antrian-kategori-form.php', $data);
	}
	
	public function edit()
	{
		$this->hasPermissionPrefix('update');
	
		$this->data['title'] = 'Edit Data Antrian';
		$data = $this->data;
		
		if (empty($_GET['id'])) {
			$this->errorDataNotFound();
		}
		$id = $_GET['id'];
		// Submit
		$data['message'] = [];
		if (isset($_POST['submit'])) 
		{
			$form_errors = $this->validateForm();

			if ($form_errors) {
				$data['message']['status'] = 'error';
				$data['message']['content'] = $form_errors;
			} else {
				
				// $query = false;
				$message = $this->model->saveData();
				$data = array_merge($data, $message);
			}
		}
		
		$data['breadcrumb']['Edit'] = '';
		$data['id_antrian_kategori'] = $id;
		$antrian_kategori = $this->model->getAntrianKategoriById($_GET['id']);
		if (empty($antrian_kategori)) {
			$this->errorDataNotFound();
		}
		$data = array_merge($data, ['antrian_kategori' => $antrian_kategori]);
		
		$this->view('antrian-kategori-form.php', $data);
	}
	
	private function validateForm() {
	
		$validation =  \Config\Services::validation();
		if ($_POST['nama_antrian_kategori'] != $_POST['nama_antrian_kategori_old']) {
			$validation->setRule('nama_antrian_kategori', 'Nama Kategori Antrian', 'trim|required|is_unique[antrian_kategori.nama_antrian_kategori]');
		} else {
			$validation->setRule('nama_antrian_kategori', 'Nama Kategori Antrian', 'trim|required');
		}
		$validation->withRequest($this->request)->run();
		$form_errors = $validation->getErrors();
		
		return $form_errors;
	}
	
	private function validateFormAntrianDetail($param, $id_antrian_kategori) {
	
		$validation =  \Config\Services::validation();
		// $validation->setRule('id_antrian_tujuan', 'Tujuan', 'trim|required|is_unique[antrian_detail.id_antrian_kategori,antrian_detail.id_antrian_tujuan]');
		$validation->setRule('id_antrian_tujuan', 'Tujuan', 'trim|required');
		$validation->withRequest($this->request)->run();
		$form_errors = $validation->getErrors();
		
		//Cek Unik
		/* $not_unique = $this->model->checkDuplicateAntrianDetail($param, $id_antrian_kategori);
		if ($not_unique) {
			$form_errors['id_antrian_tujuan_spesifik'] = $not_unique;
		} */
		
		return $form_errors;
	}
}
