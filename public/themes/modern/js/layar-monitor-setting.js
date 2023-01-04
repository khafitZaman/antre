 $(document).ready(function() {
	 	 	 
	 $('.btn-delete-kategori').click(function() {
		var $this = $(this);
		bootbox.confirm({
			title: 'Hapus Kategori',
			message: $this.attr('data-delete-title'),
			callback: function(confirmed) {
				if (confirmed) {
					$this.attr('disabled', 'disabled');
					$kategori_container = $this.parents('.kategori-container').eq(0);
					dragKategori.destroy();
					$.ajax({
						type : 'post',
						url : base_url + '/gallery/ajaxKategoriDelete',
						data : 'submit=submit&delete=delete&id=' + $this.parents('.kategori-container').eq(0).attr('id').split('-')[1],
						dataType : 'JSON',
						success : function(data) 
						{
							$this.removeAttr('disabled');
							initDragKategori();
							if (data.status == 'error') {
								show_alert('Error !!!', data.message, 'error');
							} else {
								$kategori_container.fadeOut('fast', function() { $(this).remove() });
							}
						}, error : function (xhr) {
							$this.removeAttr('disabled');
							show_alert('Ajax Error !!!', xhr.responseJSON.message + '<br/><strong>Note</strong>: Detail error ada di console browser', 'error');
							console.log(xhr);
						}
					})
				}
			}
		});
		return;
	 });
	 
	function show_message(type, content) {
		return '<div class="alert alert-danger">' + content + '</div>'; 
	}
		
	$('body').delegate('#new-category', 'change', function() {
		
		var $this = $(this);
		$loader = $('<div class="spinner-border spinner-border-sm" style="position: absolute;right: 30px;bottom: 25px;"></div>').insertAfter($this);
		
		$.ajax({
			type : 'post',
			url	: base_url + 'gallery/ajaxGalleryChangeImageCategory',
			data : 'submit=submit&id_gallery_kategori=' + $this.val() + '&id=' + $this.parent().find('input[name="id"]').val(),
			dataType : 'JSON',
			success : function(data) {
				$loader.remove();
				
				if (data.status == 'error') {
					show_alert('Error !!!', data.message, 'error');
				} else {
					id_gallery = $this.next().val();
					$('#gallery-' + id_gallery).fadeIn('fast', function() {
						$(this).remove();
					});
				}
			}, error : function (xhr) {
				$loader.remove();
				show_alert('Ajax Error !!!', xhr.responseJSON.message + '<br/><strong>Note</strong>: Detail error ada di console browser', 'error');
				console.log(xhr);
			}
		});
	});
	
	
	/* drake = dragula([document.getElementById('accordion-left'), document.getElementById('accordion-right')], {
		moves: function (el, container, handle) {
			return handle.classList.contains('grip-handler') || handle.parentNode.classList.contains('grip-handler');
		}
	});
	 */
	 dragKategori = null;
	 
	 function initDragKategori() {
		dragKategori = dragula([document.getElementById('selected-kategori-panel'), document.getElementById('list-kategori-panel')], {
			moves: function (el, container, handle) {
				return handle.classList.contains('grip-handler') || handle.parentNode.classList.contains('grip-handler');
			}
		});
		
		dragKategori.on('dragend', function(el)
		{
			id = $('#id-setting-layar').val();
			$input_urut = $('.selected-kategori-panel').find('input[name="urut[]"]');
			
			list_id = [];
			$input_urut.each(function(i, elm){
				list_id.push( $(elm).val() );
			});
			
			list_id_kategori = JSON.stringify(list_id);
			$.ajax({
				type : 'post',
				url : base_url + '/layar-monitor-setting/ajaxUpdateKategori',
				data : 'submit=submit&id_setting_layar=' + id + '&list_id_kategori=' + list_id_kategori,
				dataType : 'JSON',
				success : function(data) {
					if (data.status == 'error') {
						show_alert('Error !!!', data.message, 'error');
					}
				}, error : function (xhr) {
					show_alert('Ajax Error !!!', xhr.responseJSON.message + '<br/><strong>Note</strong>: Detail error ada di console browser', 'error');
					console.log(xhr);
				}
				
			})
		});
	 }
	
	initDragKategori();
	
 });