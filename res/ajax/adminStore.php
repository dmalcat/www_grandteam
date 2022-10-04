<?php

$forceAjax = true;
require_once PROJECT_DIR . 'res/init.php';


if ($_REQUEST['delete']) {
	$id = $_REQUEST['produkty'];
	$id = str_replace('"', '', $id);
	$SHOP->item_delete($id);
	echo json_encode(array('success' => true, 'message' => 'Ok'));
	exit();
}
if ($_REQUEST['save']) {
	$produkty = json_decode($_REQUEST['produkty']);
	if (!is_array($produkty)) {
		$produkty = array($produkty);
	}

	foreach ($produkty as $produkt) {
		$id = $produkt->id;
		if (isset($produkt->novinka)) {
			if ($produkt->novinka) {
				$SHOP->set_item_property($id, "novinka", array("0" => "4"));
			} else {
				$SHOP->set_item_property($id, "novinka", null);
			}
		}
		if (isset($produkt->sleva)) {
			if ($produkt->sleva) {
				$SHOP->set_item_property($id, "sleva", array("0" => "5"));
			} else {
				$SHOP->set_item_property($id, "sleva", null);
			}
		}
		if (isset($produkt->nejoblibenejsi)) {
			if ($produkt->nejoblibenejsi) {
				$SHOP->set_item_property($id, "nejoblibenejsi", array("0" => "6"));
			} else {
				$SHOP->set_item_property($id, "nejoblibenejsi", null);
			}
		}
		if (isset($produkt->exportLekarna)) {
			if ($produkt->exportLekarna) {
				$SHOP->set_item_property($id, "export_lekarna_cz ", array("0" => "13"));
			} else {
				$SHOP->set_item_property($id, "export_lekarna_cz ", null);
			}
		}

		if (isset($produkt->zobrazit)) {
			if ($produkt->zobrazit) {
				$SHOP->set_item_visibility($id, true);
			} else {
				$SHOP->set_item_visibility($id, false);
			}
		}
		if (isset($produkt->skladem)) {
			$SHOP->set_item_store($id, $produkt->skladem);
		}
		if (isset($produkt->priority)) {
			$SHOP->set_item_priority($id, $produkt->priority);
		}
		if (isset($produkt->kod)) {
			$SHOP->set_item_property($id, "kod", $produkt->kod);
		}
		if (isset($produkt->ean)) {
			$SHOP->set_item_property($id, "ean", $produkt->ean);
		}

		if (isset($produkt->cenaSDph)) {
			$price = str_replace(" ", "", $produkt->cenaSDph);
			$price = str_replace(",", ",", $price);
			$price = $price / DEFAULT_DPH;
			$SHOP->set_item_price($id, $price);
		}

		if (isset($produkt->cena)) {
			$price = str_replace(" ", "", $produkt->cena);
			$price = str_replace(",", ",", $price);
			$SHOP->set_item_price($id, $price);
		}
		if (isset($produkt->puvodniCena)) {
			$SHOP->set_item_property($id, "puvodniCena", $produkt->puvodniCena);
		}
		if (isset($produkt->nakladovaCena)) {
			$SHOP->set_item_property($id, "nakladova_cena", $produkt->nakladovaCena);
		}
		if (isset($produkt->doporucenaProdejniCena)) {
			$SHOP->set_item_property($id, "doporucena_prodejni_cena", $produkt->doporucenaProdejniCena);
		}
		if (isset($produkt->idKategorie)) {
			$SHOP->add_item_map_to_category($id, $produkt->idKategorie);
		}
		if (isset($produkt->pohlavi)) {
			$SHOP->set_item_property($id, "pohlavi", array($produkt->pohlavi));
		}
		if (isset($produkt->dphLekarna) && $produkt->dphLekarna) {
			$SHOP->set_item_property($id, "vyse_dph_lekarna_cz", $produkt->dphLekarna);
		}
		if (isset($produkt->nazev_zbozi_cz)) {
			$SHOP->set_item_property($id, "nazev_zbozi_cz", $produkt->nazev_zbozi_cz);
		}
		if (isset($produkt->idHeurekaKategorie)) {
			$SHOP->setHeurekaCategory($id, $produkt->idHeurekaKategorie);
		}
	}
	echo json_encode(array('success' => true, 'message' => 'Ok', 'produkty' => $produkty));
	exit();
}


$id_category = $_REQUEST["id_category"];
$start = $_REQUEST["start"];
$limit = $_REQUEST["limit"];
if ($id_category) {
	$p_items = $SHOP->get_items_for_store(false, $_REQUEST["id_category"]);
}
$return = array();
$celkem = count($p_items);

$p_items = array_slice($p_items, $start, $limit);

foreach ($p_items as $item) {
	$temp = new stdClass();
	$temp->id = $item->id_item;
//			$temp->nazev = "<a href='/admin/products/" . ID_DELIMITER . "{$item->id_item}/'>$item->nazev</a>";
	$temp->nazev = "<a href='/admin/produkty/" . ID_DELIMITER . "{$item->id_item}/'>$item->nazev</a>";
	$temp->priority = $item->priority;
	$temp->novinka = $item->novinka;
	$temp->sleva = $item->sleva;
	$temp->nejoblibenejsi = $item->nejoblibenejsi;
	$temp->puvodniCena = $item->puvodniCena;
	$temp->obrazek = isset($item->obrazek1['PROP_VALUE']['email_url']) ? "<img height='20' src='{$item->obrazek1['PROP_VALUE']['email_url']}' />" : '';
	$temp->skladem = $item->store;
	$temp->kod = $item->kod;
	$temp->ean = $item->ean;
	$temp->cena = round($item->price, 2);
	$temp->cenaSDph = round($item->price_vat);
	$temp->zobrazit = $item->visible ? true : false;
	$temp->nakladovaCena = $item->nakladova_cena;
	$temp->doporucenaProdejniCena = $item->doporucena_prodejni_cena;
	$temp->pohlavi = $item->pohlavi;
	$temp->exportLekarna = $item->export_lekarna_cz;
	$temp->dphLekarna = $item->vyse_dph_lekarna_cz;
	$temp->nazev_zbozi_cz = $item->nazev_zbozi_cz;
	$idKategorie = $DB->getOne("select cmi.id_category from s3n_category_map_item as cmi, s3n_category as c  where cmi.id_item ={$temp->id} and cmi.id_category = c.id_category and c.category_type = '" . Shop_3n::CAT_TYPE_CATEGORY . "' ORDER BY id_map DESC");
	$temp->idKategorie = $idKategorie ? $idKategorie : '';
	$temp->idHeurekaKategorie = $item->idHeurekaKategorie ? $item->idHeurekaKategorie : '';
	$return[] = $temp;
}
echo json_encode(array('success' => true, 'celkem' => $celkem, 'produkty' => $return));
?>
