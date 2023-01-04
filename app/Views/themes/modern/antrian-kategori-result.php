<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$current_module['judul_module']?></h5>
	</div>
	
	<div class="card-body">
		<?php
		helper ('html');
		echo btn_label([
			'attr' => ['class' => 'btn btn-success btn-xs'],
			'url' => base_url() . '/antrian/add',
			'icon' => 'fa fa-plus',
			'label' => 'Tambah Kategori Antrian'
		]);
		?>
		<hr/>
		<?php 
		if (!empty($message)) {
			show_alert($message);
		}
		
		if (!$antrian_kategori) {
			show_message(['status' => 'error', 'message' => 'Data tidak ditemukan']);
		}
		
		if ($antrian_kategori) {
			/* foreach ($setting_layar as $setting) 
			{ */
				/* if (!key_exists($setting['id_setting_layar'], $tujuan)) 
					continue; */
				
				/* if ($setting['nama_setting']) {
					echo $setting['nama_setting'] . '<hr/>';
				} else {
					echo 'Antrian dibawah ini belum didefinisikan di layar, didefinisikan <a href="' . base_url() . '/layar-monitor-setting" target="_blank">' . 'disini</a>' . '<hr/>';
				} */
				?>
				<table class="table display table-striped table-bordered table-hover mb-4" style="width:auto">
				<thead>
					<tr>
						<th colspan="6">Kategori Antrian</th>
						<th colspan="2">Tujuan</th>
					</tr>
					<tr>
						<th>No</th>
						<th>Nama Kategori</th>
						<th>Awalan</th>
						<th>Layar</th>
						<th>Aktif</th>
						<th>Action</th>
						<th>Nama Tujuan</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
// echo '<pre>'; print_r($antrian_kategori); die;
					foreach ($antrian_kategori as $val) {
						
						$checked = $val['aktif'] == 'Y' ? 'checked' : '';
						
						if ($val['nama_setting']) {
							$exp = explode(',', $val['nama_setting']);
							$layar = '<ul class="circle ps-4"><li>' . join('</li><li>', $exp) . '</li></ul>';
						} else {
							$layar = '';
						}							
						echo '<tr>
								<td>' . $no . '</td>
								<td>' . $val['nama_antrian_kategori'] . '</td>
								<td>' . $val['awalan'] . '</td>
								<td>' . $layar . '</td>
								
								<td>
									<input data-switch="aktif" id="switch-'.$val['id_antrian_kategori'].'" type="checkbox" data-id-antrian-kategori="'.$val['id_antrian_kategori'].'" name="aktif" class="switch toggle-kategori-aktif is-rounded is-info is-small" '.$checked .'>
									<label for="switch-'.$val['id_antrian_kategori'].'"></label>
								</td>
								<td>' . 
									 btn_action([
												'edit' => ['url' => base_url() . '/antrian/edit?id='. $val['id_antrian_kategori']]
												, 'delete' => ['url' => ''
																, 'id' =>  $val['id_antrian_kategori']
																, 'delete-title' => 'Hapus data kategori antrian: <strong>'.$val['nama_antrian_kategori'].'</strong> ?'
															]
											])
								. '</td>
								<td>';
								
								if (key_exists($val['id_antrian_kategori'], $tujuan)) {
									echo '<ul class="circle ps-4">';
									
									foreach ($tujuan[$val['id_antrian_kategori']] as $detail) {
										$tujuan_aktif = $detail['tujuan_aktif'] == 'Y' ? 'Aktif' : 'Non Aktif';
										echo '<li>', $detail['nama_antrian_tujuan']  . ' (' . $tujuan_aktif  . ')</li>';
									}
								
									echo '</ul>';
								} else {
									echo 'Tujuan belum dibuat. <a target="blank" href="' . base_url() . '/antrian/detail/add?id=' . $val['id_antrian_kategori'] . '">Tambah tujuan';
								}
								
								echo'
								</td>
								<td><div class="btn-action-group">' . 
									btn_label([
												'attr' => ['class' => 'btn btn-success me-1 btn-xs', 'target' => '_blank'],
												'url' => base_url() . '/antrian/detail/add?id=' . $val['id_antrian_kategori'],
												'icon' => 'fas fa-plus',
												'label' => 'Add'
											])
									. btn_label([
												'attr' => ['class' => 'btn btn-secondary btn-xs'],
												'url' => base_url() . '/antrian/detail?id=' . $val['id_antrian_kategori'],
												'icon' => 'fas fa-eye',
												'label' => 'View'
											])
								. '</div></td>
							</tr>';
							$no++;
					}
					?>
				</tbody>
				</table>
			<?php
			// }
		}
		?>
	</div>
</div>