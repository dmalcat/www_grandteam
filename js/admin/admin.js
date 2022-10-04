function hledat() {
    if (jQuery('#hledatFulltextAdmin').val()) {
        jQuery.ajax({
            data: {
                fulltext: jQuery('#hledatFulltextAdmin').val()
            },
            url: '/res/ajax.php?mode=adminProductSearch',
            success: function ($return) {
                jQuery('#vysledky').html($return);
                jQuery('#vysledky').fadeIn("slow");
            }
        });
    }
}


$(document).ready(function () {

//    $(".selectize").selectize();

    $(".user_activate").each(function () {
        $(this).change(
                function () {
                    loading('show');
                    $.getJSON("/res/ajax.php?mode=activateUser", {
                        idUser: $(this).attr("rel"),
                        state: $(this).attr("checked") ? 1 : 0
                    }, function (data) {
                        if (data.type == 'success') {
                            successMessage('Uživatel upraven', false);
                        } else {
                            errorMessage('Došlo k chybe při úpravě uživatele.')
                        }
                        loading('hide');
                    });
                });
    });


//	if (typeof(FCKeditorAPI)!=='undefined') {
//		CKEDITOR.replace('ckGalerieAnnotation', {width: "590px", height: "250px"});
//		CKEDITOR.replace('ckGalerieDescription', {width: "590px", height: "390px"});
//	}




    jQuery('#vyhledatProdukty').click(function () {
        hledat();
    });
    jQuery('#hledatFulltextAdmin').keypress(function (event) {
        if (event.keyCode == '13') {
            hledat();
        }
    });

    $('#content_category_tree').treeview({
        // persist: "cookie",
        persist: "location",
        animated: "fast",
        collapsed: true,
        unique: true
    });

    $('#organizerPreset').change(function () {
        loading('show');
        $.getJSON("/res/ajax.php?mode=getOrganizerDetail", {
            id: $(this).val()
        }, function (data) {
            if (data) {
//				console.log(data);
                $('input[name=organizer_name]').val(data.name);
                $('input[name=organizer_person]').val(data.person);
                $('input[name=organizer_phone]').val(data.phone);
                $('input[name=organizer_address]').val(data.address);
                $('input[name=organizer_email]').val(data.email);
                $('input[name=organizer_url]').val(data.url);
                successMessage('Pozice upravena', false);
            } else {
                errorMessage('Data organizátora se nepodařilo načíst.');
            }
            loading('hide');
        });
    });


// 	$('.cartItemStatus').change(function () {
// 		loading('show');
// 		var $id = $(this).attr('rel');
// 		$.getJSON("/res/ajax.php?mode=setCartItemStatus",{id: $id, status: $(this).val()}, function(data){
// 			if(data.result) {
// 				$('#cartItem_' + $id).attr('class', data.class);
// //				successBox('Položka upravena',false);
// 			} else {
// 				errorMessage('Došlo k chybě při úpravě položky.');
// 			}
// 			loading('hide');
// 		});
// 	});

    //	$(".contentCategoryType").click(function(event) {
    //		event.preventDefault();
    //		return false;
    //	});

    $("#hledatFulltext").autocomplete({
        source: "/res/ajax.php?mode=searchFull",
        minLength: 1,
        select: function (event, ui) {
            //				log( ui.item ?
            //					"Selected: " + ui.item.value + " aka " + ui.item.id :
            //					"Nothing selected, input was " + this.value );
            window.location = ui.item.value;
            ui.item.value = ui.item.label;
            //				return false;
        }
    });

    $("#hledatFulltextUser").autocomplete({
        source: "/res/ajax.php?mode=searchFullUser",
        minLength: 1,
        select: function (event, ui) {
            window.location = ui.item.value;
            ui.item.value = ui.item.label;
        }
    });

    $("#hledatFulltextNewsletter").autocomplete({
        source: "/res/ajax.php?mode=searchFullNewsletter",
        minLength: 1,
        select: function (event, ui) {
            window.location = ui.item.value;
            ui.item.value = ui.item.label;
        }
    });

    $("#hledatFulltextGallery").autocomplete({
        source: "/res/ajax.php?mode=searchFullGallery",
        minLength: 1,
        select: function (event, ui) {
            window.location = ui.item.value;
            ui.item.value = ui.item.label;
        }
    });

    $(".galleryImageFileInput").each(function () {
        $(this).change(
                function () {
                    idGalleryImage = ($(this).attr('rel'));
                    if ($(this).val()) {
                        $('#galleryImageForm_' + idGalleryImage).submit();
                    }
                });
    });


    $(document).on("change", "select[name='id_content_type']", function () {
        loading('show');
        $.getJSON("/res/ajax.php?mode=getContentCategoriesByIdContentType", {
            id: $(this).val(),
            ajax: 'true'
        }, function (j) {
            var options = '';
            options += '<option value="">---</option>';
            for (var i = 0; i < j.length; i++) {
                options += '<option value="' + j[i].id_content_category + '">' + j[i].name + '</option>';
            }
//			$("select[name='id_parent']").html(options);
            $("#id_content_category").html(options);
            $.uniform.update("select[name='id_parent']");
            loading('hide');
        });
    });

    // inicializace formularu
    $("input:checkbox, input:radio, input:file, select, .uniform").not('.noUniform').filter(
            function () {
                return $(this).parents('#accordion').length < 1;
            }
    ).uniform();


    // definice obrazku v accordion
    var icons = {
        header: "ui-icon ui-icon-circle-plus",
        headerSelected: "ui-icon ui-icon-circle-minus"
    };

    // zobrazovani input-file u anotacnich obrazku

    $("#upload_foto_1").click(function () {
        $("#div_upload_foto_1").show();
        $("#div_upload_foto_2").hide();
        $("#div_upload_foto_3").hide();
        $("#div_upload_foto_4").hide();
        $("#div_upload_foto_5").hide();
        $("#div_upload_foto_6").hide();
    });
    $("#upload_foto_2").click(function () {
        $("#div_upload_foto_1").hide();
        $("#div_upload_foto_2").show();
        $("#div_upload_foto_3").hide();
        $("#div_upload_foto_4").hide();
        $("#div_upload_foto_5").hide();
        $("#div_upload_foto_6").hide();
    });
    $("#upload_foto_3").click(function () {
        $("#div_upload_foto_1").hide();
        $("#div_upload_foto_2").hide();
        $("#div_upload_foto_3").show();
        $("#div_upload_foto_4").hide();
        $("#div_upload_foto_5").hide();
        $("#div_upload_foto_6").hide();
    });
    $("#upload_foto_4").click(function () {
        $("#div_upload_foto_1").hide();
        $("#div_upload_foto_2").hide();
        $("#div_upload_foto_3").hide();
        $("#div_upload_foto_4").show();
        $("#div_upload_foto_5").hide();
        $("#div_upload_foto_6").hide();
    });
    $("#upload_foto_5").click(function () {
        $("#div_upload_foto_1").hide();
        $("#div_upload_foto_2").hide();
        $("#div_upload_foto_3").hide();
        $("#div_upload_foto_4").hide();
        $("#div_upload_foto_5").show();
        $("#div_upload_foto_6").hide();
    });
    $("#upload_foto_6").click(function () {
        $("#div_upload_foto_1").hide();
        $("#div_upload_foto_2").hide();
        $("#div_upload_foto_3").hide();
        $("#div_upload_foto_4").hide();
        $("#div_upload_foto_5").hide();
        $("#div_upload_foto_6").show();
    });

    // validace formularu
    $("#novy_clanek,#nova_polozka_menu,#nova_fotogalerie,#nove_dokumenty,#prihlaseni, #novyUzivatel, #new_event").validationEngine();

    // datapicker
    $.datepicker.regional['cs'] = {
        closeText: 'Zavřít',
        prevText: '&#x3c;Dříve',
        nextText: 'Později&#x3e;',
        currentText: 'Nyní',
        monthNames: ['leden', 'únor', 'březen', 'duben', 'květen', 'červen',
            'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec'],
        monthNamesShort: ['led', 'úno', 'bře', 'dub', 'kvě', 'čer',
            'čvc', 'srp', 'zář', 'říj', 'lis', 'pro'],
        dayNames: ['neděle', 'pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota'],
        dayNamesShort: ['ne', 'po', 'út', 'st', 'čt', 'pá', 'so'],
        dayNamesMin: ['ne', 'po', 'út', 'st', 'čt', 'pá', 'so'],
        weekHeader: 'Týd',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['cs']);
    $("#datepicker1").datepicker({
        //		dateFormat: 'yy-mm-dd'
    });
    $("#datepicker2").datepicker({});
    $("#datepicker3").datepicker({});

    $("#datepicker4").datepicker({});	// log prihlaseni uzivatelu
    $("#datepicker5").datepicker({});	// log prihlaseni uzivatelu


    // zobrazime dalsi moznosti
//	$(".dalsi_moznosti_box").slideToggle("fast");
//	$(".video_box").removeClass("none");
//	$(".video_box").addClass("show");
//	$(".dalsi_moznosti_title span.ui-icon").toggleClass("ui-icon-circle-minus");


    // vyjizdeci box DALSI MOZNOSTI
    $(".dalsi_moznosti_title").click(function () {
        $(".dalsi_moznosti_box").slideToggle("fast");
        if ($(".video_box").hasClass("show")) {
            $(".video_box").removeClass("show");
            $(".video_box").addClass("none");
        } else {
            $(".video_box").removeClass("none");
            $(".video_box").addClass("show");
        }
        $(".dalsi_moznosti_title span.ui-icon").toggleClass("ui-icon-circle-minus");
    });

    //vyjizdeci box v detailu objednavky
    $(".objednavka_info_zakaznik_title").click(function () {
        $(".objednavka_info_zakaznik").slideToggle("fast");
        $(".objednavka_info_zakaznik_title span.ui-icon").toggleClass("ui-icon-circle-minus");
    });
    $(".objednavka_doprava_ppl_title").click(function () {
        $(".objednavka_doprava_ppl").slideToggle("fast");
        $(".objednavka_doprava_ppl_title span.ui-icon").toggleClass("ui-icon-circle-minus");
    });
    $(".objednavka_doprava_dpd_title").click(function () {
        $(".objednavka_doprava_dpd").slideToggle("fast");
        $(".objednavka_doprava_dpd_title span.ui-icon").toggleClass("ui-icon-circle-minus");
    });
    $(".objednavka_doprava_posta_title").click(function () {
        $(".objednavka_doprava_posta").slideToggle("fast");
        $(".objednavka_doprava_posta_title span.ui-icon").toggleClass("ui-icon-circle-minus");
    });
    $(".objednavka_doprava_zasilkovna_title").click(function () {
        $(".objednavka_doprava_zasilkovna").slideToggle("fast");
        $(".objednavka_doprava_zasilkovna_title span.ui-icon").toggleClass("ui-icon-circle-minus");
    });
    $(".objednavka_nasledne_upravy_title").click(function () {
        $(".objednavka_nasledne_upravy").slideToggle("fast");
        $(".objednavka_nasledne_upravy_title span.ui-icon").toggleClass("ui-icon-circle-minus");
    });
    // tooltip
    $("[title]").not('.notooltip').tooltip({
        effect: 'fade'
    }).dynamic({
        bottom: {
            direction: 'down',
            bounce: true
        }
    });


    $(document).on("click", ".contentCategoryDelete",
            function (event) {
                event.preventDefault();	// kvuli accordion
                $clicked = $(this);
                var id = $clicked.attr("rel");
                var nazev = $clicked.attr("alt");
                $("#dialog-confirm").text('Opravdu smazat článek ' + nazev + ' ?');
                $("#dialog-confirm").dialog({
                    resizable: false,
                    height: 200,
                    modal: true,
                    buttons: {
                        'Ano': function () {
                            $(this).dialog('close');
                            var jeRodic = false;

                            $.ajax({
                                url: "/res/ajax.php?mode=fetchSub",
                                type: "POST",
                                dataType: "json",
                                data: {id_item: id, countOnly: "1"},
                                success: function (data) {
                                    //	console.log(data);
                                    if (data.pocet > 0) {
                                        // ma potomky, nebudeme mazat
                                        $("#error-message").html("Kategorie není prázdná!<br />Není možné ji smazat.");
                                        $("#error-message").dialog({
                                            autoOpen: true,
                                            height: 190,
                                            modal: true,
                                            buttons: {
                                                Ok: function () {
                                                    $(this).dialog('close');
                                                }
                                            }
                                        });
                                        $("#error-message").dialog('open');
                                    } else {
                                        //	nema potomky, muzeme smazat
                                        $.post("/res/ajax.php?mode=contentCategoryDelete", {
                                            idContentCategory: id
                                        },
                                                function (data) {
                                                    $("#success-message").html(data.value);
                                                    if (data.type == 'success') {
                                                        $("#success-message").dialog({
                                                            autoOpen: true,
                                                            height: 190,
                                                            modal: true,
                                                            buttons: {
                                                                Ok: function () {
                                                                    $(this).dialog('close');
                                                                    $clicked.parent().parent().hide("slow");
                                                                    //													window.location.reload();
                                                                    //window.location = "/admin/seznam_clanku";
                                                                }
                                                            }
                                                        });
                                                        $("#nabidka_" + id).remove();
                                                        $("#poptavka_" + id).remove();
                                                        $("#success-message").dialog('open');
                                                    }
                                                    if (data.type == 'error') {
                                                        $("#error-message").html(data.value);
                                                        $("#error-message").dialog({
                                                            autoOpen: true,
                                                            height: 190,
                                                            modal: true,
                                                            buttons: {
                                                                Ok: function () {
                                                                    $(this).dialog('close');
                                                                }
                                                            }
                                                        });
                                                        $("#error-message").dialog('open');
                                                    }
                                                }, "json");

                                    }


                                }
                            });

                        },
                        'Ne': function () {
                            $(this).dialog('close');
                        }
                    }
                });

                return false;	// kvuli accordion
            });

    $(".galleryPositionChanger").each(
            function () {
                $(this).change(
                        function () {
                            loading('show');
                            $.getJSON("/res/ajax.php?mode=changeGalleryPosition", {
                                idGallery: $(this).attr("rel"),
                                position: $(this).val()
                            }, function (data) {
                                if (data.type == 'success') {
                                    successMessage('Pozice upravena', false);
                                } else {
                                    errorMessage('Došlo k chybe pči změně pozice.')
                                }
                                loading('hide');
                            });
                        });
            });

    $(".gallery_priority").each(
            function () {
                $(this).change(
                        function () {
                            loading('show');
                            $.getJSON("/res/ajax.php?mode=changeGalleryPriority", {
                                idMap: $(this).attr("rel"),
                                priority: $(this).val()
                            }, function (data) {
                                if (data.type == 'success') {
                                    successMessage('Priorita upravena', false);
                                } else {
                                    errorMessage('Došlo k chybe pči změně priority.')
                                }
                                loading('hide');
                            });
                        });
            });

    $(document).on("click", ".sipka_dolu", function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        var parent = $(this).attr("data-parent");
        sortContentCategory(id, parent, 'down');
        return 0;
    });
    $(document).on("click", ".sipka_nahoru", function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        var parent = $(this).attr("data-parent");
        sortContentCategory(id, parent, 'up');
        return 0;
    });

    $(document).on("click", ".pridat_clanek a", function (e) {
        e.preventDefault();
        window.location = $(this).attr("href");
    });
    $(document).on("click", ".nazev a", function (e) {
        e.preventDefault();
        window.location = $(this).attr("href");
    });

});


$(function () {
    $(".sortable").sortable({
        placeholder: "ui-state-highlight"
    });
    $(".sortable").disableSelection();
});

function loading(type) {
    if (type == 'show') {
        $('#ajaxLoader').show('slow');
    }
    if (type == 'hide') {
        $('#ajaxLoader').hide('slow');
    }
}
;

function setContentVisibility(ele, idContentCategory) {
    loading('show');
    $.getJSON("/res/ajax.php?mode=setContentCategoryVisibility", {
        idContentCategory: idContentCategory,
//		visible: $(ele).is(':checked')
        state: $(ele).parent().hasClass("checked") ? false : true
    }, function (j) {
        loading('hide');
    });
    $this_cache = $(ele);
    if ($this_cache.parent().hasClass("checked")) {
        $this_cache.parent().removeClass("checked");
        $(ele).removeAttr('checked');
    } else {
        $this_cache.parent().addClass("checked");
        $(ele).attr('checked', 'checked');
    }
}
;

function setContentCategoryHP(ele, idContentCategory) {
    loading('show');
    $.getJSON("/res/ajax.php?mode=setContentCategoryHP", {
        idContentCategory: idContentCategory,
//		visible: $(ele).is(':checked')
        state: $(ele).parent().hasClass("checked") ? false : true
    }, function (j) {
        successBox('Položka upravena');
        loading('hide');
    });
    $this_cache = $(ele);
    if ($this_cache.parent().hasClass("checked")) {
        $this_cache.parent().removeClass("checked");
        $(ele).removeAttr('checked');
    } else {
        $this_cache.parent().addClass("checked");
        $(ele).attr('checked', 'checked');
    }
}
;

function setContentCategoryZajimavosti(ele, idContentCategory) {
    loading('show');
    $.getJSON("/res/ajax.php?mode=setContentCategoryZajimavosti", {
        idContentCategory: idContentCategory,
//		state: $(ele).is(':checked')
        state: $(ele).parent().hasClass("checked") ? false : true
    }, function (j) {
        successBox('Položka upravena');
        loading('hide');
    });
    $this_cache = $(ele);
    if ($this_cache.parent().hasClass("checked")) {
        $this_cache.parent().removeClass("checked");
        $(ele).removeAttr('checked');
    } else {
        $this_cache.parent().addClass("checked");
        $(ele).attr('checked', 'checked');
    }
}
;

function setContentCategoryAktuality(ele, idContentCategory) {
    loading('show');
    $.getJSON("/res/ajax.php?mode=setContentCategoryAktuality", {
        idContentCategory: idContentCategory,
//		state: $(ele).is(':checked')
        state: $(ele).parent().hasClass("checked") ? false : true
    }, function (j) {
        successBox('Položka upravena');
        loading('hide');
    });
    $this_cache = $(ele);
    if ($this_cache.parent().hasClass("checked")) {
        $this_cache.parent().removeClass("checked");
        $(ele).removeAttr('checked');
    } else {
        $this_cache.parent().addClass("checked");
        $(ele).attr('checked', 'checked');
    }
}
;

function sortContentCategory(idContentCategory, idParent, direction) {
    //	console.log(idContentCategory, direction);
    loading('show');
    $.getJSON("/res/ajax.php?mode=sortContentCategory", {
        idContentCategory: idContentCategory,
        direction: direction
    }, function (data) {
        //	console.log(data);
        if (data.type == 'success') {
            if (direction == 'up') {
                $("#accordion_item_" + data.swap[1]).fadeOut(500).insertAfter("#accordion_item_" + data.swap[0]).fadeIn(500);
                successBox('Položka přesunuta.', true);
            } else {
                $("#accordion_item_" + data.swap[0]).fadeOut(500).insertAfter("#accordion_item_" + data.swap[1]).fadeIn(500);
                successBox('Položka přesunuta.', true);
            }
        } else {
            errorBox('Tato položka nelze přesunout.');
        }
    });
    loading('hide');
}
;

function setGalleryVisibility(ele, idGallery) {
    loading('show');
    $.getJSON("/res/ajax.php?mode=setGalleryVisibility", {
        idGallery: idGallery,
        visible: $(ele).is(':checked')
    }, function (j) {
        loading('hide');
    });
}
;


function sortGalleryImage(idGalleryImage, idGallery, direction) {
    loading('show');
    $.getJSON("/res/ajax.php?mode=sortGalleryImage", {
        idGalleryImage: idGalleryImage,
        idGallery: idGallery,
        direction: direction
    }, function (data) {
        if (data.type == 'success') {
            if (direction == 'up') {
                $("#galleryImage_" + data.swap[1]).fadeOut(400).insertAfter("#galleryImage_" + data.swap[0]).fadeIn(2000);
            } else {
                $("#galleryImage_" + data.swap[1]).fadeOut(400).insertBefore("#galleryImage_" + data.swap[0]).fadeIn(2000);
                successBox('Položka přesunuta.', true);
            }
        } else {
            errorBox('Tato položka nelze přesunout.');
        }
        loading('hide');
        return false;
    });
    return false;

}
;

function errorMessage(message) {
    $("#error-message").html(message);
    $("#error-message").dialog({
        modal: true,
        minWidth: 300,
        minHeight: 185,
        resizable: false,
        buttons: {
            Ok: function () {
                $(this).dialog("close");
            }
        }
    })
}
;

function successMessage(message) {
    $("#success-message").html(message);
    $("#success-message").dialog({
        modal: true,
        minWidth: 300,
        minHeight: 185,
        resizable: false,
        buttons: {
            Ok: function () {
                $(this).dialog("close");
            }
        }
    })
}
;

function errorBox(message, persistent) {
    $("#errorBox_text").html(message);
    if (persistent) {	// zustava dokud nekdo rucne nezavre
        $("#errorBox").show();
    } else {
        $("#errorBox").show();
//		$("#errorBox").show().delay(5000).fadeOut(400);
    }
}
;

function successBox(message, persistent) {
    $("#successBox_text").html(message);
    if (persistent) {	// zustava dokud nekdo rucne nezavre
        $("#successBox").show();
    } else {
        $("#successBox").show();
//		$("#successBox").show().delay(5000).fadeOut(400);
    }
}
;

function changeGalleryPosition(idGallery) {
    alert(idGallery);
    alert($(this).val());
}

function deleteContentCategoryVideo(idContentCategory, index) {
    $.getJSON("/res/ajax.php?mode=contentCategoryVideoDelete", {
        idContentCategory: idContentCategory,
        index: index
    }, function (data) {
        if (data.type == 'success') {
            successMessage(data.value);
            $('#contentCategoryVideo_' + index).remove();
            $('#contentCategoryVideoDelete_' + index).remove();	// tlacitko
        } else {
            errorMessage(data.value)
        }
        loading('hide');
    });

    return false;
}

function anotacniObrazekDelete(idContentCategory, imageIndex) {
    $("#dialog-confirm").text('Opravdu smazat anotační obrázek  ?');
    $("#dialog-confirm").dialog({
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Ano': function () {
                $(this).dialog('close');

                $.post("/res/ajax.php?mode=anotacniObrazekDelete", {
                    idContentCategory: idContentCategory,
                    imageIndex: imageIndex
                },
                        function (data) {
                            $("#success-message").html(data.value);
                            if (data.type == 'success') {
                                $("#success-message").dialog({
                                    autoOpen: true,
                                    height: 190,
                                    modal: true,
                                    buttons: {
                                        Ok: function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                                $('#anotacniObrazek_' + imageIndex).css('background-image', 'url(/images/admin/obr.png)');
                                $("#success-message").dialog('open');
                            }
                            if (data.type == 'error') {
                                $("#error-message").html(data.value);
                                $("#error-message").dialog({
                                    autoOpen: true,
                                    height: 190,
                                    modal: true,
                                    buttons: {
                                        Ok: function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                                $("#error-message").dialog('open');
                            }
                        }, "json");
            },
            'Ne': function () {
                $(this).dialog('close');
            }
        }
    });
}

function anotacniObrazekDelete(idContentCategory, imageIndex) {
    $("#dialog-confirm").text('Opravdu smazat anotační obrázek  ?');
    $("#dialog-confirm").dialog({
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Ano': function () {
                $(this).dialog('close');

                $.post("/res/ajax.php?mode=anotacniObrazekDelete", {
                    idContentCategory: idContentCategory,
                    imageIndex: imageIndex
                },
                        function (data) {
                            $("#success-message").html(data.value);
                            if (data.type == 'success') {
                                $("#success-message").dialog({
                                    autoOpen: true,
                                    height: 190,
                                    modal: true,
                                    buttons: {
                                        Ok: function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                                $('#anotacniObrazek_' + imageIndex).css('background-image', 'url(/images/admin/obr.png)');
                                $("#success-message").dialog('open');
                            }
                            if (data.type == 'error') {
                                $("#error-message").html(data.value);
                                $("#error-message").dialog({
                                    autoOpen: true,
                                    height: 190,
                                    modal: true,
                                    buttons: {
                                        Ok: function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                                $("#error-message").dialog('open');
                            }
                        }, "json");
            },
            'Ne': function () {
                $(this).dialog('close');
            }
        }
    });
}


function kategorieObrazekDelete(idCategory, fileIndex) {
    $("#dialog-confirm").text('Opravdu smazat soubor  ?');
    $("#dialog-confirm").dialog({
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Ano': function () {
                $(this).dialog('close');

                $.post("/res/ajax.php?mode=kategorieObrazekDelete", {
                    idCategory: idCategory,
                    fileIndex: fileIndex
                },
                        function (data) {
                            $("#success-message").html(data.value);
                            if (data.type == 'success') {
                                $("#success-message").dialog({
                                    autoOpen: true,
                                    height: 190,
                                    modal: true,
                                    buttons: {
                                        Ok: function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                                $('#anotacniObrazek_' + fileIndex).css('background-image', 'url(/images/admin/obr.png)');
                                $("#success-message").dialog('open');
                            }
                            if (data.type == 'error') {
                                $("#error-message").html(data.value);
                                $("#error-message").dialog({
                                    autoOpen: true,
                                    height: 190,
                                    modal: true,
                                    buttons: {
                                        Ok: function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                                $("#error-message").dialog('open');
                            }
                        }, "json");
            },
            'Ne': function () {
                $(this).dialog('close');
            }
        }
    });

}

function anotacniSouborDelete(idContentCategory, fileIndex) {
    $("#dialog-confirm").text('Opravdu smazat soubor  ?');
    $("#dialog-confirm").dialog({
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Ano': function () {
                $(this).dialog('close');

                $.post("/res/ajax.php?mode=anotacniSouborDelete", {
                    idContentCategory: idContentCategory,
                    fileIndex: fileIndex
                },
                        function (data) {
                            $("#success-message").html(data.value);
                            if (data.type == 'success') {
                                $("#success-message").dialog({
                                    autoOpen: true,
                                    height: 190,
                                    modal: true,
                                    buttons: {
                                        Ok: function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                                $('#anotacniSoubor_' + fileIndex).css('background-image', 'url(/images/admin/obr.png)');
                                $("#success-message").dialog('open');
                            }
                            if (data.type == 'error') {
                                $("#error-message").html(data.value);
                                $("#error-message").dialog({
                                    autoOpen: true,
                                    height: 190,
                                    modal: true,
                                    buttons: {
                                        Ok: function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                                $("#error-message").dialog('open');
                            }
                        }, "json");
            },
            'Ne': function () {
                $(this).dialog('close');
            }
        }
    });

}

function calendarObrazekDelete(idCalendar) {
    $("#dialog-confirm").text('Opravdu smazat obrázek  ?');
    $("#dialog-confirm").dialog({
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Ano': function () {
                $(this).dialog('close');

                $.post("/res/ajax.php?mode=calendarObrazekDelete", {
                    idCalendar: idCalendar
                },
                        function (data) {
                            $("#success-message").html(data.value);
                            if (data.type == 'success') {
                                $("#success-message").dialog({
                                    autoOpen: true,
                                    height: 190,
                                    modal: true,
                                    buttons: {
                                        Ok: function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                                $('#calendarObrazek').css('background-image', 'url(/images/admin/obr.png)');
                                $("#success-message").dialog('open');
                            }
                            if (data.type == 'error') {
                                $("#error-message").html(data.value);
                                $("#error-message").dialog({
                                    autoOpen: true,
                                    height: 190,
                                    modal: true,
                                    buttons: {
                                        Ok: function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                                $("#error-message").dialog('open');
                            }
                        }, "json");
            },
            'Ne': function () {
                $(this).dialog('close');
            }
        }
    });
}


/* js tree */

function is_stupid() {
    var ie = false;
    if (navigator.appName == "Microsoft Internet Explorer")
        ie = true;

    return ie;
}

function element_open(element) {
    if (is_stupid()) {
        element.parentNode.parentNode.childNodes[3].style.display = 'block';
        element.parentNode.parentNode.childNodes[0].childNodes[0].style.backgroundPosition = '-9px 0px';
    } else {
        element.parentNode.parentNode.childNodes.item(5).style.display = 'block';
        element.parentNode.parentNode.childNodes.item(1).childNodes.item(1).style.backgroundPosition = '-9px 0px';
    }
}
function element_close(element) {
    if (is_stupid()) {
        element.parentNode.parentNode.childNodes[3].style.display = 'none';
        element.parentNode.childNodes[0].style.backgroundPosition = '0px 0px';
    } else {
        element.parentNode.parentNode.childNodes.item(5).style.display = 'none';
        element.parentNode.childNodes.item(1).style.backgroundPosition = '0px 0px';
    }
}

function open_tree(element) {
    if (is_stupid()) {
        if (element.parentNode.parentNode.parentNode.childNodes[0].parentNode.parentNode.childNodes[3] != null && element.parentNode.parentNode.parentNode.childNodes[0].parentNode.parentNode.childNodes[0].childNodes[0].style != null) {
            var working_element = element.parentNode.parentNode.parentNode.childNodes[0];
            if (working_element.id != null) {
                element_open(working_element);
                open_tree(working_element);
            }
        }
    } else {
        if (element.parentNode.parentNode.parentNode.childNodes.item(1).parentNode.parentNode.childNodes.item(5) != null && element.parentNode.parentNode.parentNode.childNodes.item(1).parentNode.parentNode.childNodes.item(1).childNodes.item(1) != null) {
            var working_element = element.parentNode.parentNode.parentNode.childNodes.item(1);
            if (working_element.id != null && working_element.name != "root_elem") {
                element_open(working_element);
                open_tree(working_element);
            }
        }
    }
}

function element_change(element) {
    if (is_stupid()) {
        if (element.parentNode.parentNode.childNodes[3].style.display == null || element.parentNode.parentNode.childNodes[3].style.display == 'block') {
            element_close(element);
        } else {
            element_open(element);
        }
    } else {
        if (element.parentNode.parentNode.childNodes.item(5).style.display == 'block') {
            element_close(element);
        } else {
            element_open(element);
        }
    }
}
/* js tree konec */