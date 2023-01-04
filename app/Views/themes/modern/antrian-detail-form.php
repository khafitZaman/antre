<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	<div class="card-body">
		<?php

		helper ('html');
		echo btn_label([
			'attr' => ['class' => 'btn btn-success btn-xs'],
			'url' => base_url() . '/antrian/detail/add?id=' . $antrian_kategori['id_antrian_kategori'],
			'icon' => 'fa fa-plus',
			'label' => 'Tambah Tujuan Antrian'
		]);
		
		echo btn_label([
			'attr' => ['class' => 'btn btn-light btn-xs'],
			'url' => $config->baseURL . '/antrian/detail?id=' . $antrian_kategori['id_antrian_kategori'],
			'icon' => 'fa fa-arrow-circle-left',
			'label' => 'Daftar ' . $antrian_kategori['nama_antrian_kategori']
		]);
		?>
		<hr/>
		<?php
			if (!empty($message)) {
					show_message($message);
		} 
		?>
		<form method="post" action="<?=current_url(true)?>" class="form-horizontal" enctype="multipart/form-data">
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Kategori Antrian</label>
				<div class="col-sm-5">
					<strong><?=$antrian_kategori['nama_antrian_kategori']?></strong>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Tujuan</label>
				<div class="col-sm-5">
					<?php
					$options = ['' => 'Pilih Tujuan'];
					foreach ($antrian_tujuan as $val) {
						$options[$val['id_antrian_tujuan']] = $val['nama_antrian_tujuan'];
					}
					echo options(['name' => 'id_antrian_tujuan'], $options, set_value('id_antrian_tujuan', @$antrian_detail['id_antrian_tujuan']))
					?>
					<input type="hidden" name="id_antrian_tujuan_old" value="<?=set_value('id_antrian_tujuan_old', @$antrian_detail['id_antrian_tujuan'])?>"/>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Aktif</label>
				<div class="col-sm-5">
					<?php
					echo options(['name' => 'aktif'], ['1' => 'Ya', '0' => 'Tidak'], set_value('aktif', @$antrian_detail['aktif']) )
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-5">
					<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
					<input type="hidden" name="id" value="<?=@$id_antrian_detail?>"/>
					<input type="hidden" name="id_antrian_kategori" value="<?=@$id_antrian_kategori?>"/>
				</div>
			</div>
		</form>
	</div>
</div>