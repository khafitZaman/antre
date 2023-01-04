<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$current_module['judul_module']?></h5>
	</div>
	
	<div class="card-body">
		<?php
		helper ('html');
		echo btn_label([
			'attr' => ['class' => 'btn btn-success btn-xs'],
			'url' => base_url() . '/layar-monitor-setting/add',
			'icon' => 'fa fa-plus',
			'label' => 'Tambah Setting Layar'
		]);
		?>
		<hr/>
		<?php 
		if (!empty($message)) {
			show_alert($message);
		}
		
		if (!$result) {
			show_message(['status' => 'error', 'message' => 'Data tidak ditemukan']);
		}
		
		if ($result) {
		?>
			<table id="table-result" class="table display table-striped table-bordered table-hover" style="width:auto">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Setting</th>
					<th>Jumlah Kategori</th>
					<th>Jumlah Tujuan</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			foreach ($result as $val) {

				echo '<tr>
					<td>' . $no . '</td>
					<td>' . $val['nama_setting'] . '</td>
					<td>' . $val['jml_kategori'] . '</td>
					<td>' . ( $val['jml_tujuan'] ?: 0) . '</td>
					<td><div class="btn-action-group">' . 
						 btn_action([
									'edit' => ['url' => base_url() . '/layar-monitor-setting/edit?id='. $val['id_setting_layar']]
									, 'delete' => ['url' => ''
													, 'id' =>  $val['id_setting_layar']
													, 'delete-title' => 'Hapus data kategori antrian: <strong>DELETE</strong> ?'
												]
								])
						. btn_label([
									'attr' => ['class' => 'btn btn-secondary btn-xs ms-1'],
									'url' => base_url() . '/layar-monitor-setting/edit-kategori?id=' . $val['id_setting_layar'],
									'icon' => 'fa fa-plus',
									'label' => 'Add/Delete Kategori'
								])
					. '</div></td>';
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