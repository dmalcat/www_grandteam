<?php

//

/**
 * Content
 * @author Error
 */
class dbContentCategory extends dbBase {

    const TYPE_CLANEK = 0;
    const TYPE_MENU = 1;
    const DEEP = 5;
    const IMAGES_PATH = "/data/images_content_category/";
    const FILES_PATH = "/data/files_content_category/";
    const VIDEOS_PATH = "/data/videos_content_category/";
    const IMAGES_COUNT = 4;
    const FILES_COUNT = 2;

    public $id;
    public $id_parent;
    public $name;
    public $id_content_type;
    public $id_category;
    public $seoname;
    public $description;
    public $external_url;
    public $priority;
    public $id_content_lang;
    public $author;
    public $id_author;
    public $homepage;
    public $id_master;
    public $gps_lat;
    public $gps_lng;
    public $datum;
    public $visible_from;
    public $visible_to;
    public $image_1;
    public $image_2;
    public $image_3;
    public $image_4;
    public $image_5;
    public $image_6;
    public $image_7;
    public $image_8;
    public $image_9;
    private $video_1;
    private $video_2;
    private $video_3;
    private $video_original_1;
    private $video_original_2;
    private $video_original_3;
    private $video_thumbnail_1;
    private $video_thumbnail_2;
    private $video_thumbnail_3;
    public $sub_content_category_counter_limit;
    public $category;
    public $menu;
    private $image_1_width;
    private $image_1_height;
    private $image_1_size;
    private $image_2_width;
    private $image_2_height;
    private $image_2_size;
    private $image_3_width;
    private $image_3_height;
    private $image_3_size;
    private $image_4_width;
    private $image_4_height;
    private $image_4_size;
    public $visible;
    public $count;
    public $image1;
    public $image2;
    public $image3;
    public $video1;
    public $video2;
    public $video3;
    public $idOdbor;
    public $idVizitka;
    public $selected;
    public $znacka;
    public $model;
    public $rok;
    public $motor;
    public $provedeni;
    public $objem_zavazadlo;
    public $spotreba;
    public $max_rychlost;
    public $zrychleni;
    public $objem;
    public $vykon;
    public $palivo;
    public $autor;
    public $price;
    private static $_url = '';
    private static $limit = 18;
    private static $_pg = 1;
    private static $_offset = 0;
    private static $_numRows;
    private static $_idLang;
    private static $_idType;
    private static $cache;
    public static $params = [];
    private static $_filter = array();
    public static $_dateCheckContentType = array(
        1, 7, 8, 9, 11
    );
    public static $pCategories = [
        1 => "Zajímavosti",
        2 => "Autokatalog",
        3 => "Testy",
        4 => "Poradna",
        5 => "Svolávací akce",
    ];
    public static $pCategoriesOld = [
        "Společnost" => [
            1 => "Celebrity",
            2 => "Rozhovory",
            3 => "Recenze",
            4 => "Příroda",
            5 => "Sport",
        ],
        "Zdraví" => [
            6 => "Zdraví životní styl",
            7 => "Zdravotnictví",
            8 => "Ekologie",
            9 => "Jídlo a pití",
            10 => "Psychologie",
        ],
        "Technika" => [
            11 => "Automobily",
            12 => "Mobily",
            13 => "Počítače",
            14 => "Internet",
            15 => "Poradna",
        ],
        "Cestování" => [
            16 => "Čechy",
            17 => "Zahraničí",
            18 => "Hodnocení cestovek, ubytování",
            19 => "Cestopisy",
            20 => "Výlety",
        ],
        "Trendy" => [
            21 => "Politika",
            22 => "Ekonomika",
            23 => "Finance",
            24 => "Hračky a Hi-tech",
            25 => "Finanční gramotnost",
        ],
        "Online" => [
            26 => "Soutěže",
            27 => "Online Chat",
            28 => "Zábava",
            29 => "Blogy",
            30 => "Cosi",
        ]
    ];
    public static $pColors = [
        1 => "#2bb5bc",
        2 => "#109da5",
        3 => "#14d5e0",
        4 => "#2de5ef",
//        5 => "#b6ecef",
        5 => "#2390a3",
        6 => "#29b539",
        7 => "#21bc12",
        8 => "#2fe51d",
        9 => "#7add71",
        10 => "#ace8a7",
        11 => "#e51b40",
        12 => "#e83a59",
        13 => "#d14d64",
        14 => "#f9728a",
        15 => "#ed9eac",
        16 => "#ccc928",
        17 => "#e8e543",
        18 => "#dbd95e",
        19 => "#f4f284",
        20 => "#e5e4c3",
        21 => "#ea48ac",
        22 => "#c9549c",
        23 => "#e070b5",
        24 => "#e08bbf",
        25 => "#edbdda",
        26 => "#1abc86",
        27 => "#19e5a1",
        28 => "#29e8a8",
        29 => "#58f4c0",
        30 => "#9ad1be",
    ];
    private static $pMainColors = [
        1 => "#0e8a91",
        2 => "#248712",
        3 => "#ba0e2e",
        4 => "#e8e40b",
        5 => "#bc2080",
        6 => "#1b996f",
    ];

    /**
     * For compatibility reasons
     * @param array $array
     */
    public function __construct(Array $array) {
        global $p_pars;
        foreach ($array as $key => $var) {
            $this->$key = $var;
        }
        $this->id = $this->id_content_category;
        $this->seoname = $this->seo_name;
        $this->type = $this->menu;
        $this->idOdbor = $this->id_odbor;
        $this->idVizitka = $this->id_vizitka;
        if (in_array($this->seoname, (array) $p_pars)) {
            $this->selected = true; //TODO poresit nezavisle na url - tzn dohledavat zarazeni
        }

//	self::setLang(dbContentLang::getById($this->id_content_lang));
//	self::setType(dbContentType::getById($this->id_content_type));
        for ($i = 1; $i <= self::IMAGES_COUNT; $i++) {
            $image = "image_" . $i;
            $Image = "image" . $i;
            if ($this->$image) {
                $this->$Image->original = "/" . self::IMAGES_PATH . $this->id . "/" . $this->$image;
                $this->$Image->thumbnail = "/T-" . self::IMAGES_PATH . $this->id . "/" . $this->$image;
                $this->$Image->preview = "/P-" . self::IMAGES_PATH . $this->id . "/" . $this->$image;
                $this->$Image->detail = "/D-" . self::IMAGES_PATH . $this->id . "/" . $this->$image;
                $this->$Image->width = $this->{$image . "_width"};
                $this->$Image->height = $this->{$image . "_height"};
                $this->$Image->size = $this->{$image . "_size"};
            }
        }
        for ($i = 1; $i <= self::FILES_COUNT; $i++) {
            $file = "file_" . $i;
            $File = "file" . $i;
            if ($this->$file) {
                $this->$File->original = self::FILES_PATH . $this->id . "/" . $this->$file;
                $this->$File->size = $this->{$file . "_size"};

                $fileInfo = pathinfo($this->$File->original);
                $this->$File->extension = $fileInfo['extension'];
                $this->$File->fileInfo = dbI::cachedQuery("SELECT * FROM s3n_file_types WHERE extensions = %s", $this->$File->extension)->cache(self::$cache['fileInfo'][$this->$File->extension])->fetch();
            }
        }
    }

    /**
     * Vraci url z aktualnidbContentCategory
     * @throws dbException
     * @return string
     */
    public function getUrl($addDomain = false) {
        if ($this->url) {
            return $this->url;
        }
        $this->url = $this->external_url ? $this->external_url : "/" . self::getContentCategoryUrl($this->id);
        self::$_url = '';
        if ($addDomain) {
            return Registry::getDomain() . $this->url;
        } else {
            return $this->url;
        }
    }

//	/**
//	 * Vraci url z aktualnidbContentCategory
//	 * @throws dbException
//	 * @return string
//	 */
//	public function getUrl($addDomain = false, $getExternal = true) {
//		self::$_url = "";
////		$this->url = "";
//		if ($this->url) return $this->url;
//		if ($getExternal) {
//			$this->url = $this->external_url ? $this->external_url : ("/" . self::getContentCategoryUrl($this->id));
//			if ($this->external_url && strpos("http://", $this->external_url) === false) {
////				$this->url = "http://" . $this->url;
//				return $this->url;
//			}
//		} else {
//			$this->url = "/" . self::getContentCategoryUrl($this->id);
//			self::$_url = '';
//			if ($addDomain) {
//				return Registry::getDomain() . $this->url;
//			} else {
//				return $this->url;
//			}
//		}
//	}

    /**
     * Vraci target do <a> ( nic, nebo _blank )
     * @throws dbException
     * @return string
     */
    public function getTarget() {
        if (!$this->url) {
            $this->url = self::getContentCategoryUrl($this->id);
        }
        if (strpos($this->url, "ttp:") || strpos($this->url, "ttps:")) {
            $this->target = "_blank";
        } else {
            $this->target = "";
        }
        return $this->target;
    }

    /**
     * Vraci dbContentCategory podle id_content_category
     * @param int $id
     * @throws dbException
     * @return dbContentCategory|false
     */
    public static function getById($id) {
        if (!$id)
            return null;
        self::fixMissingContent($id);
        $res = dbI::query("SELECT * FROM s3n_content_category WHERE id_content_category = %i", $id)->fetch('dbContentCategory');
        return $res;
    }

    /**
     * Vraci dbContentCategory podle id_content
     * @param int $id
     * @throws dbException
     * @return dbContentCategory|false
     */
    public static function getByIdContent($id) {
        return dbI::query("SELECT cc.* FROM s3n_content_category cc INNER JOIN s3n_content c ON cc.id_content_category = c.id_content_category AND c.id_content = %i", $id)->fetch('dbContentCategory');
    }

    /**
     * Vraci dbContent pripojene k aktualni contentCategory
     * @param int $id
     * @throws dbException
     * @return dbContent|false
     */
    public function getContent() {
        return dbContent::getByIdContentCategory($this->id);
    }

    /**
     * Vraci dbContentCategory podle seoname
     * @param string $seoName
     * @throws dbException
     * @return dbContentCategory|false
     */
    public static function getBySeoName($seoName) {
        $res = dbI::query("
				SELECT *
				FROM s3n_content_category
				WHERE seo_name = %s
			", $seoName)->cache(self::$cache['getBySeoName'][$seoName])->fetch("dbContentCategory");
        return $res;
    }

    /**
     * Vraci dbContentCategory podle name
     * @param string $seoName
     * @throws dbException
     * @return dbContentCategory|false
     */
    public static function getByName($name) {
        $res = dbI::query("
				SELECT *
				FROM s3n_content_category
				WHERE name = %s
			", $name)->fetch("dbContentCategory");
        return $res;
    }

    /**
     * Vraci dbContentType z aktualni dbContentCategory
     * @throws dbException
     * @return dbContentType
     */
    public function getContentType() {
        return dbContentType::getById($this->id_content_type);
    }

    /**
     * Vraci obrazek z aktualni dbContentCategory podle indexu ( 1,2,3 ) apod
     * @param index
     * @throws dbException
     * @return dbContentType
     */
    public function getImageOld($index) {
        $foo = "image_" . $index;
        return new ArrayObject(array(
            "image" => $this->$foo,
            "width" => $this->$foo . "_width",
            "height" => $this->$foo . "_height"
        ));
    }

    /**
     * Vraci obrazek z aktualni dbContentCategory podle indexu ( 1,2,3 ) apod
     * @param index
     * @throws dbException
     * @return dbContentType
     */
    public function getImage($index = 1, $type = "original", $forceDefault = FALSE) {
        $image = new stdClass();
        $foo = "image_" . $index;
        $image->image = $this->$foo;
        if (!$this->$foo && $forceDefault) {
            $this->$foo = "/images/default.jpg";
            $path = "";
        } else {
            $path = self::IMAGES_PATH . $this->id . "/";
        }

        $image->width = $this->$foo . "_width";
        $image->height = $this->$foo . "_height";
        switch ($type) {
            case "original":
                $image->src = $path . $this->$foo;
                break;
            case "preview":
                $image->src = $path . "P-" . $this->$foo;
                break;
            case "thumbnail":
                $image->src = $path . "T-" . $this->$foo;
                break;
            case "detail":
                $image->src = $path . "D-" . $this->$foo;
                break;
            default :
                $image->src = $path . "" . $this->$foo;
                break;
        }

        if (!file_exists(PROJECT_DIR . $image->src)) {
//            $image->src = "/images/hp_right_2.png";
        }

        return $image;
    }

    public function getImages() {
        $res = [];
        for ($index = 1; $index <= self::IMAGES_COUNT; $index++) {
            if ($this->getImage($index)->image) {
                $res[] = $this->getImage($index);
            }
        }
        return $res;
    }

    public function setContentType($contentType) {
        if ($contentType) {
            return dbI::query("UPDATE s3n_content_category SET id_content_type = %i WHERE id_content_category = %i", $contentType, $this->id)->update($this->id_content_type, $contentType)->result();
        }
    }

    public static function limit($offest = 0, $limit = 100) {

    }

    /**
     * Vraci vsechny dbContentCategory podle parametru - pozor - neresi se rekurzivne
     * @throws dbException
     * @return dbArray|dbContentCategory
     */
    public static function getAll($visible = null, $idParent = null, $idContentType = null, $idContentLang = null, $homepage = null, $visibleFrom = null, $visibleTo = null, $idCategory = null, $menu = null) {
        global $par_1;
        if (!$idContentLang) {
            $idContentLang = self::getLang()->id;
        }

        if (!$idContentType) {
            $idContentType = self::getType()->id;
        }

        if (in_array($idContentType, self::$_dateCheckContentType) || true) {
            if ($par_1 <> 'admin') {
                $visibleFrom = $visibleFrom ? $visibleFrom : date("Y-m-d H:i:s");
                $visibleTo = $visibleTo ? $visibleTo : date("Y-m-d H:i:s");
            }
        }

        if ($idCategory) {
            $cond = " AND id_category IN (" . implode(", ", (array) $idCategory) . ") ";
        } else {
            $cond = "";
        }

        $offset = self::getOffset();
        $limit = self::getLimit();

        $offset = 0;

        $res = new dbArray(dbI::query("SELECT SQL_CALC_FOUND_ROWS s3n_content_category.* FROM s3n_content_category WHERE "
                        . "visible = COALESCE(%s, visible) AND "
                        . "IFNULL(id_parent,0) = COALESCE(%i, 0) AND "
                        . "id_content_type = COALESCE(%i, id_content_type) AND "
                        . "id_content_lang = COALESCE(%i, id_content_lang) AND "
                        . "homepage = COALESCE(%s, homepage) AND "
                        . "(visible_from <= COALESCE(%s, '2099-01-01') OR visible_from IS NULL OR visible_from = '0000-00-00') AND "
                        . "(visible_to >= COALESCE(%s, '1980-01-01') OR visible_to IS NULL OR visible_to = '0000-00-00') AND "
                        . "menu = COALESCE(%s, menu) " . $cond
                        . "ORDER BY datum DESC LIMIT %i, %i", $visible, $idParent ? $idParent : NULL, $idContentType, $idContentLang, $homepage, $visibleFrom, $visibleTo, $menu, $offset, $limit
                )->fetchAssoc('dbContentCategory', 'id_content_category'));
//        print_p(dbI::getLastSQL());
        self::$_numRows = dbI::query("SELECT FOUND_ROWS();")->fetchSingle();
//        print_p(self::$_numRows);
        return $res;
    }

    public static function getAllByCategory($idCategory) {
        return dbI::query("SELECT * FROM s3n_content_category WHERE visible = '1' AND id_category IN %in ORDER BY id_content_category DESC", (array) $idCategory)->fetchAll("dbContentCategory");
    }

    /**
     * Vraci pocet subpolozek
     * @throws dbException
     * @return array of dbContentType
     */
    public static function getSubcategoriesCount($visible = null, $idParent = null, $idContentType = null, $idContentLang = null, $homepage = null, $visibleFrom = null, $visibleTo = null, $idCategory = null, $menu = null) {
        global $par_1;
        if ($par_1 == "admin") {
            $visibleFrom = "1970-01-01";
            $visibleTo = "2090-12-31";
        }
//      FB::log("dbContentCategory::getAll");
        if (!$idContentLang) {
            $idContentLang = self::getLang()->id;
        }
        if (!$idContentType) {
            $idContentType = self::getType()->id;
        }
        return dbI::query("SELECT count(*) FROM s3n_content_category WHERE
                visible = COALESCE(%s, visible) AND
                IFNULL(id_parent,0) = COALESCE(%i, 0) AND
                id_content_type = COALESCE(%i, id_content_type) AND
                id_content_lang = COALESCE(%i, id_content_lang) AND
                homepage = COALESCE(%s, homepage) AND
                (visible_from <= COALESCE(%s, '2099-01-01') OR visible_from IS NULL OR visible_from = '0000-00-00') AND
                (visible_to >= COALESCE(%s, '1980-01-01') OR visible_to IS NULL OR visible_to = '0000-00-00') AND
                (IFNULL(category,0) = COALESCE(%i, 0) OR category = COALESCE(%i, category)) AND
                menu = COALESCE(%s, menu)
            ", $visible, $idParent ? $idParent : NULL, $idContentType, $idContentLang, $homepage, $visibleFrom, $visibleTo, $idCategory, $idCategory, $menu
                )->fetchSingle();
    }

    /**
     * Vraci vsechny dbContentCategory podle parametru - pozor - resi se rekurzivne
     * @throws dbException
     * @return dbArray|dbContentCategory
     */
    public static function getAllRecursively($visible = null, $idParent = null, $idContentType = null, $idContentLang = null, $homepage = null, $visibleFrom = null, $visibleTo = null, $idCategory = null, $menu = null) {
        if (!$idContentLang) {
            $idContentLang = self::getLang()->id;
        }
        if (!$idContentType) {
            $idContentType = self::getType()->id;
        }
        $menu = 0;
        if ($idParent) {
//			FB::log("dbContentCategory::getAllRecursivelyParent");
            return new dbArray(dbI::query("
				SELECT c1.* FROM s3n_content_category AS c1
					Left Join s3n_content_category AS c2 ON c2.id_content_category = c1.id_parent
					Left Join s3n_content_category AS c3 ON c3.id_content_category = c2.id_parent
					Left Join s3n_content_category AS c4 ON c4.id_content_category = c3.id_parent
					Left Join s3n_content_category AS c5 ON c5.id_content_category  = c4.id_parent
				WHERE
					c1.visible = COALESCE(%s, c1.visible) AND
					c1.id_content_type = COALESCE(%i, c1.id_content_type) AND
					c1.id_content_lang = COALESCE(%i, c1.id_content_lang) AND
					c1.homepage = COALESCE(%s, c1.homepage) AND
					(c1.visible_from <= COALESCE(%s, '2099-01-01') OR c1.visible_from IS NULL OR c1.visible_from = '0000-00-00') AND
					(c1.visible_to >= COALESCE(%s, '1980-01-01') OR c1.visible_to IS NULL OR c1.visible_to = '0000-00-00') AND
					(IFNULL(c1.category,0) = COALESCE(%i, 0) OR c1.category = COALESCE(%i, c1.category)) AND
					c1.menu = COALESCE(%s, c1.menu) AND
					(c5.id_parent = %i OR c4.id_parent = %i OR c3.id_parent = %i OR c2.id_parent = %i OR c1.id_parent = %i)
					GROUP by c1.id_content_category ORDER BY c1.id_content_category , datum desc , id_parent desc", $visible, $idContentType, $idContentLang, $homepage, $visibleFrom, $visibleTo, $idCategory, $idCategory, $menu, $idParent, $idParent, $idParent, $idParent, $idParent)->fetchAll('dbContentCategory'));
        } else {
//			FB::log("dbContentCategory::getAllRecursively");
            return new dbArray(dbI::query("SELECT * FROM s3n_content_category WHERE
				visible = COALESCE(%s, visible) AND
				id_content_type = COALESCE(%i, id_content_type) AND
				id_content_lang = COALESCE(%i, id_content_lang) AND
				homepage = COALESCE(%s, homepage) AND
				(visible_from <= COALESCE(%t, '2099-01-01') OR visible_from IS NULL OR visible_from = '0000-00-00') AND
				(visible_to >= COALESCE(%t, '1980-01-01') OR visible_to IS NULL OR visible_to = '0000-00-00') AND
				(IFNULL(category,0) = COALESCE(%i, 0) OR category = COALESCE(%i, category)) AND
				menu = COALESCE(%s, menu) ORDER BY priority LIMIT 0, %i
			", $visible, $idContentType, $idContentLang, $homepage, $visibleFrom, $visibleTo, $idCategory, $idCategory, $menu, self::$limit
                    )->fetchAssoc('dbContentCategory', 'id_content_category'));
        }
    }

    /**
     * Vraci vsechny dbContentCategory podle parametru
     * @throws dbException
     * @return dbArray
     * @return array of dbContentType
     */
    public function getSubCategories($visible = true, $homepage = null, $visibleFrom = null, $visibleTo = null, $idCategory = null, $menu = null) {
        global $par_1;
        if ($par_1 == "admin") {
            $visibleFrom = "1970-01-01";
            $visibleTo = "2090-12-31";
        }

        return new dbArray(dbI::query("SELECT * FROM s3n_content_category WHERE
				visible = COALESCE(%s, visible) AND
				IFNULL(id_parent,0) = COALESCE(%i, 0) AND
				id_content_lang = COALESCE(%i, id_content_lang) AND
				homepage = COALESCE(%s, homepage) AND
				(visible_from <= COALESCE(%s, '2099-01-01') OR visible_from IS NULL OR visible_from = '0000-00-00') AND
				(visible_to >= COALESCE(%s, '1980-01-01') OR visible_to IS NULL OR visible_to = '0000-00-00') AND
				(IFNULL(category,0) = COALESCE(%i, 0) OR category = COALESCE(%i, category)) AND
				menu = COALESCE(%s, menu)  ORDER BY priority
			", $visible, $this->id, $this->id_content_lang, $homepage, $visibleFrom, $visibleTo, $idCategory, $idCategory, $menu
                )->cache(self::$cache['getSubCategories'][$this->id][(int) $visible][(int) $homepage][$visibleFrom][$visibleTo][$idCategory][$menu])->fetchAll('dbContentCategory'));
    }

    /**
     * Posune contentCategory nahoru
     * @throws dbException
     * @return true|false
     */
    public static function sortUp($idContentCategory) {
        Cache::flush();
        $dbCC = dbContentCategory::getById($idContentCategory);
        self::sortContentCategories($dbCC);
        $dbCC = dbContentCategory::getById($idContentCategory);
        if ($dbCC->id_parent) {
            $upperCC = dbI::query("SELECT * FROM s3n_content_category WHERE priority < %i AND id_parent = %i AND id_content_lang = %i AND id_content_type = %i ORDER BY priority DESC LIMIT 0,1", $dbCC->priority, $dbCC->id_parent, $dbCC->id_content_lang, $dbCC->id_content_type)->fetch('dbContentCategory');
        } else {
            $upperCC = dbI::query("SELECT * FROM s3n_content_category WHERE priority < %i AND id_parent IS NULL AND id_content_lang = %i AND id_content_type = %i ORDER BY priority DESC LIMIT 0,1", $dbCC->priority, $dbCC->id_content_lang, $dbCC->id_content_type)->fetch('dbContentCategory');
        }

        if ($upperCC) {
            dbI::query("UPDATE s3n_content_category SET priority = %i WHERE id_content_category = %i", $upperCC->priority, $dbCC->id_content_category)->result();
            dbI::query("UPDATE s3n_content_category SET priority = %i WHERE id_content_category = %i", $dbCC->priority, $upperCC->id_content_category)->result();
            return array("type" => "success", "swap" => array($dbCC->id_content_category, $upperCC->id_content_category));
        }
        return false;
    }

    /**
     * Posune contentCategory dolu
     * @throws dbException
     * @return true|false
     */
    public static function sortDown($idContentCategory) {
        Cache::flush();
        $dbCC = dbContentCategory::getById($idContentCategory);
        self::sortContentCategories($dbCC);
        $dbCC = dbContentCategory::getById($idContentCategory);

        if ($dbCC->id_parent) {
            $lowerCC = dbI::query("SELECT * FROM s3n_content_category WHERE priority > %i AND id_parent = %i AND id_content_lang = %i AND id_content_type = %i ORDER BY priority LIMIT 0,1", $dbCC->priority, $dbCC->id_parent, $dbCC->id_content_lang, $dbCC->id_content_type)->fetch('dbContentCategory');
        } else {
            $lowerCC = dbI::query("SELECT * FROM s3n_content_category WHERE priority > %i AND id_parent IS NULL AND id_content_lang = %i AND id_content_type = %i ORDER BY priority LIMIT 0,1", $dbCC->priority, $dbCC->id_content_lang, $dbCC->id_content_type)->fetch('dbContentCategory');
        }
        if ($lowerCC) {
            dbI::query("UPDATE s3n_content_category SET priority = %i WHERE id_content_category = %i", $lowerCC->priority, $dbCC->id_content_category)->result();
            dbI::query("UPDATE s3n_content_category SET priority = %i WHERE id_content_category = %i", $dbCC->priority, $lowerCC->id_content_category)->result();
            return array("type" => "success", "swap" => array($dbCC->id_content_category, $lowerCC->id_content_category));
        }
        return false;
    }

    /**
     * Srovna razeni tak aby slo po jednicce za sebou 1,2,3 ...
     * @throws dbException
     * @return true|false
     */
    private static function sortContentCategories(dbContentCategory $dbCC) { // je treba sem poslat libovolnoy contant category abysme zjistili kterej jazyk a content type chceme srovnat
        if ($dbCC->id_parent) {
            $pParents = dbI::query("SELECT DISTINCT(id_parent) FROM s3n_content_category WHERE id_content_lang = %i AND id_content_type = %i AND id_parent = %i", $dbCC->id_content_lang, $dbCC->id_content_type, $dbCC->id_parent)->fetchPairs();
        } else {
            $pParents = dbI::query("SELECT DISTINCT(id_parent) FROM s3n_content_category WHERE id_content_lang = %i AND id_content_type = %i AND id_parent IS NULL", $dbCC->id_content_lang, $dbCC->id_content_type)->fetchPairs();
        }
        foreach ($pParents as $idParent) {
            if ($idParent) {
                $pRes = dbI::query("SELECT * FROM s3n_content_category WHERE id_content_type = %i AND id_parent = %i ORDER BY priority", $dbCC->id_content_type, $idParent)->fetchAll();
            } else {
                $pRes = dbI::query("SELECT * FROM s3n_content_category WHERE id_content_type = %i AND id_parent IS NULL ORDER BY priority", $dbCC->id_content_type)->fetchAll();
            }
            $cnt = 1;
            foreach ($pRes AS $item) {
                dbI::query("UPDATE s3n_content_category SET priority = %i WHERE id_content_category = %i", $cnt, $item->id_content_category)->result();
                $cnt++;
            }
        }
        return true;
    }

    /**
     * Vraci vsechny dbContentCateogry podle policka gps v databazi
     * @throws dbException
     * @return dbContentCateogry|false
     */
    public static function getByAutor($autor) {
        return new dbArray(dbI::query("
			SELECT * FROM s3n_content_category cc
			WHERE gps = %s AND cc.visible = '1'
		", $autor)->fetchAll('dbContentCategory'));
    }

    /**
     * Vrati url vcetne zanoreni
     * @throws dbException
     * @return true|false
     */
    private static function getContentCategoryUrl($id_content_category, $recursive = true, $i = 0) {
        if ($i > CONTENT_DEEP) {
            throw new Exception('get_content_category_url - asi se nam tu neco cykli' . $id_content_category);
        }
//		$res = dbI::cachedQuery("SELECT * FROM s3n_content_category WHERE id_content_category = %i", $id_content_category)->cache(self::$cache['getContentCategoryUrl'][$id_content_category])->fetch();
        $res = dbI::query("SELECT * FROM s3n_content_category WHERE id_content_category = %i", $id_content_category)->cache(self::$cache['getContentCategoryUrl'][$id_content_category])->fetch();
        if (!$res->url)
            $res->url = $res->seo_name . "/";
        self::$_url = $res->url . self::$_url;
        if ($recursive && $res->id_parent)
            self::getContentCategoryUrl($res->id_parent, true, ++$i);
        $res = substr(self::$_url, 0, -1);
        return $res;
    }

    /**
     * Vrati vsechny pripojene galerie
     * @throws dbException
     * @return dbGallery|false
     */
    public function getMappedGalleries($idGalleryType = dbGallery::TYPE_FOTO, $position = null) {
        return dbI::query("SELECT * FROM s3n_content_category_map_gallery ccmg
			INNER JOIN s3n_gallery g ON ccmg.id_gallery = g.id_gallery AND g.id_gallery_type = %i
			WHERE id_content_category = %i AND position = COALESCE(%s, position) ORDER BY priority, g.id_gallery DESC", $idGalleryType, $this->id, $position)->fetchAll('dbGallery');
    }

    /**
     * Pripoji galerii k dbContentCategory, nebo zmeni poradi | prioritu
     * @param int $idGAllery
     * @param int $priority
     * @param string position top|middle|bottom
     * @throws dbException
     * @return dbGallery|false
     */
    public function mapGallery($idGallery, $priority = dbGallery::DEFAULT_PRIORITY, $position = dbGallery::DEFAULT_POSITION) {
        if (!$position)
            $position = dbGallery::DEFAULT_POSITION;
        $idContentMapGallery = dbI::query("select id_content_map_gallery from s3n_content_category_map_gallery where id_content_category = %i and id_gallery = %i", $this->id, $idGallery)->fetchSingle();
        if ($idContentMapGallery) {
            return dbI::query("UPDATE s3n_content_category_map_gallery SET priority = %i, position = %s WHERE id_content_map_gallery = %i", $priority, $position, $idContentMapGallery)->result();
        } else {
            return dbI::query("INSERT INTO s3n_content_category_map_gallery SET id_content_category = %i, id_gallery = %i, priority = %i, position = %s", $this->id, $idGallery, $priority, $position)->result();
        }
    }

    /**
     * Odebere propojeni galerie k dbContentCategory
     * @param int $idGAllery
     * @throws dbException
     * @return true|false
     */
    public function unMapGallery($idGallery) {
        return dbI::query("DELETE FROM s3n_content_category_map_gallery WHERE id_content_category = %i AND id_gallery = %i", $this->id, $idGallery)->result();
    }

    /**
     * Vloži novou položku menu
     * @param array $data
     * @throws dbException
     * @return true|false
     */
    public static function add($data) {
        if (!$data["datum"]) {
            $data["datum"] = date("Y-m-d");
        }
        if ($data["id_parent"]) { // v pripade ze nadrazena kategorie je skryta je treba skryt i pod ni nove vytvorenou
            if (!self::getById($data["id_parent"])->visible) {
                $data["visible"] = 0;
            }
        }

        if (!$data["priority"]) {
            $last_priority = dbI::query("select priority from s3n_content_category order by priority desc limit 0,1")->fetchSingle();
            $data["priority"] = (int) $last_priority + 50;
        }

        if (!$data["name"]) {
            throw new Exception("Neni zadan nazev v menu");
        }


// 		if ($homepage) $this->DB->query("UPDATE s3n_content_category set homepage = '0' ");
        $seoname = urlFriendly($data["name"]);
        $i = 0;
        while (true) {
            $i++;
            if (!self::checkUniqSeoname($seoname)) {
                $seoname = urlFriendly($data["name"]) . "-" . $i;
            } else {
                break;
            }
        }

        $pGps = fixGps($data['gps']);

        return dbI::query("
			INSERT INTO s3n_content_category (
				name,
				description,
				datum,
				gps_lat,
				gps_lng,
				external_url,
				id_parent,
				seo_name,
				visible,
				visible_from,
				visible_to,
				homepage,
				priority,
				sub_content_category_counter_limit,
				id_content_type,
				id_content_lang,
				menu,
				id_author,
				author,
				id_odbor,
				price)
			VALUES (%s, %s, %s, %s, %s, %s, %i, %s, %s, %s, %s, %s, %i, %i, %i, %i, %s, %i, %s, %i, %s);
		", $data["name"], $data["description"], changeDatepickerDate($data["datum"]), $pGps[0], $pGps[1], $data["external_url"], $data["id_parent"] ? $data["id_parent"] : null, $seoname, $data["visible"] ? "1" : 0, changeDatepickerDate($data["visible_from"]), changeDatepickerDate($data["visible_to"]), $data["homepage"] ? "1" : 0, $data["priority"], $data["sub_content_category_counter_limit"], $data["id_content_type"], $data["lang"] ? dbContentLang::getByCode($data["lang"])->id : self::getLang()->id, $data["menu"] ? $data["menu"] : self::TYPE_CLANEK, $data["id_author"], $data["author"], $data["id_odbor"], $data["priority"])->insert();
        return dbI::query("SELECT max(id_content_category) FROM s3n_content_category")->fetchSingle();
    }

    private static function checkUniqSeoname($seoname) {
        $r = dbI::query("select count(*) from s3n_content_category where seo_name = %s;", $seoname)->fetchSingle();
        if ($r == 0) {
            return true;
        } else {
            return false;
        }
    }

    private static function getIdLang($lang_code) {
        $r = dbI::cachedQuery("
			SELECT id_content_lang FROM s3n_content_lang
			WHERE code = %s
			OR name = %s
			limit 1;
		", $lang_code, $lang_code)->cache(self::$cache["getIdLang"])->fetchSingle();
// dyz nenajdem, zkusime najit "dyfoltni"
        if (!$r) {
            return self::DEFAULT_ID_LANG;
        }
        return (int) $r;
    }

    public static function searchFull($text) {
//		return dbI::query("SELECT * FROM s3n_content_category WHERE name LIKE '%$text%' AND s3n_content_category.id_content_lang = %i", self::getLang()->id)->fetchAll('dbContentCategory', 'id_content_category');
        return new dbArray(dbI::query("SELECT cc.* FROM s3n_content_category cc LEFT JOIN s3n_content c ON c.id_content_category = cc.id_content_category WHERE (cc.name LIKE '%$text%'  OR c.text_1  LIKE '%$text%' OR c.text_2  LIKE '%$text%' OR c.text_3  LIKE '%$text%') AND cc.visible = '1' AND cc.id_content_type <> 4 AND cc.id_content_type <> 5 AND cc.menu <> '1' GROUP BY cc.id_content_category ")->fetchAll('dbContentCategory'));
    }

    /**
     * Vraci vsechny dbContentCategory podle parametru zajimavosti
     * @param int $limit
     * @throws dbException
     * @return dbArray|dbContentCategory
     */
    public static function getZajimavosti($limit = null) {
        if ($limit) {
            return new dbArray(dbI::query("SELECT * FROM s3n_content_category WHERE zajimavosti = %i ORDER BY datum DESC LIMIT -, $limit", 1)->fetchAll('dbContentCategory'));
        } else {
            return new dbArray(dbI::query("SELECT * FROM s3n_content_category WHERE zajimavosti = %i ORDER BY datum DESC ", 1)->fetchAll('dbContentCategory'));
        }
    }

    /**
     * Vraci vsechny dbContentCategory podle parametru aktuality
     * @param int $limit
     * @throws dbException
     * @return dbArray|dbContentCategory
     */
    public static function getAktuality($limit = null) {
        if ($limit) {
            return new dbArray(dbI::query("SELECT * FROM s3n_content_category WHERE aktuality = %i ORDER BY datum DESC LIMIT -, $limit", 1)->fetchAll('dbContentCategory', 'id_content_category'));
        } else {
            return new dbArray(dbI::query("SELECT * FROM s3n_content_category WHERE aktuality = %i ORDER BY datum DESC ", 1)->fetchAll('dbContentCategory', 'id_content_category'));
        }
    }

    /**
     * Vraci vsechny dbContentCategory podle parametru homepage podrizene v danem menu
     * @param int $limit
     * @throws dbException
     * @return dbArray|dbContentCategory
     */
    public function getHomepageChilds() {
        $res = new dbArray(dbI::query("
			SELECT c1.*
				FROM s3n_content_category AS c1
				LEFT JOIN s3n_content_category AS c2 ON c1.id_parent = c2.id_content_category
				LEFT JOIN s3n_content_category AS c3 ON c2.id_parent = c3.id_content_category
				LEFT JOIN s3n_content_category AS c4 ON c3.id_parent = c4.id_content_category
				WHERE (c1.id_parent = %i OR c2.id_parent = %i OR c3.id_parent = %i OR c4.id_parent = %i)
				GROUP BY c1.id_content_category
				ORDER BY c1.name", $this->id, $this->id, $this->id, $this->id)->fetchAll('dbContentCategory'));
        foreach ($res AS $item) { // trochu neprakticke, ale bohuzel to jinac asi nejde ...
            if ($item->homepage)
                $retVal[] = $item;
        }
        return $retVal;
    }

    /**
     *
     * @return dbContentCategory|array
     */
    public static function getHomepage($onlyVisible = TRUE, $limit = 6, $excludeIdCt = NULL) {
        $res = array();
        $pAllowedidCts = array(
            1
        );
        if ($excludeIdCt) {
            $res = dbI::query("SELECT * FROM s3n_content_category WHERE homepage = '1' AND visible = '1' AND id_content_type IN %in AND id_content_type <> %i ORDER priority LIMIT 0,%i", $pAllowedidCts, $excludeIdCt, $limit)->fetchAll("dbContentCategory");
        } else {
            $res = dbI::query("SELECT * FROM s3n_content_category WHERE homepage = '1' AND visible = '1' AND id_content_type IN %in ORDER BY priority LIMIT 0,%i", $pAllowedidCts, $limit)->fetchAll("dbContentCategory");
        }
        return $res;
    }

    /**
     * Vraci vsechny dbContentCategory v hierarchii smerem nahoru
     * @throws dbException
     * @return dbArray|dbContentCategory
     */
    public function getNavigation() {
//		return dbI::query("SELECT * FROM s3n_content_category WHERE  id_content_type = %i AND seo_name IN ('".  implode("','", $p_pars)."') ORDER BY id_content_category ", $this->id_content_type)->fetchAll('dbContentCategory');
        return new dbArray(dbI::query("
			SELECT c1.* FROM s3n_content_category AS c1
			Left Join s3n_content_category AS c2 ON c2.id_parent = c1.id_content_category
			Left Join s3n_content_category AS c3 ON c3.id_parent = c2.id_content_category
			Left Join s3n_content_category AS c4 ON c4.id_parent = c3.id_content_category
			Left Join s3n_content_category AS c5 ON c5.id_parent = c4.id_content_category
			WHERE (c5.id_content_category = %i OR c4.id_content_category = %i OR c3.id_content_category = %i OR c2.id_content_category = %i OR c1.id_content_category = %i)
			GROUP by c1.id_parent ORDER BY  c5.id_parent DESC, c4.id_parent DESC, c3.id_parent DESC, c2.id_parent DESC, c1.id_parent DESC, datum desc , id_parent desc
			", $this->id, $this->id, $this->id, $this->id, $this->id)->fetchAll('dbContentCategory'));
    }

    public static function setLimit($limit) { // zatim nikde nepouzito - asi pujde pryc
        self::$limit = $limit;
    }

    public static function setLang(dbContentLang $dbContentLang) {
        self::$_idLang = $dbContentLang->id;
    }

    public static function setType(dbContentType $dbContentType) {
        self::$_idType = $dbContentType->id;
    }

    public static function getLang() {
        return self::$_idLang ? dbContentLang::getById(self::$_idLang) : dbContentLang::getDefault();
    }

    public static function getType() {
        return self::$_idType ? dbContentType::getById(self::$_idType) : dbContentType::getDefault();
    }

    public function videoDelete($index) {
        $pVideo = $this->getVideo($index);

        dbi::query("UPDATE s3n_content_category SET video_" . $index . " = null WHERE id_content_category = %i", $this->id)->result();
        dbi::query("UPDATE s3n_content_category SET video_original_" . $index . " = null WHERE id_content_category = %i", $this->id)->result();
        dbi::query("UPDATE s3n_content_category SET video_thumbnail_" . $index . " = null WHERE id_content_category = %i", $this->id)->result();

        if (!Helper_FileSystem::deleteFile(PROJECT_DIR . $pVideo->original)) {
            return false;
        }
        if (!Helper_FileSystem::deleteFile(PROJECT_DIR . $pVideo->detail->video)) {
            return false;
        }
        if (!Helper_FileSystem::deleteFile(PROJECT_DIR . $pVideo->detail->image)) {
            return false;
        }
        foreach ((array) $pVideo->detail->storyBoard->images AS $image) {
            if (!Helper_FileSystem::deleteFile(PROJECT_DIR . $image)) {
                return false;
            }
        }

        if (!Helper_FileSystem::deleteFile(PROJECT_DIR . $pVideo->preview->video)) {
            return false;
        }
        if (!Helper_FileSystem::deleteFile(PROJECT_DIR . $pVideo->preview->image)) {
            return false;
        }
        foreach ((array) $pVideo->preview->storyBoard->images AS $image) {
            if (!Helper_FileSystem::deleteFile(PROJECT_DIR . $image)) {
                return false;
            }
        }


        return true;
        return false;
    }

    public function getVideo($index) {
        error_reporting(E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE); // kvuli chybe pri sortovani null v find
//	NDebugger::$strictMode = false;
        if (self::$cache[$this->id]->video->$index)
            return self::$cache[$this->id]->video->$index;
        if ($this->{"video_" . $index}) {
            self::$cache[$this->id]->video->$index->original = "/" . self::VIDEOS_PATH . $this->id . "/" . $this->{"video_original_" . $index};

            self::$cache[$this->id]->video->$index->detail->video = "/" . self::VIDEOS_PATH . $this->id . "/" . "detail/" . $this->{"video_" . $index};
            $storyBoardImages = File_Find::glob($this->{"video_" . $index} . '*.png', PROJECT_DIR . self::VIDEOS_PATH . $this->id . "/" . "detail/story_board/", 'shell');
            if (is_array($storyBoardImages))
                sort($storyBoardImages);
            foreach ($storyBoardImages AS $key => $storyBoardImage) {
                self::$cache[$this->id]->video->$index->detail->storyBoard->images->$key = "/" . self::VIDEOS_PATH . $this->id . "/detail/story_board/" . $storyBoardImage;
            }
            self::$cache[$this->id]->video->$index->detail->storyBoard->count = count($storyBoardImages);
            self::$cache[$this->id]->video->$index->detail->image = "/" . self::VIDEOS_PATH . $this->id . "/detail/thumbs/" . $this->{"video_thumbnail_" . $index};

            self::$cache[$this->id]->video->$index->preview->video = "/" . self::VIDEOS_PATH . $this->id . "/" . "preview/" . $this->{"video_" . $index};
            $storyBoardImages = File_Find::glob($this->{"video_" . $index} . '*.png', PROJECT_DIR . self::VIDEOS_PATH . $this->id . "/" . "preview/story_board/", 'shell');
            if (is_array($storyBoardImages))
                sort($storyBoardImages);
            foreach ($storyBoardImages AS $key => $storyBoardImage) {
                self::$cache[$this->id]->video->$index->preview->storyBoard->images->$key = "/" . self::VIDEOS_PATH . $this->id . "/preview/story_board/" . $storyBoardImage;
            }
            self::$cache[$this->id]->video->$index->preview->storyBoard->count = count($storyBoardImages);
            self::$cache[$this->id]->video->$index->preview->image = "/" . self::VIDEOS_PATH . $this->id . "/preview/thumbs/" . $this->{"video_thumbnail_" . $index};

            return self::$cache[$this->id]->video->$index;
        }
        return null;
    }

    /**
     * Vraci dbUser podle id_author
     * @throws dbException
     * @return dbUser|false
     */
    public function getAuthor() {
        return dbUser::getById($this->id_author);
    }

    public function ImageDelete($imageIndex) {
        if (!$imageIndex) {
            return false;
        }
        $file = dbI::query("SELECT image_" . $imageIndex . " FROM s3n_content_category WHERE id_content_category = %i", $this->id)->fetchSingle();
        $res = dbI::query("UPDATE s3n_content_category SET image_" . $imageIndex . " = '' WHERE id_content_category = %i", $this->id)->result();
        $path = PROJECT_DIR . self::IMAGES_PATH . $this->id . "/";
        @unlink($path . $file);
        @unlink($path . "T-" . $file);
        @unlink($path . "P-" . $file);
        @unlink($path . "D-" . $file);
        return true;
    }

    public function FileDelete($fileIndex) {
        if (!$fileIndex) {
            return false;
        }
        $file = dbI::query("SELECT file_" . $fileIndex . " FROM s3n_content_category WHERE id_content_category = %i", $this->id)->fetchSingle();
        $res = dbI::query("UPDATE s3n_content_category SET file_" . $fileIndex . " = '' WHERE id_content_category = %i", $this->id)->result();
        $path = PROJECT_DIR . self::FILES_PATH . $this->id . "/";
        @unlink($path . $file);
        return true;
    }

    public static function fixMissingContent($idContentCategory) {
        $idContent = dbI::cachedQuery("SELECT id_content FROM s3n_content WHERE id_content_category = %i", $idContentCategory)->cache(self::$cache['fixMissingContent'][$idContentCategory])->fetchSingle();
        if (!$idContent) {
            if (!dbI::query("SELECT id_content_category FROM s3n_content_category WHERE id_content_category = %i", $idContentCategory)->fetchSingle())
                return false;
            $dbCC = dbI::query("SELECT * FROM s3n_content_category WHERE id_content_category = %i", $idContentCategory)->fetch();
            dbi::query("INSERT INTO s3n_content (title_1, visible, id_content_category, datum) VALUES (%s, %s, %i, %s)", $dbCC->name, '1', $idContentCategory, $dbCC->datum)->result();
        }
    }

    public function getEditedBy() {
        if (!$this->_editedBy) {
            $this->_editedBy = dbI::query("SELECT * FROM (SELECT * FROM s3n_logs ORDER BY id_log DESC) AS s3n_logs_tmp WHERE id_content_category = %i AND `type` = %s AND visible = 1 GROUP BY id_user ORDER BY id_log DESC LIMIT 0,2", $this->id, dbLog::TYPE_EDIT)->fetchAll('dbLog');
        }
//		$this->_editedBy = array_reverse($this->_editedBy);
        return $this->_editedBy;
//		return array_slice($this->_editedBy, -2);
    }

    public function getMainParent() {
        return dbI::query("
			SELECT c1.* FROM s3n_content_category AS c1
			Left Join s3n_content_category AS c2 ON c2.id_parent = c1.id_content_category
			Left Join s3n_content_category AS c3 ON c3.id_parent = c2.id_content_category
			Left Join s3n_content_category AS c4 ON c4.id_parent = c3.id_content_category
			Left Join s3n_content_category AS c5 ON c5.id_parent = c4.id_content_category
			WHERE (c5.id_content_category = %i OR c4.id_content_category = %i OR c3.id_content_category = %i OR c2.id_content_category = %i OR c1.id_content_category = %i)
			GROUP by c1.id_parent ORDER BY  c5.id_parent DESC, c4.id_parent DESC, c3.id_parent DESC, c2.id_parent DESC, c1.id_parent DESC, datum desc , id_parent desc LIMIT 0,1
			", $this->id, $this->id, $this->id, $this->id, $this->id)->cache(self::$cache['getNavigation'][$this->id])->fetch('dbContentCategory');
    }

    public function setOdbor($idOdbor) {
        return dbI::query("UPDATE s3n_content_category SET id_odbor = %i WHERE id_content_category = %i", $idOdbor, $this->id)->update($this->idOdbor, $idOdbor)->result();
    }

    public function setVizitka($idVizitka) {
        return dbI::query("UPDATE s3n_content_category SET id_vizitka = %i WHERE id_content_category = %i", $idVizitka, $this->id)->update($this->idVizitka, $idVizitka)->result();
    }

    public function setParam($param, $value) {
        return dbI::query("UPDATE s3n_content_category SET {$param} = %s WHERE id_content_category = %i", $value, $this->id)->update($this->$param, $value)->result();
    }

    /**
     *
     * @return dbContentCategory
     */
    public function getParent($fullParent = false) {
        if ($fullParent) {
            if ($this->getParent()) {
                if ($this->getParent()->getParent()) {
                    if ($this->getParent()->getParent()->getParent()) {
                        if ($this->getParent()->getParent()->getParent()->getParent()) {
                            return $this->getParent()->getParent()->getParent()->getParent();
                        } else {
                            return $this->getParent()->getParent()->getParent();
                        }
                    } else {
                        return $this->getParent()->getParent();
                    }
                } else {
                    return $this->getParent();
                }
            } else {
                return $this;
            }
        } else {
            if (!$this->id_parent) {
                return null;
            }
            return self::getById($this->id_parent);
        }
    }

    /**
     *
     * @return dbContentCategory
     */
    public function getVizitka() {
        $dbVizitka = dbContentCategory::getById($this->idVizitka);
        if (!$dbVizitka && $this->getParent()) {
            $dbVizitka = dbContentCategory::getById($this->getParent()->idVizitka);
        }
        if (!$dbVizitka && $this->getParent() && $this->getParent()->getParent()) {
            $dbVizitka = dbContentCategory::getById($this->getParent()->getParent()->idVizitka);
        }
        if (!$dbVizitka && $this->getParent() && $this->getParent()->getParent() && $this->getParent()->getParent()->getParent()) {
            $dbVizitka = dbContentCategory::getById($this->getParent()->getParent()->getParent()->idVizitka);
        }
        return $dbVizitka;
    }

    public function getClassName() {
        return str_replace("-", "_", urlFriendly($this->name));
    }

    public static function getHP() {
        return self::getBySeoName("home");
    }

    public function getPrev() {
        return dbI::query("SELECT * FROM s3n_content_category WHERE id_parent = COALESCE(%i, id_parent) AND id_content_type = %i AND priority < %i  AND visible = '1' AND menu <> '1' ORDER BY priority LIMIT 0,1 ", $this->id_parent, $this->id_content_type, $this->priority)->fetch("dbContentCategory");
    }

    public function getNext() {
        return dbI::query("SELECT * FROM s3n_content_category WHERE id_parent = COALESCE(%i, id_parent) AND id_content_type = %i AND priority > %i  AND visible = '1' AND menu <> '1' ORDER BY priority LIMIT 0,1 ", $this->id_parent, $this->id_content_type, $this->priority)->fetch("dbContentCategory");
    }

    public function hasGallery() {
        return dbI::query("SELECT FROM s3n_content_category_map_gallery WHERE id_content_category = %i", $this->id)->fetchSingle();
    }

    public function hasObjednavka() {
        return $this->zajimavosti;
    }

    public static function search($znacka = NULL, $model = NULL, $motor = NULL, $provedeni = NULL, $rokOd = NULL, $rokDo = NULL, $fullText = NULL, $idContentType = NULL) {

        $cond = array(" cc.visible = '1'", "menu <> '1'");
        $join = array();

        $cond[] = " id_content_type <> 10";

        if ($znacka) {
            $cond[] = " znacka IN ('" . implode("','", (array) $znacka) . "') ";
        }
        if ($model) {
            $cond[] = " model IN ('" . implode("','", (array) $model) . "') ";
        }
        if ($motor) {
            $cond[] = " motor IN ('" . implode("','", (array) $motor) . "') ";
        }
        if ($provedeni) {
            $cond[] = " provedeni IN ('" . implode("','", (array) $provedeni) . "') ";
        }
        if ($rokOd) {
            $cond[] = " rok >= " . $rokOd;
        }
        if ($rokDo) {
            $cond[] = " rok <= " . $rokDo;
        }
        if ($fullText) {
            $cond[] = " (cc.name LIKE '%$fullText%'  OR c.text_1  LIKE '%$fullText%' OR c.text_2  LIKE '%$fullText%' OR c.text_3  LIKE '%$fullText%') ";
            $join[] = " s3n_content c ON c.id_content_category = cc.id_content_category";
        }

        if ($idContentType) {
            $cond[] = " id_content_type = " . $idContentType;
        }

        $cond = " WHERE " . implode(" AND ", $cond);

        if ($join) {
            $join = " INNER JOIN " . implode(" , ", $join);
        } else {
            $join = "";
        }

        $res = dbI::query("SELECT cc.* FROM s3n_content_category cc ", $join, $cond)->fetchAll("dbContentCategory");
//        print_p(dbI::getLastSQL());
        return $res;
    }

    public static function setFilter($key, $value) {
        self::$_filter[$key] = $value;
    }

    public static function setFilterCt($idCT) {
        self::$_filter["idCT"] = $idCT;
    }

    public static function getParamValues($param = NULL) {
        if ($param) {
            return dbI::query("SELECT DISTINCT({$param}) FROM s3n_content_category WHERE {$param} IS NOT NULL AND " . self::getCond() . " ORDER BY {$param}")->fetchPairs();
        } else {
            $res = array();
            foreach (self::$params as $param) {
                if (in_array($param, ['znacka', 'model', 'motor', 'provedeni'])) {
                    $res[$param] = dbI::query("SELECT DISTINCT({$param}) FROM s3n_content_category WHERE {$param} IS NOT NULL AND " . self::getCond() . " ORDER BY {$param}")->fetchPairs();
                }
            }
            return $res;
        }
    }

    private static function getCond() {
        $cond = array();
        $cond[] = " visible = '1' ";
        $cond[] = " (visible_from <= DATE(NOW()) OR visible_from IS NULL) ";
        $cond[] = " (visible_to >= DATE(NOW()) OR visible_to IS NULL) ";
        foreach (self::$_filter as $key => $value) {
            if ($key == "rok_from") {
                if ($value[0]) {
                    $cond[] = "rok >= " . $value[0];
                }
            } elseif ($key == "rok_to") {
                if ($value[0]) {
                    $cond[] = "rok <= " . $value[0];
                }
            } elseif ($key == "idCT") {
                $cond[] = " id_content_type = " . $value;
            } else {
                if (is_array($value)) {
                    $cond[] = "{$key} IN ('" . implode("','", $value) . "')";
                } else {
                    $cond[] = "{$key} = '{$value}'";
                }
            }
        }
//        print_p($cond);
//        die();
        return implode(" AND ", $cond);
    }

    private static function getOffset() {
        if (Registry::isAdmin()) {
            return 0;
        }
        return (self::getPage() - 1) * self::$limit;
    }

    private static function getLimit() {
        if (Registry::isAdmin()) {
            return 10000;
        }
        return self::$limit;
        return self::getPage() * self::$limit;
    }

    public static function getPerPage() {
        return self::$limit;
    }

    public static function getPage() {
        return self::$_pg ? self::$_pg : 1;
    }

    public static function setPage($pg) {
        self::$_pg = $pg;
    }

    public static function getPages() {
//        print_p(self::$_numRows);
        return ceil(self::$_numRows / $limit);
    }

    public static function getCount() {
//        print_p(self::$_numRows);
        return self::$_numRows;
    }

    public static function getCategories() {
        return self::$pCategories;
    }

    public function getCategory($toText = FALSE) {
        if ($toText) {
            return self::$pCategories[$this->id_category];
        } else {
            return $this->id_category;
        }
    }

    public function setCategory($idCategory) {
        if ($idCategory) {
            return dbI::query("UPDATE s3n_content_category SET id_category = %i WHERE id_content_category = %i", $idCategory, $this->id)->update($this->id_category, $idCategory)->result();
        }
    }

    /**
     *
     * @param type $idCategory
     * @return dbContentCategory
     */
    public static function getLastInCategory($idCategory) {
        return dbI::query("SELECT * FROM s3n_content_category WHERE visible = '1' AND id_category = %i ORDER BY datum DESC LIMIT 0,1", $idCategory)->fetch("dbContentCategory");
    }

    public static function getClankyCtIds() {
        return [1];
    }

    public static function getAktualne() {
        return dbI::query("SELECT * FROM s3n_content_category WHERE visible = '1' AND aktuality = 1 ORDER BY datum DESC LIMIT 0,1")->fetch("dbContentCategory");
    }

    public function getLastClanky($limit = 6, $excludeCategory = NULL, $excludeIdContentCategory = NULL) {
        $cond = [];
        $cond[] = " menu <> '1'";
        if ($excludeCategory) {
            $cond[] = " id_category NOT IN (" . implode(", ", (array) $excludeCategory) . ") ";
        }
        if ($excludeIdContentCategory) {
            $cond[] = " id_content_category NOT IN (" . implode(", ", (array) $excludeIdContentCategory) . ") ";
        }
        if ($cond) {
            $cond = " AND " . implode(" AND ", $cond);
        } else {
            $cond = NULL;
        }

        $res = dbI::query("SELECT SQL_CALC_FOUND_ROWS s3n_content_category.*  FROM s3n_content_category WHERE visible = '1' {$cond} AND id_parent IS NOT NULL AND id_content_type IN %in GROUP BY id_content_category  ORDER BY datum DESC, id_content_category DESC LIMIT %i,%i", self::getClankyCtIds(), self::getOffset(), self::getLimit())->fetchAll("dbContentCategory");
        self::$_numRows = dbI::query("SELECT FOUND_ROWS();")->fetchSingle();
        return $res;
    }

    public function getColor() {
        return "#2390a3";
        return self::$pColors[$this->id_category];
    }

    public static function getColors() {
        return self::$pColors;
    }

    public static function getMainColors() {
        return self::$pColors;
    }

    public static function getCategoryId($name) {
        return array_flip(self::$pCategories)[$name];
    }

    /**
     *
     * @param type $limit
     * @return dbContentCategory|array
     */
    public function getNews($limit = 100) {
        return dbI::query("SELECT * FROM s3n_content_category WHERE visible = '1' AND id_content_type = 6 ORDER BY datum DESC LIMIT 0, %i", $limit)->fetchAll("dbContentCategory");
    }

}
