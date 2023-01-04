$(document).ready(function(){
	$('.ambil-antrian').click(function(e){
		e.preventDefault();
		
		$this = $(this);
		$loader = $('<i class="fas fa-circle-notch fa-spin me-2 mt-1" style="float:left"></i>');
		$loader.prependTo($this);
		$this.attr('disabled', 'disabled');
		$this.addClass('disabled');
		$this.prop('disabled', true);
		
		$.ajax({
			url : base_url + 'antrian-ambil/ajax-ambil-antrian',
			type : 'post',
			data : 'id=' + $this.attr('data-id-antrian-kategori'),
			dataType: 'json',
			success : function(data) {
				// console.log(data);
				$this.prop('disabled', false);
				$this.removeAttr('disabled');
				$loader.remove();
				$this.removeClass('disabled');
				$this.parent().prev().html(data.data.jml_antrian);

			}, error: function(xhr) {
				console.log(xhr);
				if (xhr.responseJSON.message) {
					bootbox.alert('<strong>Error</strong>: ' + xhr.responseJSON.message);
				}
				$this.removeAttr('disabled');
				$loader.remove();
				$this.removeClass('disabled');
				
				/* Swal.fire({
					title: 'Error !!!',
					text: xhr.responseText,
					type: 'error',
					showCloseButton: true,
					confirmButtonText: 'OK'
				}) */
			}				
		})
	});
})