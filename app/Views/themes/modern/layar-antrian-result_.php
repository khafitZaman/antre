<div class="card">
	<div class="card-header">
		<h5 class="card-title">Panggil Antrian</h5>
	</div>
	
	<div class="card-body">
		<?php 
		if (!empty($msg)) {
			show_alert($msg);
		}
		helper('html');
		foreach ($setting_layar as $setting) {
			echo $setting['nama_setting'];
			?>
			<table class="table display table-striped table-bordered table-hover" style="width:auto">
			<thead>
				<tr>
					<th>No</th>
					<th>Kategori Antrian</th>
					<th>Tujuan</th>
					<th>View</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				foreach ($tujuan[$setting['id_setting_layar']] as $id_kategori => $val) {
					echo '<tr>
							<td>' . $no  . '</td>
							<td>' . $val['nama'] . '</td>
							<td><ul class="circle ps-4">';
							
							foreach ($val['tujuan'] as $detail) {
								echo '<li>', $detail['nama_antrian_tujuan']  . '</li>';
							}
							echo '
							<td>' . btn_label([
											'attr' => ['class' => 'btn btn-secondary btn-xs'],
											'url' => base_url() . '/layar/show-layar-antrian?id=' . $detail['id_antrian_kategori'],
											'icon' => 'fa fa-eye',
											'label' => 'View'
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