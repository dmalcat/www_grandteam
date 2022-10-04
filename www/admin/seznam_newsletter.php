<?php

/* @var $USER User */

$db = $DB;
if (count($_POST)) {
	$chyby = array();
	if ($_POST['predmet'] == "") {
		$chyby[] = 'Zadejte predmet';
	}
	if ($_POST['text_1'] == "<br />") {
		$chyby[] = 'Zadejte text';
	}

	$maily = array();
	if ($_POST['rozeslatKomu'] == 'vsem') {
		$maily = $USER->get_users_emails(false);
	} elseif ($_POST['rozeslatKomu'] == 'registrovanym') {
		$maily = $USER->get_users_emails(true);
	}

	$extraMaily = $_POST['extraMaily'];
	$extraMaily = explode(';', $extraMaily);
	foreach ($extraMaily as $nazev) {
		if ($nazev) {
			$maily[] = $nazev;
		}
	}

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
		$produkty = array();
		foreach ($_POST['vybraneKnihy'] as $id) {
			if ($id) {
				$detail = $SHOP->get_item_detail($id);
				$produkty[] = array('id' => $id, 'nazev' => $detail['nazev']['PROP_VALUE']);
			}
		}
		$vybranyLetak->vybraneProdukty = $produkty;
		$SMARTY->assign('newsletterVysledek', implode('<br />', $chyby));
	} else {
		$from = SUMMARY_EMAIL_FROM;

		require_once('Mail.php');
		require_once('Mail/mime.php');
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
                        <title>Novinky</title>
                    </head>
                        <body style="font-family: Arial">
                        <div>
                          <div style="background-color: #FFF; width: 500px">
                              <div style="margin-top: 10px; margin-bottom: 10px">' . $_POST['text_1'] . "</div>";

		$hdrs = array(
			'From' => $from,
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

		preg_match_all('/(\<img[^>]*\>)/i', $_POST['text_1'] . ' ' . $_POST['text_2'], $matches);
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

		if (isset($_POST['vybraneKnihy']) && count($_POST['vybraneKnihy'])) {
			$vybraneProdukty = ($_POST['vybraneKnihy']);
			$pocetProduktu = count($vybraneProdukty);
			for ($i = 0; $i < $pocetProduktu; $i = $i + 2) {
				$dvojice[$i] = array_slice($vybraneProdukty, $i, 2);
			}

			$html .= "<div style='float: left;
                                  width: 100%;
                                  padding-left: 3px;
                                  position: relative '>";

			$mime->addHTMLImage(PROJECT_DIR . '/images/pridat-do-kosiku.jpg', 'image/jpeg', '/images/pridat-do-kosiku.jpg', true);

			$html .= '<table style="width: 100%;" border="0" cellspacing="0" cellpadding="5">';
			foreach ($dvojice as $dvojka) {
				$prvniInfo = $SHOP->get_item_detail($dvojka[0]);
				$mime->addHTMLImage(PROJECT_DIR . $prvniInfo['obrazek1']['PROP_VALUE']['email_url'], 'image/jpeg', $prvniInfo['obrazek1']['PROP_VALUE']['email_url'], true);

				$druheInfo = null;
				if (isset($dvojka[1])) {
					$druheInfo = $SHOP->get_item_detail($dvojka[1]);
					$mime->addHTMLImage(PROJECT_DIR . $druheInfo['obrazek1']['PROP_VALUE']['email_url'], 'image/jpeg', $druheInfo['obrazek1']['PROP_VALUE']['email_url'], true);
				}
				$html .= "<tr>";
				$html .= "<td style='text-align: center'>";
				$html .= "<a href='" . HOST . "/{$prvniInfo['INFO']->seoname}/'>";
				$html .= "<img border='0' src='{$prvniInfo['obrazek1']['PROP_VALUE']['email_url']}' alt='{$prvniInfo['INFO']->seoname}' />";
				$html .= "</a>";
				$html .= "</td>";
				$html .= "<td style='border-right:1px solid #999999; font-size: 10px; vertical-align: top; padding-left: 5px;'>
                         <a style='font-size: 12px; color: #577530; font-weight: bold;' href='" . HOST . "/{$prvniInfo['INFO']->seoname}/'>{$prvniInfo['INFO']->basename}</a>
                         <br />
                         <span style='color: #999999; font-style: italic; '>{$prvniInfo['INFO']->manufacturer->firma}</span><br />
                         <br />
                         <span style='color: #999999; font-weight: bold'>EAN: </span><span style='color: #999999'>{$prvniInfo['ean']['PROP_VALUE']}</span><br />
                         <span style='color: #999999; font-weight: bold'>Vydavatel: </span><span style='color: #999999'>{$prvniInfo['INFO']->IN_CATEGORIES['manufacturer'][0]->name}</span><br />
                         <span style='color: #999999; font-weight: bold'>Počet stran: </span><span style='color: #999999'>{$prvniInfo['pocet_stran']['PROP_VALUE']}</span><br />
                         </td>";
				$html .= "</td>";
				if ($druheInfo) {
					$html .= "<td style='text-align: center'>";
					$html .= "<a href='" . HOST . "/{$druheInfo['INFO']->seoname}/'>";
					$html .= "<img border='0' src='{$druheInfo['obrazek1']['PROP_VALUE']['email_url']}' alt='{$druheInfo['INFO']->seoname}' />";
					$html .= "</a>";
					$html .= "</td>";
					$html .= "<td style='font-size: 10px; vertical-align: top; padding-left: 5px;'>
                              <a style='font-size: 12px; color: #577530; font-weight: bold;' href='" . HOST . "/{$druheInfo['INFO']->seoname}/'>{$druheInfo['INFO']->basename}</a>
                              <br />
                              <span style='color: #999999; font-style: italic; '>{$druheInfo['INFO']->manufacturer->firma}</span><br />
                              <br />
                              <span style='color: #999999; font-weight: bold'>EAN: </span><span style='color: #999999'>{$druheInfo['ean']['PROP_VALUE']}</span><br />
                              <span style='color: #999999; font-weight: bold'>Vydavatel: </span><span style='color: #999999'>{$druheInfo['INFO']->IN_CATEGORIES['manufacturer'][0]->name}</span><br />
                              <span style='color: #999999; font-weight: bold'>Počet stran: </span><span style='color: #999999'>{$druheInfo['pocet_stran']['PROP_VALUE']}</span><br />
                              </td>";
					$html .= "</td>";
				}
				$html .= "</tr>";
				$html .= "<tr>";
				$html .= "<td style='border-bottom: 1px solid #999999;'>&nbsp;</td>";
				$html .= "<td style='border-bottom: 1px solid #999999; border-right: 1px solid #999999; text-align:center; font-size:17px; font-weight:bold;'>" . round($prvniInfo['INFO']->price_vat) . ",- {$druheInfo['INFO']->price_unit}</td>";
				if ($druheInfo) {
					$html .= "<td style='border-bottom: 1px solid #999999;'>&nbsp;</td>";
					$html .= "<td style='border-bottom: 1px solid #999999; text-align:center; font-size:17px; font-weight:bold;'>" . round($druheInfo['INFO']->price_vat) . ",- {$druheInfo['INFO']->price_unit}</td>";
				}
				$html .= "</tr>";
			}
			$html .= '</table>';
			/*
			  foreach ($_POST['vybraneKnihy'] as $id) {
			  $border = '';
			  if(($pocetKnih % 2 == 0 && $i < $pocetKnih - 2) || ($pocetKnih % 2 == 1 && $i < $pocetKnih - 1)){
			  $border = 'border-bottom:1px solid #999999; ';
			  }
			  if($i++ % 2 == 0){
			  $border .= 'border-right:1px solid #999999;';
			  }
			  $style = 'padding: 5px; float: left; ' . $border . 'width: 46%; height: 150px;';
			  $html .= "<div style='$style' >";
			  $html .= '<table border="0" cellspacing="0" cellpadding="0">';
			  $html .= "<tr>";
			  $info = $SHOP->get_item_detail($id);
			  $html .= "<td style='vertical-align: top;'><div style='text-align:center; height: 128px; width: 100px; overflow: hidden;'><a href='".HOST."/{$info['INFO']->seoname}/'><img border='0' src='{$info['obrazek1']['PROP_VALUE']['email_url']}' alt='obálka' /></a></div></td>";
			  $html .= "<td style='font-size: 10px; vertical-align: top; padding-left: 5px;'>
			  <a style='font-size: 12px; color: #577530; font-weight: bold;' href='".HOST."/{$info['INFO']->seoname}/'>{$info['INFO']->basename}</a>
			  <br />
			  <span style='color: #999999; font-style: italic; '>{$info['INFO']->manufacturer->firma}</span><br />
			  <br />
			  <span style='color: #999999; font-weight: bold'>EAN: </span><span style='color: #999999'>{$info['ean']['PROP_VALUE']}</span><br />
			  <span style='color: #999999; font-weight: bold'>Vydavatel: </span><span style='color: #999999'>{$info['INFO']->IN_CATEGORIES['manufacturer'][0]->name}</span><br />
			  <span style='color: #999999; font-weight: bold'>Počet stran: </span><span style='color: #999999'>{$info['pocet_stran']['PROP_VALUE']}</span><br />
			  </td>";
			  $html .= "</tr>";
			  $html .= "<td>&nbsp;</td>";
			  $html .= "<td style='text-align:center; font-size:17px; font-weight:bold;'>" . round($info['bezna_cena']['PROP_VALUE']) . ",- Kč </td>";
			  $html .= "</tr>";
			  $html .= "</table>";
			  $html .= "</div>";
			  $mime -> addHTMLImage(PROJECT_DIR . $info['obrazek1']['PROP_VALUE']['email_url'], 'image/jpeg', $info['obrazek1']['PROP_VALUE']['email_url'], true);

			  } */

			$html .= "</div>";
			$html .= "<div style='clear: both'></div>";
		}

		$html .= '
              <div style="padding-top: 10px; padding-bottom: 10px;">' . $_POST['text_2'] . '</div>
              </div>
              </div>
              </body>
            </head>
        </html>';

		$mime->setHTMLBody($html);
		$body = $mime->get($params);
		$hdrs = $mime->headers($hdrs);

		foreach ($maily as $nazev) {
			$mail->send($nazev, $hdrs, $body);
		}

		$knihy = implode('|', $_POST['vybraneKnihy']);
		$db->query("INSERT INTO s3n_newsletters(subject, text_1, text_2, send_type, extra_mails, products, created )
                    values('{$_POST['predmet']}', '{$_POST['text_1']}', '{$_POST['text_2']}', '{$_POST['rozeslatKomu']}', '{$_POST['extraMaily']}', '$knihy', " . time() . ")");

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


$page = "admin/seznam_newsletter.tpl";

