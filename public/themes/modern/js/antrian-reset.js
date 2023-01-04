$(document).ready(function(){
	var suara = '';
	
	$('.kategori-reset-dipanggil').click(function(e){
		
		e.preventDefault();
		$this = $(this);
		
		if ($this.hasClass('disabled')) {
			return false;
		}
		
		$loader = $('<i class="fas fa-circle-notch fa-spin me-2 mt-1" style="float:left"></i>');
		$loader.prependTo($this);
		$tr = $this.parents('tr').eq(0);
		$button = $tr.find('a.kategori-reset-dipanggil');
		$button.attr('disabled', 'disabled').addClass('disabled');
		
		id = $(this).attr('data-id-antrian-kategori');
		$.ajax({
			url : base_url + 'antrian-reset/ajax-reset-dipanggil-by-kategori',
			type : 'post',
			data : 'id=' + id,
			dataType : 'json',
			success : function(data) {
				$loader.remove();
				if (data.status == 'ok') {
					$tr.find('.jml-dipanggil').html('0');
				}					
			}, error: function(xhr) {
				console.log(xhr);
				$loader.remove();
				$button.removeAttr('disabled').removeClass('disabled');
				Swal.fire({
					title: 'Error !!!',
					text: xhr.responseText,
					type: 'error',
					showCloseButton: true,
					confirmButtonText: 'OK'
				})
			}				
		})
	});
	
	$('.kategori-reset-all').click(function(e){
		
		e.preventDefault();
		
		$this = $(this);
		if ($this.hasClass('disabled')) {
			return false;
		}
		
		$tr = $this.parents('tr').eq(0);
		$loader = $('<i class="fas fa-circle-notch fa-spin me-2 mt-1" style="float:left"></i>');
		$loader.prependTo($this);
		$button = $tr.find('a.kategori-reset-dipanggil, a.kategori-reset-all');
		$button.attr('disabled', 'disabled').addClass('disabled');
		
		id = $(this).attr('data-id-antrian-kategori');
		$.ajax({
			url : base_url + 'antrian-reset/ajax-reset-all-by-kategori',
			type : 'post',
			data : 'id=' + id,
			dataType : 'json',
			success : function(data) {
				$loader.remove();
				if (data.status == 'ok') {
					$tr.find('.jml-dipanggil, .jml-antrian').html('0');
				}					
			}, error: function(xhr) {
				console.log(xhr);
				$loader.remove();
				$button.removeAttr('disabled').removeClass('disabled');
				Swal.fire({
					title: 'Error !!!',
					text: xhr.responseText,
					type: 'error',
					showCloseButton: true,
					confirmButtonText: 'OK'
				})
			}				
		})
	});
	
	$('.reset-all-dipanggil').click(function(e){
		
		e.preventDefault();
		
		$this = $(this);
		if ($this.hasClass('disabled')) {
			return false;
		}
		$loader = $('<i class="fas fa-circle-notch fa-spin me-2 mt-1" style="float:left"></i>');
		$loader.prependTo($this);
		
		$button = $('.reset-all-dipanggil, a.kategori-reset-dipanggil');
		$button.attr('disabled', 'disabled').addClass('disabled');

		$.ajax({
			url : base_url + 'antrian-reset/ajax-reset-all-dipanggil',
			type : 'post',
			data : '',
			dataType : 'json',
			success : function(data) {
				$loader.remove();
				if (data.status == 'ok') {
					$('.jml-dipanggil').html('0');
				}					
			}, error: function(xhr) {
				console.log(xhr);
				$loader.remove();
				$button.removeAttr('disabled').removeClass('disabled');
				Swal.fire({
					title: 'Error !!!',
					text: xhr.responseText,
					type: 'error',
					showCloseButton: true,
					confirmButtonText: 'OK'
				})
			}				
		})
	});
	
	$('.reset-all').click(function(e){
		
		e.preventDefault();
		
		$this = $(this);
		if ($this.hasClass('disabled')) {
			return false;
		}
		$loader = $('<i class="fas fa-circle-notch fa-spin me-2 mt-1" style="float:left"></i>');
		$loader.prependTo($this);
		
		$button = $('.reset-all-dipanggil, .reset-all, a.kategori-reset-dipanggil, a.kategori-reset-all');
		$button.attr('disabled', 'disabled').addClass('disabled');
		
		$.ajax({
			url : base_url + 'antrian-reset/ajax-reset-all',
			type : 'post',
			data : '',
			dataType : 'json',
			success : function(data) {
				$loader.remove();
				if (data.status == 'ok') {
					$('.jml-dipanggil, .jml-antrian').html('0');
				}					
			}, error: function(xhr) {
				console.log(xhr);
				$loader.remove();
				$button.removeAttr('disabled').removeClass('disabled');
				Swal.fire({
					title: 'Error !!!',
					text: xhr.responseText,
					type: 'error',
					showCloseButton: true,
					confirmButtonText: 'OK'
				})
			}				
		})
	});
})