<?php

class MailSend extends \PHPMailer\PHPMailer\PHPMailer {

    public function __construct($email, $emailname = null) {
        $this->AddAddress($email, $emailname);
//        $this->Encoding = "base64";
//      $this->charset = "ISO-8859-2";
//      $this->charset = "windows-1250";
        $this->CharSet = "UTF-8";
        $this->isHTML();
        $this->textstylefont = "";
        $this->textstyle = "";
    }

    public function sendVzkaz($data) {
        $this->From = $data["email"];
        $this->FromName = $data["email"];
//        $this->AddEmbeddedImage(PROJECT_DIR . "/images/logo.png", "logo", "logo.png");

        $this->Subject = "Dotaz z " . Registry::getDomainName();

//        $body = '<img alt=" " src="cid:logo">';
        $body = '';
        $body .= '<p style="' . $this->textstylefont . '">Jméno a příjmení: ' . $data["jmeno"] . '</p>';
        $body .= '<p style="' . $this->textstylefont . '">Telefon: ' . $data["telefon"] . '</p>';
        $body .= '<p style="' . $this->textstylefont . '">Email: ' . $data["email"] . '</p>';
        $body .= '<p style="' . $this->textstylefont . '">Článek: ' . $data["clanek"] . '</p>';
        $body .= '<p style="' . $this->textstylefont . '">Dotaz: ' . nl2br($data["vzkaz"]) . '</p>';
//		$body .= '<p style="' . $this->textstylefont . '">Team <a href="' . Registry::getDomain() . '">' . Registry::getDomainName() . '</a></p>';
        $this->Body = $body;
        $this->Send();
    }

}
