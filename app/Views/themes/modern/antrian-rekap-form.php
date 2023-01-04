<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	<div class="card-body">
		<?php
		if (!empty($message)) {
				show_message($message);
		}
		
		helper('html');
		if (!$antrian_kategori) {
			echo btn_label([
				'attr' => ['class' => 'btn btn-success btn-xs mb-3'],
				'url' => base_url() . '/antrian/add',
				'icon' => 'fa fa-plus',
				'label' => 'Tambah Data Antrian'
			]);
			show_message(['status' => 'error', 'message' => 'Data antrian belum dibuat.']);
		} else {
		
			$options = ['' => 'Semua'];
			if ($antrian_kategori) {
				foreach ($antrian_kategori as $val) {
					$options[$val['id_antrian_kategori']] = $val['nama_antrian_kategori'];
				}
			}
			
			if (isset($_GET['tgl_awal']) && !$antrian_rekap) {
				show_message(['status' => 'error', 'message' => 'Data tidak ditemukan']);
			}
						
			?>
			<form method="get" action="<?=current_url(true)?>" class="form-horizontal" enctype="multipart/form-data">
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Range Tanggal</label>
					<div class="col-sm-7">
						<div class="input-daterange input-group" id="datepicker">
							<input type="text" class="input-sm form-control" name="tgl_awal" value="<?=set_value('tgl_awal', '01-01-2022')?>"/>
							<span class="input-group-text">s.d.</span>
							<input type="text" class="input-sm form-control" name="tgl_akhir" value="<?=set_value('tgl_akhir', '31-01-2022')?>" />
						</div>
					</div>
				</div>
				
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Kategori Antrian</label>
					<div class="col-sm-7">
						<?=options(['name' => 'id_antrian_kategori'], $options, set_value('id_antrian_kategori'))?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-7">
						<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
			<?php

			if (isset($_GET['tgl_awal']) && $antrian_rekap) {
				
				// echo '<pre>'; print_r($antrian_rekap);
				?>
				<hr/>
				<table class="table display table-striped table-bordered table-hover" style="width:auto">
					<thead>
						<tr>
							<th>No</th>
							<th>Kategori</th>
							<th>Jumlah Tujuan</th>
							<th>Aktif</th>
							<th>Jumlah Antrian</th>
							<th>Jumlah Dipanggil</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						
						foreach ($antrian_rekap as $val) {
							echo '<tr>
									<td>' . $no  . '</td>
									<td>' . $val['nama_antrian_kategori'] . '</td>
									<td>' . $val['jml_tujuan'] . '</td>
									<td>' . ($val['aktif'] == 'Y' ? 'Ya' : 'Tidak') . '</td>
									<td>' . ($val['jml_antrian'] ?: 0) . '</td>
									<td>' . ($val['jml_dipanggil'] ?: 0) . '</td>
								</tr>';
								$no++;
						}
						?>
					</tbody>
					</table>
				
				<?php
			}
			
			?>
		<?php
		}
		?>
	</div>
</div>