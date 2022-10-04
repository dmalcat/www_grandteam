<?php
$forceAjax = true;
require_once PROJECT_DIR . 'res/init.php';

$id = $_POST['id'];
//$dbCart = dbCart::getById($id);
$CART = new Cart($DB, $USER->data["id_user"], "s3n_");
$dbCart = dbCart::getById($CART->id_cart);
$dbCart->setTransport($id);
$dbCart->setPayment($dbCart->getTransport()->getDefaultPayment()->id);

unset($CART);
include "kosik.php";
$unit = $p_cart['PRICE_UNIT'];
$platby = $dbCart->getTransport()->getPayments('1');

$htmlPlatby = "";

foreach ($platby as $dbPayment) {
    if ($dbPayment->id == $dbCart->getPayment()->id) {
        $htmlPlatby .= '<label><input type="radio" onclick="nastavZpusobPlatby(this.value)" checked="checked" value="' . $dbPayment->id . '" name="id_payment">' . $dbPayment->name . '</label><br />';
    } else {
        $htmlPlatby .= '<label><input type="radio" onclick="nastavZpusobPlatby(this.value)" value="' . $dbPayment->id . '" name="id_payment">' . $dbPayment->name . '</label><br />';
    }
}

echo json_encode(array(
    'state' => true,
    'platby' => $htmlPlatby,
    'cenaZaDopravu' => priceFormat($p_cart['TRANSPORT_SUM_VAT']),
    'kuponovaSleva' => priceFormat($p_cart['kuponovaSleva']),
    'celkovaCena' => priceFormat($dbCart->getSum(true)),
    'celkovaCenaBezDPH' => priceFormat($dbCart->getSum()),
));
?>
