<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php 
		helper('html');
		if (!empty($msg)) {
			show_message($msg['content'], $msg['status']);
		}
		
		$list = ['logo_background_color', 'color_scheme', 'sidebar_color', 'font_family'];
		foreach ($list as $val) {
			if (empty($$val)) {
				$$val = '';
			}
		}
		?>
		<form method="post" action="" id="form-setting" enctype="multipart/form-data">
			<div class="tab-content" id="myTabContent">
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Color Scheme</label>
					<div class="col-sm-5 form-inline">
						<ul id="color-scheme" class="color-scheme-options">
							<?php
							$list = ['gradient', 'blue', 'green', 'grey', 'purple', 'red', 'yellow'];
							
							foreach ($list as $val) {
								$check = $color_scheme ==  $val ? '<i class="fa fa-check theme-check"></i>' : '';
								echo '<li><a href="javascript:void(0)" class="'.$val.'-theme">' . $check . '</a></li>';
							}
							?>	
						</ul>
						<input type="hidden" name="color_scheme" id="input-color-scheme" value="<?=@set_value('logo_background_color', $color_scheme)?>">
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Link Video</label>
					<div class="col-sm-5">
						<div class="input-group">
							<?=options(['name' => 'jenis_video', 'id' => 'jenis-video', 'style' => 'flex: 0 auto;width: auto']
										, ['youtube' => 'Youtube', 'file_video' => 'File Video', 'folder' => 'Folder']
										, set_value('jenis_video', $jenis_video)
							)?>
							<?php
								$readonly = $jenis_video == 'folder' ? 'readonly' : '';
							?>
							<input name="link_video" class="form-control link-video" <?=$readonly?> value="<?=set_value('link_video', $link_video)?>"/>
							<span class="text-muted"><strong>Folder</strong>: Semua file video <strong>(.mp4)</strong> pada folder public/videos akan otomatis diputar berurutan sesuai nama file</span>
						</div>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Text Footer</label>
					<div class="col-sm-5">
						<textarea class="form-control" rows="4" name="text_footer"><?=set_value('text_footer', $text_footer)?></textarea>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Text Footer Mode</label>
					<div class="col-sm-5 form-inline">
						<?=options(['name' => 'text_footer_mode', 'id' => 'footer-text-mode'],['statis' => 'Statis', 'running_text' => 'Running Text'], @$text_footer_mode)?>
						<?php
						$display = @$text_footer_mode == 'statis' ? ' style="display:none"' : '';
						?>
						<div <?=$display?>>
							<input name="text_footer_speed" size="1" value="<?=@$text_footer_speed?>" class="form-control"/> <span class="ms-1" style="margin-top:13px; display: inline-block">(durasi dalam detik)</span>
						</div>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Font Family</label>
					<div class="col-sm-5 form-inline">
						<?=options(['name' => 'font_family', 'id' => 'font'], ['open-sans' => 'Open Sans (Default)', 'roboto' => 'Roboto', 'montserrat' => 'Montserrat', 'poppins' => 'Poppins', 'arial' => 'Arial', 'verdana' => 'Verdana'], set_value('font_family', @$font_family))?>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Font Size</label>
					<div class="col-sm-3">
						<div class="range-slider-test">
							<?php
							$value = @$font_size ? $font_size : @$_POST['font_size'];
							?>
						  <input class="range-slider" id="font-size" type="range" step="5" name="font_size" id="font-size" value="<?=$value?>" min="80" max="150">
						  <?php
						  $pos_left = (($value - 10 ) * 33);
						  ?>
						  <output for="font-size" style="left:<?=$pos_left?>px"><?=$value?></output>px
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-5">
						<button type="submit" name="submit" id="btn-submit" value="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>