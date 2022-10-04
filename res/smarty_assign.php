<?php

$SMARTY->assign("now", date("Y-m-d"));

$SMARTY->assign("dbEshop", $dbEshop);
$SMARTY->assign("dbCC", $dbCC);
$SMARTY->assign("dbC", $dbC);
$SMARTY->assign("dbCCs", $dbCCs);
$SMARTY->assign("dbCT", $dbCT);
$SMARTY->assign("dbCategories", $dbCategories);
$SMARTY->assign("dbUser", $dbUser);
$SMARTY->assign("dbItem", $dbItem);
$SMARTY->assign('dbCategory', $dbCategory);
$SMARTY->assign('dbCart', $dbCart);
$SMARTY->assign('dbTransport', $dbTransport);
$SMARTY->assign('dbPayment', $dbPayment);
$SMARTY->assign('pIcons', $pIcons);
$SMARTY->assign('pTop', $pTop);
$SMARTY->assign('pBottom', $pBottom);
$SMARTY->assign('rightSide', $rightSide);

// 	$SMARTY->debugging = true;
//	$SMARTY->assign("success_message",  Message::getMessages(Message::TYPE_SUCCESS));
//	$SMARTY->assign("error_message",Message::getMessages(Message::TYPE_ERROR));
$SMARTY->assign("success_message", Message::getMessages(Message::TYPE_SUCCESS) . $success_message);
$SMARTY->assign("error_message", Message::getMessages(Message::TYPE_ERROR) . $error_message);
//	$SMARTY->assign("error_message",  array_merge((array)Message::getMessages(Message::TYPE_ERROR), (array)$error_message));
//	$SMARTY->assign("success_message",$success_message);
//	$SMARTY->assign("error_message",$error_message);

$SMARTY->assign("par_1", $par_1);
$SMARTY->assign("par_2", $par_2);
$SMARTY->assign("par_3", $par_3);
$SMARTY->assign("par_4", $par_4);
$SMARTY->assign("par_5", $par_5);

$SMARTY->assign("par_1_main", $par_1_main);
$SMARTY->assign("par_2_main", $par_2_main);
$SMARTY->assign("par_3_main", $par_3_main);
$SMARTY->assign("par_4_main", $par_4_main);
$SMARTY->assign("par_5_main", $par_5_main);

$SMARTY->assign("category_delimiter", CATEGORY_DELIMITER);
$SMARTY->assign("p_special_order_sleva", $p_special_order_sleva);

$SMARTY->assign("page_style", "/templates/$par_1/page_style.css");
$SMARTY->assign("page_script", "/templates/$par_1/page_script.js");

$SMARTY->assign("current_url", $_SERVER["REQUEST_URI"]);

$SMARTY->assign("pg", $pg);
$SMARTY->assign("pg_count", $pg_count);
$SMARTY->assign("page_counter_start", $page_counter_start);
$SMARTY->assign("p_bottom_menu", $p_bottom_menu);
$SMARTY->assign("p_user_orders", $p_user_orders);

$SMARTY->assign("p_materialy", $p_materialy);

$SMARTY->assign("zobrazit", $zobrazit);
$SMARTY->assign("p_sort_by", $p_sort_by);
$SMARTY->assign("sort_by", $sort_by);

$SMARTY->assign("p_shop_limits", $p_shop_limits);
$SMARTY->assign("shop_limit", $limit);


$SMARTY->assign("p_cart_detail", $p_cart_detail);
$SMARTY->assign("s_dod_termin", $s_dod_termin);

$SMARTY->assign("page_content", $page_content);
$SMARTY->assign("p_content_menu", $p_content_menu);
$SMARTY->assign("p_content_selected", $p_content_selected);

$SMARTY->assign("p_content", $p_content);
$SMARTY->assign("p_selected_content_category_detail", $p_selected_content_category_detail);
$SMARTY->assign("p_selected_content_category_main_detail", $p_selected_content_category_main_detail);
$SMARTY->assign("p_selected_content_category_subcategories", $p_selected_content_category_subcategories);
$SMARTY->assign("p_selected_content_category_main_subcategories", $p_selected_content_category_main_subcategories);


$SMARTY->assign("p_urceni_enums", $p_urceni_enums);
$SMARTY->assign("p_tvar_enums", $p_tvar_enums);
$SMARTY->assign("p_pohon_enums", $p_pohon_enums);
$SMARTY->assign("p_pouzdro_enums", $p_pouzdro_enums);
$SMARTY->assign("p_reminek_enums", $p_reminek_enums);
$SMARTY->assign("p_cena_enums", $p_cena_enums);

$SMARTY->assign("p_articles", $p_articles);

$SMARTY->assign("meta_title", $meta_title);
$SMARTY->assign("meta_description", $meta_description);
$SMARTY->assign("meta_keywords", $meta_keywords);


//$SMARTY->assign("filtr", $_REQUEST["filtr"]);
$SMARTY->assign("filtr", $search_condition);
//$SMARTY->assign("HOST",HOST);
//$SMARTY->assign("ID_DELIMITER",ID_DELIMITER);
//$SMARTY->assign("IMG_DIR",IMG_DIR);
//$SMARTY->assign("IMG_CONTENT",IMG_CONTENT);
//$SMARTY->assign("NUMBER_OF_UPLOAD_IMAGES",NUMBER_OF_UPLOAD_IMAGES);
//$SMARTY->assign("CONTENT_IMG_DIR_SMARTY",CONTENT_IMG_DIR_SMARTY);

$SMARTY->assign("language", $language);

$SMARTY->assign("currency", $currency);
$SMARTY->assign("kurzy", $kurzy);

$SMARTY->assign("errors", $errors);
$SMARTY->assign("display_errors", $display_errors);

$SMARTY->assign("order_errors", $order_errors);
$SMARTY->assign("order_display_errors", $order_display_errors);


$SMARTY->assign('lang', $lang);
$SMARTY->assign('id_item', $id_item);
//print_p($USER);
$SMARTY->assign('user', $USER->data);
$SMARTY->assign("p_cart_status", $p_cart_status);
$SMARTY->assign("p_cart_item_status", $p_cart_item_status);
$SMARTY->assign("s_cart_status", $s_cart_status);
$SMARTY->assign("s_cart_item_status", $s_cart_item_status);
$SMARTY->assign('p_alpha', explode(",", $alphabet));

$SMARTY->assign("p_item", $p_item);
$SMARTY->assign("category", $category);
$SMARTY->assign("p_news", $p_news);


if ($par_1 != "admin") { //resime front end
    $SMARTY->assign("page_middle", $page_middle);

    $SMARTY->assign("p_top_articles", $p_top_articles);
    $SMARTY->assign("p_articles", $p_articles);
    $SMARTY->assign("p_menu_manufacturers", $p_menu_manufacturers);
    $SMARTY->assign("p_manufacturers", $p_manufacturers);
    $SMARTY->assign("p_main_categories", $p_main_categories);
    $SMARTY->assign("p_znacka_categories", $p_znacka_categories);
    $SMARTY->assign("p_main_sub_categories", $p_main_sub_categories);

    $SMARTY->assign("final_category_id", $final_category_id);
    $SMARTY->assign("category_last_index", $category_last_index);
    $SMARTY->assign("p_categories_names", $p_categories_names);

    $SMARTY->assign("do_search", $_REQUEST["do_search"]);
    $SMARTY->assign("search_condition", $search_condition);

    $SMARTY->assign("selected_category", $selected_category);
    $SMARTY->assign("selected_category_id", $selected_category_id);
    $SMARTY->assign("selected_category_name", $selected_category_name);
    $SMARTY->assign("selected_sub_category", $selected_sub_category);
    $SMARTY->assign("selected_sub_category_id", $selected_sub_category_id);
    $SMARTY->assign("selected_sub_category_name", $selected_sub_category_name);

    $SMARTY->assign("selected_manufacturer", $selected_manufacturer);
    $SMARTY->assign("selected_manufacturer_id", $selected_manufacturer_id);
    $SMARTY->assign("selected_manufacturer_name", $selected_manufacturer_name);

    $SMARTY->assign("p_items_result", $p_items_result);
    $SMARTY->assign("p_items_result_homepage", $p_items_result_homepage);
    $SMARTY->assign("p_items_result_nejprodavanejsi", $p_items_result_nejprodavanejsi);
    $SMARTY->assign("p_items_result_top_katalog", $p_items_result_top_katalog);

    $SMARTY->assign("p_topten_result", $p_topten_result);

    $SMARTY->assign("p_user", $p_user);

    $SMARTY->assign("menu_type", $menu_type);
    $SMARTY->assign("selected_show_type", $selected_show_type);

    $SMARTY->assign("lnk_base", $lnk_base);
    $SMARTY->assign("id_item", $id_item);

    $SMARTY->assign("p_transports", $p_transports);
    $SMARTY->assign("s_transports", $s_transports);

    $SMARTY->assign("s_payment_types", $s_payment_types);
    $SMARTY->assign("p_payments", $p_payments);
    $SMARTY->assign("s_payments", $s_payments);

    $SMARTY->assign("p_transport_map_payment", $p_transport_map_payment);


    $SMARTY->assign("p_cart", $p_cart);
} else { // resime admin
    $SMARTY->assign("p_raw_codes", $p_raw_codes);
    $SMARTY->assign('s_prop_type', $s_prop_type);
    $SMARTY->assign('s_prop_search', $s_prop_search);
    $SMARTY->assign('s_prop_inherit', $s_prop_inherit);
    $SMARTY->assign('s_prop_visible', $s_prop_visible);
    $SMARTY->assign('s_visible', $s_visible);
    $SMARTY->assign('s_prop_lang_depending', $s_prop_lang_depending);
    $SMARTY->assign('s_prop_enumerated', $s_prop_enumerated);
    $SMARTY->assign('s_prop_required', $s_prop_required);
    $SMARTY->assign('s_prop_must_fill', $s_prop_must_fill);
    $SMARTY->assign('s_yes_no', $s_yes_no);
    $SMARTY->assign('s_prop_sort', $s_prop_sort);
    $SMARTY->assign("p_items", $p_items);
}

$php_constants = get_defined_constants(true); // posleme do smartu php konstanty
foreach ($php_constants["user"] AS $key => $value) {
    $SMARTY->assign($key, $value);
}
?>