<?php

class SContent {
    static $_i = 0;
    static protected $_jsFiles = array();
    static protected $_jsScripts = array();
    static protected $_jsScriptsOnLoad = array();
    static protected $_jsScriptsDynamic = array();
    static protected $_cssFiles = array();
    static protected $_dialogs = array();
    static protected $_initialized = array();

    static protected $SERVER_URL = "/";

    static protected $globalSheets = array(
//    	"default.css",
//    	"red.css",
//    	"custom.css",
//    	"buttons.css",
    	"rs.css",
//    	"formulare.css",
    );

    static protected $globalScripts = array(
//    	"jquery.cookie.js",
//    	"jquery.ui.datepicker-cs.js",
//    	"jquery.qtip-1.0.0-rc3.min.js",
//		"jquery.timers-1.1.2.js",
//		"jquery.price_format.1.3.js",
//    	"rk_nabidky.js",
//    	"rk_nabidky_detail.js",
//    	"other_functions.js",
    );

    /**
     * zakaz vytvareni instanci
     *
     */
    private function __construct() {
    }


    private static function Sheet($name) {
    	return self::$SERVER_URL . "static/sheet/" . $name;
    }

	private static function Script($name) {
    	return self::$SERVER_URL . "static/script/" . $name;
    }

    /**
     *
     * @param string $name
     */
    static private function _initPackage($name = '')
    {
        self::$_initialized[$name] = self::$_i++;
    }

    /**
     * Vrati true pokud uz byl soubor skriptu inicializovan
     *
     * @param string $nazev
     * @return bool
     */
    static private function _isPackageInit($name)
    {
        if(isset(self::$_initialized[$name])){
            return true;
        }
        return false;
    }

    /**
     * Prida js soubor
     *
     * @param int $index
     * @param string $path
     */
    static private function _addJsFile($index, $path)
    {
        self::$_jsFiles[$index] = $path;
    }

    /**
     * Prida js skript
     *
     * @param int $index
     * @param string $path
     */
    static private function _addJsScript($index, $path)
    {
        self::$_jsScripts[$index] = $path;
    }

    /**
     * Prida js skript po spusteni
     *
     * @param int $index
     * @param string $path
     */
    static private function _addJsScriptOnLoad($index, $path)
    {
        self::$_jsScriptsOnLoad[$index] = $path;
    }

    /**
     * Prida js skript po spusteni
     *
     * @param int $index
     * @param string $path
     */
    static private function _addDynamicJsScript($index, $path)
    {
        self::$_jsScriptsDynamic[$index] = $path;
    }

    /**
     * Prida css soubor
     *
     * @param int $index
     * @param string $path
     */
    static private function _addCssFile($index, $path) {
        self::$_cssFiles[$index] = $path;
    }

	/**
     * Prida dialog
     *
     * @param string $dialog
     */
    static private function _addDialog($dialog) {
        self::$_dialogs[] = $dialog;
    }

    static public function flushJs(){
        ksort(self::$_jsFiles);
        ksort(self::$_jsScripts);
        ksort(self::$_jsScriptsOnLoad);
        ksort(self::$_jsScriptsDynamic);

        $return = "";
        foreach (self::$_jsFiles as $path) {
            $return .= '<script type="text/javascript" src="' . self::Script($path) . '"></script>' . "\n        ";
        }

        foreach (self::$globalScripts as $path) {
            $return .= '<script type="text/javascript" src="' . self::Script($path) . '"></script>' . "\n        ";
		}

        if(count(self::$_jsScripts) || count(self::$_jsScriptsOnLoad) || count(self::$_jsScriptsDynamic)){
            $return .= '<script type="text/javascript">' . "\n        " . '/* <![CDATA[ */' . "\n        ";

            if(count(self::$_jsScripts)){
                foreach (self::$_jsScripts as $script) {
                    $return .= $script . "\n        ";
                }
            }



            if(count(self::$_jsScriptsOnLoad)){
                $return .= "jQuery(document).ready(function () { \n        ";
                foreach (self::$_jsScriptsOnLoad as $script) {
                    $return .= $script . "\n        ";
                }
                $return .= "});\n        ";
            }

            if(count(self::$_jsScriptsDynamic)){
                $return .= "jQuery(document).ready(function () { \n        ";
                $return .= "        dynamicScripts(); \n        ";
                $return .= "});\n        ";

                $return .= "function dynamicScripts(target) { \n        ";
                $return .= "    if(target == undefined){ \n        ";
                $return .= "       target = jQuery(document); \n        ";
                $return .= "    } \n        ";

                foreach (self::$_jsScriptsDynamic as $script) {
                    $return .= $script . "\n        ";
                }
                $return .= "} \n        ";

            }

            $return .= "\n        " . '/* ]]> */' . "\n        " . '</script>' . "\n";
        }
        return $return . "\n";
    }

    static public function flushCss(){
        ksort(self::$_cssFiles);

        $return = "";
        foreach (self::$_cssFiles as $path) {
            $return .= '<style type="text/css"><!-- @import "' . self::Sheet($path) . '" ;--></style>' . "\n        ";
        }

        foreach (self::$globalSheets as $path) {
            $return .= '<style type="text/css"><!-- @import "' . self::Sheet($path) . '"; --></style>' . "\n        ";
		}


        return $return . "\n";
    }

	static public function flushDialogs(){
        ksort(self::$_dialogs);

        $return = "";
        foreach (self::$_dialogs as $dialog) {
            $return .= $dialog . "\n        ";
        }
        return $return . "\n";
    }

    /**
     * Inicializuje jQuery
     *
     * @return bool
     */
    static public function initjQuery()
    {
        if(self::_isPackageInit('jQuery')){
            return false;
        }
        self::_initPackage('jQuery');

        self::_addJsFile(1, "jquery.min.js");

        return true;
    }

    /**
     * Inicializuje jQueryUI
     *
     * @return bool
     */
    static public function initjQueryUI()
    {
        if(self::_isPackageInit('jQueryUI')){
            return false;
        }
        self::initjQuery();

        self::_initPackage('jQueryUI');

        self::_addJsFile(100, "jquery-ui.min.js");

        self::_addCssFile(110, "jquery-ui.css");
        self::_addCssFile(120, "ui.theme.css");
        self::_addCssFile(130, "smoothness/jquery-ui-1.7.2.custom.css");

        return true;
    }

	/**
     * Inicializuje qtip
     *
     * @return bool
     */
    static public function initjQueryQtip()
    {
        if(self::_isPackageInit('jQueryQtip')){
            return false;
        }
        self::initjQuery();

        self::_initPackage('jQueryQtip');

        self::_addJsFile(150, "jquery.qtip-1.0.0-rc3.min.js");
        return true;
    }

    /**
     * Inicializuje jquery autocomplete
     *
     * @return bool
     */
    static public function initjQueryAutocomplete()
    {
        if(self::_isPackageInit('jQueryAutocomplete')){
            return false;
        }
        self::initjQuery();

        self::_initPackage('jQueryAutocomplete');

        self::_addJsFile(800, "jquery.autocomplete.min.js");

        return true;
    }

    /**
     * Inicializuje jquery tools
     *
     * @return bool
     */
    static public function initjQueryTools()
    {
        if(self::_isPackageInit('jQueryTools')){
            return false;
        }
        self::initjQuery();

        self::_initPackage('jQueryTools');

        self::_addJsFile(50, "jquery.tools.min.js");
//        self::_addCssFile(7, "jquery/tools.css");

        return true;
    }

    /**
     * Inicializuje jquery hodnoceni
     *
     * @return bool
     */
    static public function initjQueryStars()
    {
        if(self::_isPackageInit('jQueryStars')){
            return false;
        }
        self::initjQuery();

        self::_initPackage('jQueryStars');

        self::_addJsFile(1000, "jquery.ui.stars.js");
        self::_addCssFile(1100, "jquery.ui.stars.css");

        return true;
    }

	/**
     * Inicializuje tablesorter
     *
     * @return bool
     */
    static public function initjTableSorter()
    {
        if(self::_isPackageInit('tablesorter')){
            return false;
        }
        self::initjQuery();
        self::_initPackage('tablesorter');

        self::_addJsFile(1200, "jquery.tablesorter.min.js");
        self::_addCssFile(1300, "tablesorter/style.css");

        return true;
    }


	/**
     * Inicializuje tablesorter
     *
     * @return bool
     */
    static public function initOldEngine($detail = false) {
        if(self::_isPackageInit('initOldEngine')){
            return false;
        }
        self::initjQuery();
        self::_initPackage('initOldEngine');

        self::_addJsFile(31201, "jquery.cookie.js");
        self::_addJsFile(31210, "jquery.qtip-1.0.0-rc3.min.js");
        self::_addJsFile(31215, "jquery.timers-1.1.2.js");
        self::_addJsFile(31220, "jquery.price_format.1.3.js");
        self::_addJsFile(31225, "rk_nabidky.js");
        if($detail) self::_addJsFile(31230, "rk_nabidky_detail.js");
        self::_addJsFile(31235, "other_functions.js");
        self::_addJsFile(31245, "rk_functions.js");

        self::_addJsFile(31255, "rk.js");
        self::_addJsFile(31265, "rk_klient_autocomplete.js");

        self::_addJsFile(1235, "jquery.timers-1.1.2.js");
        self::_addJsFile(1235, "jquery.price_format.1.3.js");

        self::_addCssFile(11310, "default.css");
        self::_addCssFile(11320, "red.css");
        self::_addCssFile(11330, "custom.css");
        self::_addCssFile(11340, "buttons.css");
        self::_addCssFile(11350, "rs.css");
        self::_addCssFile(11360, "formulare.css");

        return true;
    }

	/**
     * Inicializuje tablesorter
     *
     * @return bool
     */
    static public function initNewEngine() {
        if(self::_isPackageInit('initNewEngine')){ return false; }

        self::initjQuery();
        self::_initPackage('initNewEngine');

        self::_addCssFile(11310, "style_realtor.css");



        return true;
    }

	/**
     * Inicializuje MouseWheel
     *
     * @return bool
     */
    static public function initjMouseWheel() {
        if(self::_isPackageInit('jMouseWheel')){ return false; }
        self::initjQuery();

        self::_initPackage('jMouseWheel');

        self::_addJsFile(11240, "jquery.mousewheel.min.js");

        return true;
    }

	/**
     * Inicializuje CustomScrollBar
     *
     * @return bool
     */
    static public function initjCustomScrollBar() {
        if(self::_isPackageInit('jCustomScrollBar')){ return false; }
        self::initjQuery();

        self::_initPackage('jCustomScrollBar');
        self::_addJsFile(51230, "jquery.easing.1.3.js");
        self::_addJsFile(52240, "jquery.mCustomScrollbar.js");
        self::_addCssFile(51340, "jquery.mCustomScrollbar.css");

        self::_addJsScriptOnLoad(1550, '$("#mcs_container").mCustomScrollbar("vertical",100,"easeOutCirc",1.05,"fixed","yes","yes",5);');
        self::_addJsScriptOnLoad(1560, '$("#mcs2_container").mCustomScrollbar("vertical",100,"easeOutCirc",1.05,"fixed","yes","yes",5);');
        self::_addJsScriptOnLoad(1570, '$("#mcs3_container").mCustomScrollbar("vertical",100,"easeOutCirc",1.05,"fixed","yes","yes",5);');
        self::_addJsScriptOnLoad(1580, '$("#mcs4_container").mCustomScrollbar("vertical",100,"easeOutCirc",1.05,"fixed","yes","yes",2);');
        self::_addJsScriptOnLoad(1590, '$("#mcs5_container").mCustomScrollbar("vertical",100,"easeOutCirc",1.05,"fixed","yes","yes",2);');
        self::_addJsScriptOnLoad(1600, '$("#mcs6_container").mCustomScrollbar("vertical",100,"easeOutCirc",1.05,"fixed","yes","yes",2);');
        self::_addJsScriptOnLoad(1610, '$("#mcs7_container").mCustomScrollbar("vertical",100,"easeOutCirc",1.05,"fixed","yes","yes",2);');
        self::_addJsScriptOnLoad(1620, '$("#mcs8_container").mCustomScrollbar("vertical",100,"easeOutCirc",1.05,"fixed","yes","yes",2);');

        return true;
    }

	/**
     * Inicializuje Uniform
     *
     * @return bool
     */
    static public function initjUniform() {
        if(self::_isPackageInit('jUniform')){ return false; }
        self::initjQuery();

        self::_initPackage('jUniform');

        self::_addJsFile(11200, "jquery.uniform.min.js");
        self::_addCssFile(11330, "redesing_uniform.css");
        self::_addJsScriptOnLoad(510, '$("input:text, input:password, input:checkbox, input:radio, input:file, select, textarea").uniform();');

        return true;
    }

	/**
     * Inicializuje Uniform
     *
     * @return bool
     */
    static public function initjTabs() {
        if(self::_isPackageInit('jTabs')){ return false; }
        self::initjQuery();

        self::_initPackage('jTabs');

//        self::_addJsScriptOnLoad(10, '$("input:text, input:password, input:checkbox, input:radio, input:file, select, textarea").uniform();');

        return true;
    }




	/**
     * Inicializuje SuperFish
     *
     * @return bool
     */
    static public function initjSuperFish() {
        if(self::_isPackageInit('jSuperFish')){ return false; }
        self::initjQuery();

        self::_initPackage('jSuperFish');

        self::_addJsFile(21210, "superfish.js");
        self::_addJsFile(21220, "supersubs.js");
		self::_addCssFile(21320, "superfish.css");

		self::_addJsScriptOnLoad(2520, '$(".sf-menu li ul li:has(ul) a").addClass("top_menu_sipka");');
		self::_addJsScriptOnLoad(3520, '$("ul.sf-menu").supersubs({ minWidth: 6, maxWidth: 10, extraWidth: 1 }).superfish({ animation: { opacity:"show", height:"show", width:"show" }, speed: "fast", dropShadows: true, delay: 500});');


        return true;
    }


	/**
     * Inicializuje DatePicker
     *
     * @return bool
     */
    static public function initDatePicker() {
        if(self::_isPackageInit('datePicker')){ return false; }
        self::initjQuery();

        self::_initPackage('datePicker');

        self::_addJsFile(5800, "jquery.ui.datepicker-cs.js");
        self::_addJsFile(5820, "jquery-ui-timepicker-addon.js");
		self::_addJsScriptOnLoad(3950, '$.datepicker.setDefaults($.datepicker.regional["cs"]);');
		self::_addJsScriptOnLoad(3960, '$("input.datum").datepicker({ dateFormat: "dd.mm.yy", firstDay: "1", changeMonth: true, changeYear: true });');
		self::_addJsScriptOnLoad(3970, '$("input.datum").datepicker("option", "monthNames", ["Leden","Únor","Březen","Duben","Květen","Červen","Červenec","Srpen","Září","Říjen","Listopad","Prosinec"]);');
		self::_addJsScriptOnLoad(3980, '$("input.datum").datepicker("option", "dayNamesMin", ["Ne", "Po", "Út", "St", "Čt", "Pá", "So"]);');
		self::_addJsScriptOnLoad(3990, '$("input.datum_cas").datetimepicker({ timeOnlyTitle: "Pouze čas", timeText: "Čas", hourText: "Hodin", minuteText: "Minut", secondText: "Vteřin", currentText: "Aktuální", closeText: "Zavřít", stepMinute: 5 });');

        return true;
    }

	/**
     * Inicializuje Carousel
     *
     * @return bool
     */
    static public function initjCarousel() {
        if(self::_isPackageInit('jCarousel')){ return false; }
        self::initjQuery();

        self::_initPackage('jCarousel');

        self::_addJsFile(11250, "jquery.jcarousel.pack.js");

        self::_addCssFile(11350, "jquery.carousel.css");
        self::_addCssFile(11360, "/skins/ie7/skin.css");
        self::_addCssFile(11370, "/skins/tango/skin.css");

        self::_addJsScriptOnLoad('520', 'jQuery("#jcarousel_1").jcarousel({ scroll: 1 });');
        self::_addJsScriptOnLoad('530', 'jQuery("#jcarousel_2").jcarousel({ vertical:true, scroll: 1 });');
        self::_addJsScriptOnLoad('540', 'jQuery("#jcarousel_3").jcarousel({ scroll: 1 });');

        return true;
    }

	/**
     * Inicializuje ValidatorEngine
     *
     * @return bool
     */
    static public function initValidationEngine()
    {
        if(self::_isPackageInit('validationEngine')){
            return false;
        }
        self::initjQuery();


        self::_initPackage('validationEngine');

        self::_addJsFile(1800, "jquery.validationEngine-en.js");
        self::_addJsFile(1900, "jquery.validationEngine.js");
        self::_addCssFile(2000, "validationEngine.jquery.css");

        return true;
    }

    /**
     * Inicializuje rozsireni pro jquery
     *
     * @return bool
     */
    static public function initjQueryExtended()
    {
        if(self::_isPackageInit('jQueryExtended')){
            return false;
        }
        self::initjQuery();

        self::_initPackage('jQueryExtended');

        self::_addJsFile(2100, "jquery-extended.js");

        return true;
    }


    /**
     * @return bool
     */
    static public function initItemSlider()
    {
        if(self::_isPackageInit('itemSlider')){
            return false;
        }

        self::initjQuery();

        self::_initPackage('itemSlider');

        self::_addJsFile(3000, "item_slider.js");

        return true;
    }

	/**
     * @return bool
     */
    static public function initSwfObject()
    {
        if(self::_isPackageInit('swfObject')){
            return false;
        }

        self::initjQuery();

        self::_initPackage('swfObject');

        self::_addJsFile(3200, "swfobject.js");

        return true;
    }

    /**
     * Inicializuje jQuery
     *
     * @return bool
     */
    static public function initjQueryBlockUI() {
        if(self::_isPackageInit('jQueryBlockUI')){
            return false;
        }

        self::initjQuery();

        self::_initPackage('jQueryBlockUI');

        self::_addJsFile(4000, "jquery.blockUI.js");

        return true;
    }

    /**
     * Inicializuje balicky potrebne pro beh shadowboxu
     *
     * @return bool
     */
    static public function initShadowbox() {
        if(self::_isPackageInit('shadowbox')){
            return false;
        }

        self::initjQuery();
        self::_initPackage('shadowbox');
        self::_addJsFile(10000, "shadowbox.js");
        self::_addCssFile(10000, "shadowbox/shadowbox.css");
        self::_addJsScriptOnLoad(1000,'Shadowbox.init({});');

//        self::_addJsScript(100, "var AJAX_URL = '" . Link::Forge('home&ajax=true', Link::NO_ENTITY) . "';");
        return true;
    }

    /**
     * Inicializuje FullCalendar
     *
     * @return bool
     */
    static public function initFullCalendar() {
        if(self::_isPackageInit('FullCalendar')){
            return false;
        }

        self::initjQuery();
        self::_initPackage('FullCalendar');
        self::_addJsFile(11000, "fullcalendar.min.js");
        self::_addJsFile(11010, "gcal.js");
        self::_addJsFile(11020, "jquery.tmpl.min.js");
        self::_addCssFile(11000, "fullcalendar.css");
//        self::_addCssFile(11010, "fullcalendar.print.css");
        return true;
    }

    static public function initButtonsHovers() {
    	if(self::_isPackageInit('buttonsHovers')){
            return false;
        }

        self::initjQuery();
        self::_initPackage('buttonsHovers');

        self::_addJsScriptOnLoad(500, '$(".ui-state-default").mouseover(function() { $(this).removeClass("ui-state-default"); $(this).addClass("ui-state-hover"); });');
        self::_addJsScriptOnLoad(510, '$(".ui-state-default").mouseout(function() { $(this).removeClass("ui-state-hover"); $(this).addClass("ui-state-default"); });');
        self::_addJsScriptOnLoad(520, '$("img#vlozit-inzerat").mouseover(function() { $(this).attr("src", "/images/red/button/vlozit-inzerat_on.png"); });');
        self::_addJsScriptOnLoad(530, '$("img#vlozit-inzerat").mouseout(function() { $(this).attr("src", "/images/red/button/vlozit-inzerat.png"); });');
        self::_addJsScriptOnLoad(540, '$("img#vlozit-poptavku").mouseover(function() { $(this).attr("src", "/images/red/button/vlozit-poptavku_on.png"); });');
        self::_addJsScriptOnLoad(550, '$("img#vlozit-poptavku").mouseout(function() { $(this).attr("src", "/images/red/button/vlozit-poptavku.png"); });');
        self::_addJsScriptOnLoad(560, '$("img#adresar-rk").mouseover(function() { $(this).attr("src", "/images/red/button/adresar-rk_on.png"); });');
        self::_addJsScriptOnLoad(570, '$("img#adresar-rk").mouseout(function() { $(this).attr("src", "/images/red/button/adresar-rk.png"); });');
        self::_addJsScriptOnLoad(580, '$("img#indexrealtor").mouseover(function() { $(this).attr("src", "/images/red/button/index-realtor_on.png"); });');
        self::_addJsScriptOnLoad(590, '$("img#indexrealtor").mouseout(function() { $(this).attr("src", "/images/red/button/index-realtor.png"); });');
        self::_addJsScriptOnLoad(500, '$("input#hledejte_submit").mouseover(function() { $(this).attr("src", "/images/red/button/hledej_on.png"); });');
        self::_addJsScriptOnLoad(510, '$("input#hledejte_submit").mouseout(function() { $(this).attr("src", "/images/red/button/hledej.png"); });');

		return true;
    }

    static public function initjQueryTooltip() {
        if(self::_isPackageInit('jQueryTooltip')){
            return false;
        }

        self::initjQueryTools();

        self::_addDynamicJsScript(10600, '
            var body = jQuery("body");
            target.find(".toolTipTarget").tooltip({ onBeforeShow: function() { body.append(this.getTip()); } });');

        self::_addDynamicJsScript(10610, '$.easing.bouncy = function (x, t, b, c, d) {	// create custom animation algorithm for jQuery called "bouncy"
		    var s = 1.70158;
		    if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		    return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
		}');

        self::_addJsScriptOnLoad(2510, '$.tools.tooltip.addEffect("bouncy", function(done) { this.getTip().animate({ top: "+=-15" }, 500, "bouncy", done).show(); }, function(done) { this.getTip().animate({ top: "-=30" }, 500, "bouncy", function()  { $(this).hide(); done.call(); }); });');
        self::_addJsScriptOnLoad(2520, '$("[title]").not(".no_title").tooltip({ offset: [10, 2], effect: "slide" }).dynamic({ bottom: { direction: "down", bounce: true } });');
        self::_addJsScriptOnLoad(2530, 'if ($("img.qtip").html()) { $("img.qtip").qtip({ content: $(this).attr("alt"), show: "mouseover", hide: "mouseout" });}');
        //.dynamic({ bottom: { direction: "down", bounce: true } })

        self::_initPackage('jQueryTooltip');
        return true;
    }

	static public function initjQueryTooltip2() {
        if(self::_isPackageInit('jQueryTooltip2')){
            return false;
        }

		self::_addJsFile(13030, "jquery.tooltip.js");
        self::_addCssFile(13040, "jquery.tooltip.css");


		self::_addJsScriptOnLoad(52510, '$(".tooltip2").tooltip({ delay: 0  });');



        self::_initPackage('jQueryTooltip2');
        return true;
    }


    /**
     * Inicializuje dialog pro pridani konverzace mezi makleri
     *
     * @return bool
     */
    static public function initDialogKomunikator() {
    	global $dbUser;
        if(self::_isPackageInit('dialogKomunikator')){
            return false;
        }

        $pMakleri = $dbUser->getRk()->getMakleri();
        $pMakleriOptions = "";
        foreach($pMakleri AS $idMakler) {
        	$pMakleriOptions .= "<option value=".$idMakler.">" . dbUser::getById($idMakler)->getPropertyValue("prijmeni") . " " . dbUser::getById($idMakler)->getPropertyValue("jmeno") . "</option>\n        ";
        }

        self::initjQuery();
        self::initjQueryUI();
        self::_initPackage('dialogKomunikator');
        self::_addDialog('
        	<div id="dialogKomunikator" title="Poslat zprávu" style="display: none">
				<form method="post" action="" id="dialogKomunikatorForm">
					<div class="rs-pole-group-bottom">
						<span class="rs-pole-popis" style="width: 160px; ">Příjemce: </span><br/>
							<select name="dialogKomunikatorPrijemce" id="dialogKomunikatorPrijemce">'.
								$pMakleriOptions
							.'</select>
							<br/><br/>
						<span class="rs-pole-popis" style="width: 160px; ">Evidenční číslo: </span><br/>
						<input type="text" name="dialogKomunikatorIdItem" id="dialogKomunikatorIdItem"/><br/><br/>
						<span class="rs-pole-popis" style="width: 160px; ">Poznámka: </span><br/>
						<textarea name="message" id="dialogKomunikatorMessage" style="width: 255px; height: 110px;"></textarea><br/>
					</div>
				</form>
			</div>
        ');
		self::_addJsScript(10910, '
			function dialogKomunikatorOpen(idItem) {
				$("#dialogKomunikator").dialog("open");
				$("#dialogKomunikatorIdItem").val(idItem);
			}
			');
        self::_addJsScriptOnLoad(5000,'

        	$("#dialogKomunikator").dialog({ autoOpen: false, resizable: false, height:370, modal: true,
				buttons: {
					"Odeslat": function() {
						$(this).dialog("close");
						$.post(
							"/res/ajax.php?mode=dialogKomunikator",
							{idPrijemce: $("#dialogKomunikatorPrijemce").val(), idOdesilatel: '.$dbUser->id.', message: $("#dialogKomunikatorMessage").val(), idItem: $("#dialogKomunikatorIdItem").val()  },
							function (data) {
								$("#error_message").html(data.value);
								if (data.type == "success") {
									$("#error_message").show(); $("#error_message").dialog({ autoOpen: false, height: 140, modal: true, buttons: { Ok: function() { $(this).dialog("close"); }} });
									$("#error_message").dialog("open");
								}
								if (data.type == "error") {
									$("#error_message").show(); $("#error_message").dialog({ autoOpen: false, height: 140, modal: true, buttons: { Ok: function() { $(this).dialog("close"); }} });
									$("#error_message").dialog("open");
								}
							}, "json");
					},
					Cancel: function() {
						$(this).dialog("close");
					}
				}
			});
        ');
        return true;
    }


    /**
     * Inicializuje dialog pro pridani konverzace mezi makleri
     *
     * @return bool
     */
    static public function initDialogAddKomunikaceNabidky() {
    	global $dbUser;
        if(self::_isPackageInit('DialogAddKomunikaceNabidky')){
            return false;
        }


        self::initjQuery();
        self::initjQueryUI();
        self::_initPackage('DialogAddKomunikaceNabidky');
        self::_addDialog('
        	<div id="pridat_komunikaci_nabidky" title="Přidat komunikaci s klientem" style="display: none">
                    <form id="f_pridat_komunikaci_nabidky" method="post">
                            <div class="rs-pole-group-bottom">
                                    <span class="rs-pole-popis" style="width: 120px; display: inline-block;">Datum: </span>
                                    <input style="" class="datum" type="text" name="komunikace_date" id="datum_komunikace_nabidky"/><br />
                                    <span class="rs-pole-popis" style="width: 120px; display: inline-block; ">Způsob jednání: </span>
                                    <select name="type" id="typ_komunikace_nabidky">
                                        <option value="telefon">telefon</option>
                                        <option value="email">email</option>
                                        <option value="osobně">osobně</option>
                                    </select><br/>
                                    <span class="rs-pole-popis" style="width: 120px;  display: inline-block;">Popis: </span>
                                    <textarea name="popis" id="popis_komunikace_nabidky" style="width: 364px; height: 177px;" ></textarea><br/>
                            </div>
                            <input type="hidden" name="id_item" id="id_item_add_komunikace_nabidky" value="" />
                    </form>
                </div>
        ');
        self::_addJsScriptOnLoad(5010,'
                    $("#pridat_komunikaci_nabidky").dialog({ autoOpen: false, resizable: false, modal: true, width: "400px",
                        buttons: {
                            "Odeslat": function() {
                                $(this).dialog("close");
                                $("#loading").show();
                                $("div#pridat_komunikaci").dialog("close");
                                $.post("/res/ajax_results.php?mode=komunikace&sub_mode=pridat_komunikace", $("#f_pridat_komunikaci_nabidky").serialize(), function(data) {
                                    $("#error_message").html(data.value);
                                    if (data.type == "success") {
                                        var idItem = $("#id_item_add_komunikace_nabidky").val();
                                        $("#nabidkyKomunikaceDatum_" + idItem).text($("#datum_komunikace_nabidky").val());
//                                        window.location.reload();
                                        $("#error_message").show(); $("#error_message").dialog({ autoOpen: false, height: 140, modal: true, buttons: { Ok: function() { $(this).dialog("close"); }} });
                                        $("#error_message").dialog("open");
                                    }
                                if (data.type == "error") {
                                        $("#error_message").show(); $("#error_message").dialog({ autoOpen: false, height: 140, modal: true, buttons: { Ok: function() { $(this).dialog("close"); }} });
                                        $("#error_message").dialog("open");
                                }
                            }, "json");
                            return false;
                            },
                            Cancel: function() {
                                    $(this).dialog("close");
                            }
                        }
                });

//            function openDialogAddKomunikaceNabidky(idItem) {
//                alert(idItem);
//                $("#id_item_add_komunikace_nabidky").val(idItem);
//                $("#pridat_komunikaci_nabidky").dialog("open");
//            }

        ');

        self::_addDynamicJsScript(30600, '


        ');




        return true;
    }


}
