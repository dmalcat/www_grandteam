<?php

//	ini_set ('include_path',ini_get('include_path').':./res:./res/classes/pear:../res/classes/pear:');
require("def.php");
Registry::checkSystemDirs();

$p_pars = explode("/", $_GET["p_par"]);
foreach ($p_pars AS $par) {
    $i++;
    $par_tmp = "par_" . $i;
    $$par_tmp = $par;
}

$last_par = $p_pars[count($p_pars) - 1];


require_once(SMARTY_DIR . "Smarty.class.php");
require_once(SMARTY_DIR . "MySmarty.class.php");

/*  Autentizace */
$auth = new Auth('DB', $authOptions, 'displayLoginForm');
$auth->setExpire(86400, FALSE);
$auth->setIdle(86400, FALSE);
ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params(86400);
/*  Smarty */
$SMARTY = new IRSmarty();
$SMARTY->template_dir = SMARTY_DATADIR;
$SMARTY->compile_dir = PROJECT_DIR . "data/templates_c/";
$SMARTY->config_dir = SMARTY_DIR . "configs/";
$SMARTY->cache_dir = SMARTY_DIR . "cache/";
$SMARTY->plugins_dir[] = SMARTY_DIR . "plugins/"; // vlastni fce
//$SMARTY->caching = true;
//$SMARTY->debugging = true;
//import_request_variables("gp", "");
//extract($_REQUEST);

$auth->setShowLogin(false);
if ($par_1 == "admin")
    $auth->setShowLogin(true);
if (strpos($_SERVER["REQUEST_URI"], "logout")) {
    Session::set("session_data", "");
    $auth->logout();
    Session::set("id_guest", "");
    Message::success("", "/");
}
$auth->start();

$id_item = find_id_in_url();

//$auth->removeUser('test');
//$auth->addUser('3nicom', 'error007', array("admin" => "on", "vip" => "on"));
//$auth->addUser('guest','guest',array("admin"=>"","vip"=>""));
//$auth->addUser('test','test');
//$auth->changepassword("admin", "admin");

$USER = new User($DB, "s3n_");
$CONTENT = new Content_3n($DB, "cs", "s3n_");


if ($auth->checkAuth()) {
    $USER->data = $auth->getAuthData();
    $USER->data["username"] = $auth->getUsername();
    $USER->data["logged"] = "1";
    $dbUser = dbUser::getById($USER->data["id_user"]);
    if ($dbUser) {
        if ($_POST['login_user'] && !$_POST['doRegistrace']) {
            $dbUser->logLogin();
            Message::success("", "");
        }
        $dbUser->updateLastLogin();
    }
    if ($dbUser->isAdmin() || $dbUser->isEditor()) {

    } else {
        if (!$dbUser->enabled) {
            Message::error("Vaše registrace ješte nebyla schválena.", "/logout");
        }
    }
    //$USER->data["puvodni_cena_koeficient_sleva"] = (1 + ((int)$USER->data["sleva_txt"] / 100));
} else {
    if ($_POST['login_user']) {
        Message::error('Neplatné jméno, nebo heslo');
    }
    $auth_status = $auth->getStatus();
    $USER->data["username"] = "Host";
    $USER->data["id_user"] = Session::get("id_guest");
    $USER->data["logged"] = "0";
//    $dbUser = dbUser::getGuest();
}


if ($dbEshop->getEnabledEshop() || true) {
// 	$SHOP = new Shop($DB, "s3n_", $USER->data);

    if ($_POST["setContentLang"]) {
        SESSION::set("language", $_POST["setContentLang"]);
        if ($par_1 != "admin") {
            Message::success("", "");
        }
    }

    if (find_url_key_after("lang") && $par_1 <> 'admin') {
        SESSION::set("language", find_url_key_after("lang"));
        Message::success("", "/");
    }

    $language = SESSION::get("language");
    if (!$language) {
        $language = dbContentLang::getDefault()->code;
    }

    require PROJECT_DIR . "langs/$language.php";
    $Translate = new Translate($language);
    $p_langs = dbContentLang::getAll();
    dbContentCategory::setLang(dbContentLang::getByCode($language));
// 	dbContentCategory::setLang(dbContentLang::getByCode('cs'));
    $CONTENT->set_content_lang($CONTENT->get_id_lang($language));
// 	$CONTENT->set_content_lang($CONTENT->get_id_lang('cs'));
}

$USER->language = $language;

define("IMG_DIR", "/images_$language/");

require_once PROJECT_DIR . 'res/emails.php';
//require_once PROJECT_DIR . 'res/emailing.php';
//Message::success("test");
if ($_GET["force_ajax"] || $forceAjax) {
    require_once(PROJECT_DIR . 'res/ajax_results.php');
} elseif ($par_1 != "admin") {
    include_once(PROJECT_DIR . "/res/articles_content.php");
    include "include.php";
} else {
    include "include.php";
}
?>
