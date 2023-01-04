<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	<div class="card-body">
		<?php
		helper ('html');
		echo btn_label([
			'attr' => ['class' => 'btn btn-success btn-xs'],
			'url' => base_url() . '/layar-monitor-setting/add',
			'icon' => 'fa fa-plus',
			'label' => 'Tambah Data Setting'
		]);
		
		echo btn_label([
			'attr' => ['class' => 'btn btn-light btn-xs'],
			'url' => $config->baseURL . '/layar-monitor-setting',
			'icon' => 'fa fa-arrow-circle-left',
			'label' => 'Daftar Setting Layar'
		]);
		?>
		<hr/>
		<?php
			if (!empty($message)) {
					show_message($message);
		} 
		helper('html');
		?>
		<form method="post" action="<?=current_url(true)?>" class="form-horizontal" enctype="multipart/form-data">
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama Setting</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" name="nama_setting" value="<?=set_value('nama_setting', @$setting['nama_setting'])?>" required/>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-5">
					<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
					<input type="hidden" name="id" value="<?=@$setting['id_setting_layar']?>"/>
				</div>
			</div>
		</form>
	</div>
</div>