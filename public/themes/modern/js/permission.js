jQuery(document).ready(function () {
	$('select').change( function() {
		$('#form-permission').find('button').click();
	});
	
	$('.select2').select2({theme: 'bootstrap-5'});
	
	$('select[name="generate_permission"]').change(function() {
		if (this.value == 'manual') {
			$('.input-container').show();
		} else {
			$('.input-container').hide();
		}
		
	});
	
	$('.edit').click(function(e) {
		e.preventDefault;
		$this = $(this);

		$bootbox =  bootbox.dialog({
			title: 'Edit Permission',
			message: '<div class="loader-ring loader"></div>',
			buttons: {
				cancel: {
					label: 'Cancel'
				},
				success: {
					label: 'Submit',
					className: 'btn-success submit',
					callback: function() 
					{
						$bootbox.find('.alert').remove();
						$button_submit.prepend('<i class="fas fa-circle-notch fa-spin me-2 fa-lg"></i>');
						$button.prop('disabled', true);
						$form_filled = $bootbox.find('form');
						url_edit = $form_filled.attr('action');

						$.ajax({
							type: 'POST',
							url: url_edit,
							data: $form_filled.serialize(),
							dataType: 'text',
							success: function (data) {
								data = $.parseJSON(data);
								if (data.status == 'ok') 
								{
									var id_module = $form_filled.find('select[name="id_module"]').val();
									var id_module_old = $form_filled.find('input[name="id_module_old"]').val();
									var nama_permission = $form_filled.find('input[name="nama_permission"]').val();
									var judul_permission = $form_filled.find('input[name="judul_permission"]').val();
									var keterangan = $form_filled.find('textarea[name="keterangan"]').val();
									
									if( id_module != id_module_old ) {
										window.location.reload(false); 
									}
									
									$tr = $this.parents('tr');
									$td = $tr.find('td');
									$td.eq(2).html(nama_permission);
									$td.eq(3).html(judul_permission);
									$td.eq(4).html(keterangan);
									
									$bootbox.modal('hide');
									Swal.fire({
										title: 'Sukses !!!',
										text: data.message,
										type: 'success',
										showCloseButton: true,
										confirmButtonText: 'OK'
									})
								} else {
									$button_submit.find('i').remove();
									$button.prop('disabled', false);
									list = '<ul class="list-circle">';
									for (k in data.message) {
										list += '<li>' + data.message[k] + '</li>';
									}
									list += '</ul>';
									Swal.fire({
										title: 'Error !!!',
										html: list,
										type: 'error',
										showCloseButton: true,
										confirmButtonText: 'OK'
									})
								}
							},
							error: function (xhr) {
								console.log(xhr.responseText);
							}
						})
						return false;
					}
				}
			}
		});
			

		var $button = $bootbox.find('button').prop('disabled', true);
		var $button_submit = $bootbox.find('button.submit');
		var id = $(this).attr('data-id-permission');
		$.get(current_url + '/ajaxFormEdit?id=' + id, function(html){
			$button.prop('disabled', false);
			$bootbox.find('.modal-body').empty().append(html);
		});
	});
	
	$('.delete').click(function() 
	{
		$this = $(this);
		$tr = $this.parents('tr');
		$td = $tr.find('td');
		nama_permission = $td.eq(2).html();
									
		var $bootbox = bootbox.confirm({
			message: "Yakin akan menghapus permission <strong>" + nama_permission + "</strong> ?",
			buttons: {
				confirm: {
					label: 'Yes',
					className: 'btn-success submit'
				},
				cancel: {
					label: 'No',
					className: 'btn-danger'
				}
			},
			callback: function(result) {
				if(result) {
					$button = $bootbox.find('button').prop('disabled', true);
					$button_submit = $bootbox.find('button.submit');
					$button_submit.prepend('<i class="fas fa-circle-notch fa-spin me-2 fa-lg"></i>');
					url_delete = $this.attr('data-url');
					$.ajax({
						type: 'POST',
						url: url_delete,
						data: 'id=' + $this.attr('data-id-permission'),
						success: function(msg) {
							msg = $.parseJSON(msg);
							if (msg.status == 'ok') {
								$tr.fadeOut('fast', function() {
									$(this).remove();
								});
								/* Swal.fire({
									text: msg.message,
									title: 'Sukses !!!',
									type: 'success',
									showCloseButton: true,
									confirmButtonText: 'OK'
								}) */

							} else {
								/* Swal.fire({
									title: 'Error !!!',
									text: msg.message,
									type: 'error',
									showCloseButton: true,
									confirmButtonText: 'OK'
								}) */
							}
						},
						error: function() {
							
						}
					})
				}
			}
			
		});
	});
});