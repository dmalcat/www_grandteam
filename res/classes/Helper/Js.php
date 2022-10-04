<?php

class Helper_Js
{
    static $_i = 0;

    static protected $_jsFiles = array();

    static protected $_jsScripts = array();

    static protected $_jsScriptsOnLoad = array();

    static protected $_jsScriptsDynamic = array();

    static protected $_cssFiles = array();

    static protected $_initialized = array();

    /**
     * zakaz vytvareni instanci
     *
     */
    private function __construct()
    {}

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
    static private function _addCssFile($index, $path)
    {
        self::$_cssFiles[$index] = $path;
    }

    static public function flushJs(){
        ksort(self::$_jsFiles);
        ksort(self::$_jsScripts);
        ksort(self::$_jsScriptsOnLoad);
        ksort(self::$_jsScriptsDynamic);

        $return = "";
        foreach (self::$_jsFiles as $path) {
            $return .= '<script type="text/javascript" src="' . Env::Script($path) . '"></script>' . "\n        ";
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
            $return .= '<style type="text/css"><!-- @import "' . Env::Sheet($path) . '" ;--></style>' . "\n        ";
        }

        foreach (Registry::getConfig()->css->name as $path) {
            $return .= '<style type="text/css"><!-- @import "' . Env::Sheet($path) . '"; --></style>' . "\n        ";
		}

        // css pre vfkb low-end a high-end zariadenia
        if(Registry::isProjectInMobileSection() && Provider::testBrand(Provider::GROUP_VODAFONE) ){
    		if (Registry::getDevice()->isHiRes()) {
    		    $return .= '<style type="text/css"><!-- @import "' . Env::Sheet('styl_mobile_vfkb_he.css') . '"; --></style>' . "\n        ";
    		} else {
    		    $return .= '<style type="text/css"><!-- @import "' . Env::Sheet('styl_mobile_vfkb_le.css') . '"; --></style>' . "\n        ";
    		}
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

        self::_addJsFile(1, "jquery.js");

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

        self::_addJsFile(5, "jquery-ui-1.8.5.custom.min.js");
        self::_addCssFile(5, "cupertino/jquery-ui-1.8.5.custom.css");

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

        self::_addJsFile(6, "jquery.autocomplete.min.js");

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

        self::_addJsFile(7, "jquery.tools.min.js");
        self::_addCssFile(7, "jquery/tools.css");

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

        self::_addJsFile(8, "jquery.ui.stars.js");
        self::_addCssFile(8, "jquery.ui.stars.css");

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

        self::_addJsFile(9, "jquery-extended.js");

        return true;
    }

    /**
     * Inicializuje balicek pro validaci formularu
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

        self::_addJsFile(20, "jquery.validationEngine-" . Lang::getCurrent() . ".js");
        self::_addJsFile(21, "jquery.validationEngine.js");

        self::_addCssFile(20, "validationEngine.jquery.css");

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

        self::_addJsFile(30, "item_slider.js");

        return true;
    }

    /**
     * Inicializuje jQuery
     *
     * @return bool
     */
    static public function initjQueryBlockUI()
    {
        if(self::_isPackageInit('jQueryBlockUI')){
            return false;
        }

        self::initjQuery();

        self::_initPackage('jQueryBlockUI');

        self::_addJsFile(10, "jquery.blockUI.js");

        return true;
    }

    /**
     * Inicializuje balicky potrebne pro beh kosiku
     *
     * @return bool
     */
    static public function initEshop()
    {
        if(self::_isPackageInit('eshop')){
            return false;
        }

        self::initjQuery();

        self::_initPackage('eshop');

        self::_addJsFile(100, "eshop.js");

        self::_addJsScript(100, "var AJAX_URL = '" . Link::Forge('home&ajax=true', Link::NO_ENTITY) . "';");

        return true;
    }

    /**
     * Inicializuje balicky potrebne pro beh kosiku
     *
     * @return bool
     */
    static public function initCart()
    {
        if(self::_isPackageInit('cart')){
            return false;
        }

        self::initjQueryBlockUI();
        self::initjQueryTooltip();

        self::_initPackage('cart');

        self::_addJsFile(105, "cart.js");

        self::_addJsScript(105, 'var LOCALE = ' . Registry::getConfig()->lang->id . ';');

        return true;
    }

    static public function initjQueryTooltip()
    {
        if(self::_isPackageInit('jQueryTooltip')){
            return false;
        }

        self::initjQueryTools();


        self::_addDynamicJsScript(106, '
            var body = jQuery("body");
            target.find(".toolTipTarget").tooltip({
            onBeforeShow: function() {
		        body.append(this.getTip());
		    }
        	});');

        //.dynamic({ bottom: { direction: "down", bounce: true } })

        self::_initPackage('jQueryTooltip');
        return true;
    }
}
