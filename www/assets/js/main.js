$(function() {
	replaceSVG();

	AOS.init();
	
	window.addEventListener('load', AOS.refresh);

	var scroll = new SmoothScroll('a[href*="#"]');

	$("#navigation").offCanvasMenu({
		menuPosition: 'right',
		openMenu: '#hamburger'
	});

	$('#hp-slider').slick({
		infinite: true,
		autoplay: true,
		autoplaySpeed: 3000,
		fade: true,
		arrows: false,
		dots: true
	});
});