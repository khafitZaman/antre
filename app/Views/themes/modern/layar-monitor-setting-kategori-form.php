<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$current_module['judul_module']?></h5>
	</div>
	<div class="card-body">
		<?php
		helper ('html');
		$exists = false;
		// print_r($selected_kategori); die;
		echo btn_label([
			'attr' => ['class' => 'btn btn-light btn-xs'],
			'url' => $config->baseURL . '/layar-monitor-setting',
			'icon' => 'fa fa-arrow-circle-left',
			'label' => 'Daftar Setting Layar'
		]);
		
		echo '<hr/>';
		
		foreach ($selected_kategori as $val) {
			if ($val['nama_antrian_kategori'])
				$exists = true;
		}
		
		if ($list_kategori) {
			$exists = true;
		}
		
		if (!$exists) {
			show_message(['status' => 'error', 'message' => 'Antrian belum dibuat, silakan buat <a href="' . base_url() . '/antrian" target="_blank">disini</a>']);
		} else {
			?>
			
			Untuk menambah, mengubah, atau menghapus kategori antrian, silakan menuju ke halaman <a href="<?=base_url()?>/antrian" target="_blank">Antrian</a>
			<hr/>
			<div class="row panel">
				<div class="col-md-12 col-lg-6">
					<div class="container-panel selected-kategori-panel">
						<h5 class="panel-title">Kategori Digunakan</h5> 
						<hr/>
						<div id="selected-kategori-panel">
						<?php
						$list_selected = [];
						foreach ($selected_kategori as $val) 
						{
							if (!$val['nama_antrian_kategori'])
								continue;
							
							$list_selected[$val['id_antrian_kategori']] = $val['id_antrian_kategori'];
							?>
							<div class="card kategori-container shadow-sm mb-4" id="selected-<?=$val['id_antrian_kategori']?>">
								<ul class="toolbox">
									<li>
										<div class="grip-handler"><i class="fas fa-grip-horizontal"></i></div>
									</li>
									<li>
										<a class="bg-success btn-edit text-white small" target="_blank" href="<?=$config->baseURL . 'antrian'?>"><i class="fas fa-pencil-alt"></i></a>
									</li>
								</ul>
								<div class="body">
									<div class="row col-sm-12 item-container">
										<?=$val['nama_antrian_kategori']?>
									</div>
								</div>
								<input type="hidden" name="urut[]" value="<?=$val['id_antrian_kategori']?>"/>
							</div>
						<?php
						}?>
						</div>
					</div>
				</div>
				
				<div class="col-md-12 col-lg-6">
					<div class="container-panel list-kategori-panel">
						<h5 class="panel-title">List Kategori</h5> 
						<hr/>
						<div id="list-kategori-panel">
						<?php
						foreach ($list_kategori as $val) 
						{
							if (in_array($val['id_antrian_kategori'], $list_selected)) {
								continue;
							}
						?>
							<div class="card kategori-container shadow-sm mb-4" id="selected-<?=$val['id_antrian_kategori']?>">
								<ul class="toolbox">
									<li>
										<div class="grip-handler"><i class="fas fa-grip-horizontal"></i></div>
									</li>
									<li>
										<a class="bg-success btn-edit text-white small" target="_blank" href="<?=$config->baseURL . 'antrian'?>"><i class="fas fa-pencil-alt"></i></a>
									</li>
								</ul>
								<div class="body">
									<div class="row col-sm-12 item-container">
										<?=$val['nama_antrian_kategori']?>
									</div>
								</div>
								<input type="hidden" name="urut[]" value="<?=$val['id_antrian_kategori']?>"/>
							</div>
						<?php
						}?>
						</div>
					</div>
				</div>
				<input type="hidden" id="id-setting-layar" name="id" value="<?=$_GET['id']?>"/>
			</div>
		<?php
		}
		?>
	</div>
</div>