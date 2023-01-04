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
		<em>Data yang ditampilkan adalah data <strong>antrian hari ini</strong></em>
		<hr/>
		<table class="table display table-striped table-bordered table-hover" style="width:auto">
		<thead>
			<tr>
				<th>No</th>
				<th>Tujuan</th>
				<th>Jml. Antrian</th>
				<th>Ambil Nomor</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			foreach ($antrian as $val) {
				$jml_antrian = key_exists($val['id_antrian_detail'], $antrian_urut) ? $antrian_urut[$val['id_antrian_detail']] : 0;
				echo '<tr>
						<td>' . $no  . '</td>
						<td>' . $val['nama_antrian_tujuan'] . '</td>
						<td>' . $jml_antrian . '</td>
						<td>' . btn_label([
												'attr' => ['class' => 'btn btn-secondary btn-xs ambil-antrian'
															, 'data-id-antrian-detail' => $val['id_antrian_detail']
														],
												'url' => 'javascript:void(0)',
												'label' => 'Ambil'
											])
							. '</td>
					</tr>';
					$no++;
			}
			?>
		</tbody>
		</table>
	</div>
</div>