$(document).ready(function() {
	/* Cek apakah ada penambahan antrian atau yang dipanggil*/
	function check_current_ambil() 
	{
		$.ajax({
			type : 'post',
			url : base_url + '/longPolling/current_antrian_ambil',
			dataType : 'JSON',
			success : function(data) 
			{
				console.log(data);
				for (k in data.data) {
					$('tr[data-id-antrian-kategori="' + k + '"]').find('td').eq(3).html(data.data[k].jml_antrian);
				}
				
				/*$.each(data.data, function(i, v) {
					
					// Cek Pemanggilan
					jml_dipanggil = parseInt($('#total-antrian-dipanggil').text());
					if (jml_dipanggil < parseInt(v['jml_dipanggil'])) 
					{
						$td = $('#antrian-detail-' + v['id_antrian_detail']).find('td');
						$td.eq(2).html(v['jml_dipanggil']);
						jml = parseInt($td.eq(3).text());
						$td.eq(3).html(jml + 1);
					}
										
					$('#total-antrian').html(v['jml_antrian']);
					$('#total-antrian-dipanggil').html(v['jml_dipanggil']);
					
					sisa = parseInt(v['jml_antrian']) - parseInt(v['jml_dipanggil']);
					$('#total-sisa-antrian').html(sisa);
					if (sisa > 0) {
						$('a.panggil-antrian').removeClass('disabled');
					} else {
						$('a.panggil-antrian, a.panggil-ulang-antrian').attr('disabled', 'disabled').addClass('disabled');
					}
					
					
					
				}); */
				
				check_current_ambil();
			}, error : function (xhr) {
				console.log(xhr);
				alert('Ajax Error !!!', xhr.responseText + '<br/><strong>Note</strong>: Detail error ada di console browser');
			}
		})
	}
	
	check_current_ambil();
})