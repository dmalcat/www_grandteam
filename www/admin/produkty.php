<?php

$idCategory = find_url_key_after('produkty');
if($idCategory) {
	$dbCategory = dbCategory::getById($idCategory);
}


if ($_REQUEST["item_insert"]) {
	$id_item_add = $SHOP->item_add($_REQUEST["name"], array("0" => $dbCategory->id), $_REQUEST["id_parent"], is_array($_REQUEST["item_visible"]) ? 1 : 0);
	$SHOP->set_item_property($id_item_add, "nazev", $_REQUEST["name"]);
	$id_item_inserted = $id_item_add;
}
if ($_REQUEST["item_edit"]) $SHOP->item_edit($_REQUEST["id_item_to_edit"], $_REQUEST["basename"], $_REQUEST["seoname"], $_REQUEST["id_parent"], $_REQUEST["item_visible"], false);
if ($_REQUEST["item_delete"]) $SHOP->item_delete($_REQUEST["id_item_to_edit"]);

if ($_REQUEST["do_add_related_item"]) $SHOP->addRelated($_REQUEST["id_item_to_set_relates"], $_REQUEST["id_related_item"], Shop::RELATED_ITEM);
if ($_REQUEST["do_del_related_item"]) $SHOP->delRelated_item_by_id($_REQUEST["id_item_to_set_relates_delete"], $_REQUEST["id_related_item_delete"]);

if ($_REQUEST["id_item_to_edit"]) {
	if ($_REQUEST["item_property_edit"]) {

// 			$SHOP->item_edit($_REQUEST["id_item_to_edit"], $_REQUEST["basename"], $_REQUEST["seoname"], $_REQUEST["id_parent"], $_REQUEST["item_visible"] , false);
		$SHOP->set_item_visibility($_REQUEST["id_item_to_edit"], $_REQUEST["item_visible"]);
		$SHOP->set_item_priority($_REQUEST["id_item_to_edit"], $_REQUEST["priority"]);

		$prop_array = array_merge((array) $_REQUEST["name"], fileArrayToPropertyArray($_FILES["name"]));
        
		if (is_array($prop_array)) {
			foreach ($prop_array AS $prop_name => $value) {
				$SHOP->set_item_property($_REQUEST["id_item_to_edit"], $prop_name, $value);
			}
		}
		if (!$_REQUEST["is_variant"]) { // neupravujeme variantu takze musime poresit vyrobce, kategorie a related
			$arr = array_merge((array) $_REQUEST["id_category"], (array) $_REQUEST["id_category_manufacturers"]);
			$SHOP->move_item_map_to_category($_REQUEST["id_item_to_edit"], $arr, true);

			$SHOP->set_item_manufacturer($_REQUEST["id_item_to_edit"], $_REQUEST["manufacturer"]);

			$SHOP->delAllRelated($_REQUEST["id_item_to_edit"], Shop::RELATED_CATEGORY); // smazeme stare mapovani related

			foreach ((array) $_REQUEST["id_related"] AS $id_related) {
				$SHOP->addRelated($_REQUEST["id_item_to_edit"], $id_related, Shop::RELATED_CATEGORY);
			}
			foreach ((array) $_REQUEST["id_related_manufacturers"] AS $id_related) {
				$SHOP->addRelated($_REQUEST["id_item_to_edit"], $id_related, Shop::RELATED_CATEGORY);
			}
		}
		$SHOP->set_item_name($_REQUEST["id_item_to_edit"], $_REQUEST["basename"]);
		$SHOP->set_item_price($_REQUEST["id_item_to_edit"], $_REQUEST["price_vat"] / DEFAULT_DPH);
// 			$SHOP->set_item_price($_REQUEST["id_item_to_edit"],$_REQUEST["price"]);
		$SHOP->set_item_store($_REQUEST["id_item_to_edit"], $_REQUEST["store"]);
		$SHOP->set_item_dph($_REQUEST["id_item_to_edit"], $_REQUEST["id_dph"]);
	}
}

$id_store_item = find_id_in_url();

if ($_REQUEST["id_item"] || $id_store_item || $id_item_inserted) { // $id_store_item - pro primy pristup ze skladu
	$id_item = $id_store_item ? $id_store_item : $_REQUEST["id_item"];
	if ($id_item_inserted) $id_item = $id_item_inserted;
	$id_sub_item = $_REQUEST["id_sub_item"];
	$id_sub_sub_item = $_REQUEST["id_sub_sub_item"];

	$SMARTY->assign("category_tree", $SHOP->get_category_tree(Shop::CAT_TYPE_CATEGORY, $id_item));
	$SMARTY->assign("znacka_tree", $SHOP->get_category_tree(Shop::CAT_TYPE_MANUFACTURER, $id_item));
	$SMARTY->assign("related_category_tree", $SHOP->get_related_category_tree(Shop::CAT_TYPE_CATEGORY, $id_item));
	$SMARTY->assign("related_znacka_tree", $SHOP->get_related_category_tree(Shop::CAT_TYPE_MANUFACTURER, $id_item));

	if ($id_sub_item) {  //resime varianu lvl 1
		$p_item_childs[2] = $SHOP->get_raw_items($id_sub_item);  //varianty variant
		$id_get_detail = $id_sub_item;
	}
	if ($id_sub_sub_item) { //resime varianu lvl 2
		$id_get_detail = $id_sub_sub_item;
	}

	$p_item = $SHOP->get_item_detail($id_get_detail ? $id_get_detail : $id_item, true, false);
	$p_item_childs[1] = $SHOP->get_raw_items($id_item);

	if ($p_item["INFO"]->id_parent) { //zobrazujeme detatko - tj pouze zmenene vlastnosti
		$p_item_child = $SHOP->get_item_detail($p_item["INFO"]->id_item, false, false, false, Shop::DEFAULT_LANG, false);
	}
// 		if ($p_item["INFO"]["RELATED_ITEMS"]) {
// 			foreach($p_item["RELATED_ITEMS"] AS $rel_key =>$rel_item) {
// 				$p_item["RELATED_ITEMS"][$rel_key] = $SHOP->get_more_item_properties($key, array("nazev","kod"));
// 			}
// 		}
}

if ($dbCategory) {
	//$p_raw_items = $SHOP->get_raw_items_by_category($dbCategory->id);
	//$p_raw_items = $SHOP->get_items_by_category($dbCategory->id,"preview",false,"detail");
	$p_raw_items = $SHOP->get_s_raw_items($dbCategory->id);
	$SMARTY->assign("category_id", $dbCategory->id);
	$SMARTY->assign("pocet", count($p_raw_items));
} else { //zobrazit nezarazene itemy
	if (!$id_store_item) $p_raw_items = $SHOP->get_s_raw_items(null);
	//$p_raw_items = $SHOP->get_raw_items_by_category();

	$SMARTY->assign("category_id", 0);
}

$SMARTY->assign("p_raw_items", $p_raw_items);

$p_raw_codes = $SHOP->get_raw_codes($dbCategory->id);

$s_manufacturers = $SHOP->get_manufacturers_for_select();
$s_manufacturers[0] = null;

$p_items_to_related = $SHOP->get_items_for_related(null);

$SMARTY->assign("p_items_to_related", $p_items_to_related);

$p_steps = $SHOP->get_steps(false);
foreach ($p_steps AS $key=>$step) {
	$s_steps[$step["ID_STEP"]] = $step["NAME"]; // pro select vyberu stepu u kategorii vlastnosti
	$p_categories[$key]["categories"] = $SHOP->get_step_categories($step["ID_STEP"]);
	foreach ($p_categories[$key]["categories"] AS $cat_key=>$category) {
		$p_categories[$key]["categories"][$cat_key]["properties"] = $SHOP->get_category_properties($category["ID_CATEGORY"]);
// 				$p_categories[$key]["categories"][$cat_key]["properties_map"] = $SHOP->get_category_properties($category["ID_CATEGORY"]);
	}
}

?>

