$(document)
		.ready(
				function() {
					$('.slider4')
							.bxSlider(
									{
										slideWidth : 300,
										minSlides : 4,
										maxSlides : 4,
										moveSlides : 1,
										slideMargin : 10,
										nextText : '<img src="'
												+ base_url
												+ 'img/circle_next_arrow_disclosure_-32.png"></img>',
										prevText : '<img src="'
												+ base_url
												+ 'img/circle_back_arrow_-32.png"></img>'
									});
				});