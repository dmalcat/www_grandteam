function showGallery(idGallery) {
	$('#galerieFotoDetail').hide();
	$('#galerieFotoDetail').load('/res/ajax.php?mode=fetchGallery&idGallery=' + idGallery, function () {
		$('#galerieFotoDetail').fadeIn('slow');
		$(".galerie_detail_image").lightBox();
//		Shadowbox.init({
//			language:   "cs"
//		});
//		Shadowbox.setup();
	});
}

function showFileGallery(idGallery) {
	$('#galerieFileDetail').hide();
	$('#galerieFileDetail').load('/res/ajax.php?mode=fetchFileGallery&idGallery=' + idGallery, function () {
		$('#galerieFileDetail').fadeIn('slow');
		$(".galerie_detail_image").lightBox();
//		Shadowbox.init({
//			language:   "cs"
//		});
//		Shadowbox.setup();
	});
}