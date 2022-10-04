<?php

$id_user = $_REQUEST["id_user"]; // uz by to nikde nemelo byt, ale preventivne
if (!$id_user) $id_user = find_url_key_after("id_user", "");  //  users

if ($_POST["password"]) {
	$login = $DB->getOne("SELECT login FROM s3n_users WHERE id_user = $id_user");
	dbI::query("UPDATE s3n_users SET pass_plain = %s WHERE id_user = %i", $_POST["password"], $id_user)->result();
	if ($login) {
		$auth->changepassword($login, $_POST["password"]);
	}
}

$id_user_to_delete = find_url_key_after("id_user_to_delete", "");  //  mazeme

if ($_REQUEST["user_do_insert"]) {
	$dbUserInserted = dbUser::create(array("login" => $_REQUEST["login"], "pass" => $_REQUEST["pass"], "id_role" => $_REQUEST["idRole"]));
	if ($dbUserInserted) {
		if (isset($_POST["mlist"])) $dbUserInserted->setMList($_POST["mlist"]);
		header("Location: /admin/uzivatele/id_user/" . $dbUserInserted->id);
		exit();
	} else {
		$error_message = "Došlo k chybě při zakládání uživatele.";
	};
}
if ($id_user_to_delete && is_numeric($id_user_to_delete)) $USER->user_delete($id_user_to_delete);


if ($id_user) {
	if ($_REQUEST["user_property_edit"]) {
		$prop_array = array_merge((array) $_REQUEST["name"], fileArrayToPropertyArray($_FILES["name"]));
		if (is_array($prop_array)) {
			foreach ($prop_array AS $prop_name => $value) {
				$USER->set_user_property($id_user, $prop_name, $value);
			}
		}

		$USER->user_map_price_list($id_user, $_REQUEST["id_price_list"]);
		$USER->set_role($_REQUEST["idRole"], $id_user);
	}
	$p_user = $USER->get_user_detail($id_user, true, false, true);
	$dbUserEdit = dbUser::getById($id_user);
	if (isset($_POST["mlist"])) $dbUserEdit->setMList($_POST["mlist"]);

	if (isset($_POST["enabled"])) {
		if ($_POST["enabled"]) {
			if (!$dbUserEdit->getEnabled()) {
				Message::success("Odeslán aktivační email");
				$m = new MailSend($dbUserEdit->getPropertyValue("email"));
				$m->sendRegistraceConfirm();
			}
			$dbUserEdit->setEnabled(1);
		} else {
			$dbUserEdit->setEnabled(0);
		}
	}
	$SMARTY->assign("dbUserEdit", $dbUserEdit);
	if ($_POST["user_property_edit"]) {
		Message::success("Uživatel upraven.", "");
	}
}

$pager = new class_pager();
$SMARTY->assign('pager', $pager);
if (isset($par_3)) {
	$pager->strana = $par_3;
}

//$p_raw_users = $USER->get_raw_users();
$p_raw_users = $USER->search_users($_REQUEST["price_list_id"], $_REQUEST["find_what"], $_REQUEST["find_where"], $_REQUEST["filter"], $pager, $_REQUEST["idRole"]);


$p_user_list_properties = $USER->get_category_properties(null, "list", false);
foreach ($p_user_list_properties AS $property) { // naplneni selectu pro vyhledavani
	$s_user_list_properties[$property["PROP_NAME"]] = $property["PROP_NAME"];
}

foreach ($p_raw_users AS $id_user => $user_data) {
	$p_users[$id_user] = $USER->get_user_detail($id_user, true, "list", true);
}


/* @var $USER User_3n */
$p_user_steps = $USER->get_steps(false);
foreach ($p_user_steps AS $key => $step) {
	$s_user_steps[$step["ID_STEP"]] = $step["NAME"]; // pro select vyberu stepu u kategorii vlastnosti
	$p_user_categories[$key]["categories"] = $USER->get_step_categories($step["ID_STEP"]);
	foreach ($p_user_categories[$key]["categories"] AS $cat_key => $category) {
		$p_user_categories[$key]["categories"][$cat_key]["properties"] = $USER->get_category_properties($category["ID_CATEGORY"]);
	}
}


$SMARTY->assign("p_user", $p_user);  //detail konkretniho usera
$SMARTY->assign("p_users", $p_users); //detaily vyhledanejch useru
$SMARTY->assign("id_user", $id_user);
$SMARTY->assign("p_user_list_properties", $p_user_list_properties);
$SMARTY->assign("s_user_list_properties", $s_user_list_properties);
$SMARTY->assign("p_price_lists", $p_price_lists);
$SMARTY->assign("s_price_lists", $USER->get_price_lists_for_select());
$SMARTY->assign("price_list_for_guest", $USER->get_price_list_for_guest());
$SMARTY->assign("price_list_for_user", $USER->get_price_list_for_user());

$SMARTY->assign("p_steps", $p_steps);
$SMARTY->assign("p_user_steps", $p_user_steps);
$SMARTY->assign("s_steps", $s_steps);
$SMARTY->assign("s_dph", $s_dph);
$SMARTY->assign("s_user_steps", $s_user_steps);
$SMARTY->assign("p_categories", $p_categories);
$SMARTY->assign("p_user_categories", $p_user_categories);
?>