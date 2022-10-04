<?php
	/**
	* ContentType
	* @author Error
	*/
	class dbContentType extends dbBase {

		public $id;
		public $name;
		public $seoname;
		public $default;
		public $anotacniText;
		public $anotacniObrazek;

		private static $cache;

		const DEFAULT_ID_CONTENT_TYPE = 3;


		/**
		* For compatibility reasons
		* @param array $array
		*/
		public function __construct(Array $array) {
			foreach ($array as $key => $var) {
				$this->$key = $var;
			}
			$this->id = $this->id_content_type;
			$this->seoname = $this->seo_name;
			$this->anotacniText = $this->anotacni_text;
			$this->anotacniObrazek = $this->anotacni_obrazek;
		}

		/**
		* Returns a contentType by id_content_type
		* @param int $id
		* @throws dbException
		* @return dbContentType|false
		*/
		public static function getById($id) {
			return dbI::cachedQuery("SELECT * FROM s3n_content_type WHERE id_content_type = %i ", $id)->cache(self::$cache["getById"][$id])->fetch('dbContentType');
		}

		/**
		* Returns a contentType by id_content_type
		* @param int $id
		* @throws dbException
		* @return dbContentType|false
		*/
		public static function getBySeoName($seoName) {
			return dbI::cachedQuery("SELECT * FROM s3n_content_type WHERE seo_name = %s ", $seoName)->cache(self::$cache['getBySeoName'][$seoName])->fetch('dbContentType');
		}

		/**
		* Returns a contentType by id_content_type
		* @param int $id
		* @throws dbException
		* @return dbContentType|false
		*/
		public static function getDefault() {
			return dbI::cachedQuery("SELECT * FROM s3n_content_type WHERE `default` = %s ", 1)->cache(self::$cache["getDefault"])->fetch('dbContentType');
		}


		/**
		* Vraci vsechny dbContentType
		* @throws dbException
		* @return array of dbContentType
		*/
		public static function getAll() {
			return dbI::query("SELECT * FROM s3n_content_type ORDER BY id_content_type ")->fetchAssoc('dbContentType', 'id_content_type');
		}

	}