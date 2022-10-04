<?php

echo json_encode(array(
		'result' => dbCartItem::getById($_GET['id'])->setStatus($_GET['status']), 
		'class' => $p_cart_item_status[$_GET['status']]['class'])
	);

?>
