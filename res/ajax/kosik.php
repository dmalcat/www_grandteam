<?php
$forceAjax = true;
require_once PROJECT_DIR . 'res/init.php';

require "kosik.php";
$pocet = array_key_exists('pocet', $_POST) ? $_POST['pocet'] : null;
if (is_numeric($pocet) && $pocet >= 0) {
    if (isset($_POST['id'])) {
        $CART->set_item_count($_POST['id'], $_POST['pocet']);
    }
}
require "kosik.php";
echo json_encode($p_cart);
?>
