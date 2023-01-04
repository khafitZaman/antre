<table id="table-result" class="table display table-striped table-bordered table-hover" style="width:100%">
<thead>
	<tr>
		<th>No</th>
		<th>File</th>
		<th>Preview</th>
		<th>Pilih</th>
	</tr>
</thead>
<?php
$no = 1;
foreach ($files as $val) {
	if ($val == '.' || $val == '..')
		continue;
	
	$ext = pathinfo(ROOTPATH . $val, PATHINFO_EXTENSION);
	$ext = strtolower($ext);
	if ($ext == 'wav' || $ext == 'mp3') {
		
		echo '<tr>
		<td>' . $no . '</td>
		<td>' . $val . '</td>
		<td><button class="btn btn-outline-secondary audio" value="' . $val . '"><i class="fas fa-volume-off"></i></button></td>
		<td><button class="btn btn-primary pilih-audio" data-pilih-file="' . $val . '">Pilih</button></td>
		</tr>';
	}
	$no++;
}
?>
</table>