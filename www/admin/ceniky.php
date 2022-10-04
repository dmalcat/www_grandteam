<?php

if ($_REQUEST["price_list_do_insert"]) $USER->price_list_add($_REQUEST["name"], $_REQUEST["kod"], $_REQUEST["sleva"], $_REQUEST["visible"]);
if ($_REQUEST["price_list_do_edit"]) $USER->price_list_edit($_REQUEST["id_list"], $_REQUEST["name"], $_REQUEST["kod"], $_REQUEST["sleva"], $_REQUEST["visible"]);
if ($_REQUEST["price_list_do_delete"]) $USER->price_list_delete($_REQUEST["id_list"]);
if ($_REQUEST["price_list_set_for_guest"]) $USER->set_price_list_for_guest($_REQUEST["price_list_id_for_guest"]);
if ($_REQUEST["price_list_set_for_user"]) $USER->set_price_list_for_user($_REQUEST["price_list_id_for_user"]);

$p_price_lists = $USER->get_price_lists();
//print_p($p_price_lists);

/* @var $SMARTY Smarty */
$SMARTY->assign('p_price_lists', $p_price_lists);
$SMARTY->assign('price_list_for_guest', $USER->get_price_list_for_guest());
$SMARTY->assign('price_list_for_user', $USER->get_price_list_for_user());
?>