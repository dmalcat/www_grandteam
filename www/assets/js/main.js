$(function() {
	replaceSVG();

	var scroll = new SmoothScroll('a[href*="#"]');

	$("#navigation").offCanvasMenu({
		menuPosition: 'right',
		openMenu: '#hamburger'
	});

	$('#hp-slider').slick({
		infinite: true,
		autoplay: false,
		autoplaySpeed: 1000,
		fade: true,
		arrows: false,
		dots: true
	});
});