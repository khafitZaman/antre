<?php
/**
*	App Name	: Aplikasi Antrian Berbasis Web	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2022
*/

namespace App\Controllers;
use App\Models\AntrianPanggilModel;

require APPPATH . 'ThirdParty/Escpos/vendor/autoload.php';

class Antrian_panggil extends \App\Controllers\BaseController
{
	public function __construct() {
		
		parent::__construct();
		
		$this->model = new AntrianPanggilModel;	
		$this->data['site_title'] = 'Panggil Antrian';

		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/antrian-panggil.js');
	}
	
	public function index()
	{
		$this->hasPermissionPrefix('read');
		$this->data['title'] = 'Panggil Antrian';
		$this->setKategori();
		
		if (!empty($_GET['kategori'])) 
		{
			$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/antrian-panggil-liveupdate.js');
			
			$antrian_kategori = $this->model->getAntrianKategoriById($_GET['kategori']);
			if (!$antrian_kategori) {
				$this->errorDataNotFound();
			}
			
			$this->data['kategori'] = $antrian_kategori;
			$this->data['antrian'] = $this->model->getAntrianDetailByIdKategori($_GET['kategori']);
			$this->data['jml_dipanggil'] = $this->model->getDipanggil($_GET['kategori']);
			
			$query = $this->model->getAntrianUrut();

			$antrian_urut = [];
			foreach ($query as $val) {
				$antrian_urut[$val['id_antrian_kategori']] = $val;
			}
			
			
			$this->data['antrian_urut'] = $antrian_urut;
			$this->view('antrian-panggil-detail.php', $this->data);
		} else {
			
			$this->data['setting_layar'] = $this->model->getAllSettingLayar();
			$data = $this->model->getAllTujuan();
			$tujuan = [];
			foreach ($data as $val) {
				if ($val['id_setting_layar']) {
					$tujuan[$val['id_setting_layar']][$val['id_antrian_kategori']]['nama'] = $val['nama_antrian_kategori'];
					$tujuan[$val['id_setting_layar']][$val['id_antrian_kategori']]['tujuan'][] = $val;
				} else {
					$tujuan['undefined'][$val['id_antrian_kategori']]['nama'] = $val['nama_antrian_kategori'];
					$tujuan['undefined'][$val['id_antrian_kategori']]['tujuan'][] = $val;
				}
			}
			
			if (!$tujuan) {
				$this->errorDataNotFound();
				return;
			}
			
			if (key_exists('undefined', $tujuan)) {
				$this->data['setting_layar']['undefined'] = ['id_setting_layar' => 'undefined', 'nama_setting' => ''];
			}
			$this->data['tujuan'] = $tujuan;
			$this->view('antrian-panggil-kategori.php', $this->data);
			
		}
	}
	
	private function setKategori() {
		
		$antrian_kategori = $this->model->getAntrianKategoriAktif();
		if (count($antrian_kategori) == 1) {
			$_GET['kategori'] = $antrian_kategori[0]['id_antrian_kategori'];
		}
	}
		
	public function panggil_antrian() 
	{
		$this->data['title'] = 'Panggil Antrian';
		$this->setKategori();
		
		if (!empty($_GET['kategori'])) 
		{
			$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/antrian-liveupdate-panggil.js');
			
			$antrian_kategori = $this->model->getAntrianKategoriById($_GET['kategori']);
			if (!$antrian_kategori) {
				$this->errorDataNotFound();
			}
			
			$this->data['antrian'] = $this->model->getAntrianDetailByIdKategori($_GET['kategori']);
			
			$query = $this->model->getAntrianUrut();

			$antrian_urut = [];
			foreach ($query as $val) {
				$antrian_urut[$val['id_antrian_detail']] = $val;
			}
			
			$this->data['antrian_urut'] = $antrian_urut;
			$this->view('antrian-panggil-detail.php', $this->data);
		} else {
		
			$this->data['antrian'] = $this->model->getAntrianKategori();
			$this->view('antrian-panggil-kategori.php', $this->data);
		}
	}
	
	public function ajax_panggil_antrian() 
	{
		if (empty($_POST['id'])) {
			$message['status'] = 'error';
			$message['message'] = 'Invalid input';
			echo json_encode($message);
			exit;
		}
		
		$id = $_POST['id'];
		$result = $this->model->getAntrianDetailById($id);
		if (!$result) {
			$message['status'] = 'error';
			$message['message'] = 'Invalid input';
			echo json_encode($message);
			exit;
		}
		
		$urut = $this->model->getAntrianUrutByIdKategori($result['id_antrian_kategori']);

		if ($urut['jml_dipanggil'] >= $urut['jml_antrian']) {
			$message['status'] = 'error';
			$message['message'] = 'Semua antrian sudah dipanggil';
			echo json_encode($message);
			exit;
		}
		
		$panggil = $this->model->panggilAntrian($result['id_antrian_kategori'], $id);
		if ($panggil) {
			$message['status'] = 'ok';
			$message['message'] = $panggil;
		} else {
			$message['status'] = 'error';
			$message['message'] = 'Error memanggil antrian';
		}
		
		echo json_encode($message);
		exit;
	}
	
	public function ajax_panggil_ulang_antrian() 
	{
		if (empty($_POST['id'])) {
			$message['status'] = 'error';
			$message['message'] = 'Invalid input';
			echo json_encode($message);
			exit;
		}
		
		$id = $_POST['id'];
		$antrian_detail = $this->model->getAntrianDetailById($id);
		if (!$antrian_detail) {
			$message['status'] = 'error';
			$message['message'] = 'Invalid input';
			echo json_encode($message);
			exit;
		}
		
		$save = $this->model->savePanggilUlangAntrian($id);
		
		/* $urut = $this->model->getAntrianUrutByIdDetail($id);
		if (!$urut) {
			$message['status'] = 'error';
			$message['message'] = 'Invalid input';
			echo json_encode($message);
			exit;
		} */
			
		if ($save) {
			$message['status'] = 'ok';
			$message['message'] = 'Data berhasil disimpan';
		} else {
			$message['status'] = 'error';
			$message['message'] = 'Data gagal disimpan';
		}
		
		echo json_encode($message);
		exit;
	}
}
