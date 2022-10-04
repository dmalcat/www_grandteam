<?php

$SHOP = new Shop($DB, 1);

$fulltext = $_REQUEST['fulltext'];
$filter = new filterClass('adminVyhledavani');
$filter->addPropertyFilter('nazev', 'nazev', "@table.value LIKE '%{$fulltext}%'");
$filter->onlyVisible(false);
$pager = $filter->getPager();
$return = array();
if (count($pager->getItems())) {
	foreach ($pager AS $item) {
		$info = $SHOP->get_item_preview($item->id_item);
		$return[] = "<a id='vyhledani_$item->id_item' href='/admin/produkty/_id_$item->id_item'>{$info['nazev']['PROP_VALUE']}</a>";
	}
	echo implode('<br />', $return);
} else {
	echo "Nenalezen žádný záznam";
}
?>
