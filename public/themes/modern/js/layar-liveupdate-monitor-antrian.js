let i = 0;
let current_ended = 0;
let audio_ended = true;
let audio_object = [];

let current_added = [];
const data_layar_antrian = [];
 $(document).ready(function() {
	 
	function check_current_antrian() 
	{
		$.ajax({
			type : 'post',
			url : base_url + '/longPolling/monitor_current_antrian?id=' + $('#id-setting-layar').text() ,
			dataType : 'JSON',
			success : function(data) 
			{
				
				data_layar_antrian.push(data.data);
				addAudio(data.data);
				if(audio_ended) {
					playSound()
				}
				check_current_antrian();
			}, error : function (xhr) {
				console.log(xhr);
				alert('Ajax Error !!!', xhr.responseText + '<br/><strong>Note</strong>: Detail error ada di console browser');
			}
		})
	}
	check_current_antrian();
	
	function check_panggil_ulang_antrian() 
	{
		$.ajax({
			type : 'post',
			url : base_url + '/longPolling/monitor_panggil_ulang_antrian?id=' + $('#id-setting-layar').text() ,
			dataType : 'JSON',
			success : function(data) 
			{
				console.log(data); 
				data_layar_antrian.push('');
				/* data.data.map(content => {
					addAudio(content)
				}) */
				addAudio(data.data);
				
				if(audio_ended) {
					playSound()
				}
				check_panggil_ulang_antrian();
			}, error : function (xhr) {
				console.log(xhr);
				alert('Ajax Error !!!', xhr.responseText + '<br/><strong>Note</strong>: Detail error ada di console browser');
			}
		})
	}
	check_panggil_ulang_antrian();
	
	
	/* Check apakah ada loket yang diaktifkan atau di non aktifkan */
	function check_perubahan_antrian() 
	{
		$.ajax({
			type : 'post',
			url : base_url + '/longPolling/monitor_perubahan_antrian?id=' + $('#id-setting-layar').text() ,
			dataType : 'JSON',
			success : function(data) 
			{
				console.log(data);
				kategori = data.data.kategori;
				tujuan = data.data.tujuan;
				antrian_terakhir = data.data.antrian_terakhir;
				
				if (kategori) {
					
					if (kategori.aktif == 'Y') {
						$elm = $('div[data-id-kategori="' + kategori.id_antrian_kategori + '"');
						$elm.each(function(i, elm) 
						{
							$(elm).find('.antrian-awalan').html(kategori.awalan);
							
							id_antrian_detail = $(elm).attr('data-id-tujuan');
							nomor_antrian = 0;
							if (id_antrian_detail in kategori.tujuan_panggil) {
								nomor_antrian = kategori.tujuan_panggil[id_antrian_detail].nomor_panggil;
							}
							
							$(elm).find('.nomor-antrian-dipanggil').html(nomor_antrian);
						})
						
					} else if (kategori.aktif == 'N') 
					{
						
						$elm = $('div[data-id-kategori="' + kategori.id_antrian_kategori + '"');
						$elm.each(function(i, elm) {
							$(elm).find('.antrian-awalan').html('');
							$(elm).find('.nomor-antrian-dipanggil').html('---');
						})							
					}
				}
				
				if (tujuan) {
					if (tujuan.tujuan_aktif == 'Y') 
					{
						$elm = $('div[data-id-tujuan="' + tujuan.id_antrian_detail + '"');
						$elm.find('.antrian-awalan').html(tujuan.awalan);
						nomor_antrian = tujuan.tujuan_panggil?.nomor_panggil || 0;
						$elm.find('.nomor-antrian-dipanggil').html(nomor_antrian);
						
					} else if (tujuan.tujuan_aktif == 'N') 
					{
						
						$elm = $('div[data-id-tujuan="' + tujuan.id_antrian_detail + '"');
						$elm.find('.antrian-awalan').html('');
						$elm.find('.nomor-antrian-dipanggil').html('---');							
					}
					
				}
				
				if (antrian_terakhir) 
				{
					$('.number-one').html(antrian_terakhir.awalan_panggil + antrian_terakhir.nomor_panggil);
					$('.current-antrian-tujuan').html(antrian_terakhir.nama_antrian_tujuan);
				} else {
					$('.number-one, .current-antrian-tujuan').html('---');
				}
				
				/* $.each(data.data, function(i, v) {
					$box = $('#id-antrian-detail-' + v['id_antrian_detail']);
					$box.find('.box-antrian-header').html(v['nama_antrian_tujuan']);
					
					if (v['aktif'] == 0) {
						awalan = '';
						nomor_dipanggil = '---';
					} else {
						awalan = v['awalan'];
						nomor_dipanggil = v['jml_dipanggil'];
					}
					$box.find('.antrian-awalan').html(awalan);
					$box.find('.nomor-antrian-dipanggil').html(nomor_dipanggil);
				
				});
				addAudio(data.data);
				if(audio_ended) {
					playSound()
				} */
				check_perubahan_antrian();
			}, error : function (xhr) {
				console.log(xhr);
				alert('Ajax Error !!!', xhr.responseText + '<br/><strong>Note</strong>: Detail error ada di console browser');
			}
		})
	}
	
	function playSound() {
		audio_ended = false
		
		if (current_added.indexOf(i) != -1) {
			console.log('change layar');
			data = data_layar_antrian[0];
			if (data) {
				console.log(data.awalan + data.jml_dipanggil);
				$('.current-antrian-number').find('.number-one').html(data.awalan + data.jml_dipanggil);
				$('.current-antrian-tujuan').html(data.nama_antrian_tujuan);
				$('#list-antrian-detail-nomor-' + data.id_antrian_detail).html(data.jml_dipanggil);
			}
			data_layar_antrian.splice(0, 1);
		}
		suara = audio_object[i];
		
		console.log(i + "-" + audio_object.length);
		if (suara !== undefined) {
			suara.addEventListener('ended', playSound);
			suara.play();
			/* if (i > 0) {
				delete(audio_object[i-1])
			} */
			i++;
		} else {
			audio_ended = true;
		}
	}

	function updateListAudio() {
		
		/* if (i > 0) {
			delete(audio_object[i-1])
		} */
		/* current_ended++;
		// console.log(audio_object);
		console.log('Ended : ' + current_ended + "-" + audio_object.length);
		if (current_ended == audio_object.length) {
			audio_ended = true;
			// audio_object.length = 0;
			i = 0;
		} */
		
		
	}
	
	
	/* function updateListAudio2() {
		
		if (i > 0) {
			delete(audio_object[i-1])
		}
		current_ended++;
		// console.log(audio_object);
		console.log('Ended : ' + current_ended + "-" + audio_object.length);
		if (current_ended == audio_object.length) {
			// Jika ada tambahan panggilan index telah tercapai namun suara belum selesai
			console.log(i + "-" + audio_object.length);
			if (i < audio_object.length) {
				playSound();
			} else {
				audio_ended = true;
			}
			// audio_object = [];
			// i = 0;
			
		}
		
		
	} */

	function addAudio(data) {
		
		audio = [];
		current_added.push(audio_object.length)
		awalan_panggil = $('#awalan-panggil').html();
		
		if (awalan_panggil) {
			textJSON = JSON.parse(awalan_panggil);
			if (textJSON) {
				obj = JSON.parse(textJSON);
				obj.map( item => {
					audio.push(item.toLowerCase());
				});
			}
		}
		
		if (data.awalan != '') {
			audio.push(data.awalan.toLowerCase() + '.wav');
		}

		audio_angka = terbilang(data.jml_dipanggil);
		audio_angka = audio_angka.split(' ');
		for (k in audio_angka) {
			audio_angka[k] = audio_angka[k].toLowerCase() + '.wav';
		}
	
		audio = audio.concat(audio_angka);
		audio.push('silakan_menuju_ke.wav');
		nama_file = $.parseJSON(data.nama_file);
		
		for (k in nama_file) {
			if ($.trim(nama_file[k]) != '') {
				audio.push(nama_file[k].toLowerCase());
				console.log(audio);
			}
		}
		
		audio.map(file => {
			audio_object.push(new Audio( base_url + 'public/files/audio/' + file) );
		})
	}
	
	function terbilang(bilangan) 
	{
		bilangan = parseInt(bilangan);
		angka = [];
		angka[0] = '';
		angka[1] = 'satu';
		angka[2] =  'dua';
		angka[3] =  'tiga';
		angka[4] =  'empat';
		angka[5] =  'lima';
		angka[6] =  'enam';
		angka[7] =  'tujuh';
		angka[8] =  'delapan';
		angka[9] =  'sembilan';
		angka[10] =  'sepuluh';
		angka[11] =  'sebelas';
		
		result = '';
		if (bilangan < 12) {
			result = ' ' + angka[bilangan];
		} else if (bilangan < 20) {
			result = terbilang(bilangan - 10) + ' belas';
		} else if (bilangan < 100) {
			result = terbilang(bilangan/10) + ' puluh ' + terbilang(bilangan % 10);
		} else if (bilangan < 200) {
			result = ' seratus ' + terbilang(bilangan - 100);
		} else if (bilangan < 1000) {
			result = terbilang(bilangan/100) + ' ratus ' + terbilang(bilangan % 100);
		} 
		
		/*
		else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}*/
		
		return $.trim(result);
	}
	
	check_perubahan_antrian();
 });