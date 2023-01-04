<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	<div class="card-body">
		<?php
		helper ('html');
		echo btn_label([
			'attr' => ['class' => 'btn btn-success btn-xs'],
			'url' => base_url() . '/antrian/add',
			'icon' => 'fa fa-plus',
			'label' => 'Tambah Kategori Antrian'
		]);
		
		echo btn_label([
			'attr' => ['class' => 'btn btn-light btn-xs'],
			'url' => $config->baseURL . '/antrian',
			'icon' => 'fa fa-arrow-circle-left',
			'label' => 'Daftar Kategori Antrian'
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
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama Kategori Antrian</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" name="nama_antrian_kategori" value="<?=set_value('nama_antrian_kategori', @$antrian_kategori['nama_antrian_kategori'])?>"/>
					<input type="hidden" name="nama_antrian_kategori_old" value="<?=set_value('nama_antrian_kategori_old', @$antrian_kategori['nama_antrian_kategori'])?>"/>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Abjad Awal Antrian</label>
				<div class="col-sm-5">
					<?php
					echo options(['name' => 'awalan'], ['' => 'Tidak', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F'], set_value('awalan', @$antrian_kategori['awalan']) )
					?>
					<small>Misal: sistem nomor nya A1, A2, A3, dst... (diawali abjad A), berarti awalan nya adalah A</small>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Aktif</label>
				<div class="col-sm-5">
					<?php
					echo options(['name' => 'aktif'], ['Y' => 'Ya', 'N' => 'Tidak'], set_value('aktif', @$antrian_kategori['aktif']) )
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-5">
					<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
					<input type="hidden" name="id" value="<?=@$id_antrian_kategori?>"/>
				</div>
			</div>
		</form>
	</div>
</div>