<?php

function utf2ascii($text) {
    $return = Str_Replace(
	    Array("á", "č", "ď", "é", "ě", "í", "ľ", "ň", "ó", "ř", "š", "ť", "ú", "ů", "ý ", "ž", "Á", "Č", "Ď", "É", "Ě", "Í", "Ľ", "Ň", "Ó", "Ř", "Š", "Ť", "Ú", "Ů", "Ý", "Ž"), Array("a", "c", "d", "e", "e", "i", "l", "n", "o", "r", "s", "t", "u", "u", "y ", "z", "A", "C", "D", "E", "E", "I", "L", "N", "O", "R", "S", "T", "U", "U", "Y", "Z"), $text);
    $return = Str_Replace(Array(" ", "_"), "-", $return); //nahradí mezery a podtržítka pomlčkami
    $return = Str_Replace(Array("(", ")", ".", "!", ",", "\"", "'"), "", $return); //odstraní ().!,"'
    $return = StrToLower($return); //velká písmena nahradí malými.
    return $return;
}

function getUserIp() {
    switch (true) {
	case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
	case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
	case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
	default : return $_SERVER['REMOTE_ADDR'];
    }
}

function update_user_data($id_user, $user_data_update) {
    global $USER;
    foreach ($user_data_update AS $prop_name => $prop_data) {
	if (is_array($prop_data["PROP_VALUE"])) {  //preformatujema na sparvny typ pole pro set_user_property
	    foreach ($prop_data["PROP_VALUE"] AS $key => $value) {
		$p_prop_value[$key] = $value["id_enumeration"];
	    }
	    $prop_value = $p_prop_value;
	} else {
	    $prop_value = $prop_data["PROP_VALUE"];
	}
	$USER->set_user_property($id_user, $prop_name, $prop_value);
    }
}

function toArray($data) {
    if (is_scalar($data)) {
	return array($data);
    }
    return $data;
}

function check($r) {
    global $DB;
    if (PEAR::isError($r)) {
	echo $DB->last_query;
	die($r->getMessage());
	return false;
    }
}

function fixGps($data) {
    FB::info($data, "GPS IN");
//$data = str_replace(",", ".", $data);
    if (is_numeric($data))
	return $data;
    FB::info(gpsToFloat($data), "GPS OUT");
    return gpsToFloat($data);
}

function price($price, $type = null, $kurz = null) {
    return priceFormat($price, $type, $kurz);
}

function priceFormat($price, $type = null, $kurz = null) {
    if ($type == null)
	$type = MENA_KOD;
    if ($kurz == null)
	$kurz = MENA_KURZ;
    switch ($type) {
	case 'eur' :
	    return '€ ' . number_format($price / $kurz, 2, ',', ' ');
	default :
	    return number_format($price, 0, ',', ' ') . ',- Kč';
    }
}

/**
 * prevod GPS souradnic od uzivatele na souradnice ve stupnich
 *
 * @param string $gps souradnice zadane uzivatelem
 * @param boolean $toString vratit vysledek jako string misto pole floatu
 * @param boolean $strict prevest jen presny format (jen zakladni korekce chyb - bile znaky navic, jiny format uvozovek; retezec nesmi obsahovat znaky nepatrici do GPS formatu)
 * @param string $encoding kodovani vstupniho retezce
 *
 * @return array|string [sirka;delka] souradnice ve stupnich, nebo false pokud se souradnice nepodarilo prevest
 */
function gpsToFloat($gps, $toString = false, $strict = false, $encoding = 'utf-8') {
    $ret = false;
    //prevod na upper zjednodusi manipulaci se specifikaci polokoule
    $gps = mb_strtoupper($gps, $encoding);
    //generovani regularu - vyrazy pro sirku a delku jsou ekvivalentni
    if (!function_exists('gpsToFloatRegExp')) {

	function gpsToFloatRegExp($first = true) {
	    return '([' . ($first ? 'NS' : 'EW') . '-])?
		\s*

		(?P<' . ($first ? 'latSt' : 'longSt') . '>\d{1,3}(\s*[\.,]\s*\d+)?)
		\s*
		(?(' . ($first ? '3' : '9') . ')
				°?
			|
				(?:
					°\s*
					(?:
						(?(?<!\d)
							(?P<' . ($first ? 'latMin' : 'longMin') . '>\d{1,3} (\s*[\.,]\s*\d+)?)
							\s*
						)
						(?(' . ($first ? '5' : '11') . ')
								[\'`´]?
							|
								(?:
									[\'`´]\s*
									(?:
										(?(?<!\d)
											(?P<' . ($first ? 'latSec' : 'longSec') . '>\d{1,3} (?:\s*[\.,]\s*\d+)?)
											\s*(?:["“”]|(?:[\'`´]\s*[\'`´]))?
										)
									)?
								)?
						)
					)?
				)?
		)

		(?(' . ($first ? '1' : '7') . ') | \s*[' . ($first ? 'NS' : 'EW') . ']?)';
	}

    }

    $matches = false;

    //pokus o precteni souradnic podle regularniho vyrazu - povede se, jestlize vstup je v nejakem "rozumnem" tvaru pripominajicim platny format
    if (preg_match('#^\s*' . gpsToFloatRegExp() . '[^\d]+' . gpsToFloatRegExp(false) . '\s*$#xu', $gps, $matches)) {
	//pretypovani na float
	foreach (array('latSt', 'latMin', 'latSec', 'longSt', 'longMin', 'longSec') as $item) {
	    $matches[$item] = $matches[$item] ? floatval(preg_replace('#[^\d\.]+#', '', str_replace(',', '.', $matches[$item]))) : 0;
	}
	//prepocitani na stupne
	$ret = array(
	    $matches['latSt'] + $matches['latMin'] / 60 + $matches['latSec'] / 3600,
	    $matches['longSt'] + $matches['longMin'] / 60 + $matches['longSec'] / 3600
	);
	//upraveni znamenek souradnic podle znaku "-" nebo znaku oznacujiciho polokouli
	$mFirstPos = mb_strpos($gps, '-', null, $encoding);
	if ($mFirstPos === 0 ||
		$mFirstPos > 0 && $mFirstPos < mb_strpos($gps, $matches['latSt'], null, $encoding) || mb_strpos($gps, 'S', null, $encoding) !== false
	) {
	    $ret[0] = -$ret[0];
	}
	if ($mFirstPos > 0 && $mFirstPos > mb_strpos($gps, $matches['latSt'], null, $encoding) || mb_strpos($gps, '-', $mFirstPos + 1, $encoding) > 0 || mb_strpos($gps, 'W', null, $encoding) !== false
	) {
	    $ret[1] = -$ret[1];
	}
	// Jinak je-li povoleno dalsi prevadeni se pokusime vstup prevest na rozumnejsi tvar a preparsovat ho jeste jednou
    } elseif (!$strict) {
	//vyhazeni znaku ktere v GPS souradnicich nemaji co delat
	$gps = trim(preg_replace(array('#[^\d\.\,SW-]#u', '# +#u', '# *\. *#u'), array(' ', ' ', '.'), $gps));
	preg_match_all('#[\d]+(?:[\.,][\d]+)?#u', $gps, $matches);
	$count = count($matches[0]);
	//vstup lze jednoznacne prevest jen pokud obsahuje lichy pocet cisel nebo desetinnou tecku v jine skupine nez posledni
	if ($count == 2 || $count == 4 || $count == 6 ||
		( mb_strpos($gps, '.', null, $encoding) < mb_strrpos($gps, $matches[0][count($matches[0]) - 1], null, $encoding) && mb_substr_count($gps, '.', $encoding) <= 2 )
	) {
	    //escapovani tecek pro pouziti v regularu a nahrazeni carek pouzitych jako oddelovac desetinnych mist teckami
	    $matches2 = array();
	    for ($i = 0; $i < count($matches[0]); ++$i) {
		$matches2[0][$i] = str_replace('.', '\.', $matches[0][$i]);
		$matches[0][$i] = str_replace(',', '.', $matches[0][$i]);
	    }
	    //sestaveni regularu pro transformaci vstupu - z vstupu ponechame nalezena cisla, bile znaky a specifikaci polokoule v miste kde se muze nachazet a doplnime znaky jednotek, vse ostatni bude vyhazeno (po predchozi uprave zbyly znaky ktere mohou oznacovat polokouly nebo byt oddelovacem desetinnych mist)
	    $dels = array('°', "'", '"');
	    $pattern = '';
	    $replace = '';
	    if (mb_strpos($gps, '.', null, $encoding) || mb_strpos($gps, ',', null, $encoding)) {
		$j = 0;
		for ($i = 0; $i < $count; ++$i) {
		    $replace .= $matches[0][$i] . $dels[$j % 3] . ' \\' . ($i + 2) . ' ';
		    $pattern .= '([ ' . ( $i == 0 ? 'S-' : ($j == 0 ? 'SW-' : '') ) . ']*).*?' . $matches2[0][$i];
		    if (mb_strpos($matches[0][$i], '.', null, $encoding)) {
			$j = 0;
		    } else {
			++$j;
		    }
		}
	    } else {
		for ($i = 0; $i < $count; ++$i) {
		    $replace .= $matches[0][$i] . $dels[$i % ($count / 2)] . ' \\' . ($i + 2) . ' ';
		    $pattern .= '([ ' . ( $i == 0 ? 'S-' : ($i == $count / 2 ? 'SW-' : '') ) . ']*).*?' . $matches2[0][$i];
		}
	    }
	    //pokusime se preparsovat upraveny retezec ve strikt modu (byl-li platny, prevedl se na standardni format a pujde prevest)
	    $ret = gpsToFloat(
		    $count == 2 ? $gps : preg_replace('#^.*?' . $pattern . '.*?([ W]*).*?$#u', '\\1 ' . $replace, $gps), false, true, $encoding
	    );
	}
    }
    // vratime vysledne pole, nebo false pokud se retezec nepodarilo prevest nebo jsou souradnice mimo povoleny rozsah
    return (!$ret || $ret[0] > 90 || $ret[0] < -90 || $ret[1] > 180 || $ret[1] < -180) ?
	    false :
	    ($toString ? $ret[0] . ' ' . $ret[1] : $ret);
}

function fixFckContent($data) {
    if ($data == "<br />")
	$data = "";
    if ($data == "&nbsp")
	$data = "";
    return $data;
}

function resize_fixed_ratio($file, $max_width, $max_height) {
    $imageinfo = getimagesize($file);
    $src_image = imagecreatefromjpeg($file);
    if ($imageinfo[0] >= $max_width) {
	$dst_sizex = $max_width;
	$ratio = $imageinfo[1] / $imageinfo[0];
	$dst_sizey = round($dst_sizex * $ratio);
    } else {
	$dst_sizex = $imageinfo[0];
	$dst_sizey = $imageinfo[1];
    }
    if ($dst_sizey >= $max_height) {
	$dst_sizey = $max_height;
	$ratio = $imageinfo[1] / $imageinfo[0];
	$dst_sizex = round($dst_sizey / $ratio);
    }
    $dst_image = imagecreatetruecolor($dst_sizex, $dst_sizey);
    imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_sizex, $dst_sizey, $imageinfo[0], $imageinfo[1]);
    $tmpname = "/tmp/" . uniqid(rand(1000000, 9999999) . ".", True) . ".jpg";
    imagejpeg($dst_image, $tmpname, 80);
    return $tmpname;
}

function changeDatepickerDate($cdate) {
    if (!$cdate)
	return null;
    list($day, $month, $year) = explode(".", $cdate);
    if (!$year || !$month || !$day)
	return null;
    return $year . "-" . $month . "-" . $day;
}

function changeDatepickerDateTime($input) {
    list($cdate, $time) = explode(" ", $input);
    list($day, $month, $year) = explode(".", $cdate);
    if (!$year || !$month || !$day)
	return null;
    list($hours, $minutes, $seconds) = explode(":", $time);
    if (!$hours)
	$hours = "00";
    if (!$minutes)
	$minutes = "00";
    if (!$seconds)
	$seconds = "00";
    $res = $year . "-" . $month . "-" . $day . " " . $hours . ":" . $minutes . ":" . $seconds;
    if ($res == "0000-00-00 00:00:00")
	return false;
    return $res;
}

function changeDatepickerDateTimeReverse($input) {
//		echo $input;
    list($cdate, $time) = explode(" ", $input);
    list($year, $month, $day) = explode("-", $cdate);
    if (!$year || !$month || !$day)
	return null;
    list($hours, $minutes, $seconds) = explode(":", $time);
    if (!$hours)
	$hours = "00";
    if (!$minutes)
	$minutes = "00";
    if (!$seconds)
	$seconds = "00";
    $res = $day . "." . $month . "." . $year . " " . $hours . ":" . $minutes . ":" . $seconds;
    if ($res == "0000-00-00 00:00:00")
	return false;
    return $res;
}

function get_last_par() {
    global $par_1, $par_2, $par_3, $par_4, $par_5;
    if ($par_5)
	return $par_5;
    if ($par_4)
	return $par_4;
    if ($par_3)
	return $par_3;
    if ($par_2)
	return $par_2;
    if ($par_1)
	return $par_1;
}

function displayLoginForm() {

    /* 		print('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
      print('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">');
      print('<head>');
      print('<title>Administrace</title>');
      print('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />');
      print('<meta name="Author" content="3nicom.cz" />');
      print('<meta name="Robots" content="follow" />');
      print('<link href="/css/style.css" rel="stylesheet" type="text/css" />');
      print('<link href="/templates/admin/page_style.css" rel="stylesheet" type="text/css" />');
      print('<script type="text/javascript" src="/templates/admin/page_script.js"></script>');
      print('<style type="text/css">.container{background-image:none;}</style>');
      print('</head>');
      print('<body style="background-color: brown; text-align: left;">');
      print('<div id="all">');
      print('<div class="zapati">');
      print("<form action=\"/admin/\" method=\"post\">\n");
      print("<fieldset style='border:0px'>\n");
      print("<legend >Přihlašovací formulář</legend>\n");
      print("<label>Login:</label><input type=\"text\" name=\"login_user\" />\n");
      print("<label>Pass:</label><input type=\"password\" name=\"login_pass\" />\n");
      print("<input type=\"submit\" name=\"submit\" value=\"Prihlasit\" />\n");
      print("</fieldset>\n");
      print("</form>\n");
      print('</div>');
      print('</div>');
      print('</body>');
      print('</html>'); */
}

function print_p($foo, $bar = false) {
    echo "\n<hr/> <h3>$bar</h3> <pre style=\"text-align: left; color: black; background-color: white; font-size: 9px; font-family: tahoma;\">";
    if ($foo == false)
	var_dump($foo);
    else
	print_r($foo);
    echo "</pre>\n";
}

function find_url_key_after($key_to_find, $def_value = null) {
    if (!$key_to_find)
	return false;
    $keys = explode("/", $_SERVER["REQUEST_URI"]);
    $keys = unset_empty_keys($keys);
    for ($i = 0; $i <= count($keys); $i++) {
	if ($keys[$i] == $key_to_find)
	    return $keys[$i + 1];
    }
    return $def_value;
}

function find_url_key($key_to_find) {
    $keys = explode("/", $_SERVER["REQUEST_URI"]);
    $keys = unset_empty_keys($keys);
    for ($i = 0; $i <= count($keys); $i++) {
	if ($keys[$i] == $key_to_find)
	    return true;
    }
    return false;
}

function find_id_in_url() {
    $keys = explode("/", $_SERVER["REQUEST_URI"]);
    foreach ($keys AS $key) {
	$part = explode(ID_DELIMITER, $key);
	if ($part["1"])
	    return $part["1"];
    }
}

function unset_empty_keys($array) {
    foreach ($array AS $key => $item) {
	if (!$item)
	    unset($array[$key]);
    }
    return $array;
}

function iso2ascii($s) {
    $iso = from_utf8("áčďéěíĺľňóřšťúůýžäëöüÁČĎÉĚÍĹĽŇÓŘŠŤÚŮÝŽÄËÖÜ");
    $asc = from_utf8("acdeeillnorstuuyzaeouACDEEILLNORSTUUYZAEOU");
    return strtr($s, $iso, $asc);
}

function urlFriendly($title) {
    static $tbl = array("\xc3\xa1" => "a", "\xc3\xa4" => "a", "\xc4\x8d" => "c", "\xc4\x8f" => "d", "\xc3\xa9" => "e", "\xc4\x9b" => "e", "\xc3\xad" => "i", "\xc4\xbe" => "l", "\xc4\xba" => "l", "\xc5\x88" => "n", "\xc3\xb3" => "o", "\xc3\xb6" => "o", "\xc5\x91" => "o", "\xc3\xb4" => "o", "\xc5\x99" => "r", "\xc5\x95" => "r", "\xc5\xa1" => "s", "\xc5\xa5" => "t", "\xc3\xba" => "u", "\xc5\xaf" => "u", "\xc3\xbc" => "u", "\xc5\xb1" => "u", "\xc3\xbd" => "y", "\xc5\xbe" => "z", "\xc3\x81" => "A", "\xc3\x84" => "A", "\xc4\x8c" => "C", "\xc4\x8e" => "D", "\xc3\x89" => "E", "\xc4\x9a" => "E", "\xc3\x8d" => "I", "\xc4\xbd" => "L", "\xc4\xb9" => "L", "\xc5\x87" => "N", "\xc3\x93" => "O", "\xc3\x96" => "O", "\xc5\x90" => "O", "\xc3\x94" => "O", "\xc5\x98" => "R", "\xc5\x94" => "R", "\xc5\xa0" => "S", "\xc5\xa4" => "T", "\xc3\x9a" => "U", "\xc5\xae" => "U", "\xc3\x9c" => "U", "\xc5\xb0" => "U", "\xc3\x9d" => "Y", "\xc5\xbd" => "Z");


    $r = strtr($title, $tbl);

    preg_match_all('/[a-zA-Z0-9]+/', $r, $nt);
    $r = strtolower(implode('-', $nt[0]));

    return $r;
}

function fileArrayToPropertyArray($files) {
    $retval = array();
    if (is_array($files)) {
	foreach ($files["error"] as $prop_name => $err) {
	    if ($err === 0) {
		$retval[$prop_name]["name"] = $files["name"][$prop_name];
		$retval[$prop_name]["type"] = $files["type"][$prop_name];
		$retval[$prop_name]["tmp_name"] = $files["tmp_name"][$prop_name];
	    } else {
		if ($err != UPLOAD_ERR_NO_FILE)
		    throw new Exception('Došlo k chybě při uploadu souboru -> ' . file_upload_error_message($err));
	    }
	}
    }
    return $retval;
}

function getFileExtenstion($fname) {
    $fp = explode(".", $fname);
    return $fp[count($fp) - 1];
}

function getFileNameWithoutExtenstion($fname) {
    $fp = explode(".", $fname);
    unset($fp[count($fp) - 1]);
    return implode(".", $fp);
}

/*
  ISO8859-2 <-> UTF-8 conversion functions designed for use in PHP-GTK apps
  Adam Rambousek - rambousek@volny.cz

  version history:
  1.03 --- 12/02/2002
 * added Win1257 support
  1.02 --- 30/11/2001
 * added ISO8859-1 support
  1.01
 * added Win1250 support
  1.00

  string to_utf8(string string [, string charset])
  string from_utf8(string string [, string charset])

  supported charsets: name of charset you must use in script
  ISO8859-2: iso2   (this is the default charset, you don't have to specify it)
  Windows1250: win1250
  ISO8859-1: iso1
  Windows1257: win1257

  example:  $new_string=to_utf8($some_string,"win1250");
 */


/*
  translation table - actually, it's array where key is hexadecimal number of
  character in ISO8859-2/Windows1250 and value is its two byte representation in UTF-8
 */

$iso2_utf8 = array(
    0x80 => "\xc2\x80",
    0x81 => "\xc2\x81",
    0x82 => "\xc2\x82",
    0x83 => "\xc2\x83",
    0x84 => "\xc2\x84",
    0x85 => "\xc2\x85",
    0x86 => "\xc2\x86",
    0x87 => "\xc2\x87",
    0x88 => "\xc2\x88",
    0x89 => "\xc2\x89",
    0x8A => "\xc2\x8a",
    0x8B => "\xc2\x8b",
    0x8C => "\xc2\x8c",
    0x8D => "\xc2\x8d",
    0x8E => "\xc2\x8e",
    0x8F => "\xc2\x8f",
    0x90 => "\xc2\x90",
    0x91 => "\xc2\x91",
    0x92 => "\xc2\x92",
    0x93 => "\xc2\x93",
    0x94 => "\xc2\x94",
    0x95 => "\xc2\x95",
    0x96 => "\xc2\x96",
    0x97 => "\xc2\x97",
    0x98 => "\xc2\x98",
    0x99 => "\xc2\x99",
    0x9A => "\xc2\x9a",
    0x9B => "\xc2\x9b",
    0x9C => "\xc2\x9c",
    0x9D => "\xc2\x9d",
    0x9E => "\xc2\x9e",
    0x9F => "\xc2\x9f",
    0xA0 => "\xc2\xa0",
    0xA1 => "\xc4\x84",
    0xA2 => "\xcb\x98",
    0xA3 => "\xc5\x81",
    0xA4 => "\xc2\xa4",
    0xA5 => "\xc4\xbd",
    0xA6 => "\xc5\x9a",
    0xA7 => "\xc2\xa7",
    0xA8 => "\xc2\xa8",
    0xA9 => "\xc5\xa0",
    0xAA => "\xc5\x9e",
    0xAB => "\xc5\xa4",
    0xAC => "\xc5\xb9",
    0xAD => "\xc2\xad",
    0xAE => "\xc5\xbd",
    0xAF => "\xc5\xbb",
    0xB0 => "\xc2\xb0",
    0xB1 => "\xc4\x85",
    0xB2 => "\xcb\x9b",
    0xB3 => "\xc5\x82",
    0xB4 => "\xc2\xb4",
    0xB5 => "\xc4\xbe",
    0xB6 => "\xc5\x9b",
    0xB7 => "\xcb\x87",
    0xB8 => "\xc2\xb8",
    0xB9 => "\xc5\xa1",
    0xBA => "\xc5\x9f",
    0xBB => "\xc5\xa5",
    0xBC => "\xc5\xba",
    0xBD => "\xcb\x9d",
    0xBE => "\xc5\xbe",
    0xBF => "\xc5\xbc",
    0xC0 => "\xc5\x94",
    0xC1 => "\xc3\x81",
    0xC2 => "\xc3\x82",
    0xC3 => "\xc4\x82",
    0xC4 => "\xc3\x84",
    0xC5 => "\xc4\xb9",
    0xC6 => "\xc4\x86",
    0xC7 => "\xc3\x87",
    0xC8 => "\xc4\x8c",
    0xC9 => "\xc3\x89",
    0xCA => "\xc4\x98",
    0xCB => "\xc3\x8b",
    0xCC => "\xc4\x9a",
    0xCD => "\xc3\x8d",
    0xCE => "\xc3\x8e",
    0xCF => "\xc4\x8e",
    0xD0 => "\xc4\x90",
    0xD1 => "\xc5\x83",
    0xD2 => "\xc5\x87",
    0xD3 => "\xc3\x93",
    0xD4 => "\xc3\x94",
    0xD5 => "\xc5\x90",
    0xD6 => "\xc3\x96",
    0xD7 => "\xc3\x97",
    0xD8 => "\xc5\x98",
    0xD9 => "\xc5\xae",
    0xDA => "\xc3\x9a",
    0xDB => "\xc5\xb0",
    0xDC => "\xc3\x9c",
    0xDD => "\xc3\x9d",
    0xDE => "\xc5\xa2",
    0xDF => "\xc3\x9f",
    0xE0 => "\xc5\x95",
    0xE1 => "\xc3\xa1",
    0xE2 => "\xc3\xa2",
    0xE3 => "\xc4\x83",
    0xE4 => "\xc3\xa4",
    0xE5 => "\xc4\xba",
    0xE6 => "\xc4\x87",
    0xE7 => "\xc3\xa7",
    0xE8 => "\xc4\x8d",
    0xE9 => "\xc3\xa9",
    0xEA => "\xc4\x99",
    0xEB => "\xc3\xab",
    0xEC => "\xc4\x9b",
    0xED => "\xc3\xad",
    0xEE => "\xc3\xae",
    0xEF => "\xc4\x8f",
    0xF0 => "\xc4\x91",
    0xF1 => "\xc5\x84",
    0xF2 => "\xc5\x88",
    0xF3 => "\xc3\xb3",
    0xF4 => "\xc3\xb4",
    0xF5 => "\xc5\x91",
    0xF6 => "\xc3\xb6",
    0xF7 => "\xc3\xb7",
    0xF8 => "\xc5\x99",
    0xF9 => "\xc5\xaf",
    0xFA => "\xc3\xba",
    0xFB => "\xc5\xb1",
    0xFC => "\xc3\xbc",
    0xFD => "\xc3\xbd",
    0xFE => "\xc5\xa3",
    0xFF => "\xcb\x99"
);

$win1250_utf8 = array(
    0x80 => "\xc2\x80",
    0x81 => "\xc2\x81",
    0x82 => "\x140\x9a",
    0x83 => "\xc2\x83",
    0x84 => "\x140\x9e",
    0x85 => "\x140\xa6",
    0x86 => "\x140\xa0",
    0x87 => "\x140\xa1",
    0x88 => "\xc2\x88",
    0x89 => "\x140\xb0",
    0x8a => "\xc5\xa0",
    0x8b => "\x140\xb9",
    0x8c => "\xc5\x9a",
    0x8d => "\xc5\xa4",
    0x8e => "\xc5\xbd",
    0x8f => "\xc5\xb9",
    0x90 => "\xc2\x90",
    0x91 => "\x140\x98",
    0x92 => "\x140\x99",
    0x93 => "\x140\x9c",
    0x94 => "\x140\x9d",
    0x95 => "\x140\xa2",
    0x96 => "\x140\x93",
    0x97 => "\x140\x94",
    0x98 => "\xc2\x98",
    0x99 => "\x144\xa2",
    0x9a => "\xc5\xa1",
    0x9b => "\x140\xba",
    0x9c => "\xc5\x9b",
    0x9d => "\xc5\xa5",
    0x9e => "\xc5\xbe",
    0x9f => "\xc5\xba",
    0xa0 => "\xc2\xa0",
    0xa1 => "\xcb\x87",
    0xa2 => "\xcb\x98",
    0xa3 => "\xc5\x81",
    0xa4 => "\xc2\xa4",
    0xa5 => "\xc4\x84",
    0xa6 => "\xc2\xa6",
    0xa7 => "\xc2\xa7",
    0xa8 => "\xc2\xa8",
    0xa9 => "\xc2\xa9",
    0xaa => "\xc5\x9e",
    0xab => "\xc2\xab",
    0xac => "\xc2\xac",
    0xad => "\xc2\xad",
    0xae => "\xc2\xae",
    0xaf => "\xc5\xbb",
    0xb0 => "\xc2\xb0",
    0xb1 => "\xc2\xb1",
    0xb2 => "\xcb\x9b",
    0xb3 => "\xc5\x82",
    0xb4 => "\xc2\xb4",
    0xb5 => "\xc2\xb5",
    0xb6 => "\xc2\xb6",
    0xb7 => "\xc2\xb7",
    0xb8 => "\xc2\xb8",
    0xb9 => "\xc4\x85",
    0xba => "\xc5\x9f",
    0xbb => "\xc2\xbb",
    0xbc => "\xc4\xbd",
    0xbd => "\xcb\x9d",
    0xbe => "\xc4\xbe",
    0xbf => "\xc5\xbc",
    0xc0 => "\xc5\x94",
    0xc1 => "\xc3\x81",
    0xc2 => "\xc3\x82",
    0xc3 => "\xc4\x82",
    0xc4 => "\xc3\x84",
    0xc5 => "\xc4\xb9",
    0xc6 => "\xc4\x86",
    0xc7 => "\xc3\x87",
    0xc8 => "\xc4\x8c",
    0xc9 => "\xc3\x89",
    0xca => "\xc4\x98",
    0xcb => "\xc3\x8b",
    0xcc => "\xc4\x9a",
    0xcd => "\xc3\x8d",
    0xce => "\xc3\x8e",
    0xcf => "\xc4\x8e",
    0xd0 => "\xc4\x90",
    0xd1 => "\xc5\x83",
    0xd2 => "\xc5\x87",
    0xd3 => "\xc3\x93",
    0xd4 => "\xc3\x94",
    0xd5 => "\xc5\x90",
    0xd6 => "\xc3\x96",
    0xd7 => "\xc3\x97",
    0xd8 => "\xc5\x98",
    0xd9 => "\xc5\xae",
    0xda => "\xc3\x9a",
    0xdb => "\xc5\xb0",
    0xdc => "\xc3\x9c",
    0xdd => "\xc3\x9d",
    0xde => "\xc5\xa2",
    0xdf => "\xc3\x9f",
    0xe0 => "\xc5\x95",
    0xe1 => "\xc3\xa1",
    0xe2 => "\xc3\xa2",
    0xe3 => "\xc4\x83",
    0xe4 => "\xc3\xa4",
    0xe5 => "\xc4\xba",
    0xe6 => "\xc4\x87",
    0xe7 => "\xc3\xa7",
    0xe8 => "\xc4\x8d",
    0xe9 => "\xc3\xa9",
    0xea => "\xc4\x99",
    0xeb => "\xc3\xab",
    0xec => "\xc4\x9b",
    0xed => "\xc3\xad",
    0xee => "\xc3\xae",
    0xef => "\xc4\x8f",
    0xf0 => "\xc4\x91",
    0xf1 => "\xc5\x84",
    0xf2 => "\xc5\x88",
    0xf3 => "\xc3\xb3",
    0xf4 => "\xc3\xb4",
    0xf5 => "\xc5\x91",
    0xf6 => "\xc3\xb6",
    0xf7 => "\xc3\xb7",
    0xf8 => "\xc5\x99",
    0xf9 => "\xc5\xaf",
    0xfa => "\xc3\xba",
    0xfb => "\xc5\xb1",
    0xfc => "\xc3\xbc",
    0xfd => "\xc3\xbd",
    0xfe => "\xc5\xa3",
    0xff => "\xcb\x99"
);

$iso1_utf8 = array(
    0xA0 => "\xc2\xa0",
    0xA1 => "\xc2\xa1",
    0xA2 => "\xc2\xa2",
    0xA3 => "\xc2\xa3",
    0xA4 => "\xc2\xa4",
    0xA5 => "\xc2\xa5",
    0xA6 => "\xc2\xa6",
    0xA7 => "\xc2\xa7",
    0xA8 => "\xc2\xa8",
    0xA9 => "\xc2\xa9",
    0xAA => "\xc2\xaa",
    0xAB => "\xc2\xab",
    0xAC => "\xc2\xac",
    0xAD => "\xc2\xad",
    0xAE => "\xc2\xae",
    0xAF => "\xc2\xaf",
    0xB0 => "\xc2\xb0",
    0xB1 => "\xc2\xb1",
    0xB2 => "\xc2\xb2",
    0xB3 => "\xc2\xb3",
    0xB4 => "\xc2\xb4",
    0xB5 => "\xc2\xb5",
    0xB6 => "\xc2\xb6",
    0xB7 => "\xc2\xb7",
    0xB8 => "\xc2\xb8",
    0xB9 => "\xc2\xb9",
    0xBA => "\xc2\xba",
    0xBB => "\xc2\xbb",
    0xBC => "\xc2\xbc",
    0xBD => "\xc2\xbd",
    0xBE => "\xc2\xbe",
    0xBF => "\xc2\xbf",
    0xC0 => "\xc3\x80",
    0xC1 => "\xc3\x81",
    0xC2 => "\xc3\x82",
    0xC3 => "\xc3\x83",
    0xC4 => "\xc3\x84",
    0xC5 => "\xc3\x85",
    0xC6 => "\xc3\x86",
    0xC7 => "\xc3\x87",
    0xC8 => "\xc3\x88",
    0xC9 => "\xc3\x89",
    0xCA => "\xc3\x8a",
    0xCB => "\xc3\x8b",
    0xCC => "\xc3\x8c",
    0xCD => "\xc3\x8d",
    0xCE => "\xc3\x8e",
    0xCF => "\xc3\x8f",
    0xD0 => "\xc3\x90",
    0xD1 => "\xc3\x91",
    0xD2 => "\xc3\x92",
    0xD3 => "\xc3\x93",
    0xD4 => "\xc3\x94",
    0xD5 => "\xc3\x95",
    0xD6 => "\xc3\x96",
    0xD7 => "\xc3\x97",
    0xD8 => "\xc3\x98",
    0xD9 => "\xc3\x99",
    0xDA => "\xc3\x9a",
    0xDB => "\xc3\x9b",
    0xDC => "\xc3\x9c",
    0xDD => "\xc3\x9d",
    0xDE => "\xc3\x9e",
    0xDF => "\xc3\x9f",
    0xE0 => "\xc3\xa0",
    0xE1 => "\xc3\xa1",
    0xE2 => "\xc3\xa2",
    0xE3 => "\xc3\xa3",
    0xE4 => "\xc3\xa4",
    0xE5 => "\xc3\xa5",
    0xE6 => "\xc3\xa6",
    0xE7 => "\xc3\xa7",
    0xE8 => "\xc3\xa8",
    0xE9 => "\xc3\xa9",
    0xEA => "\xc3\xaa",
    0xEB => "\xc3\xab",
    0xEC => "\xc3\xac",
    0xED => "\xc3\xad",
    0xEE => "\xc3\xae",
    0xEF => "\xc3\xaf",
    0xF0 => "\xc3\xb0",
    0xF1 => "\xc3\xb1",
    0xF2 => "\xc3\xb2",
    0xF3 => "\xc3\xb3",
    0xF4 => "\xc3\xb4",
    0xF5 => "\xc3\xb5",
    0xF6 => "\xc3\xb6",
    0xF7 => "\xc3\xb7",
    0xF8 => "\xc3\xb8",
    0xF9 => "\xc3\xb9",
    0xFA => "\xc3\xba",
    0xFB => "\xc3\xbb",
    0xFC => "\xc3\xbc",
    0xFD => "\xc3\xbd",
    0xFE => "\xc3\xbe"
);

$win1257_utf8 = array(
    0x80 => "\x142\xac",
    0x81 => "\xc0\x4",
    0x82 => "\x140\x9a",
    0x83 => "\xc0\x4",
    0x84 => "\x140\x9e",
    0x85 => "\x140\xa6",
    0x86 => "\x140\xa0",
    0x87 => "\x140\xa1",
    0x88 => "\xc0\x4",
    0x89 => "\x140\xb0",
    0x8A => "\xc0\x4",
    0x8B => "\x140\xb9",
    0x8C => "\xc0\x4",
    0x8D => "\xc2\xa8",
    0x8E => "\xcb\x87",
    0x8F => "\xc2\xb8",
    0x90 => "\xc0\x4",
    0x91 => "\x140\x98",
    0x92 => "\x140\x99",
    0x93 => "\x140\x9c",
    0x94 => "\x140\x9d",
    0x95 => "\x140\xa2",
    0x96 => "\x140\x93",
    0x97 => "\x140\x94",
    0x98 => "\xc0\x4",
    0x99 => "\x144\xa2",
    0x9A => "\xc0\x4",
    0x9B => "\x140\xba",
    0x9C => "\xc0\x4",
    0x9D => "\xc2\xaf",
    0x9E => "\xcb\x9b",
    0x9F => "\xc0\x4",
    0xA0 => "\xc2\xa0",
    0xA1 => "\xc0\x4",
    0xA2 => "\xc2\xa2",
    0xA3 => "\xc2\xa3",
    0xA4 => "\xc2\xa4",
    0xA5 => "\xc0\x4",
    0xA6 => "\xc2\xa6",
    0xA7 => "\xc2\xa7",
    0xA8 => "\xc3\x98",
    0xA9 => "\xc2\xa9",
    0xAA => "\xc5\x96",
    0xAB => "\xc2\xab",
    0xAC => "\xc2\xac",
    0xAD => "\xc2\xad",
    0xAE => "\xc2\xae",
    0xAF => "\xc3\x86",
    0xB0 => "\xc2\xb0",
    0xB1 => "\xc2\xb1",
    0xB2 => "\xc2\xb2",
    0xB3 => "\xc2\xb3",
    0xB4 => "\xc2\xb4",
    0xB5 => "\xc2\xb5",
    0xB6 => "\xc2\xb6",
    0xB7 => "\xc2\xb7",
    0xB8 => "\xc3\xb8",
    0xB9 => "\xc2\xb9",
    0xBA => "\xc5\x97",
    0xBB => "\xc2\xbb",
    0xBC => "\xc2\xbc",
    0xBD => "\xc2\xbd",
    0xBE => "\xc2\xbe",
    0xBF => "\xc3\xa6",
    0xC0 => "\xc4\x84",
    0xC1 => "\xc4\xae",
    0xC2 => "\xc4\x80",
    0xC3 => "\xc4\x86",
    0xC4 => "\xc3\x84",
    0xC5 => "\xc3\x85",
    0xC6 => "\xc4\x98",
    0xC7 => "\xc4\x92",
    0xC8 => "\xc4\x8c",
    0xC9 => "\xc3\x89",
    0xCA => "\xc5\xb9",
    0xCB => "\xc4\x96",
    0xCC => "\xc4\xa2",
    0xCD => "\xc4\xb6",
    0xCE => "\xc4\xaa",
    0xCF => "\xc4\xbb",
    0xD0 => "\xc5\xa0",
    0xD1 => "\xc5\x83",
    0xD2 => "\xc5\x85",
    0xD3 => "\xc3\x93",
    0xD4 => "\xc5\x8c",
    0xD5 => "\xc3\x95",
    0xD6 => "\xc3\x96",
    0xD7 => "\xc3\x97",
    0xD8 => "\xc5\xb2",
    0xD9 => "\xc5\x81",
    0xDA => "\xc5\x9a",
    0xDB => "\xc5\xaa",
    0xDC => "\xc3\x9c",
    0xDD => "\xc5\xbb",
    0xDE => "\xc5\xbd",
    0xDF => "\xc3\x9f",
    0xE0 => "\xc4\x85",
    0xE1 => "\xc4\xaf",
    0xE2 => "\xc4\x81",
    0xE3 => "\xc4\x87",
    0xE4 => "\xc3\xa4",
    0xE5 => "\xc3\xa5",
    0xE6 => "\xc4\x99",
    0xE7 => "\xc4\x93",
    0xE8 => "\xc4\x8d",
    0xE9 => "\xc3\xa9",
    0xEA => "\xc5\xba",
    0xEB => "\xc4\x97",
    0xEC => "\xc4\xa3",
    0xED => "\xc4\xb7",
    0xEE => "\xc4\xab",
    0xEF => "\xc4\xbc",
    0xF0 => "\xc5\xa1",
    0xF1 => "\xc5\x84",
    0xF2 => "\xc5\x86",
    0xF3 => "\xc3\xb3",
    0xF4 => "\xc5\x8d",
    0xF5 => "\xc3\xb5",
    0xF6 => "\xc3\xb6",
    0xF7 => "\xc3\xb7",
    0xF8 => "\xc5\xb3",
    0xF9 => "\xc5\x82",
    0xFA => "\xc5\x9b",
    0xFB => "\xc5\xab",
    0xFC => "\xc3\xbc",
    0xFD => "\xc5\xbc",
    0xFE => "\xc5\xbe",
    0xFF => "\xcb\x99"
);

/*
  function to convert to UTF-8
  because characters numbered 0-127 are standard ASCII characters and are same in Unicode,
  we have to recode only higher characters
  function pass through the string and when it finds such character, it is replaced with
  UTF-8 two byte representation
 */

function to_utf8($string, $charset = "iso2") {
    eval("global \$" . $charset . "_utf8;");
    eval("\$coding=\$" . $charset . "_utf8;");

    for ($i = 0; $i < strlen($string); $i++) {
	if (ord($string[$i]) > 127) {
	    $string = substr($string, 0, $i) . $coding[ord($string[$i])] . substr($string, ++$i);
	}
    }
    return $string;
}

/*
  reverse function to convert from UTF-8
  and again it pass through the string and when the two following bytes correspond to
  two byte combination given in translation array, these two characters are replaced with
  one character from given coding
  it takes the key returned by array_search() and since the key is the number of specific
  character, we can use chr()
 */

function from_utf8($string, $charset = "win1250") {
    eval("global \$" . $charset . "_utf8;");
    eval("\$coding=\$" . $charset . "_utf8;");

    for ($i = 0; $i < strlen($string) - 1; $i++) {
	if ($code = array_search($string[$i] . $string[($i + 1)], $coding))
	    $string = substr($string, 0, $i) . chr($code) . substr($string, $i + 2);
    }
    return $string;
}

function delimiter_to_array($data) {
    if (strpos($data, ENUM_DELIMITER))
	return explode(ENUM_DELIMITER, $data);
    return $data;
}

function array_to_delimiter($data) {
    foreach ($data AS $key => $item) {
	$hodnota = "";
	if (count($item) > 1) {
	    foreach ($item AS $value) {
		$hodnota .= $value;
		if (next($item))
		    $hodnota .= ENUM_DELIMITER;
	    }
	} else {
	    $hodnota = $item;
	}
	$result[$key] = $hodnota;
    }
    return $result;
}

function keys_to_url($data) {
    foreach ($data AS $key => $value) {
	$key_tmp = urlFriendly($key);
	$result[$key_tmp] = $value;
    }
    return $result;
}

function kurz_euro($mena) {
    if ($mena) {
	$url = "http://www.cnb.cz/cz/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt";
	$gaddress = $url;

	$mena = strtoupper($mena);
	$handle = fopen($gaddress, "r");
	$contents = '';

	$i = 0;
	while (!feof($handle)) {
	    $contents = fread($handle, 8192);
	}

	fclose($handle);
	$contents = str_replace(",", ".", $contents);
	$contents = explode("\n", $contents);

	for ($i = 0; $i < sizeof($contents); $i++) {
	    $contents[$i] = explode("|", $contents[$i]);
	    if ($contents[$i][3] == $mena) {
		$result = $contents[$i][4] / $contents[$i][2];
//echo $result;
		return($result);
	    }
	}
    }
}

function nacti_kurzy() {

    $url = "http://www.cnb.cz/cz/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt";
    $gaddress = $url;

    $mena = strtoupper($mena);
    $handle = fopen($gaddress, "r");
    $contents = '';

    $i = 0;
    while (!feof($handle)) {
	$contents = fread($handle, 8192);
    }

    fclose($handle);
    $contents = str_replace(",", ".", $contents);
    $contents = explode("\n", $contents);

//print_p($contents);

    for ($i = 0; $i < sizeof($contents); $i++) {
	$contents[$i] = explode("|", $contents[$i]);
	$kod = strtolower($contents[$i][3]);
	if (is_numeric($contents[$i][2]))
	    $result[$kod] = array("kod" => $kod, "mena" => $contents[$i][3], "zeme" => $contents[$i][0], "kurz" => $contents[$i][4] / $contents[$i][2]);
    }
    $result["czk"] = array("kod" => "czk", "mena" => "Kč", "zeme" => "Česká Republika", "kurz" => "1");
//print_p($result);
    array_multisort($result, SORT_ASC);
    return $result;
}

/**
 *   this is a helper function, so i dont have to write so many prints :-)
 *   @param  array   $para   the result returned by some method, that will be dumped
 *   @param  string  $string the explaining string
 */
function dumpHelper($para, $string = '', $addArray = false) {
    global $tree, $element;

    if ($addArray) {
	eval("\$res=array(" . $para . ');');
    } else {
	eval("\$res=" . $para . ';');
    }
    echo '<b>' . $para . ' </b><i><u><font color="#008000">' . $string . '</font></u></i><br>';
// this method dumps to the screen, since print_r or var_dump dont
// work too good here, because the inner array is recursive
// well, it looks ugly but one can see what is meant :-)
    $tree->varDump($res);
    echo '<br>';
}

/**
 *   dumps the entire structure nicely
 *   @param  string  $string the explaining string
 */
function dumpAllNicely($string = '') {
    global $tree;

    echo '<i><u><font color="#008000">' . $string . '</font></u></i><br>';
    $all = $tree->getNode();   // get the entire structure sorted as the tree is, so we can simply foreach through it and show it
    foreach ($all as $aElement) {
	for ($i = 0; $i < $aElement['level']; $i++) {
	    echo '&nbsp; &nbsp; ';
	}
	echo $aElement['name'] . ' ===&gt; ';
	$tree->varDump(array($aElement));
    }
    echo '<br>';
}

function getmicrotime() {
    list($usec, $sec) = explode(" ", microtime());
    $usec = str_replace(".", "", $usec);
    return ((float) $usec + (float) $sec);
}

function detect_browser() {
    global $HTTP_USER_AGENT, $BName, $BVersion, $BPlatform;

// Browser
    if (eregi("(opera) ([0-9]{1,2}.[0-9]{1,3}){0,1}", $_SERVER['HTTP_USER_AGENT'], $match) || eregi("(opera/)([0-9]{1,2}.[0-9]{1,3}){0,1}", $_SERVER['HTTP_USER_AGENT'], $match)) {
	$BName = "Opera";
	$BVersion = $match[2];
    } elseif (eregi("(konqueror)/([0-9]{1,2}.[0-9]{1,3})", $_SERVER['HTTP_USER_AGENT'], $match)) {
	$BName = "Konqueror";
	$BVersion = $match[2];
    } elseif (eregi("(lynx)/([0-9]{1,2}.[0-9]{1,2}.[0-9]{1,2})", $_SERVER['HTTP_USER_AGENT'], $match)) {
	$BName = "Lynx ";
	$BVersion = $match[2];
    } elseif (eregi("(links) \(([0-9]{1,2}.[0-9]{1,3})", $_SERVER['HTTP_USER_AGENT'], $match)) {
	$BName = "Links ";
	$BVersion = $match[2];
    } elseif (eregi("(msie) ([0-9]{1,2}.[0-9]{1,3})", $_SERVER['HTTP_USER_AGENT'], $match)) {
	$BName = "MSIE ";
	$BVersion = $match[2];
    } elseif (eregi("(netscape6)/(6.[0-9]{1,3})", $_SERVER['HTTP_USER_AGENT'], $match)) {
	$BName = "Netscape ";
	$BVersion = $match[2];
    } elseif (eregi("mozilla/5", $_SERVER['HTTP_USER_AGENT'])) {
	$BName = "Netscape ";
	$BVersion = "Unknown";
    } elseif (eregi("(mozilla)/([0-9]{1,2}.[0-9]{1,3})", $_SERVER['HTTP_USER_AGENT'], $match)) {
	$BName = "Netscape ";
	$BVersion = $match[2];
    } elseif (eregi("w3m", $_SERVER['HTTP_USER_AGENT'])) {
	$BName = "w3m";
	$BVersion = "Unknown";
    } else {
	$BName = "Unknown";
	$BVersion = "Unknown";
    }

// System
    if (eregi("linux", $_SERVER['HTTP_USER_AGENT'])) {
	$BPlatform = "Linux";
    } elseif (eregi("win32", $_SERVER['HTTP_USER_AGENT'])) {
	$BPlatform = "Windows";
    } elseif ((eregi("(win)([0-9]42})", $_SERVER['HTTP_USER_AGENT'], $match)) || (eregi("(windows) ([0-9]{4})", $_SERVER['HTTP_USER_AGENT'], $match))) {
	$BPlatform = "Windows $match[2]"; // win2k
    } elseif ((eregi("(win)([0-9]{2})", $_SERVER['HTTP_USER_AGENT'], $match)) || (eregi("(windows) ([0-9]{2})", $_SERVER['HTTP_USER_AGENT'], $match))) {
	$BPlatform = "Windows $match[2]";
    } elseif (eregi("(winnt)([0-9]{1,2}.[0-9]{1,2}){0,1}", $_SERVER['HTTP_USER_AGENT'], $match)) {
	$BPlatform = "Windows NT $match[2]";
    } elseif (eregi("(windows nt)( ){0,1}([0-9]{1,2}.[0-9]{1,2}){0,1}", $_SERVER['HTTP_USER_AGENT'], $match)) {
	$BPlatform = "Windows NT $match[3]";
    } elseif (eregi("mac", $_SERVER['HTTP_USER_AGENT'])) {
	$BPlatform = "Macintosh";
    } elseif (eregi("(sunos) ([0-9]{1,2}.[0-9]{1,2}){0,1}", $_SERVER['HTTP_USER_AGENT'], $match)) {
	$BPlatform = "SunOS $match[2]";
    } elseif (eregi("(beos) r([0-9]{1,2}.[0-9]{1,2}){0,1}", $_SERVER['HTTP_USER_AGENT'], $match)) {
	$BPlatform = "BeOS $match[2]";
    } elseif (eregi("freebsd", $_SERVER['HTTP_USER_AGENT'])) {
	$BPlatform = "FreeBSD";
    } elseif (eregi("openbsd", $_SERVER['HTTP_USER_AGENT'])) {
	$BPlatform = "OpenBSD";
    } elseif (eregi("irix", $_SERVER['HTTP_USER_AGENT'])) {
	$BPlatform = "IRIX";
    } elseif (eregi("os/2", $_SERVER['HTTP_USER_AGENT'])) {
	$BPlatform = "OS/2";
    } elseif (eregi("plan9", $_SERVER['HTTP_USER_AGENT'])) {
	$BPlatform = "Plan9";
    } elseif (eregi("unix", $HTTP_USER_AGENT) || eregi("hp-ux", $_SERVER['HTTP_USER_AGENT'])) {
	$BPlatform = "Unix";
    } elseif (eregi("osf", $_SERVER['HTTP_USER_AGENT'])) {
	$BPlatform = "OSF";
    } else {
	$BPlatform = "Unknown";
    }

    return $BName;
}

/**
 * Based on an example by ramdac at ramdac dot org
 * Returns a multi-dimensional array from a CSV file optionally using the
 * first row as a header to create the underlying data as associative arrays.
 * @param string $file Filepath including filename
 * @param bool $head Use first row as header.
 * @param string $delim Specify a delimiter other than a comma.
 * @param int $len Line length to be passed to fgetcsv
 * @return array or false on failure to retrieve any rows.
 */
function importcsv($file, $head = false, $delim = ";", $len = 1000) {
    setlocale(LC_ALL, 'en_US.UTF-8');
    $cnt = 0;
    $return = false;
    $handle = fopen($file, "r");
    if ($head) {
	$header = fgetcsv($handle, $len, $delim);
    }
    while (($data = fgetcsv($handle, $len, $delim)) !== FALSE AND $cnt < 8000) {
	$cnt++;
	if ($head AND isset($header)) {
	    foreach ($header as $key => $heading) {
		$row[$heading] = (isset($data[$key])) ? $data[$key] : '';
	    }
	    $return[] = $row;
	} else {
	    $return[] = $data;
	}
    }
    fclose($handle);
    return $return;
}

function send_email($recipient, $sender, $subject, $text, $hash = null) {
    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=utf-8\n";
    $headers .= "X-Priority: 3\n";
    $headers .= "X-MSMail-Priority: Normal\n";
    $headers .= "X-Mailer: php\n";
//$sender = "leos@mazel";
//$recipient = "leos@mazel";

    if (is_array($text)) {
	foreach ($text AS $line) {
	    $new_text .= $line . "\n";
	}
	$text = $new_text;
    }

    $headers .= "From: <$sender>\n";
    mail($recipient, $subject, $text, $headers);
    //mail("pulkrabke@3nicom.cz", $subject, $text, $headers);
}

//function translate($string, $subarray = "text") {
//	global $lang;
//	if ($lang[$subarray][$string]) {
//		return $lang[$subarray][$string];
//	} else {
//		return $string;
//	}
//}


function translate($string, $subarray = "text") {
    global $language;
    $Translate = new Translate($language);
    return Translate::translate($string);
//		global $lang;
//		if ($lang[$subarray][$string]) {
//			return $lang[$subarray][$string];
//		} else {
//			return $string;
//		}
}

function url_friendly($title) {
    static $tbl = array("\xc3\xa1" => "a", "\xc3\xa4" => "a", "\xc4\x8d" => "c", "\xc4\x8f" => "d", "\xc3\xa9" => "e", "\xc4\x9b" => "e", "\xc3\xad" => "i", "\xc4\xbe" => "l", "\xc4\xba" => "l", "\xc5\x88" => "n", "\xc3\xb3" => "o", "\xc3\xb6" => "o", "\xc5\x91" => "o", "\xc3\xb4" => "o", "\xc5\x99" => "r", "\xc5\x95" => "r", "\xc5\xa1" => "s", "\xc5\xa5" => "t", "\xc3\xba" => "u", "\xc5\xaf" => "u", "\xc3\xbc" => "u", "\xc5\xb1" => "u", "\xc3\xbd" => "y", "\xc5\xbe" => "z", "\xc3\x81" => "A", "\xc3\x84" => "A", "\xc4\x8c" => "C", "\xc4\x8e" => "D", "\xc3\x89" => "E", "\xc4\x9a" => "E", "\xc3\x8d" => "I", "\xc4\xbd" => "L", "\xc4\xb9" => "L", "\xc5\x87" => "N", "\xc3\x93" => "O", "\xc3\x96" => "O", "\xc5\x90" => "O", "\xc3\x94" => "O", "\xc5\x98" => "R", "\xc5\x94" => "R", "\xc5\xa0" => "S", "\xc5\xa4" => "T", "\xc3\x9a" => "U", "\xc5\xae" => "U", "\xc3\x9c" => "U", "\xc5\xb0" => "U", "\xc3\x9d" => "Y", "\xc5\xbd" => "Z");


    $r = strtr($title, $tbl);

    preg_match_all('/[a-zA-Z0-9]+/', $r, $nt);
    $r = strtolower(implode('-', $nt[0]));

    return $r;
}

function generate_password($length = 6) {

    $password = "";
    $possible = "0123456789bcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    // set up a counter
    $i = 0;
    while ($i < $length) {
	$char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
	// we don't want this character if it's already in the password
	if (!strstr($password, $char)) {
	    $password .= $char;
	    $i++;
	}
    }
    return $password;
}

function file_upload_error_message($error_code) {
    switch ($error_code) {
	case UPLOAD_ERR_INI_SIZE:
	    return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
	case UPLOAD_ERR_FORM_SIZE:
	    return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
	case UPLOAD_ERR_PARTIAL:
	    return 'The uploaded file was only partially uploaded';
	case UPLOAD_ERR_NO_FILE:
	    return 'No file was uploaded';
	case UPLOAD_ERR_NO_TMP_DIR:
	    return 'Missing a temporary folder';
	case UPLOAD_ERR_CANT_WRITE:
	    return 'Failed to write file to disk';
	case UPLOAD_ERR_EXTENSION:
	    return 'File upload stopped by extension';
	default:
	    return 'Unknown upload error';
    }
}

?>