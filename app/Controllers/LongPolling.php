<?php
/**
*	App Name	: jMedik	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2021
*/

namespace App\Controllers;
use App\Models\LongPollingModel;

class LongPolling extends \App\Controllers\BaseController
{
	public function __construct() {
		
		parent::__construct();
		
		$this->model = new LongPollingModel;	
		session_write_close();
		ignore_user_abort(true);
		set_time_limit(0);
	}
	
	/* Liveupdate layar monitor besar */
	public function monitor_current_antrian()
	{
		try {
			if (empty($_GET['id'])) {
				echo json_encode(
					[
						'status' => 'error',
						'message' => 'Invalid input'
					]
				);
				exit;
			}
			$id = $_GET['id'];
			$current_antrian = $this->model->getLastAntrianDipanggil($id);
			
			while(true) {
				
				$new_antrian =  $this->model->getAntrianBelumDipanggil($id, $current_antrian['waktu_panggil']);
				if ($new_antrian) {
					echo json_encode([
						'status' => 'ok',
						'data' => $new_antrian
					]);
					exit;
				}
				clearstatcache();
				sleep(1);
			}
		} catch (Exception $e) {
			echo json_encode(
					array (
						'status' => false,
						'error' => $e -> getMessage()
					)
				);
			exit;
		}
	}
	
	/* Liveupdate layar monitor besar - Cek panggil ulang antrian */
	public function monitor_panggil_ulang_antrian() {
		if (empty($_GET['id'])) {
			echo json_encode(
				[
					'status' => 'error',
					'message' => 'Invalid input'
				]
			);
			exit;
		}
		$id = $_GET['id'];
		$perubahan_terakhir = $this->model->getLastAntrianAmbilUlang($id);
		if (!$perubahan_terakhir) {
			$perubahan_terakhir['waktu_panggil_ulang'] = '00:00:00';
		}
		
		while(true) {
			
			$cek_baru = $this->model->cekLastAntrianAmbilUlang($id, $perubahan_terakhir);
			
			if ($cek_baru) {
				$data_baru = $this->model->getPanggilUlang($id, $perubahan_terakhir);
				if ($data_baru) {
					
					echo json_encode([
						'status' => 'ok',
						'data' => $data_baru
					]);
					
					exit;					
				}
			}
			/* 
				
				
				
			$panggil_ulang =  $this->model->getPanggilUlang($id);
			
			if ($panggil_ulang) {
				echo json_encode([
					'status' => 'ok',
					'data' => $panggil_ulang
				]);
				exit;
			} */
			clearstatcache();
			sleep(1);
		}
	}
	
	/* Cek jika perubahan pada antrian misal nama tujuan, aktif dan non aktif */
	public function monitor_perubahan_antrian() 
	{
		try {
			if (empty($_GET['id'])) {
				echo json_encode(
					[
						'status' => 'error',
						'message' => 'Invalid input'
					]
				);
				exit;
			}
			$id = $_GET['id'];
			$perubahan_terakhir = $this->model->getLastAntrianUpdate($id);
			while(true) {
				
				if ($perubahan_terakhir) {
			
					$data_baru = $this->model->getAllAntrianUpdate($id, $perubahan_terakhir);
					if ($data_baru) {
						/* foreach ($cek_perubahan as $val) {
							$result[$val['id_antrian_detail']] = $val;
						} */
						echo json_encode([
							'status' => 'ok',
							'data' => $data_baru
						]);
						
						exit;					
					}
				}
				clearstatcache();
				sleep(1);
			}
		} catch (Exception $e) {
			echo json_encode(
					array (
						'status' => false,
						'error' => $e -> getMessage()
					)
				);
			exit;
		}
	}
	
	/* Cek apakah ada antrian baru atau ada panggilan baru, untuk update data display antrian dan panggilan di tab browser lain*/
	public function current_antrian_dipanggil() 
	{
		try {
			
			$urut_terakhir = $this->model->getLastAntrianAmbilOrDipanggil($_POST['id_antrian_kategori']);
			
			// print_r($urut_terakhir); die;
			while(true) {
				
				// if ($urut_terakhir) {
					
					
					
					$new_antrian_urut = $this->model->getAntrianAmbilDipanggilByTime($_POST['id_antrian_kategori'],$urut_terakhir['time_ambil'], $urut_terakhir['time_dipanggil'] );
					// print_r($new_antrian_urut); die;
					if ($new_antrian_urut) {
						foreach ($new_antrian_urut as $val) {
							// $result[$val['id_antrian_kategori']] = $val;
						}
						echo json_encode([
							'status' => 'ok',
							'data' => $new_antrian_urut
						]);
						
						exit;					
					}
				// }
				clearstatcache();
				sleep(1);
			}
		} catch (Exception $e) {
			echo json_encode(
					array (
						'status' => false,
						'error' => $e -> getMessage()
					)
				);
			exit;
		}
	}
	
	/* Cek apakah ada antrian baru, untuk sinkronisasi antara layar antrian dan menu ambil antrian*/
	public function current_antrian_ambil() 
	{
		try {
			
			$urut_terakhir = $this->model->getLastAntrianAmbil();
			
			while(true) {
				
				if ($urut_terakhir) {
					
					$new_antrian_urut = $this->model->getAntrianAmbilByTime($urut_terakhir['time_ambil']);
					
					if ($new_antrian_urut) {
						foreach ($new_antrian_urut as $val) {
							$result[$val['id_antrian_kategori']] = $val;
						}
						echo json_encode([
							'status' => 'ok',
							'data' => $result
						]);
						
						exit;					
					}
				}
				clearstatcache();
				sleep(1);
			}
		} catch (Exception $e) {
			echo json_encode(
					array (
						'status' => false,
						'error' => $e -> getMessage()
					)
				);
			exit;
		}
	}
	
	/* Cek apakah ada antrian baru, untuk update data display antrian */
	public function current_urut() 
	{
		try {
			
			$urut_terakhir = $this->model->getLastAntrianUrut();
			while(true) {
				
				if ($urut_terakhir) {
					
					$new_antrian_urut = $this->model->getAllAntrianUrutAfterTimeAmbil($urut_terakhir['time_ambil']);
					
					if ($new_antrian_urut) {
						foreach ($new_antrian_urut as $val) {
							$result[$val['id_antrian_detail']] = $val;
						}
						echo json_encode([
							'status' => 'ok',
							'data' => $result
						]);
						
						exit;					
					}
				}
				clearstatcache();
				sleep(1);
			}
		} catch (Exception $e) {
			echo json_encode(
					array (
						'status' => false,
						'error' => $e -> getMessage()
					)
				);
			exit;
		}
	}
	
	public function antrian_habis() 
	{
		try {
			
			$urut_terakhir = $this->model->getLastAntrianUrut();
			while(true) {
				
				$belum_dipanggil = $this->model->getAllAntrianUrutBelumDipanggil();
				if ($belum_dipanggil) {
					if ($belum_dipanggil[0]['time_ambil'] > $urut_terakhir['time_ambil']) {
						
						foreach ($belum_dipanggil as $val) {
							$result[$val['id_antrian_detail']] = $val;
						}
						echo json_encode([
							'status' => 'ok',
							'data' => $result
						]);
						
						exit;
					}
				}
				clearstatcache();
				sleep(1);
			}
		} catch (Exception $e) {
			echo json_encode(
					array (
						'status' => false,
						'error' => $e -> getMessage()
					)
				);
			exit;
		}
	}
	
	public function belum_dipanggil() 
	{
		try {
			
			$urut_terakhir = $this->model->getLastAntrianUrut();
			while(true) {
				
				$belum_dipanggil = $this->model->getAllAntrianUrutBelumDipanggil();
				if ($belum_dipanggil) {
					if ($belum_dipanggil[0]['time_ambil'] > $urut_terakhir['time_ambil']) {
						
						foreach ($belum_dipanggil as $val) {
							$result[$val['id_antrian_detail']] = $val;
						}
						echo json_encode([
							'status' => 'ok',
							'data' => $result
						]);
						
						exit;
					}
				}
				clearstatcache();
				sleep(1);
			}
		} catch (Exception $e) {
			echo json_encode(
					array (
						'status' => false,
						'error' => $e -> getMessage()
					)
				);
			exit;
		}
	}
}
