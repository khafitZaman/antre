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
		echo btn_label([
			'attr' => ['class' => 'btn btn-success btn-xs'],
			'url' => base_url() . '/setting-printer/add',
			'icon' => 'fa fa-plus',
			'label' => 'Tambah Data'
		]);
		
		echo btn_label([
			'attr' => ['class' => 'btn btn-light btn-xs'],
			'url' => $config->baseURL . '/setting-printer',
			'icon' => 'fa fa-arrow-circle-left',
			'label' => 'Daftar Setting Printer'
		]);
		?>
		<hr/>
		<form method="post" action="<?=current_url(true)?>" class="form-horizontal" enctype="multipart/form-data">
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama Setting</label>
				<div class="col-sm-5">
					<input class="form-control" type="text" name="nama_setting_printer" value="<?=set_value('nama_setting_printer', @$result['nama_setting_printer'])?>" required="required"/>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Alamat Server</label>
				<div class="col-sm-5">
					<textarea class="form-control" name="alamat_server"><?=set_value('alamat_server', @$result['alamat_server'])?></textarea>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Aktif</label>
				<div class="col-sm-5">
					<?php
					echo options(['name' => 'aktif'], ['1' => 'Ya', '0' => 'Tidak'], set_value('aktif', @$result['aktif']));
					?>
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