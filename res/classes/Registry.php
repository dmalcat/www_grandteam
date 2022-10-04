<?php

/**
 * @author jhajek
 */
class Registry {

    protected static $_registry = array();
    protected static $SERVER_DOMAIN = null;
    protected static $SERVER_URL = null;

    const MODE_PRODUCTION = 'production';
    const MODE_PREVIEW = 'preview';
    const MODE_DEVELOPMENT = 'development';
    const PROJECT_SECTION_WEB = 'web';
    const PROJECT_SECTION_MOBILE = 'mobile';

    private function __construct() {

    }

    private function __clone() {

    }

    protected static function _get($index) {
        if (!array_key_exists($index, self::$_registry)) {
            throw new Exception("Registry::$index neexistuje");
        } else {
            return self::$_registry[$index];
        }
    }

    protected static function _set($index, $value) {
        if (self::_isRegistered($index)) {
            throw new Exception("Promenna '$index' už byla nastavena");
        } else {
            self::$_registry[$index] = $value;
        }
    }

    protected static function _isRegistered($index) {
        return array_key_exists($index, self::$_registry) ? true : false;
    }

    /**
     * @return Config
     */
    public static function getBootstrapConfig() {
        if (!self::_isRegistered('boostrapConfig')) {
            // nactu bootstrap sekci log konigurace
            // zde jsou informace o tom ktera sekce se vybere
            $bootstrapConfig = new Config(PROJECT_CONFIG_DIR . 'config.ini', 'bootstrap');
            if (file_exists(PROJECT_CONFIG_DIR . 'newconfig.ini')) {
                $bootstrapConfig->mergeFile(PROJECT_CONFIG_DIR . 'newconfig.ini');
            }
            self::_set('boostrapConfig', $bootstrapConfig);
        }
        return self::_get('boostrapConfig');
    }

    /**
     * Pri prvnim volani spusti inicializaci.
     * Zjisti se jaky je:
     * mode[development|production]
     * language[cz|sk]
     * section[web|mobile]
     * provider[rajknih|vodafone|samsung]
     *
     * @return Config
     */
    public static function getConfig() {
        if (!self::_isRegistered('config')) {

            $bootstrapConfig = self::getBootstrapConfig();
            // zjistim mod, pokud neni pouziji defaultni
            if ($bootstrapConfig->fixed && $bootstrapConfig->fixed->mode) {
                $mode = $bootstrapConfig->fixed->mode;
            } else {
                $mode = $bootstrapConfig->default->mode;

                if ($bootstrapConfig->modes) {
                    // projdu mody a zjistim ktera odpovida nazvu serveru nebo ip adrese serveru
                    foreach ($bootstrapConfig->modes as $sectionName => $targets) {
                        if ($targets instanceof Config) {
                            $targets = $targets->toArray();
                        } else {
                            $targets = (array) $targets;
                        }
                        foreach ($targets as $target) {
                            if ($target == $_SERVER['SERVER_NAME'] || $target == $_SERVER['SERVER_ADDR']) {
                                $mode = $sectionName;
                                break 2;
                            }
                        }
                    }
                }
            }
            // zjistim sekci, pokud neni pouziju defaultni
            if ($bootstrapConfig->fixed && $bootstrapConfig->fixed->section) {
                $section = $bootstrapConfig->fixed->section;
            } else {
                $section = $bootstrapConfig->default->section;

                // zjistim o jakou sekci jde
                if (strpos($_SERVER['PHP_SELF'], "mobile") || strpos(self::getDomain(), 'http://m.') !== false) {
                    $section = 'mobile';
                } elseif (isset($_GET['service'])) {
                    $section = 'sms';
                }
            }

            self::_set('projectMode', $mode);
            self::_set('projectSection', $section);

            $files = array(
                PROJECT_CONFIG_DIR . 'config.ini',
                PROJECT_CONFIG_DIR . 'logs.ini',
            );

            $config = new Config($files, array(
                'mode' => 'mode-' . $mode,
                'section' => 'section-' . $section,
                    ), true);

            if (file_exists(PROJECT_CONFIG_DIR . 'newconfig.ini')) {
                $config->mergeFile(PROJECT_CONFIG_DIR . 'newconfig.ini', true);
            }

            // uprava konfigurace pro profilera
            if (self::getSession()->id_user == 1) {
                $config->unlock();
                $config->debug->nette->enabled = 1;
                $config->log->showConfigMergeDiff = 1;
                $config->log->provider->exception->default->firebug->enabled = 1;
                $config->log->provider->debug->default->firebug->enabled = 1;
                $config->lock();
            }

            self::_set('config', $config);
        }
        return self::_get('config');
    }

    public static function isConfigRegistered() {
        return self::_isRegistered('config');
    }

    /**
     * @return dbUser
     */
    public static function getUser() {
        if (!self::_isRegistered('user')) {
            $user = null;
            if (self::getSession()->id_user && intval(self::getSession()->id_user)) {
                $user = dbUser::getById(self::getSession()->id_user);
                self::getSession()->Register('user_data', array());
                self::getSession()->Register('user_newsletter', array());
                if ($user) {
                    // pole kde se ukladaji informace o uzivateli
                    self::getSession()->user_data = $user;
                    self::getSession()->user_newsletter = User::getUserNewsletter($user->id);
                } else {
                    $user = null;
                    self::getSession()->user_data = null;
                    self::getSession()->user_newsletter = null;
                }
            }
            self::_set('user', $user);
        }
        return self::_get('user');
    }

    /**
     * @return Model_Currency
     */
    public static function getCurrency() {
        if (!self::_isRegistered('currency')) {
            self::_set('currency', Model_Currency::getInstance(dbCurrency::getCurrent()));
        }
        return self::_get('currency');
    }

    /**
     * @return Server
     */
    static public function getServer() {
        if (!self::_isRegistered('server')) {
            self::_set('server', new Server());
        }
        return self::_get('server');
    }

    /**
     * @return Session
     */
    static public function getSession() {
        if (!self::_isRegistered('session')) {
            self::_set('session', new Session());
        }
        return self::_get('session');
    }

    /**
     * @return string
     */
    static public function getProjectMode() {
        return self::_get('projectMode');
    }

    /**
     * @return bool
     */
    static public function isProductionMode() {
        return self::_get('projectMode') == self::MODE_PRODUCTION ? true : false;
    }

    /**
     * pro lenochy co nejsou schopni napsat podminku self::getProjectSection() == self::PROJECT_SECTION_MOBILE
     *
     * @return bool
     */
    static public function isProjectInMobileSection() {
        return self::getProjectSection() == self::PROJECT_SECTION_MOBILE;
    }

    /**
     * vrati true pokud se jedna o ajaxove volani nebo je v url ajax == 'true'
     *
     * @return bool
     */
    static public function isXmlRequest() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || (isset($_GET['ajax']) && $_GET['ajax'] == 'true' || $_GET['mode']);
    }

    /**
     * @return string
     */
    static public function getProjectSection() {
        return self::_get('projectSection');
    }

    /**
     * @return string
     */
//    static public function getConfigProvider()
//    {
//        return self::_get('configProvider');
//    }



    public static function getDomain() {
        if (self::$SERVER_DOMAIN === null) {
            self::$SERVER_DOMAIN = "http://" . $_SERVER["HTTP_HOST"];
        }
        return self::$SERVER_DOMAIN;
    }

    public static function getDomainName() {
        if (self::$SERVER_DOMAIN == null) {
            self::$SERVER_DOMAIN = $_SERVER["HTTP_HOST"];
        }
        return str_replace('http://', '', self::$SERVER_DOMAIN);
    }

    public static function checkSystemDirs() {
        Helper_FileSystem::checkDir(PROJECT_DIR . "data");
        Helper_FileSystem::checkDir(PROJECT_DIR . "data/files_content_category");
        Helper_FileSystem::checkDir(PROJECT_DIR . "data/images_content_category");
        Helper_FileSystem::checkDir(PROJECT_DIR . "data/images_calendar");
        Helper_FileSystem::checkDir(PROJECT_DIR . "data/userfiles");
        Helper_FileSystem::checkDir(PROJECT_DIR . "data/videos_content_category");
        Helper_FileSystem::checkDir(PROJECT_DIR . "data/fotogalerie");
        Helper_FileSystem::checkDir(PROJECT_DIR . "data/fotogalerie/files");
        Helper_FileSystem::checkDir(PROJECT_DIR . "data/fotogalerie/galleries");
        Helper_FileSystem::checkDir(PROJECT_DIR . "data/fotogalerie/images");
        Helper_FileSystem::checkDir(PROJECT_DIR . "data/fotogalerie/videos");
        Helper_FileSystem::checkDir(PROJECT_DIR . "data/fotogalerie/water_images");
        Helper_FileSystem::checkDir(PROJECT_DIR . "data/fotogalerie/xml");
    }

    public static function getUrl($removePg = TRUE) {
//        $url = "?" . $_SERVER['QUERY_STRING'];
        $url = $_SERVER['REQUEST_URI'];
        if ($removePg) {
            $position = strpos($url, "p=") - 1;
            if ($position > 0) {
                $url = substr($url, 0, $position);
            }
        }
        return $url;
    }

    public static function isAdmin() {
        global $par_1;
        if ($par_1 == "admin") {
            return TRUE;
        }
    }

}
