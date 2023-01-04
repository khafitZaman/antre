<?php
/**
*	App Name	: Aplikasi Antrian Professional	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2022
*/

namespace App\Controllers;
use App\Models\LayarModel;

class Layar extends \App\Controllers\BaseController
{
	public function __construct() {
		
		parent::__construct();
		
		$this->model = new LayarModel;	
		$this->data['site_title'] = 'Layar Monitor Antrian';
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/layar-ambil-antrian.js' );
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/layar-monitor.js' );
	}
	
	public function index()
	{
		$this->hasPermissionPrefix('read');
		
		$this->data['antrian_kategori'] = $this->model->getAllSettingLayar();
		$this->view('layar-antrian-result.php', $this->data);
	}
	
	public function antrian() {
		$this->hasPermissionPrefix('read');
		
		// $this->setKategori();
		if (!empty($_GET['id'])) {
			$this->show_layar_antrian();
		} else {
			$this->data['setting_layar'] = $this->model->getAllSettingLayar();
			$data = $this->model->getAllTujuan();
			foreach ($data as $val) {
				$tujuan[$val['id_setting_layar']][] = $val['nama_antrian_tujuan'];
			}
			$this->data['tujuan'] = $tujuan;
			$this->view('layar-antrian-result.php', $this->data);
		}
	}
	
	private function setKategori() {
		
		$antrian_kategori = $this->model->getAntrianKategoriAktif();
		if (count($antrian_kategori) == 1) {
			$_GET['id'] = $antrian_kategori[0]['id_antrian_kategori'];
		}
	}
	
	public function show_layar_antrian() 
	{
		if (empty($_GET['id'])) {
			$this->errorDataNotFound();
		}
		
		$id = $_GET['id'];
		$antrian_detail = $this->model->getTujuanByIdLayarSetting($id);
		if (!$antrian_detail) {
			$this->errorDataNotFound();
		}
		$this->data['identitas'] = $this->model->getIdentitas();
		$query = $this->model->getSettingLayarMonitor();
		foreach ($query as $val) {
			$param[$val['param']] = $val['value'];
		}
		$this->data['setting'] = $param;
			
		// $this->data['antrian_detail'] = $antrian_detail;
		$this->data['antrian_kategori'] = $this->model->getAntrianKategoriByIdLayar($id);
		// $this->data['urut'] = $this->model->getAntrianUrut($id);
		
		echo view('themes/modern/layar-antrian-show.php', $this->data);
	}
	
	public function show_layar_monitor() 
	{
		$this->data['title'] = 'Layar Monitor Antrian';
		$this->setKategori();

		if (!empty($_GET['id'])) 
		{
			$id = $_GET['id'];
			$result = $this->model->getTujuanByIdLayarSetting($id);
			
			if (!$result) {
				$this->printError('Layar Antrian dengan id ' . $_GET['id'] . ' Tidak Ditemukan');
				return;
			}
			
			$this->addJs( $this->config->baseURL . 'public/themes/modern/js/layar-liveupdate-monitor-antrian.js' );
			$this->addStyle ( $this->config->baseURL . 'public/themes/modern/css/layar-monitor-show.css' );
			$this->addStyle ( $this->config->baseURL . 'public/themes/modern/css/layar-monitor-show-font.css' );
			$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/layar-monitor-show.js' );
			
			$this->addJs ( $this->config->baseURL . 'public/vendors/plyr/plyr.js' );
			
			$this->addStyle ( $this->config->baseURL . 'public/vendors/plyr/plyr.css' );		
			
			foreach ($result as $val) {
				$antrian_detail[$val['id_antrian_detail']] = $val;
			}
			 // echo '<pre>'; print_r($antrian_detail); die;
			$this->data['identitas'] = $this->model->getIdentitas();
			$this->data['antrian_detail'] = $antrian_detail;
			$this->data['antrian_terakhir'] = $this->model->getAntrianDipanggilTerakhir($id);
			$this->data['awalan_panggil'] = $this->model->getAwalanPanggil();
			
			// Urut
			$query = $this->model->getAntrianDipanggilByTujuan($id);
			$urut = [];
			// echo '<pre>'; print_r($query); die;
			foreach ($query as $val) {
				$urut[$val['id_antrian_detail']] = $val;
			}
			// echo '<pre>'; print_r($urut); die;
			$this->data['urut'] = $urut;
			
			$query = $this->model->getSettingLayarMonitor();
			foreach ($query as $val) {
				$param[$val['param']] = $val['value'];
			}
			$this->data['setting'] = $param;
			
			echo view('themes/modern/layar-monitor-show.php', $this->data);
		} else {
			$this->data['setting_layar'] = $this->model->getAllSettingLayar();
			$data = $this->model->getAllTujuan();
			foreach ($data as $val) {
				$tujuan[$val['id_setting_layar']][] = $val['nama_antrian_tujuan'];
			}
			$this->data['tujuan'] = $tujuan;
			
			// $this->data['antrian'] = $this->model->getAntrianKategori();
			$this->view('layar-monitor-kategori.php', $this->data);
		}
	}
}
