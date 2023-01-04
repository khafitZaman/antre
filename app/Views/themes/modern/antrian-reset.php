<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
		
	</div>
	<?php
	helper('html');
	?>
	<div class="card-body">
		<p>Reset semua data antrian tanggal <strong><?=format_tanggal(date('Y-m-d'))?></strong></p>
		<hr/>
		<?php
		
		
		if (!empty($message)) {
				show_message($message);
		}
		
		$jml_all_dipanggil = false;
		$jml_all_antrian = false;
		foreach ($antrian_kategori as $val) 
		{
			if ($val['jml_dipanggil'] > 0) {
				$jml_all_dipanggil = true;
				$jml_all_antrian = true;
			}
			
			if ($val['jml_antrian'] > 0) {
				$jml_all_antrian = true;
			}
		}
		
		?>
		<form method="get" action="<?=current_url(true)?>" class="form-horizontal" enctype="multipart/form-data">
			<div class="row">
				<div class="col-ofset-3">
					<button type="submit" name="reset_dipanggil" value="submit" class="reset-all-dipanggil btn btn-warning btn-xs <?=$jml_all_dipanggil ? '' : ' disabled'?>" <?=$jml_all_dipanggil ? '' : 'disabled="disabled"'?>><i class="fas fa-times"></i> Dipanggil</button>
					<button type="submit" name="reset_all" value="submit" class="reset-all btn btn-danger btn-xs <?=$jml_all_antrian ? '' : ' disabled'?>" <?=$jml_all_antrian ? '' : 'disabled="disabled"'?>><i class="fas fa-times"></i> Antrian & Dipanggil</button>
				</div>
			</div>
		</form>
		<?php
	
		if (!empty($antrian_kategori)) {
			?>
			<hr/>
			<p>Reset data berdasarkan kategori</p>
			<table class="table display table-striped table-bordered table-hover" style="width:auto">
				<thead>
					<tr>
						<th>No</th>
						<th>Kategori</th>
						<th>Aktif</th>
						<th>Jumlah Antrian</th>
						<th>Jumlah Dipanggil</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					
					foreach ($antrian_kategori as $val) {
						if (!$val['nama_antrian_kategori'])
							continue;
						
						$disabled_dipanggil = $val['jml_dipanggil'] ? '' : ' disabled';
						$disabled_all = @$val['jml_antrian'] || @$val['dipanggil'] ? '' : ' disabled';
						echo '<tr class="id-antrian-kategori-' . $val['id_antrian_kategori'] . ' id-antrian-kategori-' . $val['id_antrian_kategori'] . '">
								<td>' . $no  . '</td>
								<td>' . $val['nama_antrian_kategori'] . '</td>
								<td>' . ($val['aktif'] == 1 ? 'Ya' : 'Tidak') . '</td>
								<td class="jml-antrian">' . ($val['jml_antrian'] ?: 0) . '</td>
								<td class="jml-dipanggil">' . ($val['jml_dipanggil'] ?: 0) . '</td>
								<td><div class="btn-action-group">' . 
										btn_label(['url' => '#', 'icon' => 'fas fa-times', 'attr' => ['data-id-antrian-kategori' => $val['id_antrian_kategori'],'class' => 'kategori-reset-dipanggil btn btn-warning me-2 btn-xs ' . $disabled_dipanggil], 'label' => 'Dipanggil']) . 
										btn_label(['url' => '#', 'icon' => 'fas fa-times', 'attr' => ['data-id-antrian-kategori' => $val['id_antrian_kategori'], 'class' => 'kategori-reset-all btn btn-danger btn-xs ' . $disabled_all], 'label' => 'Antrian & Dipanggil']) 
								. '</div></td>
							</tr>';
							$no++;
					}
					?>
				</tbody>
				</table>
			
			<?php
		}
		
		?>
	</div>
</div>