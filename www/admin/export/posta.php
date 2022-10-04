<?php

// 	print_p($p_cart["CP"]["typ_zasilky"]);
	if(strpos($p_cart["CP"]["typ_zasilky"], "-")) {
		list($p_cart["CP"]["typ_zasilky"], $doplnkovaSluzba) = explode("-",$p_cart["CP"]["typ_zasilky"]);
		$doplnkovaSluzba = "41+".$doplnkovaSluzba;

	}

//        if($p_cart["CP"]["typ_zasilky"] == "BB") {
//            $p_cart["CP"]["udana_cena"] = 900;
//            if($p_cart["ITEMS_SUM_VAT"] > 900) $p_cart["CP"]["udana_cena"] = 5000;
//        }



	if($p_cart["CP"]["dobirka"]) {
		if(!$doplnkovaSluzba) $doplnkovaSluzba = "41";
	}



	$data = array(
		'cp_cislo'				=> '',
			'cp_prijmeni_nazev'		=> $p_cart["CP_CUSTOMER"]["prijmeni_nazev"],
			'cp_jmeno'				=> $p_cart["CP_CUSTOMER"]["firma"] ? "" : $p_cart["CP_CUSTOMER"]["jmeno"] ,
		'cp_datum_narozeni'		=> '',
		'cp_doplnujici_udaje'	=> $p_cart["CP_CUSTOMER"]["firma"] ? $p_cart["CP_CUSTOMER"]["jmeno"] : "" ,
			'cp_subjekt'			=> $p_cart["CP_CUSTOMER"]["subjekt"],	// P podnikatel - jinak nic
			'cp_ic'					=> $p_cart["CP_CUSTOMER"]["ic"],
			'cp_dic'				=> $p_cart["CP_CUSTOMER"]["dic"],
			'cp_obec'				=> $p_cart["CP_CUSTOMER"]["obec"],
			'cp_ulice'				=> $p_cart["CP_CUSTOMER"]["ulice"],
			'cp_psc'				=> str_replace(" ","",$p_cart["CP_CUSTOMER"]["psc"]),
		'cp_cast_obce'			=> '',
			'cp_c_popisne'			=> $p_cart["CP_CUSTOMER"]["c_popisne"],
		'cp_stat'				=> '',
		'cp_c_orientacni'		=> '',
		'cp_predcisli'			=> '',
		'cp_ucet'				=> '',
		'cp_banka'				=> '',
			'cp_telefon'			=> $p_cart["CP_CUSTOMER"]["mobil"],
			'cp_mobil'				=> $p_cart["CP_CUSTOMER"]["telefon"],
			'cp_email'				=> $p_cart["CP_CUSTOMER"]["email"],
		'cp_id_zasilky'			=> '',
			'cp_udana_cena'			=> $p_cart["CP"]["udana_cena"],
			'cp_dobirka'			=> $p_cart["CP"]["dobirka"],
		'cp_vs_poukazka'		=> $p_cart["CP"]["vs_zasilka"],
		'cp_vyska'				=> '',
			'cp_typ_zasilky'		=> $p_cart["CP"]["typ_zasilky"],
			'cp_vs_zasilka'			=> $p_cart["CP"]["vs_zasilka"],
		'cp_mena_iso'			=> '',
			'cp_poznamka'			=> $p_cart["CP"]["poznamka"],
		'cp_sirka'				=> '',
			'cp_hmotnost'			=> $p_cart["CP"]["hmotnost"],
		'cp_doplnkova_sl'		=> $doplnkovaSluzba,
			'cp_pocet_vk'			=> '',
		'cp_delka'				=> ''

	);

//	print_p($data); die();
	foreach($data AS $key => $value) {
		$data[$key] = iconv("utf-8", "windows-1250", $value);
	}

	$filename = "export_posta_".$id_cart.".csv";
	$f = fopen(PROJECT_DIR."export/post/".$filename, 'w');
	foreach($data AS $key => $value) {
//		if(!strpos($data["Type"], "PRO") && ($key == "Proaktivni_1_svoz" || $key == "Proaktivni_2_nedoruceno")) continue; // proaktivni sluzbu resime jen v typ baliku private
		fwrite($f,$value.";");
	}

//    fputcsv($f, array_values($data),";","");
	fputcsv($f, array_values($data),";");
	fclose($f);

	if(true) {
	    header('Content-Description: File Transfer');
	    header("Content-type: text/xml");
	    header('Content-Disposition: attachment; filename='.$filename);
	    header('Content-Transfer-Encoding: binary');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	    header('Pragma: public');
	//    header('Content-Length: ' . strlen($filename));
	    ob_clean();
	    flush();
	    readfile(PROJECT_DIR."export/post/".$filename);
	}
    exit;











//ALTER TABLE `s3n_cart` ADD `cp_cislo` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_prijmeni_nazev` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_jmeno` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_datum_narozeni` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_doplnujici_udaje` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_subjekt` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_ic` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_dic` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_obec` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_ulice` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_psc` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_cast_obce` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_c_popisne` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_stat` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_c_orientacni` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_predcisli` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_ucet` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_banka` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_telefon` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_mobil` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_email` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_id_zasilky` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_typ_zasilky` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_hmotnost` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_udana_cena` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_vs_zasilka` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_doplnkova_sl` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_dobirka` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_mena_iso` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_pocet_vk` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_vs_poukazka` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_poznamka` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_vyska` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_sirka` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
//ADD `cp_delka` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ;







?>