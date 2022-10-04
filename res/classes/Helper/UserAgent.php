<?php

/**
 * trida pro zjistovani useragentu uzivatelu
 */
class Helper_UserAgent {

	const iOS = 'iOS';
	const iOSiPad = 'iOSiPad';

	private static $iOS = 'iPhone|iPad|iPod';
	private static $iOSiPad = 'iPad';

	public static function is($type) {
		switch ($type) {
			case self::iOS : $reg = self::$iOS; break;
			case self::iOSiPad : $reg = self::$iOSiPad; break;
		}
		return (bool)preg_match('/[^A-Za-z0-9]('.$reg.')[^A-Za-z0-9]/', $_SERVER['HTTP_USER_AGENT']);
		//return (bool)preg_match('/('.$reg.')/', $_SERVER['HTTP_USER_AGENT']);
	}

}
