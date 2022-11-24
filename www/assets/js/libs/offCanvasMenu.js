(function ($) {
    $.fn.offCanvasMenu = function (options) {
        // default settings >>
        var settings = $.extend({
            menuPosition: 'right',
            openMenu: '.offCanvasMenuOpen',
            closeMenu: '.offCanvasMenuHeader .closeButton',
            footerContent: ''
        }, options);
        // << default settings

        // menu variables >>
        var menuParent = $('<div class="offCanvasMenu">');
        var menuOverlay = $('<div class="offCanvasMenu-overlay">');
        var menuHeader = $('<div class="offCanvasMenuHeader"><div class="subPageText"></div><div class="closeButton"><span class="closeButton-in"></span></div><div class="subcloseButton"><span class="subcloseButton-in"></span></div></div>');
        var menuFooter = $('<div class="offCanvasMenuFooter">' + settings.footerContent + '</div>');
        var menuContent = $('<div class="menuContent">');
        var menuContentIn = $('<div class="menuContent-in">');
        // << menu variables

        // add side >>
        if (settings.menuPosition == 'right') {
            menuParent.addClass('offCanvasMenu-right');
        } else {
            menuParent.addClass('offCanvasMenu-left');
        }
        // << add side

        // load menu >>
        // clone menu>>
        var menuItems = this.find('>ul').clone();

        // chotes speciality >>
        menuItems.find('img').remove();
        menuItems.find('svg').remove();
        menuItems.find('ul').each(function () {
            if ($(this).parent().is("div")) {
                $(this).unwrap();
            }
        });
        menuItems.find('li').each(function () {
            var ul = $('<ul>');
            if ($(this).hasClass('has-submenu-2')) {
                $('.submenu-2').find('li').each(function () {
                    ul.append($(this).clone());
                });
                $(this).append(ul);
            } else {
                if ($(this).find('ul').length) {
                    $(this).find('li').each(function () {
                        ul.append($(this));
                    });
                    $(this).find('ul').remove();
                    $(this).append(ul);
                }
            }
        });

        menuItems.find('div').each(function () {
            if ($(this).parent().is("div")) {
                $(this).unwrap();
            }
        });
        // << chotes speciality

        // clear classes >>
        menuItems.removeAttr('class').find('*:not(.active)').removeAttr('class');
        menuItems.find('.has-submenu').removeClass('has-submenu').removeClass('nav-item');
        // clear br
        menuItems.find('br').remove();
        // add subitems anchors
        menuItems.find('ul').each(function () {
            $(this).parent('li').find('> a').prepend($('<span class="offCanvasMenu-subItem">'));
            $(this).parent('li').find('a').prepend($('<span class="offCanvasMenu-sub-subItem">'));
        });
        // << load menu
        // append menu >>

        menuParent.append(menuHeader);
        menuParent.append(menuContent.append(menuContentIn.append(menuItems)));
        menuParent.append(menuFooter);

        $('body').append(menuParent);
        $('body').append(menuOverlay);

        // events >>
        $(settings.openMenu).on('click', function () {
            $('body').addClass('offCanvasMenu-open');
            return false;
        });

        $(settings.closeMenu).on('click', function () {
            $('body').removeClass('offCanvasMenu-open');
            $('.subcloseButton').removeClass('active');
            $('.offCanvasMenuHeader .pageLogo').show();
            $('.offCanvasMenuHeader .subPageText').hide();
            menuParent.find('ul').removeClass('offCanvasMenu-active').removeClass('offCanvasMenu-active');
            return false;
        });

        menuOverlay.on('click', function () {
            $('body').removeClass('offCanvasMenu-open');
            $('.subcloseButton').removeClass('active');
            $('.offCanvasMenuHeader .pageLogo').show();
            $('.offCanvasMenuHeader .subPageText').hide();
            menuParent.find('ul').removeClass('offCanvasMenu-active').removeClass('offCanvasMenu-active');
            return false;
        });

        $('.offCanvasMenu-subItem').on('click', function () {
            $(this).closest('li').find('> ul').addClass('offCanvasMenu-active');
            var title = $(this).closest('li').find('> a').text();
            $('.offCanvasMenuHeader .pageLogo').hide();
            $('.offCanvasMenuHeader .subPageText').text(title).show();
            $('.subcloseButton').addClass('active');
            return false;
        });

        $('.subcloseButton').on('click', function () {
            menuParent.find('ul').removeClass('offCanvasMenu-active');
            $('.subcloseButton').removeClass('active');
            $('.offCanvasMenuHeader .pageLogo').show();
            $('.offCanvasMenuHeader .subPageText').hide();
            return false;
        });
        $('.subPageText').on('click', function () {
            menuParent.find('ul').removeClass('offCanvasMenu-active');
            $('.subcloseButton').removeClass('active');
            $('.offCanvasMenuHeader .pageLogo').show();
            $('.offCanvasMenuHeader .subPageText').hide();
            return false;
        });

        $('.offCanvasMenuHeader .pageLogo').on('click', function () {
            window.location.href = $('.logo-link').attr('href');
        });
        // << events

    }
}(jQuery));