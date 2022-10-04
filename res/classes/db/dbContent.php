<?php

/**
 * Content
 * @author Error
 */
class dbContent extends dbBase {

    const DEFAULT_ID_LANG = 1;
    const CONTENT_WIDTH = 980; // hodnota pouzita v fck editoru pri uploadu obrazku - resize

    public $id;
    public $id_content_category;
    public $title_1;
    public $title_2;
    public $title_3;
    public $text_1;
    public $text_2;
    public $text_3;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $image;
    public $id_lang;
    public $id_author;
    public $priority;
    public $rate;
    public $visible;
    public $visible_from;
    public $visible_to;
    public $author;
    public $homepage;
    public $id_template;
    public $datum;
    public $orderBy = ' priority DESC ';
    private static $cache;

    /**
     * For compatibility reasons
     * @param array $array
     */
    public function __construct(Array $array) {
        foreach ($array as $key => $var) {
            $this->$key = $var;
        }
        $this->id = $this->id_content;
        $this->id_lang = $this->id_lang ? $this->id_lang : self::DEFAULT_ID_LANG;
    }

    /**
     * Vraci dbContent podle id_content
     * @param int $id
     * @throws dbException
     * @return dbContent|false
     */
    public static function getById($id) {
        $res = dbI::cachedQuery("
				SELECT *
				FROM s3n_content
				WHERE id_content = %i
			", $id)->cache(self::$cache['getById'][$id])->fetch('dbContent', 'id_content');
        return $res;
    }

    /**
     * Vraci dbContent podle id_content_category. Je mozne vyhledove ze bude vracet vic dbContent pripojenych k dbContentCategory
     * @param int $id
     * @throws dbException
     * @return dbContent|false
     */
    public static function getByIdContentCategory($id) {
        $res = dbI::query("
				SELECT *
				FROM s3n_content
				WHERE id_content_category = %i
			", $id)->cache(self::$cache['getByIdContentCategory'][$id])->fetch('dbContent');
        return $res;
    }

    /**
     * Vraci dbUser podle id_author
     * @throws dbException
     * @return dbUser|false
     */
    public function getAuthor() {
        return dbUser::getById($this->id_author);
    }

}
