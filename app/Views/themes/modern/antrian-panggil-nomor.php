<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$current_module['judul_module']?></h5>
	</div>
	
	<div class="card-body">
		
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
				<th>Kategori</th>
				<th>Tujuan</th>
				<th>Jml. Antrian</th>
				<th>No. Dipanggil</th>
				<th>Sisa</th>
				<th>Panggil</th>
				<th>Panggil Ulang</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			
			foreach ($antrian as $val) {
				$jml_antrian = key_exists($val['id_antrian_tujuan'], $antrian_urut) ? $antrian_urut[$val['id_antrian_tujuan']]['urut'] : 0;
				$dipanggil = key_exists($val['id_antrian_tujuan'], $antrian_urut) ? $antrian_urut[$val['id_antrian_tujuan']]['dipanggil'] : 0;
				$sisa = $jml_antrian - $dipanggil;
				
				$btn_disabled = $sisa == 0 ? ' disabled' : '';
				echo '<tr id="antrian-detail-' . $val['id_antrian_detail'] . '">
						<td>' . $no  . '</td>
						<td>' . $val['nama_antrian_kategori'] . '</td>
						<td>' . $val['nama_antrian_tujuan'] . '</td>
						<td>' . $jml_antrian . '</td>
						<td>' . $dipanggil. '</td>
						<td>' . $sisa. '</td>
						<td>' . btn_label([
												'attr' => ['class' => 'btn btn-secondary btn-xs panggil-antrian' . $btn_disabled
															, 'data-id-antrian-detail' => $val['id_antrian_tujuan']
															, 'data-url' => base_url() . '/antrian/panggil-antrian'
														],
												'url' => 'javascript:void(0)',
												'label' => 'Panggil'
											])
							. '</td>
						<td>' . btn_label([
												'attr' => ['class' => 'btn btn-warning btn-xs panggil-ulang-antrian' . $btn_disabled
															, 'data-id-antrian-detail' => $val['id_antrian_detail']
															, 'data-url' => base_url() . '/antrian/panggil-ulang-antrian'
															, 'data-url-panggil-ulang' => base_url() . '/antrian/panggil-ulang-antrian'
														],
												'url' => 'javascript:void(0)',
												'label' => 'Panggil Ulang'
											])
							. '</td>
					</tr>';
					$no++;
			}
			?>
		</tbody>
		</table>
		<span id="id-antrian-kategori"></span>
	</div>
</div>