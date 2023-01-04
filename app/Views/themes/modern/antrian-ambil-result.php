<div class="card">
	<div class="card-header">
		<h5 class="card-title">Ambil Antrian</h5>
	</div>
	
	<div class="card-body">
		<?php 
		if (!empty($msg)) {
			show_alert($msg);
		}
		helper('html');
		foreach ($setting_layar as $setting) 
		{
			if ($setting['nama_setting']) {
				echo $setting['nama_setting'] . '<hr/>';
			} else {
				echo 'Antrian belum didefinisikan di layar, didefinisikan <a href="' . base_url() . '/layar-monitor-setting" target="_blank">' . 'disini</a>' . '<hr/>';
			}
			?>
			<table class="table display table-striped table-bordered table-hover mb-4" style="width:auto">
			<thead>
				<tr>
					<th>No</th>
					<th>Kategori Antrian</th>
					<th>Tujuan</th>
					<th>Jml. Antrian</th>
					<th>View</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				
				foreach ($tujuan[$setting['id_setting_layar']] as $id_setting_layar => $val) {

					$jml_antrian = key_exists($val['kategori']['id'], $antrian_urut) ? $antrian_urut[$val['kategori']['id']] : 0;
					echo '<tr data-id-antrian-kategori="' .  $val['kategori']['id'] . '">
							<td>' . $no  . '</td>
							<td>' . $val['kategori']['nama'] . '</td>
							<td><ul class="circle ps-4">';
							
							foreach ($val['tujuan'] as $detail) {
								echo '<li>', $detail['nama_antrian_tujuan']  . '</li>';
							}
							echo '
							<td>' . $jml_antrian . '</td>
							<td>' . btn_label([
											'attr' => ['class' => 'btn btn-success btn-xs ambil-antrian', 'data-id-antrian-kategori' => $val['kategori']['id']],
											'url' => '#',
											'label' => 'Ambil'
										]) .
							'</td>
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