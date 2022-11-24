$(function() {
	replaceSVG();

	var scroll = new SmoothScroll('a[href*="#"]');

	$("#navigation").offCanvasMenu({
		menuPosition: 'right',
		openMenu: '#hamburger',
		footerContent: 'Test'
	});

	$('#hp-news').slick({
		infinite: true,
		speed: 300,
		slidesToShow: 3,
		centerMode: true,
		variableWidth: true
	});
});