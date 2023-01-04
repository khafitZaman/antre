<div class="card">
	<div class="card-header">
		<h5 class="card-title">Layar Ambil Antrian</h5>
	</div>
	
	<div class="card-body">
		<?php 
		if (!empty($msg)) {
			show_alert($msg);
		}
		helper('html');
		?>
		<table class="table display table-striped table-bordered table-hover" style="width:auto">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Setting</th>
				<th>Kategori Antrian</th>
				<th>Tujuan</th>
				<th>View</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			
			foreach ($setting_layar as $val) {
				if ($val['nama_kategori']) {
					$list_kategori = explode(',', $val['nama_kategori']);
					echo '<tr>
							<td>' . $no  . '</td>
							<td>' . $val['nama_setting'] . '</td>
							<td><ul class="circle ps-4"><li>' . join('</li><li>', $list_kategori)  . '</li></ul></td>
							<td><ul class="circle ps-4"><li>' . join('</li><li>', $tujuan[$val['id_setting_layar']])  . '</li></ul></td>
							<td>' . btn_label([
											'attr' => ['class' => 'btn btn-secondary btn-xs'],
											'url' => base_url() . '/layar/show-layar-antrian?id=' . $val['id_setting_layar'],
											'icon' => 'fa fa-eye',
											'label' => 'View'
										]) . '</td>
						</tr>';
						$no++;
				}
			}
			?>
		</tbody>
		</table>
	</div>
</div>