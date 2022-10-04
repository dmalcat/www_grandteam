<?php


$tbl_prefix = "s3n_";
$orders_section_max = 30; // pocet na jedne strance zobrazenych objednavek

$id_cart = find_id_in_url();
$page = find_url_key_after("page", 1);
$orders_section_start = ($page - 1) * $orders_section_max;

if (find_url_key_after("delete") AND find_url_key_after("id_user")) {
	Cart::delete_cart($DB, $tbl_prefix, find_url_key_after("delete"), find_url_key_after("id_user"));
}
$p_transports = $SHOP->get_transports();
$p_payments = $SHOP->get_payments();

if ($id_cart) {
	/* @var $dbCart dbCart */
	$dbCart = dbCart::getById($id_cart);
	
//	print_p(Zasilkovna::getById(40)); die();
	
	$CART = new Cart($DB, null, $tbl_prefix, $id_cart);
	$id_user = $CART->get_cart_owner($id_cart);

	$user_email = $dbCart->getOwner()->getPropertyValue('email');
	$user_telefon = $dbCart->getOwner()->getPropertyValue('telefon');
	$user_telefon = str_replace(" ", "", $user_telefon);
	$SMARTY->assign("user_email", $user_email);
	$SMARTY->assign("user_telefon", $user_telefon);

	if($_POST["idZasilkovna"]) {
		$dbCart->setIdZasilkovna($_POST["idZasilkovna"]);
		$success_message = "Zasilkovna byla změněna";
	}

	if ($_POST["do_add_to_cart"] AND $_POST["newOrderItemIdItem"]) {
		$CART->add_item($_POST["newOrderItemIdItem"], $_POST["newOrderItemCount"], $SHOP->get_item_price($_POST["newOrderItemIdItem"], null, $USER->get_price_list_for_user($CART->id_user)),$SHOP->get_item_price($_POST["newOrderItemIdItem"],null, null, $ignore_price_list = true));
	}

	if ($_REQUEST["do_change_order"]) {
		if (in_array($CART->get_transport(), $pDpdTransports)) {
			if (strlen($_REQUEST["transport_number"]) != 14)
				$_REQUEST["transport_number"] = substr($_REQUEST["transport_number"], 8, 14);
// 				die($_REQUEST["transport_number"]);
		}

		$dbCart->setTransportNumber(str_replace('"', "M", $_POST["transport_number"]));
		$CART->set_nasledna_sleva_pocet($_REQUEST["nasledna_sleva_pocet"]);
		$CART->set_nasledna_sleva_procenta($_REQUEST["nasledna_sleva_procenta"] / 100);
		$CART->set_special_order_type($_REQUEST["special_order_type"]);
	}

//	print_p($_POST);
	
	if (isset($_REQUEST["payed"])) {
		$CART->set_payed($_REQUEST["payed"]);
//		if ($_REQUEST["payed"]) $CART->send_zaplaceno_email($user_email, $p_cart, $p_user, $_REQUEST["sum_transport"]);
	}
	if (isset($_REQUEST["status"])) $dbCart->setStatus($_REQUEST["status"]);
	if (isset($_REQUEST["id_transport"])) $dbCart->setTransport($_REQUEST["id_transport"]);
	if (isset($_REQUEST["item_status"]) AND $_REQUEST["id_cart_item"]) dbCartItem::getById($_REQUEST["id_cart_item"])->setStatus($_REQUEST["id_cart_item"]);
	if (isset($_REQUEST["dod_termin"]) AND $_REQUEST["id_cart_item"]) $CART->set_dod_termin($_REQUEST["dod_termin"], $_REQUEST["id_cart_item"]);
	if (isset($_REQUEST["do_delete_cart_item"]) AND $_REQUEST["id_cart_item"]) $CART->del_item($_REQUEST["id_cart_item"]);

	if (in_array($CART->get_transport(), Shop_3n::$zasilkovnaTransports) && $CART->getZasilkovna()) {
		$xml = simplexml_load_file(ZASILKOVNA_VYDEJNY_URL);
		$vydejny = (array) $xml->xpath('database/table');
		foreach ($vydejny AS $pVydejna) {
			$pVydejna = (array) $pVydejna;
			$pVydejny[$pVydejna["column"][0]] = array("id" => $pVydejna["column"][0], "stat" => $pVydejna["column"][1], "mesto" => $pVydejna["column"][2], "adresa" => $pVydejna["column"][3], "popis" => $pVydejna["column"][4]);
		}
		$pZasilkovna = $pVydejny[$CART->getZasilkovna()];
		$SMARTY->assign("pZasilkovna", $pZasilkovna);
		$SMARTY->assign("pVydejny", $pVydejny);
		$SMARTY->assign('idZasilkovna', $CART->getZasilkovna());
		FB::info($pVydejny, $CART->getZasilkovna());

	}

	$p_cart["ITEMS"] = $CART->get_items(null);
	$p_cart["CELKOVA_HMOTNOST"] = $SHOP->get_sum_hmotnost();
// 		foreach($p_cart["ITEMS"] AS $tmp_item) {
// 			$p_cart["CELKOVA_HMOTNOST"] += (int)$tmp_item->PROPS["hmotnost"]["PROP_VALUE"];
// 		}
	$p_cart["ITEMS_COUNT"] = count($dbCart->getItems());
	$p_cart["ITEMS_SUM"] = $dbCart->getItemsSum();
	$p_cart["ITEMS_SUM_VAT"] = $dbCart->getItemsSum(true);
	$p_cart["TRANSPORT_SUM"] = $dbCart->getTransportPaymentSum();
	$p_cart["TRANSPORT_SUM_VAT"] = $dbCart->getTransportPaymentSum(true);
	$p_cart["PRICE_UNIT"] = Shop::DEFAULT_ITEM_PRICE_UNIT;
	$p_cart["SUM"] = $dbCart->getSum();
	$p_cart["SUM_VAT"] = $dbCart->getSum(true);
	$p_cart["VAT"] = $dbCart->getVat();
	$p_cart["SUM_VAT_CURRENCY"] = round($p_cart["SUM_VAT"] / $CART->vratMenu()->currency_rate, $CART->vratMenu()->code == "czk" ? 0 : 2);
	$p_cart["ID_TRANSPORT"] = $dbCart->getTransport()->id;
	$p_cart["ID_PAYMENT"] = $dbCart->getPayment()->id;
	$p_cart["VARSYMB"] = $dbCart->getVarsymb();
	$p_cart["MESSAGE"] = $dbCart->getMessage();
	$p_cart["ID_ZASILKOVNA"] = $dbCart->getIdZasilkovna();
	$p_cart["PAYMENT"] = $p_payments[$CART->get_payment()];
	$p_cart["TRANSPORT"] = $p_transports[$CART->get_transport()];

	$p_cart["NASLEDNA_SLEVA_POCET"] = $CART->get_nasledna_sleva_pocet();
	$p_cart["NASLEDNA_SLEVA_PROCENTA"] = $CART->get_nasledna_sleva_procenta() * 100;
	$p_cart["SPECIAL_ORDER_TYPE"] = $CART->get_special_order_type();

	$p_cart["TRANSPORT_NUMBER"] = $dbCart->getTransportNumber();
	$p_cart["MESSAGE"] = $CART->get_message();
	$p_cart["CREATED"] = $CART->get_created();
	$p_cart["CLOSED"] = $CART->get_closed();
	$p_cart["STATUS"] = $CART->get_status();
	$p_cart["PAYED"] = $CART->get_payed();
	$p_cart["OPTIONAL_PROPS"] = $CART->get_optional_properties();
	$p_cart["CURRENCY"] = $CART->vratMenu();

	if ($p_cart["CURRENCY"]->code == "eu") {
		$SHOP->language = "sk";
	}
	if ($p_cart["CURRENCY"]->code == "eu_de") {
		$SHOP->language = "de";
	}
	$p_transports = $SHOP->get_transports();

	$p_cart["CUSTOMER"] = $USER->get_user_detail($id_user, true, "detail", false);
	$p_cart["CUSTOMER_COMPACT"] = $USER->get_user_detail_compact($id_user, true, "detail", false);
	$p_cart["CUSTOMER"]["firma"] = $USER->get_user_property($id_user, USER_FIRMA_PROPERTY_NAME);
	$p_cart["CUSTOMER"]["prijmeni"] = $USER->get_user_property($id_user, USER_PRIJMENI_PROPERTY_NAME);
	$p_cart["CUSTOMER"]["jmeno"] = $USER->get_user_property($id_user, USER_JMENO_PROPERTY_NAME);
	$p_cart["jeKuponovaSleva"] = $CART->jeKuponovaSleva();
	$p_cart["typDarkovehoBaleni"] = $CART->vratTypDarkovehoBaleni();
	$p_cart["typDodaciAdresy"] = $USER->vratTypDodaciAdresy();
	if ($p_cart["jeKuponovaSleva"]) {
//		$p_cart["kuponovaSleva"] = ($p_cart['ITEMS_SUM_VAT'] / KUPONOVA_SLEVA_KOEFICIENT) - ($p_cart['ITEMS_SUM_VAT']);
//          $p_cart['ITEMS_SUM_VAT'] = $p_cart['ITEMS_SUM_VAT'] - $p_cart["kuponovaSleva"];
	}

	$p_cart["PPL"] = $CART->getPplInfo();
	$p_cart["PPL_CUSTOMER"] = $CART->getPplCustomerInfo();
	$p_cart["DPD"] = $CART->getDpdInfo();
	$p_cart["DPD_CUSTOMER"] = $CART->getDpdCustomerInfo();
	$p_cart["CP"] = $CART->getCpInfo();
	$p_cart["CP_CUSTOMER"] = $CART->getCpCustomerInfo();

	$SMARTY->assign("p_user", $USER->get_user_detail($CART->get_cart_owner($id_cart), false, "detail", true));
	$SMARTY->assign("dodaci_udaje_stejna", $USER->get_user_property($CART->get_cart_owner($id_cart), USER_DODACISTEJNA_PROPERTY) ? true : false);

	//print_p($USER->get_user_detail($CART->get_cart_owner($id_cart),false,"detail",true));

	if ($par_3 == "print") { //pouze tisk objednavky
		$SMARTY->assign("p_cart", $p_cart);
		$page = "admin/objednavky/print.tpl";
		include(PROJECT_DIR . "/res/display.php");
		exit;
	}
	if ($par_3 == "print_2") { //pouze tisk objednavky
		$id_odeslano = 3;
		//$p_cart["BALNE"] = $CART->get_balne();
		//$p_cart["BALNE_VAT"] = $CART->get_balne() * 1.19;
		$p_cart["ITEMS"] = $CART->get_items($id_odeslano);
		$p_cart["ITEMS_SUM"] = $CART->get_sum($id_odeslano);
		$p_cart["ITEMS_SUM_VAT"] = $CART->get_sum_vat($id_odeslano);
		$p_cart["ITEMS_VAT"] = $p_cart["ITEMS_SUM_VAT"] - $p_cart["ITEMS_SUM"];
		//$p_cart["DATUM_SPLATNOSTI"] = $CART->get_datum_splatnosti();
		//$p_cart["DATUM_VYSTAVENI"] = $CART->get_datum_vystaveni();
		//$p_cart["FORMA_UHRADY"] = $CART->get_forma_uhrady();
//		$p_cart["SUM"] = $p_cart["ITEMS_SUM"] + $p_cart["TRANSPORT_SUM"] + $p_cart["BALNE"];
//		$p_cart["SUM_VAT"] = $p_cart["ITEMS_SUM_VAT"] + $p_cart["TRANSPORT_SUM"] + $p_cart["BALNE_VAT"];
//		$p_cart["SUM_VAT_CEILED"] = ceil($p_cart["SUM_VAT"]);
		$p_cart["SUM"] = $dbCart->getSum(null, $id_odeslano);
		$p_cart["SUM_VAT"] = $dbCart->getSum(true);
		$p_cart["SUM_VAT_CEILED"] = ceil($p_cart["SUM_VAT"]);
		$p_cart["CEILED"] = $p_cart["SUM_VAT_CEILED"] - $p_cart["SUM_VAT"];
		$SMARTY->assign("p_cart", $p_cart);
		$page = "admin/objednavky/print_2.tpl";
		include(PROJECT_DIR . "/res/display.php");
		exit;
	}
	if ($_POST["ppl_do_save"]) {
		$pplData = $_POST["ppl"];
		$CART->SetPplInfo($pplData);
		$p_cart["PPL"] = $CART->getPplInfo();
		$p_cart["PPL_CUSTOMER"] = $CART->getPplCustomerInfo();
	}
	if ($_POST["ppl_do_save_export"]) {
		$pplData = $_POST["ppl"];
		$CART->SetPplInfo($pplData);
		$p_cart["PPL"] = $CART->getPplInfo();
		$p_cart["PPL_CUSTOMER"] = $CART->getPplCustomerInfo();
		include(PROJECT_DIR . "/www/admin/export/ppl.php");
//			exit;
	}
	if ($_POST["dpd_do_save"]) {
		$dpdData = $_POST["dpd"];
		$CART->SetdpdInfo($dpdData);
		$p_cart["DPD"] = $CART->getdpdInfo();
		$p_cart["DPD_CUSTOMER"] = $CART->getdpdCustomerInfo();
	}
	if ($_POST["dpd_do_save_export"]) {
		$dpdData = $_POST["dpd"];
		$CART->SetdpdInfo($dpdData);
		$p_cart["DPD"] = $CART->getdpdInfo();
		$p_cart["DPD_CUSTOMER"] = $CART->getdpdCustomerInfo();
		include(PROJECT_DIR . "/www/admin/export/dpd.php");
//			exit;
	}
	if ($_POST["cp_do_save"]) {
		$pData = $_POST["cp"];
		$CART->SetCpInfo($pData);
		$p_cart["CP"] = $CART->getCpInfo();
		$p_cart["CP_CUSTOMER"] = $CART->getCpCustomerInfo();
	}
	if ($_POST["cp_do_save_export"]) {
		$pData = $_POST["cp"];
		$CART->SetCpInfo($pData);
		;
		$p_cart["CP"] = $CART->getCpInfo();
		$p_cart["CP_CUSTOMER"] = $CART->getCpCustomerInfo();
		include(PROJECT_DIR . "/www/admin/export/posta.php");
		exit;
	}

	if ($_POST["zasilkovna_export"]) {
		include(PROJECT_DIR . "/www/admin/export/zasilkovna.php");
//		exit;
	}

	if ($_REQUEST["do_send_email"] == "Potvrzující email") {
		$CART->send_potvrzeni_email($user_email, $p_cart, $p_user, $_REQUEST["sum_transport"]);
		Message::success('Potvrzující email byl odeslán');
	}
	if ($_REQUEST["do_send_email"] == "Storno email") {
		$CART->send_storno_email($user_email, $p_cart, $p_user);
		Message::success('Storno email byl odeslán');
	}
	if ($_REQUEST["do_send_email"] == "odeslat platba prijata email") {
// 			die();
// 			$CART->send_storno_email($user_email,$p_cart,$p_user);
	}

	if ($p_cart["CURRENCY"]->code == "eu") {
		$sms_dodani_message = "Dnes Vam byla odeslana objednavka c. " . $p_cart["VARSYMB"] . " z eshopu ".Registry::getDomainName()." Dekujeme";
	} else {
		$sms_dodani_message = "Dnes Vam byla odeslana objednavka c. " . $p_cart["VARSYMB"] . " z eshopu ".Registry::getDomainName()." Dekujeme";
	}


	if ($_REQUEST["do_send_sms"]) {
		if ($_POST["sms_text"]) {
			if ($user_telefon) {
				$sms = new CSMSConnect();
				$sms->Create(SMSBRANA_LOGIN, SMSBRANA_PASS_HASH, 2); // inicializace a prihlaseni login, heslo, typ zabezpeceni
				$pAnswer = ($sms->Send_SMS($user_telefon, $_POST["sms_text"]));
				$sms->Logout();
				if ($pAnswer["err"] == 0) {
					$success_message = "
							SMS Úspěšně odeslána !<br/>
							Cena sms: " . $pAnswer["price"] . " Kč <br/>
							Odeslaných sms: " . $pAnswer["sms_count"] . " <br/>
							Zbývá kredit: " . $pAnswer["credit"] . "
						";
				} else {
					$error_message = "Došlo k chybě při odeslání sms. SMS neodeslána.<br/>Kontaktujtesprávce. Číslo chyby: " . $pAnswer["err"];
				}
			} else {
				$error_message = "U zákazníka není uveden tel. kontakt. SMS neodeslána.";
			}
		} else {
			$error_message = "Text sms nesmí být prázdný. SMS neodeslána.";
		}
	}

	$SMARTY->assign("id_cart", $id_cart);
} else {
	$date_from = $_REQUEST["date_from"];
	$date_to = $_REQUEST["date_to"];
	$show_cart_status = $_REQUEST["show_cart_status"];
	$varsymb = $_REQUEST["varsymb"];

	$limit = $_REQUEST["limit"];
	if (!$limit) {
		$limit = $orders_section_max;
	}
	$offset = ($page - 1) * $limit;

	$default_date_from = strtotime('-1 month');

	$p_orders = Cart::get_orders($DB, $tbl_prefix, $_REQUEST["id_user"], $date_from, $date_to, $show_cart_status, $varsymb, $limit, $_REQUEST["id_cart_item"], $offset);
	$celkovyPocetObjednavek = CART::get_orders_count($DB, $tbl_prefix, $_REQUEST["id_user"], $date_from, $date_to, $show_cart_status, $varsymb, $limit, $_REQUEST["id_cart_item"], $offset);
	$pages = ceil($celkovyPocetObjednavek / $limit);

	$count = 0;
	$sum_price = 0;
	$sum_price_vat = 0;
	foreach ($p_orders AS $key => $order) {
		if (!$CART) $CART = new Cart($DB, $order->id_user, $tbl_prefix, $count);
		$CART->id_cart = $order->id_cart;
		$CART->id_user = $order->id_user;

		$dbCart = dbCart::getById($order->id_cart);
		
		$p_cart[$count]["dbCart"] = $dbCart;
		$p_cart[$count]["id_cart"] = $dbCart->id;
		$p_cart[$count]["id_user"] = $dbCart->id_user;
		$p_cart[$count]["varsymb"] = $dbCart->varsymb;
		$p_cart[$count]["open"] = $dbCart->open;
		$p_cart[$count]["status"] = $dbCart->status;
		$p_cart[$count]["id_transport"] = $dbCart->id_transport;
		$p_cart[$count]["id_payment"] = $dbCart->id_payment;
		$p_cart[$count]["PAYMENT"] = $p_payments[$p_cart[$count]["id_payment"]];
		$p_cart[$count]["TRANSPORT"] = $p_transports[$p_cart[$count]["id_transport"]];
		$p_cart[$count]["message"] = $dbCart->message;
		$p_cart[$count]["created"] = $dbCart->created;
		$p_cart[$count]["closed"] = $dbCart->closed;
		$p_cart[$count]["PAYED"] = $dbCart->payed;
		$p_cart[$count]["CURRENCY"] = $CART->vratMenu();

		$p_cart[$count]["NASLEDNA_SLEVA_POCET"] = $CART->get_nasledna_sleva_pocet();
		$p_cart[$count]["NASLEDNA_SLEVA_PROCENTA"] = $CART->get_nasledna_sleva_procenta() * 100;
		$p_cart[$count]["SPECIAL_ORDER_TYPE"] = $CART->get_special_order_type();


		$p_cart[$count]["price"] = $dbCart->getSum(false);
		$p_cart[$count]["price_vat"] = $dbCart->getSum(true);
		$p_cart[$count]["price_unit"] = Shop::DEFAULT_ITEM_PRICE_UNIT;
		$p_cart[$count]["customer"]["firma"] = $USER->get_user_property($order->id_user, USER_FIRMA_PROPERTY_NAME);
		$p_cart[$count]["customer"]["prijmeni"] = $USER->get_user_property($order->id_user, USER_PRIJMENI_PROPERTY_NAME);
		$p_cart[$count]["customer"]["jmeno"] = $USER->get_user_property($order->id_user, USER_JMENO_PROPERTY_NAME);
		//print_p($p_cart[$count]);

		$sum_price += $p_cart[$count]["price"];
		$sum_price_vat += $p_cart[$count]["price_vat"];
		$count++;
	}

	unset($CART);
}
$s_users = $USER->get_users_for_select();
$s_manufacturers = $SHOP->get_manufacturers_for_select();
//$s_manufacturers[99999] = "vyberte:";
if ($_REQUEST["id_manufacturer"]) {
	$p_items = $SHOP->get_items_for_store_by_manufacturer(false, $_REQUEST["id_manufacturer"]);
}
$SMARTY->assign("s_users", $s_users);
$SMARTY->assign("default_date_from", $default_date_from);
$SMARTY->assign("orders_section_max", $orders_section_max);
$SMARTY->assign("orders_section_start", $orders_section_start);
$SMARTY->assign("celkovyPocetObjednavek", $celkovyPocetObjednavek);
$SMARTY->assign("pages", $pages);
$SMARTY->assign("p_cart", $p_cart);
$SMARTY->assign("sum_price", $sum_price);
$SMARTY->assign("sum_price_vat", $sum_price_vat);
?>