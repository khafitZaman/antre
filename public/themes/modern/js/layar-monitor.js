 $(document).ready(function() {
	/* window.setTimeout(jam_live(), 1000);
	function jam_live() {
		waktu = new Date();
		
		// console.log(waktu);
		 $('.jam').html(waktu.getHours());
		$('.menit').html(waktu.getMinutes());
		$('.detik').html(waktu.getSeconds());
		setTimeout(jam_live(), 1000);
	} */
	// jam_live();
	
	setInterval(function(){ 
		waktu = new Date();
		jam = "0" + waktu.getHours();
		menit = "0" + waktu.getMinutes();
		detik = "0" + waktu.getSeconds();
		$('#live_jam').html(jam.substr(-2) + ':' + menit.substr(-2) + ':' + detik.substr(-2));
		
	}, 1000);
 });