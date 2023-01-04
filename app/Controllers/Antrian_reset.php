<?php
/**
*	App Name	: Aplikasi Antrian Professional	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2022
*/

namespace App\Controllers;
use App\Models\AntrianResetModel;

require APPPATH . 'ThirdParty/Escpos/vendor/autoload.php';

class Antrian_reset extends \App\Controllers\BaseController
{
	public function __construct() {
		
		parent::__construct();
		
		$this->model = new AntrianResetModel;	
		$this->data['site_title'] = 'Reset Antrian';
		
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/antrian-reset.js');
	}
	
	public function index()
	{
		$this->hasPermissionPrefix('read');
		$this->data['title'] = 'Reset Antrian';
		$this->data['antrian_kategori'] = $this->model->getAntrianKategori();

		if (!$this->data['antrian_kategori']) {
			$this->data = array_merge($this->data, ['status' => 'error', 'message' => 'Data antrian hari ini tidak ditemukan']);
		}
		
		$this->view('antrian-reset.php', $this->data);
	}
	
	public function ajax_reset_dipanggil_by_kategori() 
	{
		if (empty($_POST['id'])) {
			echo json_encode(
				[
					'status' => 'error',
					'message' => 'Invalid input'
				]
			);
			exit;
		}
		$id = $_POST['id'];
		$reset = $this->model->resetDipanggilByIdKategori($id); 
		// $reset = true;
		if ($reset) {
			$message = ['status' => 'ok', 'message' => 'Data berhasil dihapus'];
		} else {
			$message = ['status' => 'error', 'message' => 'Data gagal dihapus'];
		}
		
		echo json_encode($message);
	}
	
	public function ajax_reset_all_by_kategori() 
	{
		if (empty($_POST['id'])) {
			echo json_encode(
				[
					'status' => 'error',
					'message' => 'Invalid input'
				]
			);
			exit;
		}
		$id = $_POST['id'];
		$reset = $this->model->resetAllByIdKategori($id); 
		// $reset = true;
		if ($reset) {
			$message = ['status' => 'ok', 'message' => 'Data berhasil dihapus'];
		} else {
			$message = ['status' => 'error', 'message' => 'Data gagal dihapus'];
		}
		
		echo json_encode($message);
	}
	
	public function ajax_reset_all_dipanggil() 
	{
		$reset = $this->model->resetAllDipanggil(); 
		// $reset = true;
		if ($reset) {
			$message = ['status' => 'ok', 'message' => 'Data berhasil dihapus'];
		} else {
			$message = ['status' => 'error', 'message' => 'Data gagal dihapus'];
		}
		
		echo json_encode($message);
	}
	
	public function ajax_reset_all() 
	{
		$reset = $this->model->resetAll(); 
		// $reset = true;
		if ($reset) {
			$message = ['status' => 'ok', 'message' => 'Data berhasil dihapus'];
		} else {
			$message = ['status' => 'error', 'message' => 'Data gagal dihapus'];
		}
		
		echo json_encode($message);
	}
}
