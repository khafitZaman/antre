<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?=$site_title?></title>
<meta name="descrition" content="<?=$site_title?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?=$config->baseURL . 'public/images/favicon.png?r='.time()?>" />
<link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'public/vendors/bootstrap/css/bootstrap.min.css?r='.time()?>"/>
<link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'public/vendors/font-awesome/css/all.css?r='.time()?>"/>
<link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'public/themes/modern/builtin/css/fonts/'.$setting['font_family'].'.css?r='.time()?>"/>
<link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'public/themes/modern/css/layar-monitor-show-'.$setting['color_scheme'].'.css?r='.time()?>"/>
<?php
if (@$styles) {
	foreach($styles as $file) {
		echo '<link rel="stylesheet" type="text/css" href="'.$file.'?r='.time().'"/>' . "\n";
	}
}

if ($setting['text_footer_mode'] == 'running_text') {
	echo '<style>
	.text-container {
		animation: running-text ' . $setting['text_footer_speed'] . 's linear infinite;
	}

	@keyframes running-text {
		from {
			transform: translateX(100%);
		}
		to {
			transform: translateX(-100%);
			
		}
	}
	</style>';
}
?>

<script type="text/javascript" src="<?=$config->baseURL . 'public/vendors/jquery/jquery.min.js?r='.time()?>"></script>
<script type="text/javascript" src="<?=$config->baseURL . 'public/vendors/bootstrap/js/bootstrap.min.js?r='.time()?>"></script>
<script type="text/javascript">
	var base_url = "<?=base_url()?>/"
</script>
<?php
if (@$scripts) {
	foreach($scripts as $file) {
		if (is_array($file)) {
			if ($file['print']) {
				echo '<script type="text/javascript">' . $file['script'] . '</script>' . "\n";
			}
		} else {
			echo '<script type="text/javascript" src="'.$file.'?r='.time().'"></script>' . "\n";
		}
	}
}

if ($setting['jenis_video'] == 'folder') {

	$path = 'public/videos/';
	$files = scandir($path);

	foreach ($files as $file) {
		if ($file == '.' || $file == '..') {
			continue;
		}
		if (is_dir($path . $file)) {
			continue;
		}
		
		$mime = mime_content_type($path .$file);
		
		if ($mime == 'video/mp4') {
			$videos[] = base_url() . '/' . $path . $file; 
		}
	}
} else if ($setting['jenis_video'] == 'file_video') {
	$videos[] = $setting['link_video'];
}

echo '<script type="text/javascript">const jenis_video = ' . '"' . $setting['jenis_video'] . '";';
if ($setting['jenis_video'] != 'youtube') {
	echo 'const list_videos = ' . "'" .  json_encode($videos) . "'";
}

echo '</script>';

?>

</head>
<body>
	<div class="block-container">
		<header class="shadow-sm">
			<div class="header-left-container">
				<div class="logo">
					<img src="<?=base_url()?>/public/images/<?=$identitas['file_logo']?>?r=<?=time()?>">
				</div>
				<div class="detail">
					<div class="logo-text">
						<?=$identitas['nama']?>
					</div>
					<div class="alamat">
						<p><?=$identitas['alamat']?></p>
						<p>Telp: <?=$identitas['no_hp']?></p>
					</div>
				</div>
			</div>
			<div class="header-right-container">
				<div class="tanggal">
					<?=format_tanggal(date('Y-m-d'))?>
				</div>
				<div class="waktu">
					<span id="live_jam"><?=date('H:i:s')?></span>
				</div>
			</div>
		</header>
		<div class="content-container">
			<div class="row mx-auto content-middle-top-container">
				<div class="current-antrian-container col-sm-4">
					<div class="current-antrian current-antrian-title">
						NOMOR ANTRIAN
					</div>
					<div class="current-antrian current-antrian-number">
						<div class="number-one">
						<?php
						
						$current_tujuan = '---';
						$current_antrian = '---';
						/* if ($urut) {
							foreach ($urut as $id_antrian_detail => $val) {
								$current_antrian = $antrian_detail[$id_antrian_detail]['awalan'] . $val['count_dipanggil'];
								$current_tujuan = $antrian_detail[$id_antrian_detail]['nama_antrian_tujuan'];
								break;
							}
						} */
						if ($antrian_terakhir) {
							$current_antrian = $antrian_terakhir['awalan_panggil'] . $antrian_terakhir['nomor_panggil'];
							$current_tujuan = $antrian_terakhir['nama_antrian_tujuan'];
						}
						echo $current_antrian;
						?>
						</div>
					</div>
					<div class="current-antrian current-antrian-tujuan">
						<?=$current_tujuan?>
					</div>
				</div>
				<div class="media-container col-sm-8">
					<div class="media">
						<div class="loader-ring"></div>
						<!-- <iframe src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen> -->
						</iframe>
					</div>
				</div>
			</div>
			<div class="content-middle-bottom-container">
				<div class="box-antrian-container">
				<?php
				// echo '<pre>'; print_r($setting); die;
				if (count($antrian_detail) < 4) {
					for ($i = 0; $i <= ( 4 - count($antrian_detail) ); $i++) {
						$antrian_detail[] = ['id_antrian_detail' => '', 'nama_antrian_tujuan' => '---', 'awalan' => '', 'aktif' => 0];
					}
				}
				
				// echo '<pre>'; print_r($antrian_detail);
				$list_color = [
									[	'header' => '#9e26fb',
										'header_border' => '#9e26fb',
										'body' => '#a838ff'
									],
									[	
										'header' => '#00be7a',
										'header_border' => '#00c67f',
										'body' => '#00cf85'
									],
									[
										'header' => '#e63f48',
										'header_border' => '#f55961',
										'body' => '#ee4e57'
									],
									[
										'header' => '#308ded',
										'header_border' => '#278cf5',
										'body' => '#3699ff'
									],
									[
										'header' => '#ec8431',
										'header_border' => '#e87c25',
										'body' => '#ff9541'
									],
									[
										'header' => '#6678b6',
										'header_border' => '#536398',
										'body' => '#7285c5'
									]
								];
				
				$index = 0;
				// echo '<pre>'; 
				// echo '<pre>'; print_r($antrian_detail); die;
				foreach ($antrian_detail as $val) 
				{
					$jml_dipanggil = key_exists($val['id_antrian_detail'], $urut) ? $urut[$val['id_antrian_detail']]['nomor_panggil_terakhir'] : 0;
					$awalan = $val['awalan'];
					
					$aktif = true;
					if (!empty($val['tujuan_aktif'])) {
						if ($val['tujuan_aktif'] == 'N') {
							$aktif = false;
						} else {
							if ($val['kategori_aktif'] == 'N') {
								$aktif = false;
							}
						}
					}
					
					if (!$aktif) {
						
						$jml_dipanggil = '---';
						$awalan = '';
					}
					$background_header = $setting['color_scheme'] == 'gradient' ? 'style="background:' . $list_color[$index]['header'] . '; border-color:' . $list_color[$index]['header_border'] .'"' : '';
					$background_body = $setting['color_scheme'] == 'gradient' ? 'style="background:' . $list_color[$index]['body'] . '"' : '';
					if ($val['id_antrian_detail']) {
						echo '<div class="box-antrian" data-id-kategori="' . $val['id_antrian_kategori'] . '" data-id-tujuan="' . $val['id_antrian_detail'] . '">
								<div class="box-antrian-header" ' . $background_header . '>' . $val['nama_antrian_tujuan'] . '</div>
								<div class="box-antrian-body" ' . $background_body . '>
									<div class="group-nomor">
										<span class="antrian-awalan">' . $awalan . '</span><span class="nomor-antrian-dipanggil" id="list-antrian-detail-nomor-' . $val['id_antrian_detail'] . '">' . $jml_dipanggil . '</span>
									</div>
								</div>
							</div>';
					} else {
						echo '<div class="box-antrian">
								<div class="box-antrian-header" ' . $background_header . '>' . $val['nama_antrian_tujuan'] . '</div>
								<div class="box-antrian-body" ' . $background_body . '>
									<div class="group-nomor">
										<span class="antrian-awalan"></span><span class="nomor-antrian-dipanggil">---</span>
									</div>
								</div>
							</div>';
					}
					
					$index++;
					if ($index > ( count($list_color) - 1 ) ) {
						$index = 0;
					}
				}
				?>
				</div>
			</div>
		</div>
		<footer>
			<div class="text-container"><?=$setting['text_footer']?></div>
		</footer>
	</div>
	<span style="display:none" id="id-setting-layar"><?=$_GET['id']?></span>
	<span style="display:none" id="link-video"><?=$setting['link_video']?></span>
	<span style="display:none" id="awalan-panggil"><?=json_encode($awalan_panggil['nama_file'])?></span>
</body>
</html>