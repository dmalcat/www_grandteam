<?php

$fulltext = $_REQUEST['search'];
$filter = new filterClass('adminVyhledavani');
$filter->addPropertyFilter('nazev', 'nazev', "@table.value LIKE '%{$fulltext}%'");
$filter->addPropertyFilter('kod', 'kod', "@table.value LIKE '%{$fulltext}%'");
$filter->onlyVisible(false);
$pager = $filter->getPager();
$return = array();
if (count($pager->getItems())) {
	foreach ($pager AS $item) {
//					$info = $SHOP->get_item_preview($item->id_item);
//		            $return[] = "<a id='vyhledani_$item->id_item' href='/admin/products/_id_{$item->id_item}//'>{$info['nazev']['PROP_VALUE']}</a>";
		$return[] = array(
			"kod" => Shop::get_item_property_string_value($item->id_item, "kod"),
			"nazev" => Shop::get_item_property_string_value($item->id_item, "nazev"),
			"nazev_sk" => Shop::get_item_property_string_value($item->id_item, "nazev_sk"),
			"id_item" => $item->id_item,
		);
	}
	echo json_encode($return);
} else {
	echo "Nenalezen žádný záznam";
}
?>
