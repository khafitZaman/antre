jQuery(document).ready(function () 
{
	$('.gunakan-printer').click(function(e) {
		const checked = $(e.target).prop('checked');
		const id = $(e.target).attr('data-id');
		const status = checked ? 1 : 0;
		$.ajax({
			type: 'POST',
			url: base_url + 'setting-printer/ajaxSetAktif',
			data: 'id=' + id + '&status=' + status,
			success: function(data) {
				
			},
			error: function(xhr) {
				console.log(xhr);
				bootbox.alert('Error update data, cek console browser');
			}
		})
	})
});