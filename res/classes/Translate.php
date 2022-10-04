<?php


/**
 * Description of Translate
 *
 * @author leos
 */
class Translate {

	public static $langCode;
	public static $cache = array();

	public function __construct($langCode) {
		self::$langCode = $langCode;
	}

	public static function translate($text) {
		if(self::$cache['translate'][$text]) return self::$cache['translate'][$text];
		$dbTranslate = self::getDb($text);
		$plainTranslate = self::getText($text);
		$translate = $dbTranslate ? $dbTranslate : $plainTranslate;
		$res = $translate ? $translate : $text;
		self::$cache['translate'][$text] = $res;
		return $res;
	}

	private static function getDb($text) {
		$text = trim($text);
//		$pTranslate = dbI::cachedQuery("SELECT * FROM s3n_translates WHERE text = '".$text."' ")->cache(self::$cache['getDb'][md5($text)])->fetch();
		$pTranslate = dbI::query("SELECT * FROM s3n_translates WHERE text = '".$text."' ")->fetch();
		if(!$pTranslate) {
			if(self::$langCode == "cs") $r = dbI::query("INSERT INTO s3n_translates (`text`, ".self::$langCode.") VALUES ('$text', '".self::getText($text)."')")->result();
			return false;
		} else {
			if($pTranslate && $pTranslate->{self::$langCode}) {
				return $pTranslate->{self::$langCode};
			} else {
				$translate = self::getText($text);
				$r = dbI::query("UPDATE s3n_translates SET ".self::$langCode." = '".$translate."' WHERE text = '$text'")->result();
				return $translate;
			}
		}
		return false;
	}

	private static function getText($text) {
		global $lang;
		return $lang["text"][trim($text)];

	}

	public static function getAll($onlyVisible = false) {
		if($onlyVisible) {
			return dbI::query("SELECT * FROM s3n_translates WHERE visible = 1 ORDER by text")->fetchAll();
		} else {
			return dbI::query("SELECT * FROM s3n_translates ORDER by text")->fetchAll();
		}
	}

	public static function set($id, $cs, $sk, $de) {
		return dbI::query("UPDATE s3n_translates SET cs = %s, sk = %s, de = %s WHERE id = %i", $cs, $sk, $de, $id)->result();
	}
	public static function hide($id) {
		return dbI::query("UPDATE s3n_translates SET visible = 0 WHERE id = %i", $id)->result();
	}
	public static function unHide($id) {
		return dbI::query("UPDATE s3n_translates SET visible = 0 WHERE id = %i", $id);
	}



}

?>
