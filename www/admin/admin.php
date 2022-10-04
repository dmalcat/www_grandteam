<?php

/* @var $dbUser dbUser */

if ($dbUser && $dbUser->isAllowed('administrace-prihlaseni')) {
//	die();
//    Cache::flush();

    if ($_POST['doChangePass'] && $_POST['newPass']) {
        $auth->changepassword($dbUser->login, $_POST['newPass']);
        $success_message = 'Heslo bylo upraveno.';
    }

    $SHOP->limit = 100;
    $SHOP->admin_mode = true;

    if ($par_2 == "lang") {
        Session::set("contentLangCode", $par_3);
        Message::success("", "/admin/seznam_clanku");
    }

    if ($_REQUEST["setContentLang"]) {
        Session::set("contentLangCode", $_REQUEST["setContentLang"]);
    }

    if ($_REQUEST["idContentType"]) {
        Session::set("idContentType", $_REQUEST["idContentType"]);
    }

    if ($_REQUEST["id_content_type"]) {
        Session::set("idContentType", $_REQUEST["id_content_type"]);
    }


    $contentLangCode = Session::get('contentLangCode');
    $idContentType = Session::get('idContentType');
    $SMARTY->assign('idContentType', $idContentType);


    dbContentCategory::setType(dbContentType::getById($idContentType ? $idContentType : dbContentType::getDefault()->id));
    dbContentCategory::setLang($contentLangCode ? dbContentLang::getByCode($contentLangCode) : dbContentLang::getDefault());

    $content_type = Session::get("idContentType");
    $content_lang = Session::get("contentLangCode"); // deprecated ...
    $CONTENT->set_content_type($content_type);
    $CONTENT->set_content_lang($content_lang); // deprecated ...

    $spravaObsahuMenu = array("seznam_clanku", "clanek", "menu", "seznam_fotogalerii", "editace_fotogalerie", "fotogalerie", "seznam_dokumentu", "dokumenty", "editace_dokumentu", "videa", "seznam_videa", "editace_videa", "emails", "soutez");
    $uzivateleMenu = array("uzivatele", "opravneni", "novy_uzivatel", "role", "dotazy", "uzivatele_log", "prodejny");
    $newsletterMenu = array("seznam_newsletter", "newsletter");
    if (in_array($par_2, $spravaObsahuMenu)) {
        $menuSelected = "obsah";
    }
    if (in_array($par_2, $uzivateleMenu)) {
        $menuSelected = "uzivatele";
    }
    if (in_array($par_2, $newsletterMenu)) {
        $menuSelected = "newsletter";
    }

    $CONTENT->check_date_from = false;
    $CONTENT->check_date_to = false;


    if (!$par_2) {
        if ($dbUser->isAllowed("SPRAVA OBSAHU")) {
            header('Location: /admin/seznam_clanku');
            exit();
        } else {
            header('Location: /admin/uzivatele');
            exit();
        }
    }
    $fileName = "/www/admin/" . $par_2 . ".php";
    if (file_exists(PROJECT_DIR . $fileName)) {
        if ($dbUser->isAllowed($pAdminRights[$menuSelected])) {
            require_once PROJECT_DIR . $fileName;
        } else {
            $error_message = "Nemáte oprávnění pro vstup do této sekce. ";
            $par_2 = "access_denied";
        }
    } else {
        throw new Exception("Nelze najit modul administrace pro " . $par_2);
    }

    $SMARTY->assign("content_lang", $CONTENT->content_lang);
    $SMARTY->assign("content_type", $CONTENT->content_type);
    $SMARTY->assign("menuSelected", $menuSelected);

    $page = "admin/main.tpl";
} else {
    if ($_POST) {
        $error_message = "Tento Uživatel nemá administrátorská oprávnění";
    }
    $page = "admin/main.tpl";
}

//Cache::flush();
include(PROJECT_DIR . "res/display.php");
?>
