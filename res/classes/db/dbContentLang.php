<?php

/**
 * dbContentLang
 * @author Error
 */
class dbContentLang extends dbBase {

	public $id;
	public $name;
	public $code;
	public $priority;
	public $default;
	private static $cache;

	/**
	 * For compatibility reasons
	 * @param array $array
	 */
	public function __construct(Array $array) {
		foreach ($array as $key => $var) {
			$this->$key = $var;
		}
		$this->id = $this->id_content_lang;
	}

	/**
	 * Returns a dbContentLang by id_content_lang
	 * @param int $id
	 * @throws dbException
	 * @return dbContentLang|false
	 */
	public static function getById($id) {
		return dbI::cachedQuery("SELECT * FROM s3n_content_lang WHERE id_content_lang = %i ", $id)->cache(self::$cache['getById'][$id])->fetch('dbContentLang');
	}

	/**
	 * Returns a dbContentLang podle id_content_lang
	 * @param int $id
	 * @throws dbException
	 * @return dbContentLang|false
	 */
	public static function getByCode($code) {
		return dbI::cachedQuery("SELECT * FROM s3n_content_lang WHERE code = %s ", $code)->cache(self::$cache['getByCode'][$code])->fetch('dbContentLang');
	}

	/**
	 * Returns a default dbContentLang
	 * @throws dbException
	 * @return dbContentLang|false
	 */
	public static function getDefault() {
//		return dbI::cachedQuery("SELECT * FROM s3n_content_lang WHERE `default` = %s ", 1)->cache(self::$cache['getDefault'])->fetch('dbContentLang');
		return dbI::query("SELECT * FROM s3n_content_lang WHERE `default` = %s ", 1)->fetch('dbContentLang');
	}

	/**
	 * Vraci vsechny dbContentLang
	 * @throws dbException
	 * @return array of dbContentLang
	 */
	public static function getAll() {
		return dbI::query("SELECT * FROM s3n_content_lang ORDER BY priority DESC;")->fetchAll('dbContentLang');
	}

}
