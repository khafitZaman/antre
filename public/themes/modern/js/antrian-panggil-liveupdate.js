$(document).ready(function() {
	/* Cek apakah ada penambahan antrian atau yang dipanggil*/
	function check_current_dipanggil() 
	{
		$.ajax({
			type : 'post',
			url : base_url + '/longPolling/current_antrian_dipanggil',
			data : 'id_antrian_kategori=' + $('#id-antrian-kategori').text(),
			dataType : 'JSON',
			success : function(data) 
			{
				console.log(data);
				$.each(data.data, function(i, v) {
					
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
						$('a.panggil-antrian').attr('disabled', 'disabled').addClass('disabled');
					}
				});
				
				check_current_dipanggil();
			}, error : function (xhr) {
				console.log(xhr);
				alert('Ajax Error !!!', xhr.responseText + '<br/><strong>Note</strong>: Detail error ada di console browser');
			}
		})
	}
	
	check_current_dipanggil();
	
	/* Cek apakah ada antrian baru sehingga tombol panggil menjadi aktif */
	// Live update
	/* function check_belum_dipanggil() 
	{
		$.ajax({
			type : 'post',
			url : base_url + '/longPolling/belum_dipanggil',
			dataType : 'JSON',
			success : function(data) 
			{
				console.log(data);
				$.each(data.data, function(i, v) {
					
					$row = $('#' + 'antrian-detail-' + v['id_antrian_detail']);
					$td = $row.find('td');
					$td.eq(3).html(v['urut']);
					$td.eq(4).html(v['dipanggil']);
					$td.eq(5).html(parseInt(v['urut']) - parseInt(v['dipanggil']));
					$row.find('a').removeClass('disabled');
				});
				
				check_belum_dipanggil();
			}, error : function (xhr) {
				console.log(xhr);
				alert('Ajax Error !!!', xhr.responseText + '<br/><strong>Note</strong>: Detail error ada di console browser');
			}
		})
	}
	
	check_belum_dipanggil(); */
	
	/* Cek apakah antrian sudah habis tombol panggil menjadi tidak aktif */
	// Live update
	/* function check_antrian_habis() 
	{
		$.ajax({
			type : 'post',
			url : base_url + '/longPolling/antrian_habis',
			dataType : 'JSON',
			success : function(data) 
			{
				console.log(data);
				$.each(data.data, function(i, v) {
					
					$row = $('#' + 'antrian-detail-' + v['id_antrian_detail']);
					$td = $row.find('td');
					$td.eq(3).html(v['urut']);
					$td.eq(4).html(v['dipanggil']);
					$td.eq(5).html(parseInt(v['urut']) - parseInt(v['dipanggil']));
					$row.find('a').removeClass('disabled');
				});
				
				check_antrian_habis();
			}, error : function (xhr) {
				console.log(xhr);
				alert('Ajax Error !!!', xhr.responseText + '<br/><strong>Note</strong>: Detail error ada di console browser');
			}
		})
	} */
	
	// check_antrian_habis();
})