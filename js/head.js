$(function () {
    $.scrolltop();
    setInterval("changeBackground()", 10000);
//    changeBackground();
});

var imageIndex = 0;
var imagesArray = new Array();

//Set Images
imagesArray[0] = "/images/bg/gray/80/Praha_1.jpg";
imagesArray[1] = "/images/bg/gray/80/Praha_2.jpg";
imagesArray[2] = "/images/bg/gray/80/Praha_3.jpg";
imagesArray[3] = "/images/bg/gray/80/Praha_4.jpg";
imagesArray[4] = "/images/bg/gray/80/Praha_6.jpg";


function changeBackground() {
    $("#bg_cycle").css("background-image", "url('" + imagesArray[imageIndex] + "')");
    imageIndex++;
    if (imageIndex >= imagesArray.length) {
        imageIndex = 0;
    }
}

//$(document).ready(function () {
//    $("#XXimage-holder").backgroundCycle({
//        imageUrls: [
//            '/images/bg/Praha_1.jpg',
//            '/images/bg/Praha_2.jpg',
//            '/images/bg/Praha_3.jpg',
//            '/images/bg/Praha_4.jpg',
//            '/images/bg/Praha_5.jpg',
//            '/images/bg/Praha_6.jpg'
//
//        ],
//        fadeSpeed: 1500,
//        duration: 5000,
//        backgroundSize: SCALING_MODE_COVER
////        backgroundSize: SCALING_MODE_CONTAIN
////        backgroundSize: SCALING_MODE_STRETCH
////		backgroundSize: SCALING_MODE_NONE
//    });
//    cycleToNextImage();
//});

(function (w2b) {
    w2b(document).ready(function () {
        var $dur = 'medium'; // Duration of Animation
        w2b('#fbplikebox').css({right: -250, 'top': 100})
        w2b('#fbplikebox').hover(function () {
            w2b(this).stop().animate({
                right: 0
            }, $dur);
        }, function () {
            w2b(this).stop().animate({
                right: -250
            }, $dur);
        });
        w2b('#fbplikebox').show();
    });
})(jQuery);



var waiting;

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0)
            return c.substring(nameEQ.length, c.length);
    }
    return null;
}



$(document).ready(function () {

    $(".item_seznam").each(function () {
        var attr = $(this).attr('data-image-src');
        if (typeof attr !== typeof undefined && attr !== false) {
            $(this).css('background', 'url(' + attr + ')');
        }

    });


    $('[data-onload-select2]').each(function () {
        $(this).select2();
    });


});


(function ($) {
    $(document).ready(function () {
        $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).parent().siblings().removeClass('open');
            $(this).parent().toggleClass('open');
        });
    });
})(jQuery);

function change_captcha() {
    document.getElementById('captcha').src = "/plugins/captcha_stylish_99/get_captcha.php?rnd=" + Math.random();
}

$(document).ready(function () {


    if (document.getElementById("sroolHere")) {
        $('html, body').animate({
            scrollTop: $("#sroolHere").offset().top
        }, 2000);
    }


    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $('body').tooltip();


//	$(".content_clanek_text table").addClass("table table-responsive table-striped table-hover table-bordered table-condensed");
    $(".content_clanek_text table").addClass("Xtable Xtable-responsive table-striped table-hover table-bordered table-condensed");
//	$(".content_clanek_text table").css("width", "auto");

//	smoothScroll.init();

    $('.swipebox').swipebox({
//		useCSS : true, // false will force the use of jQuery for animations
        useSVG: true, // false to force the use of png for buttons
//		initialIndexOnArray : 0, // which image index to init when a array is passed
        hideCloseButtonOnMobile: false, // true will hide the close button on mobile devices
        hideBarsDelay: 0, // delay before hiding bars on desktop
//		videoMaxWidth : 1140, // videos max width
//		beforeOpen: function() {}, // called before opening
//		afterOpen: null, // called after opening
//		afterClose: function() {}, // called after closing
        loopAtEnd: true // true will return to the first image after the last image is reached
    });


});

function checkdate(field, rules, i, options) {
    var datum = new Date();
    var rok = datum.getFullYear();
    if (field.val() != rok) {
        return options.allrules.spatnyrok.alertText;
    }
}

function login_dialog(status) {
    if (status == "ok") {
        $(document).ready(function () {
            $("#login_ok").dialog({
                modal: true,
                minWidth: 300,
                minHeight: 115,
                resizable: false
            });
        });
    } else {
        $(document).ready(function () {
            $("#login_nok").dialog({
                modal: true,
                minWidth: 300,
                minHeight: 115,
                resizable: false
            });
        });
    }
}


jQuery.extend({
    numberFormat: function ($number, $decimals, $dec_point, $thousands_sep, $roundType) {
        if ($dec_point == undefined || $dec_point == null) {
            $dec_point = '.';
        }
        if ($thousands_sep == undefined || $thousands_sep == null) {
            $thousands_sep = ' ';
        }
        if ($roundType == undefined || $roundType == null) {
            $roundType = 'round';
        }
        if ($decimals != undefined && $decimals != null) {
            if (typeof $number == 'string') {
                $number = parseFloat($number);
            }
            var $pow = Math.pow(10, $decimals);
            $number *= $pow;

            if ($roundType == 'round') {
                $number = Math.round($number);
            } else if ($roundType == 'ceil') {
                $number = Math.ceil($number);
            } else if ($roundType == 'floor') {
                $number = Math.floor($number);
            }
            $number /= $pow;
        }

        $number += '';
        var $x = $number.split('.');
        $number = $x[0];
        var $dec = $x[1];

        if ($thousands_sep != '') {
            var $i = 0;
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test($number)) {
                $number = $number.replace(rgx, '$1' + $thousands_sep + '$2');
                if ($i++ > 5) {
                    break;
                }
            }
        }
        if ($dec != undefined) {
            $dec += '';
            for (var $i = 0; $i < $decimals - $dec.length; $i++) {
                $dec += '0';
            }
            $number = $number + $dec_point + $dec;
        }
        return $number;
    }
});

$(document).ready(function () {

// 	$('.video').click(function(){this.paused?this.play():this.pause();});

    $(".content_clanek_text img").addClass("img-responsive");

    $("#fadeButton").click(function (event) {
        event.preventDefault();
        $("#hp_text_full").fadeToggle("slow", function () {
//			$("#log").append("<div>finished</div>");
        });
    });

//	Shadowbox.init({});

//	$("#registraceForm").validationEngine({scroll: false});
//	$("#registraceForm").validationEngine('attach', {onSuccess : test()});

//	function test() {
//		alert("test");
//	}





    $(".content_text_content img").each(function () {
        if (!$(this).closest('a').attr('href')) {
            var src = $(this).attr('src');
            var a = $('<a/>').attr('href', src).attr('class', 'swipebox').addClass('shadow');
            $(this).wrap(a);
            $(this).addClass("content_img");
//			$(".content_text2 a.shadow").shadowbox();
        }
    });


});


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