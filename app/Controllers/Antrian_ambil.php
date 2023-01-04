<?php
/**
*	App Name	: jMedik	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2022
*/

namespace App\Controllers;
use App\Models\AntrianAmbilModel;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

require APPPATH . 'ThirdParty/Escpos/vendor/autoload.php';

class Antrian_ambil extends \App\Controllers\BaseController
{
	public function __construct() {
		
		parent::__construct();
		
		$this->model = new AntrianAmbilModel;	
		$this->data['site_title'] = 'Ambil Antrian';
		
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/antrian-ambil.js');
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/antrian-ambil-liveupdate.js');
	}
	
	public function index()
	{
		$this->hasPermissionPrefix('read');
		$this->data['title'] = 'Ambil Antrian';
		$this->setKategori();
				
		if (!empty($_GET['id_layar'])) 
		{
			/* $this->addJs ( $this->config->baseURL . 'public/themes/modern/js/antrian-liveupdate-urut.js');
			
			$antrian_kategori = $this->model->getAntrianKategoriById($_GET['kategori']);
			if (!$antrian_kategori) {
				$this->errorDataNotFound();
			}

			$this->data['antrian'] = $this->model->getAntrianDetailByIdKategori($_GET['kategori']);
			$query = $this->model->getAntrianUrut();

			$antrian_urut = [];
			foreach ($query as $val) {
				$antrian_urut[$val['id_antrian_detail']] = $val['jml_antrian'];
			}
			$this->data['antrian_urut'] = $antrian_urut;
			$this->view('antrian-lihat-detail.php', $this->data); */
			
			$query = $this->model->getAntrianUrut();

			$antrian_urut = [];
			foreach ($query as $val) {
				$antrian_urut[$val['id_antrian_kategori']] = $val['jml_antrian'];
			}
			
			$this->data['antrian_urut'] = $antrian_urut;
			$this->data['antrian'] = $this->model->getAntrianKategori();
			$this->view('antrian-ambil-kategori.php', $this->data);
		
		} else {
			
			$this->data['setting_layar'] = $this->model->getAllSettingLayar();
			$data = $this->model->getAllTujuan();
			
			$tujuan = [];
			foreach ($data as $val) 
			{
				if ($val['id_setting_layar']) {
					$tujuan[$val['id_setting_layar']][$val['id_antrian_kategori']]['kategori'] = ['id' => $val['id_antrian_kategori'], 'nama' => $val['nama_antrian_kategori']];
					$tujuan[$val['id_setting_layar']][$val['id_antrian_kategori']]['tujuan'][] = $val;
				} else {
					$tujuan['undefined'][$val['id_antrian_kategori']]['kategori'] = ['id' => $val['id_antrian_kategori'], 'nama' => $val['nama_antrian_kategori']];
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
			
			
			// Jumlah antrian
			$query = $this->model->getAntrianUrut();
			$antrian_urut = [];
			foreach ($query as $val) {
				$antrian_urut[$val['id_antrian_kategori']] = $val['jml_antrian'];
			}
			
			$this->data['antrian_urut'] = $antrian_urut;
		
			$this->data['tujuan'] = $tujuan;
			$this->view('antrian-ambil-result.php', $this->data);
			
			
			/* $this->data['setting_layar'] = $this->model->getAllSettingLayar();
			$data = $this->model->getAllTujuan();
			foreach ($data as $val) {
				$tujuan[$val['id_setting_layar']][] = $val['nama_antrian_tujuan'];
			}
			$this->data['tujuan'] = $tujuan;
			$this->view('antrian-ambil-result.php', $this->data); */
		}
		
		/* $query = $this->model->getAntrianUrut();

		$antrian_urut = [];
		foreach ($query as $val) {
			$antrian_urut[$val['id_antrian_kategori']] = $val['jml_antrian'];
		}
		
		$this->data['antrian_urut'] = $antrian_urut;
		$this->data['antrian'] = $this->model->getAntrianKategori();
		$this->view('antrian-lihat-kategori.php', $this->data); */
	}
	
	private function setKategori() {
		
		$antrian_kategori = $this->model->getAntrianKategoriAktif();
		if (count($antrian_kategori) == 1) {
			$_GET['kategori'] = $antrian_kategori[0]['id_antrian_kategori'];
		}
	}
	
	public function ajax_ambil_antrian() 
	{
		if (empty($_POST['id'])) {
			$message['status'] = 'error';
			$message['message'] = 'Invalid input id';
			echo json_encode($message);
			exit;
		}
		
		$id = $_POST['id'];
		$result = $this->model->getAntrianKategoriById($id);
		if (!$result) {
			$message['status'] = 'error';
			$message['message'] = 'Invalid input result';
			echo json_encode($message);
			exit;
		}
		
		$antrian = $this->model->ambilAntrian($id);
		if ($antrian) {
			$this->cetakAntrian($antrian);
			$message['status'] = 'ok';
			$message['data'] = $antrian;
		} else {
			$message['status'] = 'error_printer';
			$message['data'] = 'Error mengambil antrian';
		}
		
		echo json_encode($message);
		exit;
	}
	
	private function cetakAntrian($antrian) {
		
		try {
			
			$identitas = $this->model->getIdentitas();
			$printer_aktif = $this->model->getAktifPrinter();
			if ($printer_aktif) {
				foreach ($printer_aktif as $val) {
					$connector = new WindowsPrintConnector($val['alamat_server']);
					$printer = new Printer($connector);
					
					$printer -> setJustification(Printer::JUSTIFY_CENTER);
					$printer->setFont(Printer::FONT_A);
					$printer->setTextSize(1,1);
					$printer -> text(strtoupper($identitas['nama']) . "\n");
					$printer -> text("NOMOR ANTRIAN\n");
					$printer -> text("=========================");
					$printer -> text("\n");
					$printer->setTextSize(7,7);
					$printer -> text($antrian['awalan'] . $antrian['jml_antrian']);
					$printer->setTextSize(1,1);
					$printer -> text("\n=========================\n");
					$printer -> text($antrian['nama_antrian_kategori'] . "\n");
					$printer -> text(format_tanggal(date('Y-m-d')) . "\n");
					$printer -> text(date('H:i:s'));
					$printer -> feed(2);
					// $printer -> cut();
					
					/* Close printer */
					$printer -> close();
				}
			}
		} catch (Exception $e) {
			echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
		}
	}
}
