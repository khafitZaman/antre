<?php
/**
*	App Name	: Aplikasi Antrian Professional	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2022
*/

namespace App\Controllers;
use App\Models\AntrianRekapModel;

require APPPATH . 'ThirdParty/Escpos/vendor/autoload.php';

class Antrian_rekap extends \App\Controllers\BaseController
{
	public function __construct() {
		
		parent::__construct();
		
		$this->model = new AntrianRekapModel;	
		$this->data['site_title'] = 'Rekap Antrian';
		
		$this->addJs ( $this->config->baseURL . 'public/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js' );
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/antrian-rekap.js');
		$this->addStyle ( $this->config->baseURL . 'public/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.css');
	}
	
	public function index()
	{
		$this->hasPermissionPrefix('read');
		$this->data['title'] = 'Rekap Antrian';
		$this->data['antrian_kategori'] = $this->model->getAntrianKategori();
		
		if (!empty($_GET['submit'])) {
			$this->data['antrian_rekap'] = $this->model->getAntrianRekap();
		}
				
		$this->view('antrian-rekap-form.php', $this->data);
	}
}
