$(document).ready(function(){
	$('.ambil-antrian').click(function(){
		$this = $(this);
		$loader = $('<i class="fas fa-circle-notch fa-spin fa-lg mt-2"></i>');
		$loader.appendTo($this);
		$this.attr('disabled', 'disabled');
		$this.prop('disabled', true);
		
		$.ajax({
			url : base_url + 'antrian-ambil/ajax-ambil-antrian',
			type : 'post',
			data : 'id=' + $this.attr('data-id-antrian-kategori'),
			success : function(data) {
				$this.prop('disabled', false);
				$this.removeAttr('disabled');
				$loader.remove();
				console.log(data);
			}, error: function(xhr) {
				$this.prop('disabled', false);
				$this.removeAttr('disabled');
				$loader.remove();
				bootbox.alert('<strong>Error</strong> ' + xhr.responseJSON.message);
			}				
		})
	});
})