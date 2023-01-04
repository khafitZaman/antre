<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	<div class="card-body">
		<?php
			if (!empty($message)) {
					show_message($message);
		} 
		helper ('html');
		echo btn_label(['attr' => ['class' => 'btn btn-success btn-xs'],
			'url' => $config->baseURL . 'tujuan/add',
			'icon' => 'fas fa-plus',
			'label' => 'Tambah Data'
		]);
		echo btn_label(['attr' => ['class' => 'btn btn-light btn-xs'],
			'url' => $config->baseURL . 'tujuan',
			'icon' => 'fas fa-arrow-circle-left',
			'label' => 'Tujuan Antrian'
		]);
		
		?>
		<hr/>
		<form method="post" action="<?=current_url(true)?>" class="form-horizontal" enctype="multipart/form-data">
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama Tujuan</label>
				<div class="col-sm-5">
					<input class="form-control" type="text" name="nama_antrian_tujuan" value="<?=set_value('nama_antrian_tujuan', @$result['nama_antrian_tujuan'])?>" required="required"/>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">File Audio</label>
				<div class="col-sm-5">
					<div class="clearfix mb-2 audio-container">
					<?php
					if (!empty($result)) {
						$audio = json_decode($result['nama_file'], true);
						foreach ($audio as $file) {
							echo '
							<div style="position:relative;float:left;margin-right:25px;margin-bottom:10px">
								<button class="audio btn btn-outline-secondary" value="' . $file . '">' . $file . ' <i class="fas fa-volume-off"></i>
								
								</button>
								<button class="btn btn-danger delete-audio" style="position:absolute;right:-20px;top: 0;padding: 2px 5px;"><i class="fas fa-times"></i></button>
								<input type="hidden" name="nama_file[]" value="' . $file . '"/>
							</div>';
						}
					}
					?>
					</div>
					<div>
					<button class="btn btn-success btn-xs add-audio"><i class="fa fa-plus pe-1"></i> Add Audio</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-5">
					<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
					<input type="hidden" name="id" value="<?=@$id?>"/>
				</div>
			</div>
		</form>
	</div>
</div>