<?php

helper('html');
// echo '<pre>'; print_r($module_permission);
?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<a href="<?=$module_url?>/add" class="btn btn-success btn-xs" id="add-menu"><i class="fa fa-plus pe-1"></i> Tambah Role</a>
		<a href="<?=$module_url?>" class="btn btn-light btn-xs" id="add-menu"><i class="fa fa-arrow-circle-left pe-1"></i> Daftar Role</a>
		<hr/>
		<?php
		if (!empty($message)) {
			show_message($message);
		}
		
		foreach($module_status as $val) {
			$module_status_list[$val['id_module_status']] = $val['nama_status'];
		}
		
		foreach ($module_role as $key => $val) {
			$module_allowed[$val['id_role']][$val['id_module']] = $val['nama_module'] . ' | ' . $val['judul_module'] . ' (' . $module_status_list[$val['id_module_status']] . ')';
		}
		
		// echo '<pre>'; print_r($module_allowed); die;
		$disabled = $request->getGet('id') ? 'readonly="readonly"' : '';
		?>
		<form method="post" action="<?=current_url(true)?>" >
			<div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama Role</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="nama_role" value="<?=set_value('nama_role', @$role['nama_role'] ?: '')?>" placeholder="Nama Role" <?=$disabled?> required="required"/>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Judul Role</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="judul_role" value="<?=set_value('judul_role', @$role['judul_role'] ?: '')?>" placeholder="Judul Role" required="required"/>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Keterangan</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="keterangan" value="<?=set_value('keterangan', @$role['keterangan'] ?: '')?>" placeholder="Keterangan"/>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Halaman Default</label>
					<div class="col-sm-8">
						<?php
						if (key_exists(@$role['id_role'], $module_permission)) {
							echo options(['name' => 'id_module'], $module_permission[$role['id_role']], set_value('id_module', $role['id_module']));
							echo '<span class="text-muted">Halaman default: Module dimana role memiliki permission dengan awalan read. <a href="'.$config->baseURL.'builtin/role-permission/edit?id='.$role['id_role'].'" target="_blank">Ubah permission role</a>';
						} else {
							if (empty($role)) {
								echo '<span class="text-danger">Halaman default dapat dipilih setelah role dibuat</span>';
							} else {
								echo '<span class="text-danger">Role ini tidak memiliki permission read atau read_all di module manapun, silakan <a href="'.$config->baseURL.'builtin/role-permission/edit?id='.$role['id_role'].'" target="_blank">assign permission</a> terlebih dahulu</span>';
							}
						}
						?>
						<p class="mt-0"><em>Halaman awal sesaat setelah user login. </p>
					</div>
				</div>
				<div class="row mb-3">
					<?php 
					$id = '';
					if (!empty($msg['id_role'])) {
						$id = $msg['id_role'];
					} 
					elseif ($request->getPost('id')) {
						$id = $request->getPost('id');
					}
					elseif ($request->getGet('id')) {
						$id = $request->getGet('id');
					} ?>
					<input type="hidden" name="id" value="<?=$id?>"/>
					<div class="col-sm-8 offset-sm-2">
						<button type="submit" name="submit" value="submit" class="btn btn-primary mt-2">Save</button>
						<?=$auth->createFormToken('form_role')?>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>