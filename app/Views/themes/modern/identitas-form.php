<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	<div class="card-body">
		<?php
			if (!empty($message)) {
					show_message($message);
		} ?>
		<form method="post" action="<?=current_url(true)?>" class="form-horizontal" enctype="multipart/form-data">
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama</label>
				<div class="col-sm-5">
					<input class="form-control" type="text" name="nama" value="<?=set_value('nama', @$result['nama'])?>" required="required"/>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Alamat</label>
				<div class="col-sm-5">
					<textarea class="form-control" name="alamat"><?=set_value('alamat', @$result['alamat'])?></textarea>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">No. HP</label>
				<div class="col-sm-5">
					<input class="form-control" type="text" name="no_hp" value="<?=set_value('no_hp', @$result['no_hp'])?>" required="required"/>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Email</label>
				<div class="col-sm-5">
					<input class="form-control" type="text" name="email" value="<?=set_value('email', @$result['email'])?>" required="required"/>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Website</label>
				<div class="col-sm-5">
					<input class="form-control" type="text" name="website" value="<?=set_value('website', @$result['website'])?>" required="required"/>
				</div>
			</div>
			<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Logo</label>
					<div class="col-sm-5">
						<?php
						if (!empty($result['file_logo']) && file_exists(ROOTPATH . '/public/images/' . $result['file_logo']))
						echo '<div class="img-choose mb-3"><img src="'. base_url() . '/public/images/' . $result['file_logo'] . '?r='.time().'"/></div>';
						
						?>
						<input type="file" class="file form-control" name="file_logo">
							<?php if (!empty($form_errors['file_logo'])) echo '<small class="alert alert-danger">' . $form_errors['file_logo'] . '</small>'?>
							<small class="form-text text-muted"><strong>Gunakan file PNG transparan</strong>. Maksimal 300Kb, tipe file: .JPG, .JPEG, .PNG</small>
						<div class="upload-img-thumb"><span class="img-prop"></span></div>
					</div>
					
				</div>
			<div class="row">
				<div class="col-sm-5">
					<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>