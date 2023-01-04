<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$current_module['judul_module']?></h5>
	</div>
	
	<div class="card-body">
		<?php
		helper ('html');
		echo btn_label([
			'attr' => ['class' => 'btn btn-success btn-xs'],
			'url' => current_url() . '/add?id=' . $antrian_kategori['id_antrian_kategori'],
			'icon' => 'fa fa-plus',
			'label' => 'Tambah Tujuan Antrian'
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
			show_alert($message);
		}
		helper('html');
		if (!$result){
			show_message(['status' => 'error', 'message' => 'Data tidak ditemukan']);
		} else {
		?>
		<p>Kategori Antrian: <strong><?=$antrian_kategori['nama_antrian_kategori']?></strong></p>
		<table class="table display table-striped table-bordered table-hover" style="width:auto">
		<thead>
			<tr>
				<th>No</th>
				<th>Awalan</th>
				<th>Tujuan</th>
				<th>Aktif</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			
			foreach ($result as $val) {
				// echo 
				$checked = $val['aktif'] == 'Y' ? 'checked' : '';
				echo '<tr>
						<td>' . $no  . '</td>
						<td>' . $val['awalan'] . '</td>
						<td>' . $val['nama_antrian_tujuan'] . '</td>
						<td>
							<input data-switch="aktif" id="switch-'.$val['id_antrian_detail'].'" type="checkbox" data-id-antrian-detail="'.$val['id_antrian_detail'].'" name="aktif" class="switch toggle-antrian-detail-aktif is-rounded is-info is-small" '.$checked .'>
							<label for="switch-'.$val['id_antrian_detail'].'"></label>
						</td>
						<td>' . btn_action([
									'edit' => ['url' => base_url() . '/antrian/detail/edit?id='. $val['id_antrian_detail']]
								, 'delete' => ['url' => ''
												, 'id' =>  $val['id_antrian_detail']
												, 'delete-title' => 'Hapus data tujuan antrian: <strong>'.$val['nama_antrian_tujuan'].'</strong> ?<br/><em>Data antrian (diambil dan dipanggil) akan ikut terhapus</em>'
											]
							]) . '</td>
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