 $(document).ready(function() {
	 
	$media_container = $('.media');
	w = $media_container.outerWidth();
	h = $media_container.outerHeight();
	
	function playVideo() 
	{
		const data_videos = JSON.parse(list_videos);
		const controls = `
		<div class="plyr__controls">
			${ data_videos.length > 1 ?
			`<button class="plyr__controls__item plyr__control" type="button" id="prev-video" aria-label="Prev Video">
				<svg class="icon--not-pressed" aria-hidden="true" focusable="false">
					<use xlink:href="${base_url}public/vendors/font-awesome/sprites/solid.svg#step-backward"></use>
				</svg>
					<span class="plyr__tooltip" role="tooltip">Prev Video</span>
			</button>` : ``
			}
			<button class="plyr__controls__item plyr__control" type="button" data-plyr="play" aria-label="Play">
				<svg class="icon--pressed" aria-hidden="true" focusable="false">
					<use xlink:href="#plyr-pause"></use>
				</svg>
				<svg class="icon--not-pressed" aria-hidden="true" focusable="false">
					<use xlink:href="#plyr-play"></use>
				</svg>
					<span class="label--pressed plyr__sr-only">Pause</span>
					<span class="label--not-pressed plyr__sr-only">Play</span>
			</button>
			${ data_videos.length > 1 ?
			`<button class="plyr__controls__item plyr__control" type="button" id="next-video" aria-label="Next Video">
				<svg class="icon--not-pressed" aria-hidden="true" focusable="false">
					<use xlink:href="${base_url}public/vendors/font-awesome/sprites/solid.svg#step-forward"></use>
				</svg>
					<span class="plyr__tooltip" role="tooltip">Next Video</span>
			</button>` : ``}
			<div class="plyr__controls__item plyr__progress__container">
			<div class="plyr__progress">
				<input data-plyr="seek" type="range" min="0" max="100" step="0.01" value="0" autocomplete="off" role="slider" aria-label="Seek" aria-valuemin="0" aria-valuemax="183.126" aria-valuenow="0" id="plyr-seek-2924" aria-valuetext="00:00 of 03:03" style="--value:0%;">
				<progress class="plyr__progress__buffer" min="0" max="100" value="0" role="progressbar" aria-hidden="true">% buffered</progress>
				<span class="plyr__tooltip">00:00</span>
			</div>
			</div>
			<div class="plyr__controls__item plyr__time--current plyr__time" aria-label="Current time">03:03</div>
			<div class="plyr__controls__item plyr__volume">
				<button type="button" class="plyr__control" data-plyr="mute">
					<svg class="icon--pressed" aria-hidden="true" focusable="false">
					<use xlink:href="#plyr-muted"></use>
					</svg>
					<svg class="icon--not-pressed" aria-hidden="true" focusable="false">
						<use xlink:href="#plyr-volume"></use>
					</svg>
					<span class="label--pressed plyr__sr-only">Unmute</span>
					<span class="label--not-pressed plyr__sr-only">Mute</span>
				</button>
				<input data-plyr="volume" type="range" min="0" max="1" step="0.05" value="1" autocomplete="off" role="slider" aria-label="Volume" aria-valuemin="0" aria-valuemax="100" aria-valuenow="45" id="plyr-volume-2924" aria-valuetext="45.0%" style="--value:45%;">
			</div>
		</div>`;


		$video = $('<video controls crossorigin playsinline>');
		$video.attr({'width': w, 'height' : h});
		$('.loader-ring').remove();
		$video.appendTo($('.media').height(h));
		$('.current-antrian-container').height(h);
		$source = $('<source>').appendTo($video);
		$source.attr('src', "");
		const player = new Plyr($video[0], {controls});
		
		let urut = 0;
	
		player.source = {
			type: 'video',
			title: 'Example title',
			sources: [
			 {
				  src: data_videos[urut],
				  type: "video/mp4",
			  }
			]
		 };

		player.on('ended', function(event) {
			
			urut = urut + 1;
			if (urut == data_videos.length) {
				urut = 0;
			}
			player.source = {
				type: 'video',
				title: 'Example title',
				sources: [
				 {
					  src: data_videos[urut],
					  type: "video/mp4",
				  }
				]
			 };
			 
			 player.play();

		})

		$(document).delegate('#next-video', 'click', function() {
			urut = urut + 1;
			if (urut == data_videos.length) {
				urut = 0;
			}
			
			player.source = {
				type: 'video',
				title: 'Example title',
				sources: [
				 {
					  src: data_videos[urut],
					  type: "video/mp4",
				  }
				]
			 };
			 
			 player.play();
		})

		$(document).delegate('#prev-video', 'click', function() {
			if (urut == 0) {
				urut = data_videos.length - 1;
			} else {
				urut = urut - 1;
				
			}
			
			player.source = {
				type: 'video',
				title: 'Example title',
				sources: [
				 {
					  src: data_videos[urut],
					  type: "video/mp4",
				  }
				]
			 };
			 
			 player.play();
		})
		
		 // player.play();
	}
	
	
	function playYoutube() {
		const $cont = $('<div class="plyr__video-embed" id="player">')
		const $iframe = $('<iframe title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen allowtransparency>');
			$iframe.attr({'width': w, 'height' : h});
			$('.loader-ring').remove();
			$iframe.appendTo($cont);
			
			$cont.appendTo($('.media').height(h));
			$('.current-antrian-container').height(h);
			$iframe.attr('src', $('#link-video').text());
		const player = new Plyr('#player');
		player.play()
	}
	
	if (jenis_video == 'youtube') {
		playYoutube();
	} else {
		playVideo();
	}

	// Box 
	$box = $('.box-antrian-header');
	let boxHeight = [];
	$box.each(function(i, elm) {
		boxHeight.push($(elm).outerHeight());
	});
	height = Math.max.apply(null, boxHeight);
	$box.each(function(i, elm) {
		$(elm).css('height', height);
	});
	
 });