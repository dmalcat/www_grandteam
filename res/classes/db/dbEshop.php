<?php

/**
 * Description of dbEshop
 * @package db
 * @author leos
 */
class dbEshop {

	public $id;
	public $name;
	public $description;
	public $domain;
	public $visible;
	public $language;
	public $currency_code;
	public $dodavatel_nazev;
	public $dodavatel_adresa;
	public $dodavatel_psc;
	public $dodavatel_mesto;
	public $dodavatel_telefon;
	public $dodavatel_email;
	public $dodavatel_fax;
	public $dodavatel_ic;
	public $dodavatel_dic;
	public $dodavatel_banka;
	public $dodavatel_cu;
	private $enabled_eshop;
	private $enabled_users;
	private $enabled_permissions;
	private $enabled_calendar;
	private $enabled_galleries;
	private $enabled_polls;
	private $enabled_discussion;
	private $enabled_languages;
	public $meta_title;
	public $meta_description;
	public $meta_keywords;
	public $email;
	public $ga_key;
	public $heureka_api_code;
	public $sms_brana_login;
	public $sms_brana_pass;
	public $sms_brana_pass_hash;

	/**
	 * For compatibility reasons
	 * @param array $array
	 */
	public function __construct(Array $array) {
		foreach ($array as $key => $var) {
			$this->$key = $var;
		}
		$this->id = $this->id_eshop;
	}

	public function __destruct() {
		
	}

	public function cleanUp() {
		Helper_FileSystem::deleteDirectory(PROJECT_DIR . 'userfiles');
		Helper_FileSystem::checkDir(PROJECT_DIR . 'userfiles');
	}

	/**
	 * Returns a dbEshop by id
	 * @param int $id
	 * @throws dbException
	 * @return dbEshop|false
	 */
	public static function getById($id) {
		return dbI::Query("SELECT * FROM s3n_eshop WHERE id_eshop = %i", $id)->fetch('dbEshop');
	}

	/**
	 * Returns a dbEshop by domain
	 * @param int $id
	 * @throws dbException
	 * @return dbEshop|false
	 */
	public static function getByDomain($domain = null) {
		if (!$domain) $domain = Registry::getDomainName();
		$res = dbI::Query("SELECT * FROM s3n_eshop WHERE domain LIKE '%$domain%'")->fetch('dbEshop');
		if (!$res) {
			$res = dbI::Query("SELECT * FROM s3n_eshop LIMIT 0,1")->fetch('dbEshop');
		}
		if (!$res) throw new Exception('Nenalezen eshop pro domenu ' . $domain);
		return $res;
	}

	public static function getAll($onlyVisible = null) {
		return new dbArray(dbI::query("SELECT * FROM s3n_eshop WHERE visible = COALESCE(%s, visible)", $onlyVisible)->fetchAll('dbEshop'));
	}

	public function getEnabledEshop() {
		return (bool) $this->enabled_eshop;
	}

	public function getEnabledUsers() {
		return (bool) $this->enabled_users;
	}

	public function getEnabledCalendar() {
		return (bool) $this->enabled_calendar;
	}

	public function getEnabledGalleries() {
		return (bool) $this->enabled_galleries;
	}

	public function getEnabledPolls() {
		return (bool) $this->enabled_polls;
	}

	public function getEnabledDiscussion() {
		return (bool) $this->enabled_discussion;
	}

	public function getEnabledLanguages() {
		return (bool) $this->enabled_languages;
	}

	public function getEnabledPermissions() {
		return (bool) $this->enabled_permissions;
	}

}

?>
