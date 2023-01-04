<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		
		<?php 
		if (!empty($message)) {
			show_alert($message);
		}
		helper('html');
		?>
		<em>Pilih Kategori Antrian Berikut</em>
		<hr/>
		<?php
		
		foreach ($setting_layar as $id_setting_layar => $nama_layar) {
				// echo '<pre>';
				// print_r($list_layar);
			echo $nama_layar;
			?>
			<table class="table display table-striped table-bordered table-hover" style="width:auto">
					<thead>
						<tr>
							<th>No</th>
							<th>Kategori</th>
							<th>Jml. Tujuan</th>
							<th>Detail</th>
						</tr>
					</thead>
					<tbody>
			<?php
			// foreach ($list_layar as $layar) {
				/* echo '<pre>';
				print_r($tujuan[$id_setting_layar]);
				die; */
				// echo $layar['nama_setting'];
				?>
					
						<?php
						$no = 1;
						
						foreach ($tujuan[$id_setting_layar] as $val) {

							echo '<tr>
									<td>' . $no  . '</td>
									<td>' . $val['nama_antrian_kategori'] . '</td>
									<td>' . $val['nama_antrian_tujuan'] . '</td>
									<td>' . btn_label([
															'attr' => ['class' => 'btn btn-secondary btn-xs'],
															'url' => base_url() . '/antrian-panggil?kategori=' . $val['id_antrian_kategori'],
															'icon' => 'fas fa-eye me-1',
															'label' => 'Detail'
														])
										. '</td>
								</tr>';
								$no++;
						}
						
					
			?>
			</tbody>
			</table>
				<?php
		}?>
		
	</div>
</div>