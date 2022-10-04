<?php

if (isset($_POST["do_send_vzkaz"])) {

    require_once(PROJECT_DIR . 'res/recaptchalib.php');

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => array(
            'secret' => "6LeU1HMUAAAAAF3QYvOofPdx8yX9GazKOltoSLDj",
            'response' => $_POST['g-recaptcha-response']
        )
    ));
    $resp = curl_exec($curl);
    curl_close($curl);
    if (strpos($resp, '"success": true') !== FALSE) {
        $m = new MailSend(INFO_EMAIL);
        $m->sendVzkaz($_POST["kontakt"], $_POST["itemName"]);
        $m = new MailSend("info@3nicom.cz");
        $m->sendVzkaz($_POST["kontakt"], $_POST["itemName"]);
        Message::success(Translate::translate("Váš vzkaz byl odeslán. Děkujeme."), "");
    } else {
        Message::error("Kontrolní kód neodpovídá");
    }
}
?>