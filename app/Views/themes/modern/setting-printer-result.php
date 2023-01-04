<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$current_module['judul_module']?></h5>
	</div>
	
	<div class="card-body">
		<?php
			if (!empty($message)) {
					show_message($message);
		} ?>
		<a href="<?=$config->baseURL?>setting-printer/add" class="btn btn-success btn-xs"><i class="fas fa-plus pe-1"></i> Tambah Data</a>
		<?php
		if ($result) {
			
		?>
		<hr/>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Setting</th>
						<th>Nama Server</th>
						<th>Aktif</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				helper('html');
				$no = 1;
				foreach ($result as $val) {
					$checked = $val['aktif'] ? 'checked' : '';
					echo 
					'<tr>
						<td>' . $no . '</td>
						<td>' . $val['nama_setting_printer'] . '</td>
						<td>' . $val['alamat_server'] . '</td>
						<td>
							<div class="form-switch form-switch-lg">
								<input class="form-check-input gunakan-printer" data-id="' . $val['id_setting_printer'] . '" type="checkbox" role="switch" ' . $checked . '>
							</div>
						</td>
						<td>' . btn_action([
								 'edit' => ['url' => $config->baseURL . 'setting-printer/edit?id='. $val['id_setting_printer']]
								, 'delete' => ['url' => ''
											, 'id' =>  $val['id_setting_printer']
											, 'delete-title' => 'Hapus data setting printer: <strong>'.$val['nama_setting_printer'].'</strong> ?'
										]
							]) .
						'</td>
					</tr>';
					$no++;
				}
				?>
				</tbody>
			</table>
		</div>
		<?php
		}
		
		?>
	</div>
</div>
