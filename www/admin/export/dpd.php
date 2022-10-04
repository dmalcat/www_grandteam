<?php 
		
/*		
		
		
		
		
		Spolecnost odesilatele
		Jmeno odesilatele
		Adresa odesilatele 1
		Stat odesilatele
		PSC odesilatele
		Mesto odesilatele
		Tel. odesilatele
		Email odesilatele
		Pocet baliku
		Shop spolecnost
		Shop name*/
		
// 		print_p($p_cart["DPD_CUSTOMER"]);
// 		die();

		$predvolba = $p_cart["DPD"]["Currency"] == "EUR" ? "+421#" : "+420#";

		if($p_cart["DPD"]["Currency"] == "EUR") {
			$identifikace_banky = "8330";
			$nazev_banky = "Fio banka";
			$bankovni_ucet = "2200058521";
			$majitel_uctu = "Vladimír Fučík";
		} else {
			$identifikace_banky = "2010";
			$nazev_banky = "Fio banka";
			$bankovni_ucet = "2600043695";
			$majitel_uctu = "Vladimír Fučík";
		}


		$data = array(
			"Type" => $p_cart["DPD"]["PackageType"],		//Typ baliku
			"Name" => $p_cart["DPD_CUSTOMER"]["ContactPerson"],	//Jmeno
			"Address 1" =>  $p_cart["DPD_CUSTOMER"]["RecStreet"]." ".$p_cart["DPD_CUSTOMER"]["RecStreetNr"],	//Adresa 1 - Ulice a cislo
			"Country" =>  $p_cart["DPD_CUSTOMER"]["RecCountry"],	//Stat
			"Postcode" =>  $p_cart["DPD_CUSTOMER"]["RecZipCode"],	//PSČ
			"Town" =>  $p_cart["DPD_CUSTOMER"]["RecCity"],	//Mesto
			"COD amount" =>  $p_cart["DPD"]["DobirkaPrice"],	//Doberecna castka
			"Currency" =>  $p_cart["DPD"]["Currency"],	//Měna dobírky
			"Referenznr. 1" => $p_cart["DPD"]["Varsymb"],	//Variabilní symbol
			"Company" => $p_cart["DPD_CUSTOMER"]["RecCompany"],		//Spolecnost
			"Kontakt" => $p_cart["DPD"]["ContactPerson"],		//Kontakt
			"Tel." =>  $p_cart["DPD"]["ContactPhone"],		//Telefon
			"Spolecnost odesilatele" => "Vladimír Fučík - VFFOTO",
			"Jmeno odesilatele" => "Vladimír Fučík",
			"Adresa odesilatele 1" => "Sadová 1469",
			"Stat odesilatele" => "CZ",
			"PSC odesilatele" => "396 01",
			"Mesto odesilatele" => "Humpolec",
			"Tel. odesilatele" => "+420 731 474 681",
			"Email odesilatele" => "info@vffoto.com",
			"Nr. of parcels" =>  $p_cart["DPD"]["ItemsCount"],	//Počet kusů
			"Shop spolecnost" => "",
			"Shop name" => "",
			"Zpusob platby" => "Bar",

			"Identifikace banky" => $identifikace_banky,
			"Nazev banky" => $nazev_banky,
			"bankovni ucet" => $bankovni_ucet,
			"majitel uctu" => $majitel_uctu,

			"Proaktivni_1_svoz" => "S;".$predvolba.$p_cart["DPD_CUSTOMER"]["ContactPhone"].";1;CZ",
			"Proaktivni_2_nedoruceno" => "S;".$predvolba.$p_cart["DPD_CUSTOMER"]["ContactPhone"].";2;CZ",
		);
// 			"Weight (kg)" => "",
// 			"Referenznr. 2" =>  "",
// 			"attention of" => "",
// 			"Address 2	" =>  "",
// 			"Area" =>  "",
// 			"Ref. (address)" =>  "",
// 			"Collection Type" =>  "",
// 			"Purpose" =>  $p_cart["DPD"]["PrintMessage"],	//Poznámka pro tisk na etiketě
// 		array_push($data,$p_cart["DPD"]["InsertBack"] == "on" ? 1 : 0);	//Vložit zpětnou zásilku
// 		array_push($data,$p_cart["DPD"]["Insurance"]);	//Připojistit na
// 		array_push($data,$p_cart["DPD"]["ContactSms"]);	//Telefon pro SMS
// 		array_push($data,$p_cart["DPD"]["ContactEmail"]);	//E-mail
// 		array_push($data,$p_cart["DPD"]["CustomerReference"]);	//Zákaznické reference
// 		array_push($data,$p_cart["DPD"]["Content"]);	//Obsah - jen pro export
// 		array_push($data,$p_cart["DPD"]["ItemsPrice"]);	//Cena zboží - jen pro export
// 		array_push($data,$p_cart["DPD"]["DeliveryDate"]);	//Datum doručení - Datum a čas doručení může být nastaven pouze u zásilek typu "Soukromý balík" a "Soukromý balík - dobírka".
// 		array_push($data,$p_cart["DPD"]["DeliveryTime"]);	//Čas doručení [1,2] => [Den,Vecer] - Datum a čas doručení může být nastaven pouze u zásilek typu "Soukromý balík" a "Soukromý balík - dobírka".
	
	foreach($data AS $key => $value) {
		$data[$key] = iconv("utf-8", "windows-1250", $value);
	}

	$filename = "export_dpd_".$id_cart.".csv";
	$f = fopen(PROJECT_DIR."export/dpd/".$filename, 'w');
	foreach($data AS $key => $value) {
		if(!strpos($data["Type"], "PRO") && ($key == "Proaktivni_1_svoz" || $key == "Proaktivni_2_nedoruceno")) continue; // proaktivni sluzbu resime jen v typ baliku private
		fwrite($f,$value.";");
	}

//     fputcsv($f, array_values($data),";","");
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
	    readfile(PROJECT_DIR."export/dpd/".$filename);
	}
    exit;
    
    
    //		ALTER TABLE `s3n_cart` ADD `dpd_RecCompany` VARCHAR(200) NOT NULL, ADD `dpd_RecStreet` VARCHAR(200) NOT NULL, ADD `dpd_RecStreetNr` VARCHAR(50) NOT NULL, ADD `dpd_RecCity` VARCHAR(50) NOT NULL, ADD `dpd_RecZipCode` VARCHAR(20) NOT NULL, ADD `dpd_RecCountry` VARCHAR(50) NOT NULL, ADD `dpd_PackageType` VARCHAR(5) NOT NULL, ADD `dpd_InsertBack` VARCHAR(5) NOT NULL, ADD `dpd_ItemsCount` VARCHAR(5) NOT NULL, ADD `dpd_Insurance` VARCHAR(20) NOT NULL, ADD `dpd_DobirkaPrice` VARCHAR(20) NOT NULL, ADD `dpd_Currency` VARCHAR(5) NOT NULL, ADD `dpd_Varsymb` VARCHAR(50) NOT NULL, ADD `dpd_ContactPerson` VARCHAR(200) NOT NULL, ADD `dpd_ContactPhone` VARCHAR(50) NOT NULL, ADD `dpd_ContactSms` VARCHAR(50) NOT NULL, ADD `dpd_ContactEmail` VARCHAR(50) NOT NULL, ADD `dpd_Content` VARCHAR(255) NOT NULL, ADD `dpd_ItemsPrice` VARCHAR(20) NOT NULL, ADD `dpd_PrintMessage` VARCHAR(255) NOT NULL, ADD `dpd_CustomerReference` VARCHAR(50) NOT NULL, ADD `dpd_DeliveryDate` VARCHAR(20) NOT NULL, ADD `dpd_DeliveryTime` VARCHAR(5) NOT NULL;
    
?>