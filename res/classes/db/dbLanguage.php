<?php


/**
 * Description of dbLanguage
 *
 * @author leos
 */
class dbLanguage {
	
	public $id;
	public $code;
	public $currency_code;
	public $name;
	public $default;
	public $visible;
	
	
	/**
	 * For compatibility reasons
	 * @param array $array
	 */
	public function __construct(Array $array) {
		foreach ($array as $key => $var) {
			$this->$key = $var;
		}
		$this->id = $this->id_lang;
		$this->name = $this->lang_name;
		$this->code = $this->lang_code;
	}
	
	/**
	 * Returns a dbLanguage by id
	 * @param int $id
	 * @throws dbException
	 * @return dbdbLanguage|false
	 */
	public static function getById($id) {
		return dbI::Query("SELECT * FROM s3n_langs WHERE id = %i", $id)->fetch('dbLanguage');
	}
	
	
	/**
	 * Returns a default dbLanguage
	 * @param int $id
	 * @throws dbException
	 * @return dbLanguage|false
	 */
	public static function getDefault() {
		return dbI::Query("SELECT * FROM s3n_langs WHERE `default` = '1'")->fetch('dbLanguage');
	}
	
	public static function getAll($onlyVisible = NULL) {
		return new dbArray(dbI::query("SELECT * FROM s3n_langs WHERE visible = COALESCE(%s, visible)", $onlyVisible)->fetchAll('dbLanguage'));
	}
	
	public function getCurency() {
		return dbCurrency::getByCode($this->currency_code);
	}
	
}

?>
