<?php


//if(!$p_cart['SUM_VAT_CURRENCY']) $p_cart['SUM_VAT_CURRENCY'] = 1;
$p_cart['SUM_VAT'] = $p_cart['SUM_VAT_CURRENCY'];
//$p_cart['SUM_VAT'] = 30;

//print_p($p_cart["CURRENCY"]->id);

$telefon = $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['telefon']['PROP_VALUE'];

//$telefon = "+420604435800";

$telefon = str_replace(" ", "", $telefon);
$telefon = substr($telefon, -9);
//die($telefon);


//$telefon = str_replace("+", "", $telefon);
//$telefon = str_replace("420", "", $telefon);
//$telefon = str_replace("421", "", $telefon);
//$telefon = str_replace("09", "0", $telefon);

if($telefon[0] == 9) {	// da se predpokladat ze se jedna o slovaka ....
	$telefon = "+421" . $telefon;
} else {
	$telefon = "+420" . $telefon;
}

//die($telefon);
// $p_cart['SUM_VAT'] = str_replace(',','.',$p_cart['SUM_VAT']);

if($p_cart['ID_PAYMENT'] == 1 || $p_cart['ID_PAYMENT'] == 8 || $p_cart['ID_PAYMENT'] == 11) $dobirka = $p_cart['SUM_VAT'];



$data = array(
	1 => "", //Vyhrazeno
	2 => $p_cart['VARSYMB'], //Číslo objednávky	*
	3 => $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['dod_jmeno']['PROP_VALUE'] ? $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['dod_jmeno']['PROP_VALUE'] : $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['jmeno']['PROP_VALUE'], //Jméno	*
	4 => $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['dod_prijmeni']['PROP_VALUE'] ? $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['dod_prijmeni']['PROP_VALUE'] : $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['prijmeni']['PROP_VALUE'], //Příjmení	*
	5 => $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['dod_firma']['PROP_VALUE'] ? $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['dod_firma']['PROP_VALUE'] : $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['firma']['PROP_VALUE'], //Firma
	6 => $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['email']['PROP_VALUE'], //E-mail	* email, nebo mobil
	7 => $telefon, //Mobil	* email, nebo mobil
	8 => round($dobirka,2), //Dobírková částka
// 	9 => str_replace('.',',', round($p_cart['SUM_VAT'], 2)) , //Hodnota zásilky	*
	9 => str_replace(',','.', round($p_cart['SUM_VAT'], 2)) , //Hodnota zásilky	*
	10 => $p_cart['ID_ZASILKOVNA'], //Cílová pobočka	*
//	11 => "vffoto.com", //Doména e-shopu	*Je-li podáváno za více e-shopů (     vffoto.com )
//	12 => "", //Dodani postou Ulice - Je-li cílová pobočka pošta
//	13 => "", //Dodani postou Číslo domu - Je-li cílová pobočka pošta
//	14 => "", //Dodani postou Obec - Je-li cílová pobočka pošta
//	15 => "", //Dodani postou PSČ - Je-li cílová pobočka pošta
);

if($p_cart["ID_TRANSPORT"] == 10 || $p_cart["ID_TRANSPORT"] == 11 ) {	// SK posta
	$adresa = $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['dod_adresa']['PROP_VALUE'];
	if(!$adresa) $adresa = $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['adresa']['PROP_VALUE'];
	$pAdresa = explode(" ", $adresa);
	for($i=0; $i<count($pAdresa)-1; $i++) {
		$ulice .= $pAdresa[$i] . " ";
	}
//	print_p($pAdresa);
	$data["10"] = 16;
	$data["11"] = 'vffoto.com';
	$data["12"] = trim($ulice);
	$data["13"] = $pAdresa[count($pAdresa)-1];
	$data["14"] = $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['dod_mesto']['PROP_VALUE'] ? $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['dod_mesto']['PROP_VALUE'] : $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['mesto']['PROP_VALUE'];
	$data["15"] = $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['dod_psc']['PROP_VALUE'] ? $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['dod_psc']['PROP_VALUE'] : $p_cart['CUSTOMER_COMPACT']['PROPERTIES']['psc']['PROP_VALUE'];
//	print_p($data); die();
}

//print_p( array_values($data), "data");

$filename = "export_zasilkovna_" . $id_cart . ".csv";
$f = fopen(PROJECT_DIR . "export/zasilkovna/" . $filename, 'w');
	foreach($data AS $key => $value) {
////		if(!strpos($data["Type"], "PRO") && ($key == "Proaktivni_1_svoz" || $key == "Proaktivni_2_nedoruceno")) continue; // proaktivni sluzbu resime jen v typ baliku private
		fwrite($f,$value.";");
	}

//fputcsv($f, array_values($data), ";", "");
//fputcsv($f, $data, ";", "");
fclose($f);

if (true) {
	header('Content-Description: File Transfer');
	header("Content-type: text/plain");
	header('Content-Disposition: attachment; filename=' . $filename);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	//    header('Content-Length: ' . strlen($filename));
	ob_clean();
	flush();
	readfile(PROJECT_DIR . "export/zasilkovna/" . $filename);
}
exit;
?>