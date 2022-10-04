<?php 
	$xmlstr = '<?xml version="1.0" encoding="utf-8" standalone="yes"?><data></data>';
	$XML = new SimpleXMLElement($xmlstr);
	
	for($i = 0; $i < 1 ; $i++) {
		$dataItem = $XML->addChild("dataitem");
		
		$dataItem ->addChild("RecCompany",$p_cart["PPL_CUSTOMER"]["RecCompany"]);	//Název firmy 
		$dataItem ->addChild("RecStreet",$p_cart["PPL_CUSTOMER"]["RecStreet"]);	//Ulice
		$dataItem ->addChild("RecStreetNr",$p_cart["PPL_CUSTOMER"]["RecStreetNr"]);	//Číslo domu
		$dataItem ->addChild("RecCity",$p_cart["PPL_CUSTOMER"]["RecCity"]);	//Město
		$dataItem ->addChild("RecZipCode",$p_cart["PPL_CUSTOMER"]["RecZipCode"]);	//PSČ
		$dataItem ->addChild("RecCountry",$p_cart["PPL_CUSTOMER"]["RecCountry"]);	//Země

		$dataItem ->addChild("PackageType",$p_cart["PPL"]["PackageType"]);	//Typ zásilky
		$dataItem ->addChild("InsertBack",$p_cart["PPL"]["InsertBack"] == "on" ? 1 : 0);	//Vložit zpětnou zásilku
		
		$dataItem ->addChild("ItemsCount",$p_cart["PPL"]["ItemsCount"]);	//Počet kusů
		$dataItem ->addChild("Insurance",$p_cart["PPL"]["Insurance"]);	//Připojistit na
		$dataItem ->addChild("DobirkaPrice",$p_cart["PPL"]["DobirkaPrice"]);	//Dobírková částka
		$dataItem ->addChild("Currency",$p_cart["PPL"]["Currency"]);	//Měna dobírky
		$dataItem ->addChild("Varsymb",$p_cart["PPL"]["Varsymb"]);	//Variabilní symbol
		$dataItem ->addChild("ContactPerson",$p_cart["PPL"]["ContactPerson"]);	//Kontaktní osoba
		$dataItem ->addChild("ContactPhone",$p_cart["PPL"]["ContactPhone"]);	//Telefon
		$dataItem ->addChild("ContactSms",$p_cart["PPL"]["ContactSms"]);	//Telefon pro SMS
		$dataItem ->addChild("ContactEmail",$p_cart["PPL"]["ContactEmail"]);	//E-mail
		$dataItem ->addChild("PrintMessage",$p_cart["PPL"]["PrintMessage"]);	//Poznámka pro tisk na etiketě
		$dataItem ->addChild("CustomerReference",$p_cart["PPL"]["CustomerReference"]);	//Zákaznické reference

		$dataItem ->addChild("Content",$p_cart["PPL"]["Content"]);	//Obsah - jen pro export
		$dataItem ->addChild("ItemsPrice",$p_cart["PPL"]["ItemsPrice"]);	//Cena zboží - jen pro export
		$dataItem ->addChild("DeliveryDate",$p_cart["PPL"]["DeliveryDate"]);	//Datum doručení - Datum a čas doručení může být nastaven pouze u zásilek typu "Soukromý balík" a "Soukromý balík - dobírka".
		$dataItem ->addChild("DeliveryTime",$p_cart["PPL"]["DeliveryTime"]);	//Čas doručení [1,2] => [Den,Vecer] - Datum a čas doručení může být nastaven pouze u zásilek typu "Soukromý balík" a "Soukromý balík - dobírka".
	}
	
	$filename = "export_ppl_".$id_cart.".xml";
	$f = fopen(PROJECT_DIR."export/ppl/".$filename, 'w');
	fwrite($f,$XML->asXML());
	fclose($f);
	
//	echo header("Content-type: text/xml");
//	echo $XML->asXML();
	
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
	    echo $XML->asXML();
	}
    exit;
?>