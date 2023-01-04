<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$current_module['judul_module']?></h5>
	</div>
	
	<div class="card-body">
		<a href="<?=current_url()?>/add" class="btn btn-success btn-xs"><i class="fa fa-plus pe-1"></i> Tambah Data</a>
		<hr/>
		<?php 
		if (!empty($message)) {
			show_alert($message);
		}
		helper('html');
		?>
		<table class="table display table-striped table-bordered table-hover" style="width:auto">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Tujuan</th>
				<th>File Audio</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			
			foreach ($result as $val) {
				
				$audio = json_decode($val['nama_file'], true);
				$button = '';
				foreach ($audio as $file) {
					$button .= '<button class="audio btn btn-outline-secondary me-2" value="' . $file . '">' . $file . ' <i class="fas fa-volume-off"></i><input type="hidden" name="audio[' . $val['id_antrian_tujuan'] . '][]"/></button>';
				}
				
				echo '<tr>
						<td>' . $no  . '</td>
						<td>' . $val['nama_antrian_tujuan'] . '</td>
						<td>' . $button . '</td>
						<td>' . btn_action([
									'edit' => ['url' => base_url() . '/tujuan/edit?id='. $val['id_antrian_tujuan']]
								, 'delete' => ['url' => ''
												, 'id' =>  $val['id_antrian_tujuan']
												, 'delete-title' => 'Hapus data tujuan antrian: <strong>'.$val['nama_antrian_tujuan'].'</strong> ?'
											]
							]) . '</td>
					</tr>';
					$no++;
			}
			?>
		</tbody>
		</table>
	</div>
</div>