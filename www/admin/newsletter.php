<?php

/* @var $USER User */

$db = $DB;
if (count($_POST)) {

	/* @var $SMARTY Smarty */
	$content = $SMARTY->fetch("admin/emails/newsletter.tpl");

	$chyby = array();
	if ($_POST['predmet'] == "") {
		$chyby[] = 'Zadejte predmet';
	}

//	if (!$content) {
//		$chyby[] = 'Zadejte text';
//	}

	$maily = array();

	switch ($_POST["rozeslatKomu"]) {
		case "extra":
			$extraMaily = $_POST['extraMaily'];
			$extraMaily = explode(';', $extraMaily);
			foreach ($extraMaily as $nazev) {
				if ($nazev) {
					$maily[] = $nazev;
				}
			}
			break;
		case "vsem":
			$maily = dbUser::getZpravodajEmails();
			$extraMaily = $_POST['extraMaily'];
			$extraMaily = explode(';', $extraMaily);
			foreach ($extraMaily as $nazev) {
				if ($nazev) {
					$maily[] = $nazev;
				}
			}
			break;
	}


	if ($_POST["doSendTest"]) {
		$maily = array();
		$maily[] = "pulkrabek@3nicom.cz";
	}

//	print_p($maily); die();


	if (!count($maily)) {
		$chyby[] = 'Nebyl zadán žádný mail';
	}

	if (count($chyby)) {
		$vybranyLetak = new stdClass();
		$vybranyLetak->predmet = $_POST['predmet'];
		$vybranyLetak->text_1 = $_POST['text_1'];
		$vybranyLetak->text_2 = $_POST['text_2'];
		$vybranyLetak->rozeslatKomu = $_POST['rozeslatKomu'];
		$vybranyLetak->extraMaily = $_POST['extraMaily'];
		$SMARTY->assign('newsletterVysledek', implode('<br />', $chyby));
		Message::error(explode("<br/>", $chyby));
	} else {
		$from = NEWSLETTER_EMAIL_FROM;

		require_once('Mail.php');
		require_once('Mail/mime.php');




		foreach ($maily as $nazev) {

			$mime = new Mail_mime("\n");
			$mail = & Mail::factory('mail');

			$params['head_encoding'] = 'base64';
			$params['text_encoding'] = 'base64';
			$params['html_encoding'] = 'base64';
			$params['head_charset'] = 'UTF-8';
			$params['text_charset'] = 'UTF-8';
			$params['html_charset'] = 'UTF-8';

			$html = '
                <html>
                    <head>
                        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
                        <title>' . $_POST['predmet'] . '</title>
                    </head>
                        <body style="font-family: Arial">
                        <div>
                          <div style="background-color: #FFF; width: 700px">
                              <div style="margin-top: 10px; margin-bottom: 10px">' . $content . "</div>";

			$hdrs = array(
				'From' => NEWSLETTER_EMAIL_FROM,
				'Subject' => $_POST['predmet'],
				'Content-Type' => 'multipart/related;charset="UTF-8"',
				'Content-Transfer-Encoding' => '8bit'
			);

			$pripony = array(
				'jpeg' => 'jpeg',
				'jpg' => 'jpeg',
				'png' => 'png',
				'gif' => 'gif',
			);

			preg_match_all('/(\<img[^>]*\>)/i', $content, $matches);
			if (isset($matches[1])) {
				foreach ($matches[1] as $index => $tag) {
					preg_match_all('/src="([^"]*)"/i', $tag, $tagMatches);
					$cesta = $tagMatches[1][0];
					$celaCesta = PROJECT_DIR . $cesta;
					$celaCesta = str_replace('%20', ' ', $celaCesta);
					if (file_exists($celaCesta)) {
						$info = pathinfo($celaCesta);
						$pripona = array_key_exists('extension', $info) ? $info['extension'] : '';
						if (array_key_exists($pripona, $pripony)) {
							$mime->addHTMLImage($celaCesta, 'image/' . $pripony[$pripona], $cesta, true);
						}
					}
				}
			}



			$html .= '
              <div style="padding-top: 10px; padding-bottom: 10px;">' . $_POST['text_2'] . '</div>
              </div>
              </div>
              </body>
            </head>
        </html>';

			$html_replaced = str_replace("#email#", $nazev, $html);
			$mime->setHTMLBody($html_replaced);
			$body = $mime->get($params);
			$hdrs = $mime->headers($hdrs);
			$mail->send($nazev, $hdrs, $body);
		}

		$db->query("INSERT INTO s3n_newsletters(subject, text_1, text_2, send_type, extra_mails, products, created ) values('{$_POST['predmet']}', '{$content}', '{$_POST['text_2']}', '{$_POST['rozeslatKomu']}', '{$_POST['extraMaily']}', '$knihy', " . time() . ")");
		if ($_POST["doSend"]) { // pokud se finalne odesle zpravodaj, odznacime vybrane clanky
			dbI::query("UPDATE s3n_content_category SET zajimavosti = 0")->result();
		}


		$SMARTY->assign('newsletterVysledek', 'Odesláno');
	}
} else {
	$vybranyLetak = new stdClass();
	if (isset($par_3) && $par_3) {
		$letak = $db->getRow("SELECT * FROM s3n_newsletters WHERE id = $par_3");
		if ($letak) {
			$vybranyLetak->predmet = $letak->subject;
			$vybranyLetak->text_1 = $letak->text_1;
			$vybranyLetak->text_2 = $letak->text_2;
			$vybranyLetak->rozeslatKomu = $letak->send_type;
			$vybranyLetak->extraMaily = $letak->extra_mails;
			$produkty = $letak->products;
			$explode = explode('|', $produkty);
			$produkty = array();
			foreach ($explode as $id) {
				if ($id) {
					$detail = $SHOP->get_item_detail($id);
					$produkty[] = array('id' => $id, 'nazev' => $detail['nazev']['PROP_VALUE']);
				}
			}
			$vybranyLetak->vybraneProdukty = $produkty;
		}
	}
}


$SMARTY->assign('vybranyLetak', $vybranyLetak);

$odeslaneLetaky = $db->getAll("SELECT * FROM s3n_newsletters ORDER BY created DESC");
$SMARTY->assign('odeslaneLetaky', $odeslaneLetaky);


$page = "admin/sub_newsletter.tpl";

