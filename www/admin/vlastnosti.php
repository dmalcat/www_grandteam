<?php

	if ($_POST["property_do_insert"]) {
		if ($SHOP->property_add($_REQUEST["id_category"], $_REQUEST["prop_name"], $_REQUEST["prop_type"], $_REQUEST["prop_unit"], $_REQUEST["prop_search"], $_REQUEST["prop_lang_depending"], $_REQUEST["prop_validation_regex"], $_REQUEST["prop_show"], $_REQUEST["move_to_category"], $_REQUEST["prop_visible"], $_REQUEST["prop_inherit"], $_REQUEST["prop_sort"], $_REQUEST["prop_weight"], $_REQUEST["prop_copy_to_cart"])) {
			$success_message = "Vlastnost vložena";
		} else {
			$error_message = "Chyba při vkládání vlastnosti";
		}
	}
	if ($_REQUEST["property_do_edit"]) {
		if ($SHOP->property_edit($_REQUEST["id_property"], $_REQUEST["prop_name"], $_REQUEST["prop_type"], $_REQUEST["prop_unit"], $_REQUEST["prop_search"], $_REQUEST["prop_lang_depending"], $_REQUEST["prop_validation_regex"], $_REQUEST["prop_show"], $_REQUEST["move_to_category"], $_REQUEST["prop_visible"], $_REQUEST["prop_inherit"], $_REQUEST["prop_sort"], $_REQUEST["prop_weight"], $_REQUEST["prop_copy_to_cart"])) {
			$SHOP->set_property_category_mapping($_REQUEST["id_property"], $_REQUEST["property_map_category_general"],"GENERAL");
			$SHOP->set_property_category_mapping($_REQUEST["id_property"], $_REQUEST["property_map_category_variant"],"VARIANT");
			$SHOP->set_property_category_mapping($_REQUEST["id_property"], $_REQUEST["property_map_category_additional"],"ADDITIONAL");
			$success_message = "Vlastnost upravena";
		} else {
			$ERROR->spawn("Shop_3n", 1, ERROR::NONE, ERROR::WARNING, "Chyba při úpravě vlastnosti");
		}
	}
	if ($_REQUEST["property_do_delete"]) {
		if ($SHOP->property_delete($_REQUEST["id_property"])) {
			$success_message = "Vlastnost smazana";
		} else {
			$error_message = "Chyba při mazání vlastnosti";
		}
	}
	if ($_REQUEST["property_enum_do_insert"]) {
		if ($SHOP->property_enum_add($_REQUEST["id_property"], $_REQUEST["value"])) {
			$success_message = "Hodnota přidána";
		} else {
			$error_message = "Chyba při vkládání hodnoty";
		}
	}
	if ($_REQUEST["property_enum_do_edit"]) {
		if ($SHOP->property_enum_edit($_REQUEST["id_property"], $_REQUEST["id_enumeration"], $_REQUEST["value"])) {
			$success_message = "Vlastnost upravena";
		} else {
			$error_message = "Chyba při úpravě vlastnosti";
		}
	}
	if ($_REQUEST["property_enum_do_delete"]) {
		if ($SHOP->property_enum_delete($_REQUEST["id_property"], $_REQUEST["id_enumeration"])) {
			$success_message = "Hodnota smazána";
		} else {
			$error_message = "Chyba při úpravě vlastnosti";
		}
	}

	$p_steps = $SHOP->get_steps(false);
	foreach ($p_steps AS $key=>$step) {
		$s_steps[$step["ID_STEP"]] = $step["NAME"]; // pro select vyberu stepu u kategorii vlastnosti
		$p_categories[$key]["categories"] = $SHOP->get_step_categories($step["ID_STEP"]);
		foreach ($p_categories[$key]["categories"] AS $cat_key=>$category) {
			$p_categories[$key]["categories"][$cat_key]["properties"] = $SHOP->get_category_properties($category["ID_CATEGORY"]);
// 				$p_categories[$key]["categories"][$cat_key]["properties_map"] = $SHOP->get_category_properties($category["ID_CATEGORY"]);
		}
	}

	$SMARTY->assign("p_steps",$p_steps);
	$SMARTY->assign("p_categories",$p_categories);
	$SMARTY->assign("p_property_categories", $SHOP->get_items_categories(false, false, null, Shop::CAT_TYPE_CATEGORY));
	$SMARTY->assign('s_prop_item_show',$SHOP->get_enum_options($SHOP->tbl_prefix."property","show"));
?>