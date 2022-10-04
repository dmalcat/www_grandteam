<?php
$forceAjax = true;
require_once PROJECT_DIR . 'res/init.php';
//

$id = $_POST['id'];
$CART = new Cart($DB, $USER->data["id_user"], "s3n_");
$CART->set_payment($id);
unset($CART);
include "kosik.php";
$unit = $p_cart['PRICE_UNIT'];
echo json_encode(array(
    'state' => true,
    'cenaZaDopravu' => priceFormat($p_cart['TRANSPORT_SUM_VAT']),
    'kuponovaSleva' => priceFormat($p_cart['kuponovaSleva']),
    'celkovaCena' => priceFormat($dbCart->getSum(true)),
    'celkovaCenaBezDPH' => priceFormat($dbCart->getSum()),
));
?>
