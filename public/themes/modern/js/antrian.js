$(document).ready(function(){
	
	$('.toggle-kategori-aktif').change(function()
	{
		var id_antrian_kategori = $(this).data('id-antrian-kategori');
		var switch_type = $(this).data('switch');
		var aktif = $(this).is(':checked') ? 'Y' : 'N';
		$.ajax({
			type: "POST",
			url: base_url + 'antrian/ajaxStatusKategori',
			data: 'id_antrian_kategori=' + id_antrian_kategori + '&aktif=' + aktif + '&switch_type=' + switch_type + '&ajax=true',
			dataType: 'text',
			success: function(data) {
				if (data == 'ok') {
					/* if (switch_type == 'aktif') {
						var text = id_result == 1 ? 'Aktif' : 'Non Aktif';
						$('[data-status-text="'+id_module+'"]').html(text);
					} */
				}
			},
			error: function(xhr) {
				console.log(xhr);
			}
		});
	})
	
	$('.toggle-antrian-detail-aktif').change(function()
	{
		var id_antrian_detail = $(this).data('id-antrian-detail');
		var switch_type = $(this).data('switch');
		var aktif = $(this).is(':checked') ? 'Y' : 'N';
		$.ajax({
			type: "POST",
			url: base_url + 'antrian/ajaxStatusAntrianDetail',
			data: 'id_antrian_detail=' + id_antrian_detail + '&aktif=' + aktif + '&switch_type=' + switch_type + '&ajax=true',
			dataType: 'text',
			success: function(data) {
				if (data == 'ok') {
					/* if (switch_type == 'aktif') {
						var text = id_result == 1 ? 'Aktif' : 'Non Aktif';
						$('[data-status-text="'+id_module+'"]').html(text);
					} */
				}
			},
			error: function(xhr) {
				console.log(xhr);
			}
		});
	})
})