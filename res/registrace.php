<?php

$userId = isset($USER->data["id_user"]) ? $USER->data["id_user"] : null;

//print_p($_POST);
//unset($dbUser);

if ($_POST["doRegistrace"]) {
    $validProperties = array();
    $validForm = true;
    $redirect = false;

    if (!$dbUser->id) {
        if (!$_POST["login"]) {
            Message::error("Vyplňte uživatelské jméno");
            $validForm = false;
        }
        if (!$_POST["passwd"]) {
            Message::error("Vyplňte heslo");
            $validForm = false;
        }
        if ($_REQUEST["passwd"] != $_REQUEST["passwd_confirm"]) {
            Message::error("Hesla se neshodují");
            $validForm = false;
        }
        if (dbUser::getByLogin($_POST['login'])) {
            Message::error("Uživatelské jméno je již registrováno");
            $validForm = false;
        }
    }
    if ($dbUser->id) {
        if (isset($_POST['passwd'])) {
            if ($_REQUEST["passwd"] != $_REQUEST["passwd_confirm"]) {
                Message::error("Hesla se neshodují");
                $validForm = false;
            }
        }
    }

    foreach ($_POST AS $prop_name => $prop_value) {
        unset($p_user_data["PROPERTIES"][$prop_name]["PROP_VALUE"]);
        $prop_info = $USER->get_property_info($prop_name);
        if ($prop_info["PROP_MUST_FILL"] AND ! $prop_value) {
            Message::error("Pole $prop_name je třeba vyplnit");
            print_p($prop_name);
            $validForm = false;
        } else {
            $validProperties[$prop_name] = $prop_value;
            if (is_array($prop_value)) {
                foreach ($prop_value AS $key => $enum_item) {
                    $validProperties[$prop_name][$key] = $enum_item;
                }
            }
        }
    }

    if (isset($_POST['DodaciAdresaStejna'])) {
        $USER->nastavTypDodaciAdresy($_POST['DodaciAdresaStejna']);
    }

    if (isset($_POST['FakturaceNaFirmu'])) {
        $USER->nastavTypFiremnichUdaju($_POST['FakturaceNaFirmu']);
    }

    /* @var $USER User */
    // pokud byl formular v poradku a jednalo se o registraci, tak uzivateli zmenim login a heslo
    if ($validForm) {
        if (!$dbUser->id) {
            $dbUser = dbUser::create(array(
                        "login" => $_POST["login"],
                        "pass" => $_POST["passwd"],
                        "mlist" => $_POST["mlist"] ? 1 : 0,
                        "date_created" => date("Y-m-d H:i:s"),
                        "id_role" => 100,
            ));


            $m = new MailSend($_POST["email"]);
            $m->sendRegistraceInfo($dbUser, $_POST["login"], $_POST["passwd"], $_POST["firma"], $_POST["jmeno"], $_POST["prijmeni"]);

// 			$m = new MailSend(REGISTRACE_EMAIL_COPY_5);
// 			$m->sendRegistraceInfo($dbUser, $_POST["login"], $_POST["passwd"], $_POST["firma"], $_POST["jmeno"], $_POST["prijmeni"]);

            $m = new MailSend(REGISTRACE_EMAIL_COPY_1);
            $m->sendRegistraceInfo($dbUser, $_POST["login"], $_POST["passwd"], $_POST["firma"], $_POST["jmeno"], $_POST["prijmeni"]);

// 			$m = new MailSend(REGISTRACE_EMAIL_COPY_2);
// 			$m->sendRegistraceInfo($dbUser, $_POST["login"], $_POST["passwd"], $_POST["firma"], $_POST["jmeno"], $_POST["prijmeni"]);
// 			$m = new MailSend(REGISTRACE_EMAIL_COPY_3);
// 			$m->sendRegistraceInfo($dbUser, $_POST["login"], $_POST["passwd"], $_POST["firma"], $_POST["jmeno"], $_POST["prijmeni"]);
// 			$m = new MailSend(REGISTRACE_EMAIL_COPY_4);
// 			$m->sendRegistraceInfo($dbUser, $_POST["login"], $_POST["passwd"], $_POST["firma"], $_POST["jmeno"], $_POST["prijmeni"]);
// 			$m = new MailSend(REGISTRACE_EMAIL_COPY_5);
// 			$m->sendRegistraceInfo($dbUser, $_POST["login"], $_POST["passwd"], $_POST["firma"], $_POST["jmeno"], $_POST["prijmeni"]);
//			$USER->send_registration_email($_POST['name']["email"], $_POST["login"], $_POST["passwd"], $dbUser->id);
            $redirect = true;
        } else {
            $message = "Změna údajů proběhla v pořádku.";
        }

        if ($dbUser->id) {
            foreach ($_POST as $propName => $propValue) {
                if (!dbUserProperty::getByName($propName, "user"))
                    continue;
                $dbUser->setPropertyValue($propName, $propValue);
            }

            $dbUser->setMList($_POST["mlist"]);

//			$auth->setAuth($_POST["login"]);
//			$auth->setAuthData("id_user", $dbUser->id, true); // setAuth jen predstira lognuti
//			$USER->data["logged"] = true;
//			$USER->data["username"] = $_POST["login"];

            $registraceOk = true;
            Message::success($message);
        } else {
            throw new Exception("Problem pri registraci");
        }
    }

    if ($validForm && $zmenaUdaju) {
        if (isset($_POST['passwd'])) {
            $auth->changepassword($USER->data["username"], $_POST["passwd"]);
        }
    }
    if ($redirect)
        Message::success("Registrace proběhla v pořádku. Na uvedený e-mail Vám přijde autorizace Vašeho přístupu.", "/logout");
}


$p_user_steps = $USER->get_steps(true);
foreach ($p_user_steps AS $key => $step) {
    $s_user_steps[$step["ID_STEP"]] = $step["NAME"]; // pro select vyberu stepu u kategorii vlastnosti
    $p_user_categories[$key]["categories"] = $USER->get_step_categories($step["ID_STEP"], true);
    foreach ($p_user_categories[$key]["categories"] AS $cat_key => $category) {
        $p_user_categories[$key]["categories"][$cat_key]["properties"] = $USER->get_category_properties($category["ID_CATEGORY"], "", true);
    }
}
$SMARTY->assign("p_user_categories", $p_user_categories);

if ($USER->data["logged"] || $USER->data["id_user"]) {
    $p_user_data = $USER->get_user_detail_compact($USER->data["id_user"]);
}

$display_errors[] = $ERROR->GetBySource("REGISTRACE");
$SMARTY->assign("p_user_data", $p_user_data);



