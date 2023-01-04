$(document).ready(function(){
	$('.ambil-antrian').click(function(){

		audio = [];
		audio.push('nomor_antrian');
		audio.push('a');
		audio_angka = terbilang();
		audio_angka = audio_angka.split(' ');
		audio = audio.concat(audio_angka);
		audio.push('silakan_menuju_ke');
		audio.push('poliklinik');
		audio.push('umum');
		
		i = 0;	
		playSnd();
		function playSnd() 
		{
			if (i == audio.length) return;
			suara = new Audio('public/files/audio/' + audio[i] + '.wav');
			suara.addEventListener('ended', playSnd);
			suara.play();
			i++;
		}
	});
	
	function terbilang(bilangan) 
	{
		bilangan = '25';
		bilangan = parseInt(bilangan);
		angka = [];
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

		if (bilangan <= 10) {
			return angka[bilangan];
			
		} else if (bilangan < 20) {
			if (bilangan == 11) {
				return 'sebelas';
			} else {
				sisa = bilangan % 10;
				bilangan_sisa = sisa ? ' ' + angka[sisa] : '';
				return bilangan_sisa + ' belas';
			}
			
		} else if (bilangan < 100) {
			sisa = bilangan % 10;
			bilangan_sisa = sisa ? ' ' + angka[sisa] : '';
			puluhan = Math.floor(bilangan/10);
			return  angka[puluhan] + ' puluh' + bilangan_sisa;
		}
	}
})