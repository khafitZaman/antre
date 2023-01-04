$(document).ready(function() {
	// Live update
	function check_current_urut() 
	{
		$.ajax({
			type : 'post',
			url : base_url + '/longPolling/current_urut',
			dataType : 'JSON',
			success : function(data) 
			{
				console.log(data);
				$.each(data.data, function(i, v) {
					
					$row = $('#' + 'antrian-detail-' + v['id_antrian_detail']);
					$td = $row.find('td').eq(3).html(v['urut']);
				});
				
				check_current_urut();
			}, error : function (xhr) {
				console.log(xhr);
				alert('Ajax Error !!!', xhr.responseText + '<br/><strong>Note</strong>: Detail error ada di console browser');
			}
		})
	}
	
	check_current_urut();
})