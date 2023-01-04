<div class="card">
	<div class="card-header">
		<h5 class="card-title">Daftar Role</h5>
	</div>
	
	<div class="card-body">
		<a href="<?=current_url()?>/add" class="btn btn-success btn-xs"><i class="fa fa-plus pe-1"></i> Tambah Role</a>
		<hr/>
		<?php 
		if (!$result) {
			show_message('Data tidak ditemukan', '', false);
		} else {
			if (!empty($msg)) {
				show_alert($msg);
			}
		
			foreach($module as $val) {
				$module_list[$val['id_module']] = $val;
			}
			foreach($module_status as $val) {
				$module_status_list[$val['id_module_status']] = $val['nama_status'];
			}

			?>
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr>
				<th>No</th>
				<th>Nama Role</th>
				<th>Judul Role</th>
				<th>Default Module</th>
				<th>Keterangan</th>
				<th>Aksi</th>
				<th>Permission</th>
			</tr>
			</thead>
			<tbody>
			<?php
			// echo '<pre>'; print_r($result); die;
			foreach ($result as $key => $val) 
			{
				$default = '';
				if ($val['id_module']) {
					$default = $val['nama_module'] . ' | ' . $val['judul_module'] . ' (' . $module_status_list[$val['id_module_status']] . ')';
				}
				
				$not_exists = '';
				if (!$val['id_module']) {
					$not_exists = '<div><small class="text-danger"><em>Module default belum didefinisikan</em></small></div>';
				} else if (!$val['id_module_permission']) {
					$not_exists = '<div><small class="text-danger"><em>Role ini tidak memiliki permission read pada module ' . $val['judul_module'] . '</em></small></div>';
				}
				echo '<tr>
						<td>' . ($key + 1) . '</td>
						<td>' . $val['nama_role'] . '</td>
						<td>' . $val['judul_role'] . '</td>
						<td>' . $default . $not_exists . '</td>
						<td>' . $val['keterangan'] . '</td>
						<td>
							<div class="btn-action-group">
							<a target="_blank" href="'.current_url().'/edit?id='. $val['id_role'] .'" class="btn btn-success btn-xs me-1"><i class="fa fa-edit"></i>&nbsp;Edit</a>
							<form method="post" action="'.current_url().'"><button data-action="delete-data" data-delete-title="Hapus Role: <strong>'.$val['judul_role'].'</strong>?" type="submit" class="btn btn-danger btn-xs" name="delete"><i class="fas fa-times"></i>&nbsp;Delete</button><input type="hidden" name="id" value="'.$val['id_role'].'"/><input type="hidden" name="delete" value="delete"/></form>
							</div>
						</td>
						<td><a target="_blank" href="'.base_url().'/builtin/role-permission/edit?id='. $val['id_role'] .'" class="btn btn-secondary btn-xs me-1"><i class="fa fa-edit"></i>&nbsp;Edit</a></td>
					</tr>';
			}
			?>
			</tbody>
			</table>
			</div>
			<?php 
		} ?>
		
	</div>
</div>