// knihovna jquery 1.4.4 pro scrollovani novejsi nejde
//<script src="/js/admin/jquery-pro-scroll.1.4.4.js" type="text/javascript"/>


function setCalendarVisibility(ele, idCalendar) {
	loading('show');
	$.getJSON("/res/ajax.php?mode=setCalendarVisibility",{
		idCalendar: idCalendar,
		visible: $(ele).is(':checked')
	}, function(j){
		loading('hide');
	});
};

$(document).ready(function(){	//http://www.uploadify.com/documentation/
	$(".calendarDelete").each(
		function () {
			$(this).click(
				function () {
					var id = $(this).attr("rel");
					$("#dialog-confirm").text('Opravdu smazat událost ?');
					$("#dialog-confirm").dialog({
						resizable: false,
						height:200,
						modal: true,
						buttons: {
							'Ano': function() {
								$(this).dialog('close');

								$.post("/res/ajax.php?mode=calendarDelete",{
									idCalendar: id
								},
								function (data) {
									$("#success-message").html(data.value);
									if (data.type == 'success') {
										$('#calendarList_' + id).remove();
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
