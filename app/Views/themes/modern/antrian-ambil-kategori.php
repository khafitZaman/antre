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
		<em>Pilih Kategori Antrian Berikut</em>
		<hr/>
		<table class="table display table-striped table-bordered table-hover" style="width:auto">
		<thead>
			<tr>
				<th>No</th>
				<th>Kategori</th>
				<th>Jml. Tujuan</th>
				<th>Jml. Antrian</th>
				<th>Ambil Nomor</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			
			foreach ($antrian as $val) {
				$jml_antrian = key_exists($val['id_antrian_kategori'], $antrian_urut) ? $antrian_urut[$val['id_antrian_kategori']] : 0;
				echo '<tr>
						<td>' . $no  . '</td>
						<td>' . $val['nama_antrian_kategori'] . '</td>
						<td>' . ($val['jml_tujuan'] ?: 0) . '</td>
						<td>' . $jml_antrian . '</td>
						<td>' . btn_label([
												'attr' => ['class' => 'btn btn-secondary btn-xs ambil-antrian'
															, 'data-id-antrian-kategori' => $val['id_antrian_kategori']
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