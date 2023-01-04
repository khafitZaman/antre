<?php

helper('html');?>

<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php
		if (!empty($msg)) {
			show_message($msg['content'], $msg['status']);
		}
		
		?>
		<form method="post" class="modal-form" id="add-form" action="<?=current_url(true)?>" >
			<div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Module</label>
					<div class="col-sm-8 form-inline">
						<?=$module['judul_module']?>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Role</label>
					<div class="col-sm-8">
						
						<?php 
						/* foreach ($role_detail as $val) {
							$role_detail_options[$val['nama_role_detail']] = $val['nama_role_detail'] . ' | ' . $val['judul_role_detail'];
						} */
						
						$module_role_check = [];
						foreach ($module_role as $val) {
							$module_role_check[$val['id_role']] = $val;
						}
						
						$url_permission = base_url() . '/builtin/role-permission?id_module='. $_GET['id'];
						echo '<div id="check-all-wrapper">';
						foreach ($role as $role_val) 
						{
							$checkbox = ['attr' => ['class' => 'toggle-role', 'id' => $role_val['id_role'], 'name' => 'role_' . $role_val['id_role']], 'label' => $role_val['judul_role']];
							
							$checked = [];
							if (isset($_POST['role_' . $role_val['id_role']])) {
								$checked = ['role_' . $role_val['id_role']];
							} else {
								if (key_exists($role_val['id_role'], $module_role_check)) {
									$checked[] = 'role_' . $role_val['id_role'];
								}
							}
							
							echo checkbox($checkbox, $checked);
							$display = !$checked ? ' style="display:none"' : '';
							// $display = '';
							// echo '<pre>'; print_r($role_permission_module[$val['id_role']]); die;
							// echo $role_val['id_role'];

							if (key_exists($role_val['id_role'], $role_permission_module)) {
								// echo 'xxx'; die;
								echo '<div class="ms-4 mb-2 role-child" ' . $display . '>
										<ul class="list-circle">';
										foreach ($role_permission_module[$role_val['id_role']] as $key => $val_permission) 
										{
											echo '<li>' . $val_permission['nama_permission'] . ' ('. $val_permission['judul_permission'] . ')</li>';
										}
								echo '</ul></div>';
							} else {
								echo '<div class="ms-4 mb-2"' . $display . '>Role ini belum memiliki permission untuk module ' . $module['judul_module'] . ', Anda tetap dapat meng-assign role untuk module ini. Klik <a title="Halaman Permission" target="_blank" href="' . $url_permission . '">disini</a> untuk mengatur permission module ' . $module['nama_module'] . '.</div>'; 
							}
							
						}
						
						echo '</div>';
						?>
						
					</div>
				</div>
				
				<?php 
				$id = '';
				if (!empty($msg['id_module'])) {
					$id = $msg['id_module']; // Setelah submit add
				} elseif (!empty($_GET['id'])) {
					$id = $_GET['id'];
				} ?>
				<input type="hidden" name="id" value="<?=$id?>"/>
				<button type="submit" name="submit" value="submit" class="btn btn-primary mt-2">Save</button>
				<?php
					$form_token = $auth->generateFormToken('form_edit');
				?>
				<input type="hidden" name="form_token" value="<?=$form_token?>"/>
			</div>
		</form>
	</div>
</div>