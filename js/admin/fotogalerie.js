// knihovna jquery 1.4.4 pro scrollovani novejsi nejde
//<script src="/js/admin/jquery-pro-scroll.1.4.4.js" type="text/javascript"/>

$(document).ready(function(){	//http://www.uploadify.com/documentation/

	// scrollbar v galeriich
	//	1) scroll type (values: "vertical" or "horizontal")
	//	2) scroll easing amount (0 for no easing)
	//	3) scroll easing type
	//	4) extra bottom scrolling space for vertical scroll type only (minimum value: 1)
	//	5) scrollbar height/width adjustment (values: "auto" or "fixed")
	//	6) mouse-wheel support (values: "yes" or "no")
	//	7) scrolling via buttons support (values: "yes" or "no")
	//	8) buttons scrolling speed (values: 1-20, 1 being the slowest)

	$("#mcs_container").mCustomScrollbar("vertical",100,"easeOutCirc",1.05,"fixed","yes","yes",1);


	$.uniform.restore("#text input");

	$("#text").show();

	$('#file_upload').uploadify({
		'uploader'	: '/res/uploadify/uploadify.swf',
		'script'	: '/res/uploadify/uploadify.php',
		//	'buttonImg' : 'img/browse.png',
		'buttonText'  : 'Vl',
		'buttonImg' : '/images/admin/upload_foto_text.png',
		'cancelImg' : '/res/uploadify/cancel.png',
		'folder'	: '/files',
		'height'		:	'46', //height of your browse button file
		'width'			:	'272', //width of your browse button file
		'auto'		: true,
		'multi'	: true,
		'wmode'       : 'transparent',
		// 'hideButton'  : true,
		'scriptData'  : {
			'idGallery': $('#file_upload').attr('rel'),
			'type': 'foto'
		},
		'onAllComplete' : function(event,data) {
			//			alert(data.filesUploaded + ' fotografie náhrano');
			$("#success-message").html("Fotografie uloženy");
			$("#success-message").dialog({
				autoOpen: true,
				height: 190,
				modal: true,
				buttons: {
					Ok: function() {
						$(this).dialog('close');
						window.location.reload();
					}
				}
			});
		}
	});



	$(".imageName, .imageDescription, .imageUrl, .imagePriority, .imageVisible, .imageAuthor, .imageUrl, .imagePriority").each(
		function () {
			$(this).change(
				function () {
					var id = $(this).attr("rel");
					$.post("/res/ajax.php?mode=imageEdit",{
						idImage: id,
						name: $('#imageName_'+id).val(),
						description: $('#imageDescription_'+id).val(),
						url: $('#imageUrl_'+id).val(),
						priority: $('#imagePriority_'+id).val(),
						visible: $('#imageVisible_'+id).is(':checked'),
						author: $('#imageAuthor_'+id).val(),
						url: $('#imageUrl_'+id).val()
					},
					function (data) {
						if (data.type == 'success') {
							successBox(data.value, false);
							$("#nabidka_"+id).remove();
							$("#poptavka_"+id).remove();
							$("#error-message").dialog('open');
						}
						if (data.type == 'error') {
							errorBox(data.value, false);
						}
					}, "json");
				});
		});


	$(".imageDelete").each(
		function () {
			$(this).click(
				function () {
					var id = $(this).attr("rel");
					$("#dialog-confirm").text('Opravdu smazat fotografii ?');
					$("#dialog-confirm").dialog({ resizable: false, height:200, modal: true,
						buttons: {
							'Ano': function() {
								$(this).dialog('close');
								$.post("/res/ajax.php?mode=imageDelete",{ idImage: id },
								function (data) {
									if (data.type == 'success') {
										$('#galleryImage_' + id).remove();
										successBox(data.value, false);
									}
									if (data.type == 'error') {
										errorBox(data.value, false);
									}
								}, "json");
							},
							Cancel: function() {
								$(this).dialog('close');
							}
						}
					});
				});
		});


	$(".galleryDelete").each(
		function () {
			$(this).click(
				function () {
					var id = $(this).attr("rel");
					$("#dialog-confirm").text('Opravdu smazat galerii ?');
					$("#dialog-confirm").dialog({
						resizable: false,
						height:200,
						modal: true,
						buttons: {
							'Ano': function() {
								$(this).dialog('close');

								$.post("/res/ajax.php?mode=galleryDelete",{
									idGallery: id
								},
								function (data) {
									$("#success-message").html(data.value);
									if (data.type == 'success') {
										$('#galleryList_' + id).remove();
										$("#success-message").dialog({
											autoOpen: true,
											height: 190,
											modal: true,
											buttons: {
												Ok: function() {
													$(this).dialog('close');

												//													window.location.reload();
												}
											}
										});
										$("#nabidka_"+id).remove();
										$("#poptavka_"+id).remove();
										$("#error-message").dialog('open');
									}
									if (data.type == 'error') {
										$("#error-message").html(data.value);
										$("#error-message").dialog({
											autoOpen: true,
											height: 190,
											modal: true,
											buttons: {
												Ok: function() {
													$(this).dialog('close');
												}
											}
										});
										$("#error-message").dialog('open');
									}
								}, "json");
							},
							Cancel: function() {
								$(this).dialog('close');
							}
						}
					});
				});
		});

});

$(".imageDelete").each(
	function () {
		$(this).click(
			function () {
				var id = $(this).attr("rel");
				$("#dialog-confirm").text('Opravdu smazat fotografii ?');
				$("#dialog-confirm").dialog({
					resizable: false,
					height:200,
					modal: true,
					buttons: {
						'Ano': function() {
							$(this).dialog('close');

							$.post("/res/ajax.php?mode=imageDelete",{
								idImage: id
							},
							function (data) {
								$("#success-message").html(data.value);
								if (data.type == 'success') {
									$("#success-message").dialog({
										autoOpen: true,
										height: 190,
										modal: true,
										buttons: {
											Ok: function() {
												$(this).dialog('close');
												window.location.reload();
											}
										}
									});
									$("#nabidka_"+id).remove();
									$("#poptavka_"+id).remove();
									$("#error-message").dialog('open');
								}
								if (data.type == 'error') {
									$("#error-message").html(data.value);
									$("#error-message").dialog({
										autoOpen: true,
										height: 190,
										modal: true,
										buttons: {
											Ok: function() {
												$(this).dialog('close');
											}
										}
									});
									$("#error-message").dialog('open');
								}
							}, "json");
						},
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});


			});

	});
