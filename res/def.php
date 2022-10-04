<?php

ini_set("session.cookie_lifetime", "360000"); //an hour
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 360000);
ini_set('session.cookie_lifetime', 360000);
ini_set('session.use_only_cookies', 1);
//ini_set('session.use_trans_sid', 0);
// 	apc_clear_cache();

setlocale(LC_ALL, "cs_CZ");
define('ERROR_REPORTING', E_ALL ^ E_NOTICE ^ E_DEPRECATED);
//ini_set ('include_path',':./res:./pear:../pear:'.PROJECT_DIR.'res:'.PROJECT_DIR.'pear:'.PROJECT_DIR.'res/classes/gCal/library:');



define("INFO_EMAIL", 'info@grandteam.cz'); //pro odesilani infa o objednavce
define("INFO_EMAIL_TEST", 'info@3nicom.cz');
//define("SUMMARY_EMAIL_FROM", 'info@3nicom.cz'); //pro odesilani infa o objednavce
define("SUMMARY_EMAIL_FROM", 'info@3nicom.cz'); //pro odesilani infa o objednavce
define("SUMMARY_EMAIL_SUBJECT", 'Potvrzení objednávky '); //pro odesilani infa o objednavce

define("DISABLE_SHOPPING", false);

error_reporting(ERROR_REPORTING);
ini_set("display_errors", 1);

define('PROJECT_DIR', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);  // root projektu
define('PROJECT_CONFIG_DIR', PROJECT_DIR . "etc/");
define('PROJECT_NETTE_LIBS_DIR', PROJECT_DIR . "res/classes/Nette/");
define("SMSBRANA_LOGIN", "3nicom_h1");
define("SMSBRANA_PASS", "");
define("SMSBRANA_PASS_HASH", "");

set_include_path(PROJECT_DIR . 'res/classes/pear/' . PATH_SEPARATOR . get_include_path() . PATH_SEPARATOR . PROJECT_DIR . '/res/');

require_once(PROJECT_DIR . 'res/classes/pear/FirePHPCore/fb.php');
require_once(PROJECT_DIR . "res/classes/db/dbException.php");
require_once(PROJECT_DIR . "res/loader.php");

$dbEshop = dbEshop::getByDomain();


ini_set("display_errors", 1);
define('PROJECT_DIR', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);  // root projektu
define("HOST", Registry::getDomainName());
define('CACHE_PREFIX', md5(HOST));
//	define("HOST",					'http://'.$_SERVER["SERVER_NAME"]);

define("DEFAULT_DPH", 1.21);

define("DEFAULT_TITLE", $dbEshop->default_title);
define("DEFAULT_KEYWORDS", $dbEshop->default_keywords);
define("DEFAULT_DESCRIPTION", $dbEshop->default_description);

define("ID_CONTENT_CATEGORY_TO_MAP_USERS", 4852);

define("ENABLE_SHOP", $dbEshop->getEnabledEshop());
define("ENABLE_GALLERIES", $dbEshop->getEnabledGalleries());
define("ENABLE_POLLS", $dbEshop->getEnabledPolls());
define("ENABLE_LANGUAGES", $dbEshop->getEnabledLanguages());
define("ENABLE_USERS", $dbEshop->getEnabledUsers());

define("ENABLE_FCK_ADMIN", true);
define("FCK_RESIZE_IMAGE", true);
define("ENABLE_DATUM_ADMIN", false);
define("FORCE_HOMEPAGE", true);
define("FORCE_SINGLE_GALLERY_DETAIL", false);


define("COMPANY_NAME", "");
define("REGISTRACE_EMAIL_FROM", "info@3nicom.cz");

define("DOTAZ_EMAIL_FROM", "info@3nicom.cz");
define("DOTAZ_EMAIL_COPY", "info@3nicom.cz");
define("DOTAZ_EMAIL_ANSWERED_INFO", "info@3nicom.cz");


define("NEWSLETTER_EMAIL_FROM", "info@3nicom.cz");

if ($dbEshop->getEnabledEshop())
    include_once("def_shop.php");

define("SHOP_NAME", Registry::getDomainName());

define("SYS_SESSION_TIME", 7200); // implicitni delka session
define('SMARTY_DIR', PROJECT_DIR . "res/classes/smarty/");
define('SMARTY_DATADIR', PROJECT_DIR . "templates/");

define("SYS_IMG_DATA_DIR", PROJECT_DIR . "images_content/");
define("SYS_IMG_IMPORT_DIR", PROJECT_DIR . "images_import/");
define("SYS_IMG_HTTP_DIR", "/images_content");  // bez lomitka na konci !!

define("SYS_IMG_CATEGORY_PATH", PROJECT_DIR . "images_categories/");

define("LANGUAGE_FLAGS_DIR", "/images/flags/");
// 		define("ENUM_DELIMITER",						"|");	//uz snad nikde neni pouzit


define("CONTENT_DELIMITER", ""); //par_1 kdyz jde o content
define("CONTENT_DEEP", 5); //uroven zanoreni meny contentu

define("NEWS_EMAIL_FROM", 'info@3nicom.cz'); //pro odesilani infa o objednavce
define("REGISTRATION_EMAIL_FROM", 'info@3nicom.cz'); //pro odesilani infa o objednavce


define("CATEGORY_DELIMITER", "");
define("CATEGORY_DEEP", 3); //uroven zanoreni meny produktu

define('LANGS_PATH', PROJECT_DIR . 'langs/');
define("DEFAULT_LANGUAGE", "cs");
define('ID_DELIMITER', '_id_'); // pokud se objevi v url tak cislo po je id objektu


/* * ********************* XML seznam zbozi ***************************** */
define("XML_nazev", 'nazev');
/* * ********************* XML seznam zbozi ***************************** */

define("IN_CODEPAGE", "UTF-8"); // pro flash data
define("OUT_CODEPAGE", "UTF-8"); // pro flash data



define("REQUEST_URI", $_SERVER['REQUEST_URI']);
// 	define("DEFAULT_CATEGORY_CATEGORY_SEO_NAME", 	"zabradli");

$s_yes_no = array('1' => '');
$s_prop_type = array('S_CHECKBOX' => 'S_CHECKBOX', 'E_SELECT' => 'E_SELECT', 'E_RADIO' => 'E_RADIO', 'IMAGE' => 'IMAGE', 'FILE' => 'FILE', 'STRING' => 'STRING', 'TEXTAREA' => 'TEXTAREA');
$s_prop_search = array('1' => '');
$s_prop_inherit = array('1' => '');
$s_prop_visible = array('1' => '');
$s_visible = array('1' => '');
$s_prop_required = array('1' => '');
$s_prop_must_fill = array('1' => '');
$s_prop_sort = array('int' => 'číselné', "string" => "textové");
$s_prop_lang_depending = array('1' => '');
//$s_prop_show = array('preview'=>'preview','detail'=>'detail','list'=>'list');


$authOptions = array(
    'sessionName' => 'login_session_' . Registry::getDomainName(),
    'allowLogin' => true,
    'postUsername' => 'login_user',
    'postPassword' => 'login_pass',
    //'advancedSecurity' => false,
    //'cryptType' => 'md5',
    'dsn' => $configArray['driver'] . '://' . $configArray['username'] . ':' . $configArray['password'] . '@' . $configArray['host'] . '/' . $configArray['database'],
    'table' => 's3n_users',
    'db_fields' => '*',
    'usernamecol' => 'login',
    'passwordcol' => 'pass');


//$ACL = new Class_Acl($DB, "s3n_");

require_once "functions.php";
require_once "sql.php";
require_once "Auth.php";
$auth = new Auth('DB', $authOptions, 'displayLoginForm');
require_once "File/Find.php";
require_once "HTTP/Upload.php";
require_once ('Mail.php');
require_once ('Mail/mime.php');
require PROJECT_DIR . 'langs/cs.php';

$ACL = new Class_Acl();

$pAdminRights = array(
    'obsah' => 'SPRAVA OBSAHU',
    'kalendar' => 'SPRAVA KALENDARE',
    'uzivatele' => 'UZIVATELE',
    'eshop' => 'ESHOP',
    'objednavky' => 'OBJEDNAVKY',
    'nastaveni' => 'NASTAVENI',
    'newsletter' => 'NEWSLETTER'
);



define("GA_ACCOUNT", $dbEshop->ga_key);
define("HEUREKA_API_CODE", $dbEshop->heureka_api_code);
define("HEUREKA_TRACK_ID", "");
define("SMSBRANA_LOGIN", $dbEshop->sms_brana_login);
define("SMSBRANA_PASS", $dbEshop->sms_brana_pass);
define("SMSBRANA_PASS_HASH", $dbEshop->sms_brana_pass_hash);
?>
