$(function() {
	replaceSVG();

	$('#hp-news').slick({
		infinite: true,
		speed: 300,
		slidesToShow: 3,
		centerMode: true,
		variableWidth: true
	});
});