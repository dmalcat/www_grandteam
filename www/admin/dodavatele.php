<?php

//$id_manufacturer = find_url_key_after("id_manufacturer","");  //  /vyrobci
$id_manufacturer = $_REQUEST["id_manufacturer"];

if ($id_manufacturer) {
	if ($_REQUEST["manufacturer_do_edit_info"]) $SHOP->manufacturer_edit_info($id_manufacturer, $_REQUEST["firma"], $_REQUEST["jmeno"], $_REQUEST["prijmeni"], $_REQUEST["telefon"], $_REQUEST["email"], $_REQUEST["www"], $_REQUEST["visible"]);
	if ($_REQUEST["manufacturer_do_edit"]) $SHOP->manufacturer_edit($id_manufacturer, $_REQUEST["firma"], $_REQUEST["jmeno"], $_REQUEST["prijmeni"], $_REQUEST["telefon"], $_REQUEST["email"], $_REQUEST["www"], $_REQUEST["visible"], $_REQUEST["ulice"], $_REQUEST["mesto"], $_REQUEST["psc"], $_REQUEST["bank_ucet"], $_REQUEST["bank"], $_REQUEST["ico"], $_REQUEST["dic"], $_REQUEST["popis"]);
	if ($_REQUEST["manufacturer_do_delete"]) $SHOP->manufacturer_delete($id_manufacturer);
}
if ($_REQUEST["manufacturer_do_insert_info"]) $SHOP->manufacturer_add($_REQUEST["firma"], $_REQUEST["jmeno"], $_REQUEST["prijmeni"], $_REQUEST["telefon"], $_REQUEST["email"], $_REQUEST["www"], $_REQUEST["visible"]);

$p_manufacturers = $SHOP->get_manufacturers_compact();

/* @var $SMARTY Smarty */
$SMARTY->assign('p_manufacturers', $p_manufacturers);

//print_p($p_manufacturers);
?>