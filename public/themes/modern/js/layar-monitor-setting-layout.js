jQuery(document).ready(function () {
	var $body =$('body');
	$('.range-slider').on('input', function(){
		
		 // Cache this for efficiency
		el = $(this);
		
		// console.log(el.position().top);
		
		// console.log();
		// $body = el.parents('body');
		// $body.css('font-size', el.val());
		// document.getElementsByTagName("BODY")[0].style.fontSize = '18px';
		// $(document.getElementsByTagName("BODY")).css('font-size', '18px');
		// $("body").css('font-size', el.val() + 'px');
// console.log(el.val());
	/* 	// Measure width of range input
		width = el.width();

		// Figure out placement percentage between left and right of input
		newPoint = (el.val() - el.attr("min")) / (el.attr("max") - el.attr("min"));

		// Janky value to get pointer to line up better
		offset = -1;

		// Prevent bubble from going beyond left or right (unsupported browsers)
		if (newPoint < 0) { newPlace = 0; }
		else if (newPoint > 1) { newPlace = width; }
		else { newPlace = width * newPoint + offset; offset -= newPoint; }

		// Move bubble
		/* el
		.next("output")
		.css({
			left: newPlace,
			marginLeft: offset + "%"
		})
		.text(el.val()); */
		$output = el.next("output");
		box = $output.width() / 2;
		
		var init = 25;
		var curr = ( (el.val() - 10 ) * 33 ) - box;
		var top_pos = 22 + el.position().top;
		
		el
		.next("output")
		.css({ 
			left: curr + init,
			top: top_pos
			
		})
		.text(el.val());
	})
	
	
	 var el, newPoint, newPlace, offset;
 
	 // Select all range inputs, watch for change
	 $("input[type='range']").change(function() {
	 
	  
	 })
	 
	$('#color-scheme').delegate('a', 'click', function() {
		
		$this = $(this);
		if ($this.children('i').length > 0) {
			return false;
		}
		classes = $this.attr('class');
		split = classes.replace('-theme','');
		
		$elm = $('#color-scheme, #color-scheme-side');
		$elm.each(function(i, elm) {
			$elm.find('i').remove();
			$elm.find('a.' + classes).append('<i class="fa fa-check theme-check"></i>');
		});
		
		$('#input-color-scheme').val(split);
	});

	
	$('#font-size').on('change', function() {
		// $('body').css('font-size', this.value);
	});
	
	const $jenis_video = $('#jenis-video');
	const $input = $jenis_video.next();
	let link_video = $input.val();
	$input.blur(function() {
		link_video = $input.val();
	})
	$('#jenis-video').change(function() {
		
		if (this.value == 'folder') {
			$input.attr('readonly', 'readonly');
			$input.val('public/videos/')
		} else {
			if ($jenis_video.val() != 'folder') {
				if (link_video == 'public/videos/') {
					link_video = '';
				}
			}
			$input.removeAttr('readonly');
			$input.val(link_video);
		}
	})
	
	$('#form-setting').submit(function(e) {
		e.preventDefault();
		$btn = $(this).find('button[type="submit"]').addClass('disabled').css('float', 'left');
		
		$btn.attr('disabled', 'disabled');
		$loader = $('<div class="spinner-submit fa-3x"><i class="fas fa-circle-notch fa-spin"></i></div>').insertAfter($btn);
		$.ajax({
			'url' : module_url
			, 'method': 'POST'
			, 'data': $(this).serialize() + '&submit=submit&ajax=ajax'
			, 'success' : function(data) {
				// console.log(data);
				msg = $.parseJSON(data);
				title = msg.status == 'ok' ? 'SUKSES !!!' : 'ERROR !!!';
				type = msg.status == 'ok' ? 'success' : 'error';
				Swal.fire({
					text: msg.message,
					title: title,
					type: type,
					showCloseButton: true,
					confirmButtonText: 'OK'
				})
				$btn.removeAttr('disabled').removeClass('disabled');
				$loader.remove();
			}, 'error' : function(xhr) {
				Swal.fire({
					text: 'Request error, lihat log console',
					title: 'Error !!!',
					type: 'error',
					showCloseButton: true,
					confirmButtonText: 'OK'
				})
				console.log(xhr);
			}
		})
		
	});
	
	$('#footer-text-mode').change(function(){
		if (this.value == 'statis') {
			$(this).next().hide()
		} else {
			$(this).next().show();
		}
	})
});