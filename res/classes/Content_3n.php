<?php

/**
 * @package 3n_devel
 * @class content_3n - trida pro praci s obsahy editovatelnych clanku
 * @author Error pulkrabek@3nicom.cz
 * @version 1.2-20071111A
 * @depends ErrorHeap
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Content_3n {

    const DEFAULT_LANG = "cs";

    var $DB;
    var $ERROR;
    var $tbl_prefix;
    var $content_lang;
    var $content_type;
    var $offset = 0;
    var $limit = null;
    var $result_count;
// 	var $order_by = "priority desc";
    var $order_by = "priority , datum desc , id_content_category desc";
    var $check_date_from = true;
    var $check_date_to = true;
    private static $cache;

    const CREATE_FILE_MODE = 0666;
    const CREATE_DIR_MODE = 0777;
    const DEFAULT_ID_CONTENT_TYPE = 3;
    const IMAGES_PATH = "/data/images_content_category/";
    const FILES_PATH = "/data/files_content_category/";
    const VIDEOS_PATH = "/data/videos_content_category/";
    const MAX_VIDEO_UPLOAD_COUNT = 3;
    const MAX_IMAGES_UPLOAD_COUNT = 9;
    const MAX_FILES_UPLOAD_COUNT = 2;
    const DETAIL_SIZEX = 1920;
    const DETAIL_SIZEY = 1080;
    const PREVIEW_SIZEX = 1024;
    const PREVIEW_SIZEY = 768;
    const THUMB_SIZEX = 300;
    const THUMB_SIZEY = 240;
    const VIDEO_PREVIEW_SIZEX = 120;
    const VIDEO_PREVIEW_SIZEY = 90;
    const VIDEO_PREVIEW_4_3_SIZEY = 90;
    const VIDEO_PREVIEW_1_1_SIZEY = 120;
    const VIDEO_PREVIEW_16_9_SIZEY = 90;
    const VIDEO_DETAIL_SIZEX = 568;
    const VIDEO_DETAIL_SIZEY = 450;
    const VIDEO_DETAIL_4_3_SIZEY = 450;
    const VIDEO_DETAIL_1_1_SIZEY = 600;
//     const VIDEO_DETAIL_16_9_SIZEY = 338;
    const VIDEO_DETAIL_16_9_SIZEY = 320;

    public function __construct($DB, $lang = self::DEFAULT_LANG, $tbl_prefix = "") {
        global $ERROR;
        $this->DB = $DB;
        $this->tbl_prefix = $tbl_prefix;
        $this->ERROR = &$ERROR;
        $this->content_lang = $this->get_id_lang($lang);

        $this->DB->autoCommit(true);
        $this->DB->setFetchMode(DB_FETCHMODE_OBJECT);
    }

    public function __destruct() {
        $this->DB->commit();
    }

    private function spawn_error($msg, $severity, $svrcode = ERROR::OK) {
        $this->DB->rollback();
        $this->ERROR->spawn("Shop_3n", 1, $svrcode, $severity, $msg);
    }

    private function check($r) {
        //echo $this->DB->last_query;
        if (PEAR::isError($r)) {
            echo $this->DB->last_query;
            self::spawn_error($r->getMessage(), ERROR::CRIT);
            return false;
        }
    }

    private function url_friendly($title) {
        if (strtolower($title) == "fotogalerie") {
            $title = "foto-galerie";
        }
        static $tbl = array("\xc3\xa1" => "a", "\xc3\xa4" => "a", "\xc4\x8d" => "c", "\xc4\x8f" => "d", "\xc3\xa9" => "e", "\xc4\x9b" => "e", "\xc3\xad" => "i", "\xc4\xbe" => "l", "\xc4\xba" => "l", "\xc5\x88" => "n", "\xc3\xb3" => "o", "\xc3\xb6" => "o", "\xc5\x91" => "o", "\xc3\xb4" => "o", "\xc5\x99" => "r", "\xc5\x95" => "r", "\xc5\xa1" => "s", "\xc5\xa5" => "t", "\xc3\xba" => "u", "\xc5\xaf" => "u", "\xc3\xbc" => "u", "\xc5\xb1" => "u", "\xc3\xbd" => "y", "\xc5\xbe" => "z", "\xc3\x81" => "A", "\xc3\x84" => "A", "\xc4\x8c" => "C", "\xc4\x8e" => "D", "\xc3\x89" => "E", "\xc4\x9a" => "E", "\xc3\x8d" => "I", "\xc4\xbd" => "L", "\xc4\xb9" => "L", "\xc5\x87" => "N", "\xc3\x93" => "O", "\xc3\x96" => "O", "\xc5\x90" => "O", "\xc3\x94" => "O", "\xc5\x98" => "R", "\xc5\x94" => "R", "\xc5\xa0" => "S", "\xc5\xa4" => "T", "\xc3\x9a" => "U", "\xc5\xae" => "U", "\xc3\x9c" => "U", "\xc5\xb0" => "U", "\xc3\x9d" => "Y", "\xc5\xbd" => "Z");


        $r = strtr($title, $tbl);

        preg_match_all('/[a-zA-Z0-9]+/', $r, $nt);
        $r = strtolower(implode('_', $nt[0]));

        return $r;
    }

    public function get_avail_langs() {
        $r = $this->DB->getAll("
			select * from s3n_content_lang order by `priority` asc;
		", DB_FETCHMODE_ASSOC);
        $this->check($r);

        return $r;
    }

    public function get_avail_content_types() {
        $r = $this->DB->getAll("
			select * from s3n_content_type order by id_content_type desc;
		", DB_FETCHMODE_ASSOC);
        $this->check($r);

        return $r;
    }

    public function get_content_type_detail($id_content_type = null) {
        if ($id_content_type) {
            $r = $this->DB->getRow("select * from s3n_content_type where id_content_type = " . $id_content_type);
        } else {
            $r = $this->DB->getRow("select * from s3n_content_type where id_content_type = " . $this->content_type);
        }
        $this->check($r);

        return $r;
    }

    public function get_id_lang($lang_code) {
        if (self::$cache["idLang"][$lang_code])
            return self::$cache["idLang"][$lang_code];
        $r = dibi::fetchSingle("
			select id_content_lang from s3n_content_lang
			where code = %s
			or name = %s
			limit 1;
		", $lang_code, $lang_code);
        $this->check($r);
        // dyz nenajdem, zkusime najit "dyfoltni"
        if ($r == null) {
            $r = dibi::fetchSingle("
				select id_content_lang from s3n_content_lang
				where code = %s;
			", self::DEFAULT_LANG);
            $this->check($r);
        }
        self::$cache["idLang"][$lang_code] = $r;
        return (int) $r;
    }

    public function set_content_lang($id_lang) {
        if ($id_lang) {
            $this->content_lang = $id_lang;
        } else {
            $this->content_lang = $this->get_id_lang(DEFAULT_LANG);
        }
    }

    public function set_content_type($id_content_type) {
        if (!$id_content_type) {
            $this->content_type = $this->get_default_content_type();
        } else {
            $this->content_type = $id_content_type;
        }
    }

    public function get_content_category_id_by_seo_name($seo_name, $check_master = true) {
        if ($check_master) {
            $id_content_category = $this->DB->getone("SELECT id_master FROM s3n_content_category WHERE seo_name = '$seo_name'");
            $this->check($id_content_category);
            if ($id_content_category)
                return $id_content_category;
        }
        $id_content_category = $this->DB->getone("SELECT id_content_category FROM s3n_content_category WHERE seo_name = '$seo_name'");
// 		echo $seo_name;
// 		echo $this->DB->last_query;
        $this->check($id_content_category);
// 		echo $id_content_category;
        return $id_content_category;
    }

// 	public function get_content_detail_by_seo_name($seo_name) {
// 		$id_content_category = $this->DB->getone("SELECT id_content_category FROM s3n_content_category WHERE seo_name = '$seo_name'");
// 		$this->check($id_content_category);
// 		return $this->get_content_detail($id_content_category);
// 	}

    public function get_content_detail($id_content) {
        $res = $this->DB->getrow("SELECT * FROM s3n_content WHERE id_content = $id_content");
        $this->check($res);
        return $res;
    }

    public function get_content_detail_by_seo_name($seo_name) {
        // v podstate jde o to kdyz seo_name v content_category se vyskytuje duplicitne tak zkusime najit ten s obsahem

        $id_content_category = $this->get_content_category_id_by_seo_name($seo_name);
        if ($id_content_category)
            return $this->get_content_detail_by_id_content_category($id_content_category);

        /* 		$sql = "
          SELECT c.id_content
          FROM s3n_content_category as cat, s3n_content AS c
          WHERE cat.seo_name = '$seo_name' AND (c.title_1 != '' OR c.title_2  != '' OR c.title_3  != '')
          AND c.id_content_category = cat.id_content_category and cat.id_content_lang = ".$this->content_lang ." order by c.id_content desc limit 0,1 ";
          $id_content = $this->DB->getone($sql);
          // 		echo $sql."<br/>";
          if (!$id_content) return false;
          $this->check($id_content);
          return $this->get_content_detail($id_content); */
    }

    public function get_content_detail_by_id_content_category($id_content_category, $check_master = false) { // toto je uz reseno v get_content_category_id_by_seo_name
        global $content_url;
        if ($check_master) {
            $id_master = $this->DB->getone("SELECT id_master FROM s3n_content_category WHERE id_content_category = $id_content_category");
            $this->check($id_master);
            if ($id_master)
                $id_content_category = $id_master;
        }

        $result_tmp = $res->content = $this->DB->getrow("SELECT * FROM s3n_content WHERE id_content_category = $id_content_category");
        $this->check($result_tmp);
// 		if (!$res->content) return false;
        $res->content_type = $this->DB->getrow("SELECT ct.* FROM s3n_content_type as ct, s3n_content_category as cc where cc.id_content_type = ct.id_content_type and cc.id_content_category = $id_content_category");
        $res->content_category = $this->DB->getrow("SELECT cc.* FROM s3n_content_category as cc where cc.id_content_category =$id_content_category");
        $res->content->IMAGES_PATH = self::IMAGES_PATH . $res->content_category->id_content_category . "/";
        $res->content->IMAGES = array(
            "image_1" => $res->content_category->image_1,
            "image_2" => $res->content_category->image_2,
            "image_3" => $res->content_category->image_3,
            "image_4" => $res->content_category->image_4,
            "image_5" => $res->content_category->image_5,
            "image_6" => $res->content_category->image_6,
            "image_7" => $res->content_category->image_7,
            "image_8" => $res->content_category->image_8,
            "image_9" => $res->content_category->image_9,
        );

        $res->content->VIDEOS = $this->populate_video_details($res->content_category);

        if ($res->content_category->external_url) {
            $res->content_category->target = "_BLANK";
            $res->content_category->url = $res->content_category->external_url;
        } else {
            $res->content_category->url = CONTENT_DELIMITER . "/" . $this->get_content_category_url($res->content_category->id_content_category, true);
            $res->content_category->target = "";
            $content_url = "";
        }

        $res->content_parent_class = $res->content_category->id_parent ? $res->content_category->id_parent : $res->content_category->id_content_category;
// 		$res->content_category_id_master = $this->DB->getone("SELECT cc.id_master FROM s3n_content_category as cc where cc.id_content_category = $id_content_category");
        if ($res->content->id_template) {
            $res->template = $this->DB->getrow("SELECT ct.* FROM s3n_content_templates as ct where ct.id_template =" . $res->content->id_template);
        }
        $this->check($res);

// 		print_p($res);

        return $res;
    }

    public function increment_number_views($id_content_category) {
// 		$id_content = $this->DB->getone("SELECT id_content FROM s3n_content WHERE id_content_category = $id_content_category");
// 		check($id_content);
        $result_tmp = $this->DB->query("UPDATE  s3n_content SET zobrazeni=zobrazeni+1 WHERE id_content_category = $id_content_category");
        check($result_tmp);
    }

    public function populate_video_details($p_content_category) {
        if ($p_content_category->video_1) {
            $story_board_images_detail_1 = File_Find::glob($p_content_category->video_1 . '*.png', PROJECT_DIR . self::VIDEOS_PATH . $p_content_category->id_content_category . "/" . "detail/story_board/", 'shell');
            if (is_array($story_board_images_detail_1))
                sort($story_board_images_detail_1);
            $story_board_images_preview_1 = File_Find::glob($p_content_category->video_1 . '*.png', PROJECT_DIR . self::VIDEOS_PATH . $p_content_category->id_content_category . "/" . "preview/story_board/", 'shell');
            if (is_array($story_board_images_preview_1))
                sort($story_board_images_preview_1);
        };
        if ($p_content_category->video_2) {
            $story_board_images_detail_2 = File_Find::glob($p_content_category->video_2 . '*.png', PROJECT_DIR . self::VIDEOS_PATH . $p_content_category->id_content_category . "/" . "detail/story_board/", 'shell');
            if (is_array($story_board_images_detail_2))
                sort($story_board_images_detail_2);
            $story_board_images_preview_2 = File_Find::glob($p_content_category->video_2 . '*.png', PROJECT_DIR . self::VIDEOS_PATH . $p_content_category->id_content_category . "/" . "preview/story_board/", 'shell');
            if (is_array($story_board_images_preview_2))
                sort($story_board_images_preview_2);
        };
        if ($p_content_category->video_3) {
            $story_board_images_detail_3 = File_Find::glob($p_content_category->video_3 . '*.png', PROJECT_DIR . self::VIDEOS_PATH . $p_content_category->id_content_category . "/" . "detail/story_board/", 'shell');
            if (is_array($story_board_images_detail_3))
                sort($story_board_images_detail_3);
            $story_board_images_preview_3 = File_Find::glob($p_content_category->video_3 . '*.png', PROJECT_DIR . self::VIDEOS_PATH . $p_content_category->id_content_category . "/" . "preview/story_board/", 'shell');
            if (is_array($story_board_images_preview_3))
                sort($story_board_images_preview_3);
        };
        $res = array(
            "1" => array(
                "original" => array(
                    "video" => $p_content_category->video_original_1,
                    "path" => self::VIDEOS_PATH . $p_content_category->id_content_category,
                ),
                "detail" => array(
                    "path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/detail/",
                    "video" => $p_content_category->video_1,
                    "thumbnail" => $p_content_category->video_thumbnail_1,
                    "thumbnail_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/detail/thumbs/",
                    "story_board_images_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/detail/story_board/",
                    "story_board_images_count" => count($story_board_images_detail_1),
                    "story_board_images" => $story_board_images_detail_1,
                    "story_board_images_json" => $p_content_category->video_1 ? json_encode(array(
                        "images" => $story_board_images_detail_1,
                        "images_count" => count($story_board_images_detail_1),
                        "images_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/detail/story_board/",
                    )) : null,
                ),
                "preview" => array(
                    "path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/preview/",
                    "video" => $p_content_category->video_1,
                    "thumbnail" => $p_content_category->video_thumbnail_1,
                    "thumbnail_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/preview/thumbs/",
                    "story_board_images_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/preview/story_board/",
                    "story_board_images_count" => count($story_board_images_preview_1),
                    "story_board_images" => $story_board_images_preview_1,
                    "story_board_images_json" => $p_content_category->video_1 ? json_encode(array(
                        "images" => $story_board_images_preview_1,
                        "images_count" => count($story_board_images_preview_1),
                        "images_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/preview/story_board/",
                    )) : null,
                ),
            ),
            "2" => array(
                "original" => array(
                    "video" => $p_content_category->video_original_2,
                    "path" => self::VIDEOS_PATH . $p_content_category->id_content_category,
                ),
                "detail" => array(
                    "path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/detail/",
                    "video" => $p_content_category->video_2,
                    "thumbnail" => $p_content_category->video_thumbnail_2,
                    "thumbnail_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/detail/thumbs/",
                    "story_board_images_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/detail/story_board/",
                    "story_board_images_count" => count($story_board_images_detail_2),
                    "story_board_images" => $story_board_images_detail_2,
                    "story_board_images_json" => $p_content_category->video_2 ? json_encode(array(
                        "images" => $story_board_images_detail_2,
                        "images_count" => count($story_board_images_detail_2),
                        "images_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/detail/story_board/",
                    )) : null,
                ),
                "preview" => array(
                    "path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/preview/",
                    "video" => $p_content_category->video_2,
                    "thumbnail" => $p_content_category->video_thumbnail_2,
                    "thumbnail_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/preview/thumbs/",
                    "story_board_images_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/preview/story_board/",
                    "story_board_images_count" => count($story_board_images_preview_2),
                    "story_board_images" => $story_board_images_preview_2,
                    "story_board_images_json" => $p_content_category->video_2 ? json_encode(array(
                        "images" => $story_board_images_preview_2,
                        "images_count" => count($story_board_images_preview_2),
                        "images_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/preview/story_board/",
                    )) : null,
                ),
            ),
            "3" => array(
                "original" => array(
                    "video" => $p_content_category->video_original_3,
                    "path" => self::VIDEOS_PATH . $p_content_category->id_content_category,
                ),
                "detail" => array(
                    "path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/detail/",
                    "video" => $p_content_category->video_3,
                    "thumbnail" => $p_content_category->video_thumbnail_3,
                    "thumbnail_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/detail/thumbs/",
                    "story_board_images_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/detail/story_board/",
                    "story_board_images_count" => count($story_board_images_detail_3),
                    "story_board_images" => $story_board_images_detail_3,
                    "story_board_images_json" => $p_content_category->video_3 ? json_encode(array(
                        "images" => $story_board_images_detail_3,
                        "images_count" => count($story_board_images_detail_3),
                        "images_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/detail/story_board/",
                    )) : null,
                ),
                "preview" => array(
                    "path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/preview/",
                    "video" => $p_content_category->video_3,
                    "thumbnail" => $p_content_category->video_thumbnail_3,
                    "thumbnail_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/preview/thumbs/",
                    "story_board_images_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/preview/story_board/",
                    "story_board_images_count" => count($story_board_images_preview_3),
                    "story_board_images" => $story_board_images_preview_3,
                    "story_board_images_json" => $p_content_category->video_3 ? json_encode(array(
                        "images" => $story_board_images_preview_3,
                        "images_count" => count($story_board_images_preview_3),
                        "images_path" => self::VIDEOS_PATH . $p_content_category->id_content_category . "/preview/story_board/",
                    )) : null,
                ),
            ),
        );

        return $res;
    }

    public function get_content_category_detail($id_content_category) {
        $res = $this->DB->getrow("
			SELECT cat.*, Count(cat1.id_parent) AS num_child
			FROM s3n_content_category AS cat
			Left Join s3n_content_category AS cat1 ON cat1.id_parent = cat.id_content_category
			WHERE cat.id_content_category = $id_content_category
			GROUP BY cat.id_content_category
			");
        $this->check($res);

        if ($res->content_category->external_url) {
            $res->content_category->target = "_BLANK";
            $res->content_category->url = $res->content_category->external_url;
        } else {
            $res->content_category->url = CONTENT_DELIMITER . "/" . $this->get_content_category_url($res->id_content_category, true);
            $res->content_category->target = "";
            $content_url = "";
        }
// 		$res->url = "/".$this->get_content_category_url($res->id_content_category,true);

        $res->content->VIDEOS = $this->populate_video_details($res);
        $res->content->VIDEOS_PATH = self::VIDEOS_PATH;
        $res->content->IMAGES_PATH = self::IMAGES_PATH . $res->id_content_category . "/";
// 		print_p($res);
        return $res;
    }

    public function get_content_category($id_content_category) {

        $r = $this->DB->getone("
            SELECT category FROM s3n_content_category
            where id_content_category = ?
        ", array(
            (int) $id_content_category
        ));
        return $r;
    }

    public function get_categories_by_category($category) {
        $sql = " FROM s3n_content_category"
                . " WHERE category = $category"
                . " AND visible = '1'";

        $count = "SELECT count(1) as pocet " . $sql;
        $pocet = $this->DB->getOne($count);
        $this->result_count = $pocet;
        $select = "SELECT * " . $sql;
        if ($this->limit) {
            $select .= " limit " . $this->offset . ", " . $this->limit;
        }
        $r = $this->DB->getAll($select);
        return $r;
    }

    public function get_content_categories($only_parents = false, $only_visible = false, $id_parent = null, $remove_categories = null, $only_categories = null, $ids_content_category = array()) {
        global $content_url;
        if (!$this->content_type)
            $this->content_type = self::DEFAULT_ID_CONTENT_TYPE; // TODO doresit defaulty
        if (!$this->content_lang)
            $this->content_lang = 1; // TODO doresit defaulty
        if ($id_parent)
            $id_parent = (int) $id_parent;
        if ($only_parents) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS  cat.id_content_category AS cat_id, cat.*, cont.title_1, cont.text_1, cont.text_2, cont.text_3, Count(cat1.id_parent) AS num_child
					FROM s3n_content_category AS cat
					Left Join s3n_content_category AS cat1 ON cat1.id_parent = cat.id_content_category
					LEFT JOIN s3n_content as cont ON cont.id_content_category = cat.id_content_category
					";
// 					if ($only_visible) $sql .= " AND cat1.visible = '1' ";
            $sql .= " WHERE cat.id_content_type = {$this->content_type} AND cat.id_content_lang = " . $this->get_id_lang($this->content_lang);
            if ($id_parent) {
                $sql .= " and cat.id_parent = " . $id_parent;
            } else {
                $sql .= " and cat.id_parent IS NULL";
            }
            if ($this->check_date_from)
                $sql .= " and (cat.visible_from <= NOW() OR cat.visible_from = '0000-00-00' OR cat.visible_from IS NULL) ";
            if ($this->check_date_to)
                $sql .= " and (cat.visible_to >= NOW() OR cat.visible_to = '0000-00-00' OR cat.visible_to  IS NULL) ";
            if ($remove_categories)
                $sql .= " AND cat.menu != '1' ";
            if ($only_categories)
                $sql .= " AND cat.menu = '1' ";
            if ($only_visible)
                $sql .= " AND cat.visible = '1'";
            $sql .= " GROUP BY cat.id_content_category ORDER BY cat." . $this->order_by;
// 			if ($this->limit) $sql .= " limit ".$this->offset.", ".$this->limit;
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS  c1.id_content_category AS cat_id, c1.*, cont.text_1, cont.text_2, cont.text_3
					FROM s3n_content_category AS c1
					Left Join s3n_content_category AS c2 ON c2.id_content_category = c1.id_parent
					LEFT JOIN s3n_content as cont ON cont.id_content_category = c1.id_content_category
					where c1.id_content_type = {$this->content_type} AND  c1.id_content_lang =  " . $this->get_id_lang($this->content_lang);
            if ($this->check_date_from)
                $sql .= " and (c1.visible_from <= NOW() or c1.visible_from = '0000-00-00' or c1.visible_from IS NULL) ";
            if ($this->check_date_to)
                $sql .= " and (c1.visible_to >= NOW() or c1.visible_to = '0000-00-00' or c1.visible_to IS NULL) ";
            if ($only_visible)
                $sql .= " AND c1.visible = '1' AND c2.visible = '1'";
            if ($remove_categories)
                $sql .= " AND c1.menu != '1' ";
            if ($only_categories)
                $sql .= " AND c1.menu = '1' ";
            if ($id_parent)
                $sql .= " AND (c2.id_parent = " . (int) $id_parent . " OR c1.id_parent = " . (int) $id_parent . ") GROUP by c1.id_content_category";
            if (count($ids_content_category)) {
                $sql .= " AND c1.id_content_category IN(" . implode(',', $ids_content_category) . ")";
            }
            // 					if ($remove_categories) $sql .= " ";
// 			$sql .= " ORDER BY c1.id_parent ASC, c1.priority DESC";
            $sql .= " ORDER BY c1." . $this->order_by;
        }
        if ($this->limit)
            $sql .= " limit " . $this->offset . ", " . $this->limit;
// 		echo $sql."<br/><br/>";

        $r = $this->DB->getAll($sql);
        $this->check($r);

        $this->result_count = $this->DB->getone("SELECT FOUND_ROWS();"); //TODO pocita pouze pro jednu kategorii druha neni doresena uplne spravne
// 		echo $sql."<br/><br/>";
// 		if ($remove_categories) {
// 			foreach($r AS $key=>$item) {
// 					if($item->category) unset($r[$key]);
// 					$this->result_count --;
// 			}
// 		}
// 		$r = $this->DB->getAssoc($sql);

        foreach ($r as $key => $item) {
// 			if ($item->id_master) $res[$key]->id_content = $item->id_master;
            if ($r[$key]->external_url) {
                $r[$key]->target = "_BLANK";
                $r[$key]->url = $r[$key]->external_url;
            } else {
                $content_url = "";
                $r[$key]->url = "/" . $this->get_content_category_url($item->id_content_category, true);
                $r[$key]->target = "";
                $content_url = "";
            }
            $content_url = "";
        }
// 		print_p($r);

        return $r;
    }

    public function get_content_category_url($id_content_category, $recursive = true, $i = 0) {
        if (self::$cache['get_content_category_url'][$id_content_category])
            return self::$cache['get_content_category_url'][$id_content_category];
        global $content_url, $ERROR;
        if ($i > CONTENT_DEEP) {
            $ERROR->spawn('get_content_category_url - asi se nam tu neco cykli', '', ERROR::OK, ERROR::ALERT, $id_content_category);
        }
        $res = $this->DB->getrow("select * from s3n_content_category where id_content_category = $id_content_category");
        $this->check($res);
        if (!$res->url) {
            $res->url = $res->seo_name . "/";
        }
        $content_url = $res->url . $content_url;
// 		echo $id_content_category ." ma parenta " . $res->id_parent."<br/>";
        if ($recursive AND $res->id_parent)
            $this->get_content_category_url($res->id_parent, true, ++$i);
        $res = substr($content_url, 0, -1);
        self::$cache['get_content_category_url'][$id_content_category] = $res;
        return $res;
    }

    public function get_childs($id_content_category) {
        $r = $this->DB->getAll("
				SELECT cat.*, Count(cat1.id_parent) AS num_child
				FROM s3n_content_category AS cat
				Left Join s3n_content_category AS cat1 ON cat1.id_parent = cat.id_content_category
				WHERE cat.id_parent = ?
				GROUP BY cat.id_content_category
				ORDER BY cat.id_content_category DESC
						", array(
            (int) $id_content_category
        ));
        $this->check($r);

        return $r;
    }

    public function get_content_category_visibility($id_content_category) {
        return $this->DB->getOne("SELECT cat.visible FROM s3n_content_category AS cat WHERE cat.id_category = $id_content_category");
    }

    public function set_content_category_visibility($id_content_category, $visible) {
        $r = $this->DB->query("
			update s3n_content_category set visible = ?
			where id_content_category = ?
		", array(
            $visible ? "1" : "0",
            (int) $id_content_category
        ));

        $this->check($r);
        return true;
    }

    public function set_content_category_content_type($idContentCategory, $idContentType) {
        $r = $this->DB->query("
			update s3n_content_category set id_content_type = ?
			where id_content_category = ?
		", array(
            $idContentType,
            (int) $idContentCategory
        ));

        $this->check($r);
        return true;
    }

    public function set_content_category($id_content_category, $category) {
        if (!(int) $category) {
            $category = NULL;
        }
        $r = $this->DB->query("
			update s3n_content_category set category = ?
			where id_content_category = ?
		", array(
            $category,
            (int) $id_content_category
        ));

        $this->check($r);
        return true;
    }

    public function content_category_check_uniq_seoname($seoname, $idContentCategory = null) {
        if ($idContentCategory) {
            $r = dbI::query("select count(*) from s3n_content_category where seo_name = %s AND id_content_category <> %i;", $seoname, $idContentCategory)->fetchSingle();
        } else {
            $r = dbI::query("select count(*) from s3n_content_category where seo_name = %s;", $seoname)->fetchSingle();
        }

        if (!$r) {
            return true;
        } else {
            return false;
        }
    }

    public function content_category_add($data) {
        if (!$data["datum"])
            $data["datum"] = date("Y-m-d");
        if ($data["id_parent"]) { // v pripade ze nadrazena kategorie je skryta je treba skryt i pod ni nove vytvorenou
            if (!$this->get_content_category_visibility($data["id_parent"]))
                $data["visible"] = 0;
        }

        if (!$data["priority"]) {
            $last_priority = $this->DB->getOne("select priority from s3n_content_category order by priority desc limit 0,1");
            $this->check($res);
            $data["priority"] = (int) $last_priority + 50;
        }

        if (!$data["name"])
            throw new Exception("Neni zadan nazev v menu");;

// 		if ($homepage) $this->DB->query("UPDATE s3n_content_category set homepage = '0' ");
        $seoname = $this->url_friendly($data["name"]);
        $i = 0;
        while (true) {
            $i++;
            if (!$this->content_category_check_uniq_seoname($seoname)) {
                $seoname = $this->url_friendly($data["name"]) . "-" . $i;
            } else {
                break;
            }
        }
        $pGps = fixGps($data['gps']);
//		print_p($data); die();
        // vytvoreni kategorie
        $r = dibi::query("
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
				menu)
			VALUES (%s, %s, %s, %s, %s, %i, %s, %s, %s, %s, %s, %i, %i, %i, %i, %s);
		", $data["name"], $data["description"], changeDatepickerDate($data["datum"]), $pGps[0], $pGps[1], $data["external_url"], $data["id_parent"] ? $data["id_parent"] : null, $seoname, $data["visible"] ? "1" : 0, changeDatepickerDate($data["visible_from"]), changeDatepickerDate($data["visible_to"]), $data["homepage"] ? "1" : 0, $data["priority"], $data["sub_content_category_counter_limit"], $data["id_content_type"], $this->get_id_lang($this->content_lang), $menu ? "1" : 0);
        $this->check($r);
        return dibi::fetchSingle("SELECT max(id_content_category) FROM s3n_content_category");
    }

    public function content_category_edit($idContentCategory, $data) {
        if (!$data["name"] || !$idContentCategory) {
            throw new Exception(("Neni dostatek informací pro úpravu."));
        }

        $seo_name = $this->url_friendly($data["name"]);
        $i = 0;
        while (true) {
            $i++;
            if (!$this->content_category_check_uniq_seoname($seo_name, $idContentCategory)) {
                $seo_name = $this->url_friendly($data["name"]) . "-" . $i;
            } else {
                break;
            }
        }

        if ($homepage)
            dbI::query("UPDATE s3n_content_category set homepage = '0' WHERE id_content_lang = %i", $this->content_lang)->result();

        $pGps = fixGps($data['gps']);

        if ($idContentCategory == $data["id_parent"]) {
            $this->spawn_error("Nelze být vlastním rodičem !", ERROR::ERR);
            return false;
        }
        $r = dbI::query("
			UPDATE s3n_content_category set
				name = %s,
				seo_name = %s,
				description = %s,
				datum = %s,
				gps_lat = %s,
				gps_lng = %s,
				external_url = %s,
				id_parent = %i,
				visible = %s,
				visible_from = %s,
				visible_to = %s,
				homepage = %s,
				priority = %i,
				sub_content_category_counter_limit = %i,
				menu = %s,
				id_odbor = %i,
				author = %s,
				price = %s
			WHERE id_content_category = %i
		", $data["name"], $seo_name, $data["description"], changeDatepickerDate($data["datum"]), $pGps[0], $pGps[1], $data["external_url"], $data["id_parent"] ? $data["id_parent"] : null, $data["visible"] ? "1" : 0, changeDatepickerDate($data["visible_from"]), changeDatepickerDate($data["visible_to"]), $data["homepage"] ? "1" : 0, $data["priority"], $data["sub_content_category_counter_limit"], $data["menu"] ? "1" : 0, $data["id_odbor"], $data["author"], $data["price"], $idContentCategory
                )->result();
        $this->set_content_category_visibility($idContentCategory, $data["visible"]);

// 		if (!$visible) {	// schovavame kategorii tak schovame i vsechny podrizene
// 			foreach ($this->get_content_categories(false,false,$id_category) AS $cat) {
// 				$this->set_content_category_visibility($cat->cat_id,0);
// 			}
// 		}
// 		$this->DB->commit();
        return true;
    }

    public function content_category_delete($idContentCategory) {
        $r = dbI::query("DELETE FROM s3n_content_category WHERE id_content_category = %i;", $idContentCategory)->result();
        for ($i = 1; $i <= self::MAX_IMAGES_UPLOAD_COUNT; $i++) {
            $this->content_category_image_delete($idContentCategory, $i);
        }
        for ($i = 1; $i <= self::MAX_VIDEO_UPLOAD_COUNT; $i++) {
            $this->content_category_video_delete($idContentCategory, $i);
        }
        return true;
    }

    public function content_edit($idContent, $data) {
        if (!$idContent)
            throw new Exception("Chybi id_content");
// 		print_p($homepage);
        if ($data["homepage"]) {
            $res = $this->DB->query("UPDATE s3n_content as c, s3n_content_category as cat set c.homepage = '0' WHERE c.id_content_category = cat.id_content_category AND cat.id_content_lang = " . $this->content_lang);
            $this->check($res);
        }
        $r = $this->DB->query("
			UPDATE s3n_content set
				id_template = ?,
				title_1 = ?,
				title_2 = ?,
				title_3 = ?,
				text_1 = ?,
				text_2 = ?,
				text_3 = ?,
				datum = ?,
				visible = ?,
				visible_from = ?,
				visible_to = ?,
				meta_title = ?,
				meta_description = ?,
				meta_keywords = ?,
				homepage = ?
			WHERE id_content = ?
		", array(
            $data["id_template"],
            $data["title_1"],
            $data["title_2"],
            $data["title_3"],
            $data["text_1"],
            $data["text_2"],
            $data["text_3"],
            changeDatepickerDate($data["datum"]),
            $data["visible"],
            changeDatepickerDate($data["visible_from"]),
            changeDatepickerDate($data["visible_to"]),
            $data["meta_title"],
            $data["meta_description"],
            $data["meta_keywords"],
            $data["homepage"] ? "1" : "0",
            $idContent
        ));
//		print_p($this->DB->last_query);
        $this->check($r);
        return true;
    }

    public function content_add($idContentCategory, $data) {
        if ($data["homepage"]) {
            $res = $this->DB->query("UPDATE s3n_content as c, s3n_content_category as cat set c.homepage = '0' WHERE c.id_content_category = cat.id_content_category AND cat.id_content_lang = " . $this->content_lang);
            $this->check($res);
        }

        $r = $this->DB->query("
			INSERT INTO s3n_content (
				id_content_category,
				id_template,
				title_1,
				title_2,
				title_3,
				text_1,
				text_2,
				text_3,
				meta_title,
				meta_description,
				meta_keywords,
				homepage,
				id_author)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);
		", array(
            $idContentCategory,
            $data["id_template"],
            $data["title_1"],
            $data["title_2"],
            $data["title_3"],
            $data["text_1"],
            $data["text_2"],
            $data["text_3"],
            $data["meta_title"],
            $data["meta_description"],
            $data["meta_keywords"],
            $data["homepage"] ? "1" : "0",
            $data["id_author"],
        ));
        $this->check($r);
// 		echo $this->DB->last_query;
        return true;
    }

    public function content_delete($id_content) {
        $r = $this->DB->query("
			DELETE FROM s3n_content
			WHERE id_content = ?;
		", array(
            (int) $id_content
        ));
        $this->check($r);
        return true;
    }

    public function get_id_content_type_by_seoname($seo_name) {
        if (!$seo_name)
            return false;
        $res = $this->DB->getone("select id_content_type from s3n_content_category where seo_name = '$seo_name'");
        $this->check($res);
        return $res;
    }

    public function get_id_content_category_by_seoname($seo_name) {
        if (!$seo_name)
            return false;
        $res = $this->DB->getone("select id_content_category from s3n_content_category where seo_name = '$seo_name' ");
        $this->check($res);
        return $res;
    }

    public function get_default_content_category_id() {
        $sql = "SELECT cat.id_content_category FROM s3n_content_category as cat, s3n_content as c WHERE cat.id_content_lang = {$this->content_lang} AND c.homepage = '1' AND cat.id_content_category = c.id_content_category ";
        $res = $this->DB->getone($sql);
        $this->check($res);
        return $res;
    }

    public function get_default_content_type() {
        $sql = "SELECT id_content_type FROM s3n_content_type WHERE `default` = '1' ";
        $res = $this->DB->getone($sql);
        $this->check($res);
        return $res;
    }

    public function get_templates() {
        $res = $this->DB->getAssoc("SELECT t.id_template, t.* from s3n_content_templates as t");
        $this->check($res);
        return $res;
    }

    public function content_category_map_gallery($id_content_category, $id_gallery, $priority) {
        $res = $this->DB->getone("select count(id_content_map_gallery) from s3n_content_category_map_gallery where id_content_category = $id_content_category and id_gallery = $id_gallery");
        $this->check($res);
        if ($res == 0) {
            $res = $this->DB->query("insert into s3n_content_category_map_gallery set id_content_category = $id_content_category ,id_gallery = $id_gallery, priority = $priority");
            $this->check($res);
        }
    }

    public function set_content_category_map_gallery_priprity($id_content_map_gallery, $priority) {
        if (!$id_content_map_gallery)
            return false;
        $res = $this->DB->query("update s3n_content_category_map_gallery set priority = $priority where id_content_map_gallery = $id_content_map_gallery");
        $this->check($res);
        return $res;
    }

    public function get_mapped_galleries($id_content_category) {
        $res = $this->DB->getall("select * from s3n_content_category_map_gallery where id_content_category = $id_content_category order by priority DESC");
        $this->check($res);
        return $res;
    }

    public function delete_mapped_gallery($id_gallery, $id_content_category) {
        if (!$id_gallery)
            return false;
        $res = $this->DB->query("delete from s3n_content_category_map_gallery where id_gallery = $id_gallery AND id_content_category = $id_content_category");
        $this->check($res);
        return true;
    }

    public function get_content_categories_seo_names() {
        $res = $this->DB->getcol("SELECT seo_name from s3n_content_category AS cat ");
        $this->check($res);
        return $res;
    }

    public function set_content_category_images($id_content_category, $name, $additional_images = null) {
        $uploaded_files = $this->upload_images($this->url_friendly($name), $id_content_category, $additional_images);
        $path = self::IMAGES_PATH . $id_content_category . "/";
        foreach ((array) $uploaded_files AS $key => $upload_file) {
            if ($upload_file) {
                $res = $this->DB->query("UPDATE s3n_content_category set image_" . ($key) . " = '" . $upload_file . "' WHERE id_content_category = $id_content_category");
                $this->check($res);
                $res = $this->resize_image($path . $upload_file, $path . "D-" . $upload_file, self::DETAIL_SIZEX, self::DETAIL_SIZEY, "width");
                $res = $this->resize_image($path . $upload_file, $path . "P-" . $upload_file, self::PREVIEW_SIZEX, self::PREVIEW_SIZEY, "width");
                $res = $this->resize_image($path . $upload_file, $path . "T-" . $upload_file, self::THUMB_SIZEX, self::THUMB_SIZEY, "width");
                $this->update_image_props($id_content_category, $key, $res);
            }
        }
    }

    public function set_content_category_files($id_content_category, $name) {
        $uploaded_files = $this->upload_files($this->url_friendly($name), $id_content_category);
        $path = self::IMAGES_PATH . $id_content_category . "/";
        foreach ((array) $uploaded_files AS $key => $upload_file) {
            if ($upload_file) {
                $res = dbI::query("UPDATE s3n_content_category SET file_{$key} = %s, file_{$key}_size = %s WHERE id_content_category = %i", $upload_file, filesize(PROJECT_DIR . self::FILES_PATH . $id_content_category . "/" . $upload_file), $id_content_category)->result();
            }
        }
    }

    public function set_content_category_videos($id_content_category, $name, $additional_videos = null) {
        $uploaded_files = $this->upload_videos($this->url_friendly($name), $id_content_category, $additional_videos);
        Helper_FileSystem::checkDir(PROJECT_DIR . self::VIDEOS_PATH);
        Helper_FileSystem::checkDir(PROJECT_DIR . self::VIDEOS_PATH . $id_content_category);
        $dir = PROJECT_DIR . self::VIDEOS_PATH . $id_content_category . "/";
        foreach ((array) $uploaded_files AS $key => $upload_file) {
            if ($upload_file) {
                $fileName = $dir . $upload_file;
                $format = $this->getMovieFormat($fileName);
                $previewX = self::VIDEO_PREVIEW_SIZEX;
                $detailX = self::VIDEO_DETAIL_SIZEX;
                switch ($format) {
                    case 0:
                        $previewY = self::VIDEO_PREVIEW_16_9_SIZEY;
                        $detailY = self::VIDEO_DETAIL_16_9_SIZEY;
                        break;
                    case 1:
                        $previewY = self::VIDEO_PREVIEW_4_3_SIZEY;
                        $detailY = self::VIDEO_DETAIL_4_3_SIZEY;
                        break;
                    case 2:
                        $previewY = self::VIDEO_PREVIEW_1_1_SIZEY;
                        $detailY = self::VIDEO_DETAIL_1_1_SIZEY;
                        break;

                    default:
                        $previewY = self::VIDEO_PREVIEW_4_3_SIZEY;
                        $detailY = self::VIDEO_DETAIL_4_3_SIZEY;
                        break;
                }

                $res = $this->DB->query("UPDATE s3n_content_category set video_original_" . ($key) . " = '" . $upload_file . "' WHERE id_content_category = $id_content_category");
                $this->check($res);

                $this->resize_video($id_content_category, $upload_file, $upload_file, "preview", $previewX, $previewY, $create_story_board = true);
                $RetVal = $this->resize_video($id_content_category, $upload_file, $upload_file, "detail", $detailX, $detailY, $create_story_board = true);

                $res = $this->DB->query("UPDATE s3n_content_category set video_" . ($key) . " = '" . $RetVal["video"] . "' WHERE id_content_category = $id_content_category");
                $this->check($res);
// 				$res = $this->DB->query("UPDATE s3n_content_category set story_board_images_count_". ($key) . " = '" . $RetVal["count"] . "' WHERE id_content_category = $id_content_category");
// 				$this->check($res);
                $res = $this->DB->query("UPDATE s3n_content_category set video_thumbnail_" . ($key) . " = '" . $RetVal["video_thumbnail"] . "' WHERE id_content_category = $id_content_category");
                $this->check($res);
            }
// 			print_p($RetVal);
// 			$res = $this->DB->query("UPDATE s3n_content_category set video_". ($key+1) . " = '" . $upload_file . "' WHERE id_content_category = $content_category_id");
        }
        return true;
    }

    private function upload_images($name, $id_content_category, $additional_images = null) {
        $dir = PROJECT_DIR . self::IMAGES_PATH . $id_content_category . "/";
        if (!file_exists($dir)) {
            if (!mkdir($dir))
                throw new Exception("Nelze vytvorit adresar pro upload obrazku ($dir) !");
        }

        $p_files = $_FILES["content_category_image"];
        if (count($additional_images)) {
            for ($i = 0; $i < self::MAX_IMAGES_UPLOAD_COUNT; $i++) {
                if ($additional_images[$i + 1]) {
                    $p_files["name"][$i] = urlFriendly($additional_images[$i + 1]);
                    $p_files["tmp_name"][$i] = PROJECT_DIR . urldecode($additional_images[$i + 1]);
                }
            }
        }
        chmod($dir, self::CREATE_DIR_MODE);
        if ($p_files) {
            for ($cnt = 0; $cnt < self::MAX_IMAGES_UPLOAD_COUNT; $cnt++) {
                $p_images[$cnt + 1] = "";
                if ($p_files["name"][$cnt]) {
                    $p_images[$cnt + 1] = $name . "-" . ($cnt + 1) . "." . end(explode(".", $p_files['name'][$cnt]));
                    copy($p_files['tmp_name'][$cnt], $dir . $p_images[$cnt + 1]);
                }
            }
        }
        return $p_images;
    }

    private function upload_files($name, $id_content_category) {
        $dir = PROJECT_DIR . self::FILES_PATH;
        if (!file_exists($dir))
            if (!mkdir($dir))
                throw new Exception("Nelze vytvorit adresar pro upload souboru ($dir) !");
        chmod($dir, self::CREATE_DIR_MODE);
        $dir = PROJECT_DIR . self::FILES_PATH . $id_content_category . "/";
        if (!file_exists($dir))
            if (!mkdir($dir))
                throw new Exception("Nelze vytvorit adresar pro upload souboru ($dir) !");
        chmod($dir, self::CREATE_DIR_MODE);

        $p_files = $_FILES["content_category_file"];
        if ($p_files) {
            for ($cnt = 0; $cnt < self::MAX_FILES_UPLOAD_COUNT; $cnt++) {
                $pathInfo = pathinfo($p_files["name"][$cnt]);
                $name = $pathInfo['basename'];
                $p_images[$cnt + 1] = $name;
                if ($p_files["name"][$cnt]) {
                    $p_images[$cnt + 1] = $name;
                    copy($p_files['tmp_name'][$cnt], $dir . $p_images[$cnt + 1]);
                }
            }
        }
        return $p_images;
    }

// 	private function upload_videos($name,$id_content_category, $additional_videos = null) {
// 			$dir = PROJECT_DIR.self::VIDEOS_PATH.$id_content_category."/";
// 			if (!file_exists($dir)) {
// 				if (!mkdir($dir)) { $this->spawn_error("Nele vytvorit adresar pro upload videa ($dir) !", ERROR::CRIT); }
// 			}
// 			chmod($dir, self::CREATE_DIR_MODE);
// 			if ($_FILES["content_category_video"]) {
// 				for($cnt = 0; $cnt < self::MAX_VIDEO_UPLOAD_COUNT ; $cnt++) {
// 					$p_videos[$cnt+1] = "";
// 					if ($_FILES["content_category_video"]["name"][$cnt]) {
// 						$p_videos[$cnt+1] = $name."-".($cnt+1).".".end(explode(".", $_FILES['content_category_video']['name'][$cnt]));
// 						move_uploaded_file($_FILES['content_category_video']['tmp_name'][$cnt], $dir.$p_videos[$cnt+1]);
// 					}
// 				}
// 			}
// 			return $p_videos;
// 	}

    private function upload_videos($name, $id_content_category, $additional_videos = null) {
// 			$additional_videos = array("1"=>"/videos_content_category/3343/muj_prvni_clanek_3343-1.wmv");
        $dir = PROJECT_DIR . self::VIDEOS_PATH . $id_content_category . "/";
        if (!file_exists($dir)) {
            if (!mkdir($dir)) {
                $this->spawn_error("Nele vytvorit adresar pro upload videa ($dir) !", ERROR::CRIT);
            }
        }

// 			print_p($additional_videos,"add videos");
        $p_files = $_FILES["content_category_video"];
        if (count($additional_videos)) {
            for ($i = 0; $i < self::MAX_VIDEO_UPLOAD_COUNT; $i++) {
// 				echo "x";
                if ($additional_videos[$i + 1]) {
                    $p_files["name"][$i] = urlFriendly($additional_videos[$i + 1]);
// 						$p_files["tmp_name"][$i] = PROJECT_DIR.$additional_images[$i+1];
                    $p_files["tmp_name"][$i] = PROJECT_DIR . urldecode($additional_videos[$i + 1]);
// 						$p_files["tmp_name"][$i] = PROJECT_DIR.iconv("UTF-8", "ISO-8859-1//TRANSLIT", $additional_images[$i+1]);
                }
            }
        }
// 			print_p($p_files, "p_files");

        chmod($dir, self::CREATE_DIR_MODE);
        if ($p_files) {
            for ($cnt = 0; $cnt < self::MAX_VIDEO_UPLOAD_COUNT; $cnt++) {
                $p_videos[$cnt + 1] = "";
                if ($p_files["name"][$cnt]) {
                    $p_videos[$cnt + 1] = $name . "-" . ($cnt + 1) . "." . end(explode(".", $p_files['name'][$cnt]));
                    copy($p_files['tmp_name'][$cnt], $dir . $p_videos[$cnt + 1]);
                }
            }
        }
        return $p_videos;
    }

    private function resize_image($src, $dst, $width, $height, $resize_type) {
// 		echo $src."<br/>";
// 		echo $src;
        require_once 'Image/Transform.php';
        //create transform driver object
        $it = Image_Transform::factory('GD');
        if (PEAR::isError($it)) {
            die($it->getMessage());
        }

// 		echo PROJECT_DIR.$src;
        $ret = $it->load(PROJECT_DIR . $src);
        if (PEAR::isError($ret)) {
            die($ret->getMessage());
        }

        switch ($resize_type) {
            case "width" : $ret = $it->scaleByX($width);
                break;
            case "height" : $ret = $it->scaleByY($height);
                break;
            case "auto" : $ret = $it->scaleByLength($width);
                break;
            default: $ret = $it->scaleByLength($width);
        }
        if (PEAR::isError($ret)) {
            die($ret->getMessage());
        }
// 		$result["width"] = $it->getImageSize( );
// 		$result["height"] = $it->getImageHeight();
// 		$result["type"] = $it->getImageType();

        $ret = $it->save(PROJECT_DIR . $dst);
        if (PEAR::isError($ret)) {
            die($ret->getMessage());
        }
// 		$result["typex"] = $ret->getImageType();

        return(PROJECT_DIR . $dst);
    }

    private function resize_video($id_content_category, $source, $destination, $resize_prefix, $width, $height, $create_story_board = false) {
        define('FFMPEG_DATABASE', 'mysql://ffmpeg:mayqraxvxkiej387@mysql/ffmpeg_encode'); // connection string do DB
//		define('FFMPEG_DATABASE', 'mysql://root:error5037@localhost/ffmpeg_encode'); // connection string do DB
        $DB_FFMPEG = & DB::connect(FFMPEG_DATABASE);
        if (PEAR::isError($DB_FFMPEG)) {
            throw new Exception("FFMPEG Encoder " . $DB_FFMPEG->getMessage());
        }
        $DB_FFMPEG->setFetchMode(DB_FETCHMODE_ASSOC);
        $DB_FFMPEG->query("SET names 'utf8'");
        if (PEAR::isError($DB_FFMPEG)) {
            $this->spawn_error($DB_FFMPEG->getMessage(), ERROR::ERR);
        }

        $dir = PROJECT_DIR . self::VIDEOS_PATH . $id_content_category;
        if (!file_exists($dir)) {
            if (!mkdir($dir)) {
                $this->spawn_error("Nele vytvorit adresar pro upload videa 1 ($dir ) !", ERROR::CRIT);
            }
        }
        chmod($dir, self::CREATE_DIR_MODE);

        $dir .= "/" . $resize_prefix;
        if (!file_exists($dir)) {
            if (!mkdir($dir)) {
                $this->spawn_error("Nele vytvorit adresar pro upload videa 2 ($dir ) !", ERROR::CRIT);
            }
        }
        chmod($dir, self::CREATE_DIR_MODE);
//		$command = ' -i ' . PROJECT_DIR . self::VIDEOS_PATH . $id_content_category . "/" . $source . ' -deinterlace -y -nr 500 -r 30 -b 400k -me_range 25 -i_qfactor 0.9 -qmin 8 -qmax 8 -g 500 -vcodec flv -acodec libmp3lame -ac 2 -ar 44100 -s ' . $width . 'x' . $height . ' ' . $dir . "/" . $destination . ".flv";
        $command = ' -i ' . PROJECT_DIR . self::VIDEOS_PATH . $id_content_category . "/" . $source . ' -vcodec libx264 ' . $dir . "/" . $destination . ".mp4";
        $res_ffmpeg = $DB_FFMPEG->query("INSERT INTO queue set ffmppar = '$command', state = 'new', id_content_category = '$id_content_category', host = '" . HOST . "'  ");
        if (PEAR::isError($res_ffmpeg)) {
            $this->spawn_error($res_ffmpeg->getMessage(), ERROR::ERR);
        }

        $dir .= "/thumbs";
        if (!file_exists($dir)) {
            if (!mkdir($dir)) {
                $this->spawn_error("Nele vytvorit adresar pro upload videa 3 ($dir ) !", ERROR::CRIT);
            }
        }
        chmod($dir, self::CREATE_DIR_MODE);

//		$command = " -i ".PROJECT_DIR.self::VIDEOS_PATH.$id_content_category."/".$source."  -r 25 -y -ss 00:00:06 -t 00:00:01 -f image2 -s ".$width."x".$height." ".$dir."/".$destination.".png";
        $command = " -i " . PROJECT_DIR . self::VIDEOS_PATH . $id_content_category . "/" . $source . "  -ss 00:00:06 -t 00:00:01 -f image2 -s " . $width . "x" . $height . " -vframes 1 " . $dir . "/" . $destination . ".png";
        $res_ffmpeg = $DB_FFMPEG->query("INSERT INTO queue set ffmppar = '$command', state = 'new', id_content_category = '$id_content_category' , host = '" . HOST . "' ");
        if (PEAR::isError($res_ffmpeg)) {
            $this->spawn_error($res_ffmpeg->getMessage(), ERROR::ERR);
        }
// 		$thumb = exec($command);

        if ($create_story_board) {
            $dir = PROJECT_DIR . self::VIDEOS_PATH . $id_content_category . "/" . $resize_prefix . "/story_board/";
            if (!file_exists($dir)) {
                if (!mkdir($dir)) {
                    $this->spawn_error("Nele vytvorit adresar pro upload videa 4 ($dir ) !", ERROR::CRIT);
                }
            }
            chmod($dir, self::CREATE_DIR_MODE);
            $command = (' -i ' . PROJECT_DIR . self::VIDEOS_PATH . $id_content_category . "/" . $source . ' -y -r 0.1 -ss 00:00:16 -f image2 -s ' . $width . 'x' . $height . ' ' . $dir . $destination . ".flv" . '%02d.png');
            $res_ffmpeg = $DB_FFMPEG->query("INSERT INTO queue set ffmppar = '$command', state = 'new', id_content_category = '$id_content_category' ,  host = '" . HOST . "' ");
            if (PEAR::isError($res_ffmpeg)) {
                $this->spawn_error($res_ffmpeg->getMessage(), ERROR::ERR);
            }
// 			$res = exec($command);
            $dir = $dir;
// 			$count = count(glob("" . $dir . "*.png"));
        }
//		$res["video"] = $source . ".flv";
        $res["video"] = $source . ".mp4";
        $res["video_thumbnail"] = $source . ".png";
        $res["story_board_base_name"] = "";
// 		$res["story_board_images_count"] = $count;
        return($res);
    }

    public function content_category_image_delete($id_content_category, $image_index) {
        if (!$id_content_category or ! $image_index)
            return false;
        $file = $this->DB->getone("select image_" . $image_index . " from s3n_content_category where id_content_category = $id_content_category");
        $this->check($file);
        $res = $this->DB->query("update s3n_content_category set image_" . $image_index . " = '' where id_content_category = $id_content_category");
        $this->check($res);
        $path = PROJECT_DIR . self::IMAGES_PATH . $id_content_category . "/";
        @unlink($path . $file);
        @unlink($path . "T-" . $file);
        @unlink($path . "P-" . $file);
        @unlink($path . "D-" . $file);
        return true;
    }

    public function content_category_video_delete($id_content_category, $video_index) {
        if (!$id_content_category or ! $video_index)
            return false;
        $res = $this->DB->getrow("select * from s3n_content_category where id_content_category = $id_content_category");
        $this->check($res);
// 		print_p($res);
// 		$res = $this->DB->query("update s3n_content_category set image_".$image_index." = '' where id_content_category = $id_content_category");
// 		$this->check($res);
        $path = PROJECT_DIR . self::VIDEOS_PATH . $id_content_category . "/";
        $to_delete = array(
            "original" => $path . $res->{video_original . "_" . $video_index},
            "preview" => $path . "preview/" . $res->{video . "_" . $video_index},
            "detail" => $path . "detail/" . $res->{video . "_" . $video_index},
            "preview_thumb" => $path . "preview/thumbs/" . $res->{video_original . "_" . $video_index} . ".png",
            "detail_thumb" => $path . "detail/thumbs/" . $res->{video_original . "_" . $video_index} . ".png",
        );
        foreach ($to_delete as $file) {
            if (is_file($file))
                unlink($file);
        }

        $video_tmp = "video_" . $video_index;
        $res = $this->DB->query("update s3n_content_category set video_original_{$video_index} = '', video_{$video_index} = '', video_thumbnail_{$video_index} = '' where id_content_category = $id_content_category");
        $this->check($res);

        $video_tmp = $res->$video_tmp;
        $p_story_board_preview = File_Find::glob($video_tmp . '*.png', $path . "/" . "preview/story_board/", 'shell');
        foreach ($p_story_board_preview as $file) {
            if (is_file($path . "/" . "preview/story_board/" . $file))
                unlink($path . "/" . "preview/story_board/" . $file);
        }
        $p_story_board_detail = File_Find::glob($video_tmp . '*.png', $path . "/" . "detail/story_board/", 'shell');
        foreach ($p_story_board_detail as $file) {
            if (is_file($path . "/" . "detail/story_board/" . $file))
                unlink($path . "/" . "detail/story_board/" . $file);
        }


// 		print_p($to_delete,"to_delete");
        return true;
    }

    public function get_contents_for_homepage($id_content_category = null) {
        $sql = "SELECT cc.* FROM s3n_content_category AS cc, s3n_content AS c WHERE cc.id_content_category = c.id_content_category AND c.homepage = '1' ";
        if ($id_content_category)
            $sql .= " AND c.id_content_category = $id_content_category";
        $sql .= " order by cc.priority DESC";
        if ($this->limit)
            $sql .= " limit 0," . $this->limit;
        $p_content_categories = $this->DB->getall($sql);
        $this->check($p_content_categories);

        foreach ($p_content_categories AS $key => $p_content_category) {
// 			$this->content_type = $p_content_category->id_content_type;
// 			$p_content_categories[$key]->content = $this->get_content_detail($p_content_category->id_content_category);
// 			$p_content_categories[$key]->url = "/".$this->get_content_category_url($p_content_category->id_content_category,true);
        }
        return $p_content_categories;
    }

    public function search_content($keyword, $id_parent, $p_fields, $only_visible = true) {
        if (!$keyword) {
            return false;
        }

//	$keyword = iconv('ascii//translit', 'utf-8', $keyword);
        $p_fields_content_category = array("name", "description", "video_original_1", "video_original_2", "video_original_3", "image_1", "image_2", "image_3", "image_4", "image_5", "image_6", "image_7", "image_8", "image_9");
        $p_fields_content = array("title_1", "title_2", "title_3", "text_1", "text_2", "text_3");
        foreach ($p_fields_content_category as $key => $field) {
            $cond_append_content_category .= " cc.$field like '%$keyword%' ";
            if ($p_fields_content_category[$key + 1]) {
                $cond_append_content_category .= " or ";
            }
        }
        foreach ($p_fields_content as $key => $field) {
            $cond_append_conent .= " c.$field like '%$keyword%' ";
            if ($p_fields_content[$key + 1])
                $cond_append_conent .= " or ";
        }

        $sql = "SELECT cc.* FROM s3n_content_category as cc, s3n_content as c WHERE cc.id_content_category = c.id_content_category AND id_content_type IN (" . implode(", ", dbContentCategory::getClankyCtIds()) . ") AND ( $cond_append_content_category or $cond_append_conent)";
        if ($id_parent) {
            $sql .= " and cc.id_parent =  $id_parent";
        }

        $sql .= " ORDER BY datum DESC, priority DESC";
        $res = dbI::query($sql)->fetchAll("dbContentCategory");
        return $res;
    }

    private function update_image_props($id_content_category, $image_spec, $image_file) {
// 		echo $image_file."<br/>";
        $props = getimagesize($image_file);
// 		print_p($props);
        $this->check($this->DB->query("
			update s3n_content_category set
				image_{$image_spec}_width = '" . $props["0"] . "',
				image_{$image_spec}_height = '" . $props["1"] . "',
				image_{$image_spec}_size = '" . filesize($image_file) . "'
				where id_content_category = $id_content_category"));
// 		echo $this->DB->last_query."<br/>";
    }

    public function left_categories_with_video($p_content_menu) {
        $sql = "SELECT * "
                . " FROM s3n_content_category"
                . " WHERE video_1 IS NOT NULL"
                . " OR video_2 IS NOT NULL"
                . " OR video_3 IS NOT NULL ";
        $res = $this->DB->getAll($sql);
        $kategorieSVidei = array();
        foreach ($res as $kategorie) {
            $kategorieSVidei[] = $kategorie->id_content_category;
        }

        // zjistim zda uz se jedna o pole kategorii nebo teprve tridu s atributem CATEGORIES
        if (is_array($p_content_menu)) {
            $this->_left_categories_with_video_recursion($p_content_menu, $kategorieSVidei);
        } else {
            if (isset($p_content_menu->CATEGORIES) && is_array($p_content_menu->CATEGORIES)) {
                $this->_left_categories_with_video_recursion($p_content_menu->CATEGORIES, $kategorieSVidei);
            }
        }
        return $p_content_menu;
    }

    private function _left_categories_with_video_recursion(&$categories, $kategorieSVidei) {
        // alespon jedna z kategorii se musi byt s videem jinak se vraci false
        $return = false;
        foreach ($categories AS $key => $category) {
            $idKategorie = $category->cat_id;

            // zjistim zda primo tato kategorie ma prirazene nejake video
            $kategorieMaVideo = in_array($idKategorie, $kategorieSVidei);
            $podKategorieMaVideo = false;
            // projdu pod kategorie a zjistim zda ma alespon jedna video
            if (isset($category->CATEGORIES) && is_array($category->CATEGORIES)) {
                $podKategorieMaVideo = $this->_left_categories_with_video_recursion($category->CATEGORIES, $kategorieSVidei);
            }
            // pokud ma pod kategorie nebo primo tato kaetgorie video, nebudu ji mazat
            // a navic nastavim priznak $return na true
            // tim zajistim, ze se nesmaze ani parent
            if ($podKategorieMaVideo || $kategorieMaVideo) {
                $return = true;
            } else {
                // pokud nema kategorie ani podkategorie video, muzu ji smazat
                unset($categories[$key]);
            }
        }
        // vratim priznak, zda mela alespon jedna kategorie nebo podkategorie video
        return $return;
    }

    public function getMovieFormat($fileName) {
        $movie = new ffmpeg_movie($fileName, false);
        $x = $movie->getFrameWidth();
        $y = $movie->getFrameHeight();

        // poměr stran videa
        $x_y = $x / $y;

        // poměr stran formátů
        $s_d = 16 / 9;
        $c_t = 4 / 3;
        $j_j = 1 / 1;

        // mezní body
        $mb1 = ($s_d + $c_t) / 2;
        $mb2 = ($c_t + $j_j) / 2;

        if ($x_y > $mb1)
            return 0;
        if ($x_y > $mb2)
            return 1;
        return 2;
    }

    public function get_last_content_category_id_with_video($id_parent) {
        $sql = "SELECT cc.id_content_category FROM s3n_content_category AS cc WHERE (cc.video_1 != '' or cc.video_2 != '' or cc.video_3 != '' ) ";
        if ($id_parent)
            $sql .= " and cc.id_content_category in (
			select cc1.id_content_category from s3n_content_category AS cc1
			left join s3n_content_category as cc2 on cc2.id_content_category = cc1.id_parent
			where (cc1.id_parent = $id_parent or cc2.id_parent = $id_parent) or cc1.id_content_category = $id_parent
		)";
        $sql .= " order by datum desc, id_content_category desc ";
        $res = $this->DB->getone($sql);
// 		print_p($res);
        $this->check($res);
        return $res;
    }

    public function get_last_content_category_ids($id_parent, $limit) {
        $sql = "SELECT cc.id_content_category FROM s3n_content_category AS cc WHERE 1 ";
        if ($id_parent)
            $sql .= " and cc.id_content_category in (
			select cc1.id_content_category from s3n_content_category AS cc1
			left join s3n_content_category as cc2 on cc2.id_content_category = cc1.id_parent
			where (cc1.id_parent = $id_parent or cc2.id_parent = $id_parent) or cc1.id_content_category = $id_parent
		)";
        $sql .= "  and cc.menu != '1' and cc.visible = '1'  group by cc.id_content_category order by datum desc, id_content_category desc limit 0,$limit";
        $res = $this->DB->getcol($sql);
// 		print_p($res);
        $this->check($res);
        return $res;
    }

    public function content_category_map_poll($id_content_category, $id_poll, $priority) {
        $res = $this->DB->getone("select count(id_content_map_poll) from s3n_content_category_map_poll where id_content_category = $id_content_category and id_poll = $id_poll");
        $this->check($res);
        if ($res == 0) {
            $res = $this->DB->query("insert into s3n_content_category_map_poll set id_content_category = $id_content_category ,id_poll = $id_poll, priority = $priority");
            $this->check($res);
        }
    }

    public function set_content_category_map_poll_priprity($id_content_map_poll, $priority) {
        if (!$id_content_map_poll)
            return false;
        $res = $this->DB->query("update s3n_content_category_map_poll set priority = $priority where id_content_map_poll = $id_content_map_poll");
        $this->check($res);
        return $res;
    }

    public function get_mapped_polls($id_content_category) {
        $res = $this->DB->getall("select * from s3n_content_category_map_poll where id_content_category = $id_content_category order by priority DESC");
        $this->check($res);
        return $res;
    }

    public function delete_mapped_poll($id_poll, $id_content_category) {
        if (!$id_poll)
            return false;
        $res = $this->DB->query("delete from s3n_content_category_map_poll where id_poll = $id_poll AND id_content_category = $id_content_category");
        $this->check($res);
        return true;
    }

    /*
      public function get_content_category_id_user($id_content_category) {
      $res = $this->DB->getone("select id_user from s3n_content_category_map_author where id_content_category = $id_content_category");
      $this->check($res);
      return $res

      }

      public function set_content_category_id_user($id_content_category, $id_user) {
      $res = $this->DB->getone("select count(id_map) from s3n_content_category_map_user where id_content_category = $id_content_category and id_user = $id_user");
      $this->check($res);
      if ($res == 0) {
      $res = $this->DB->query("insert into s3n_content_category_map_user set id_content_category = $id_content_category ,id_user = $id_user");
      $this->check($res);
      }
      return true;
      }
     */

    public function get_content_category_id_user($id_content_category) {
        $res = $this->DB->getone("select id_user from s3n_content_category where id_content_category = $id_content_category");
        $this->check($res);
        return $res;
    }

    public function set_content_category_id_user($id_content_category, $id_user) {
        $res = $this->DB->query("update s3n_content_category set id_user = $id_user where id_content_category = $id_content_category");
        $this->check($res);
        return true;
    }

    public static function setContentCategoryVisibility($idContentCategory, $visibility) {
        $visibility = $visibility == 'true' ? 1 : 0;
        dibi::query("UPDATE s3n_content set visible = '$visibility' WHERE id_content_category = %i", $idContentCategory);
        dibi::query("UPDATE s3n_content_category set visible = '$visibility' WHERE id_content_category = %i", $idContentCategory);
        return true;
    }

    public static function setContentCategoryHP($idContentCategory, $state) {
        if ($state) {
//			dbI::query("UPDATE s3n_content_category SET homepage = '0'")->result();
        }
        return dibi::query("UPDATE s3n_content_category SET homepage = %s WHERE id_content_category = %i", $state == 'true' ? 1 : 0, $idContentCategory);
    }

    public static function setContentCategoryZajimavosti($idContentCategory, $state) {
        return dibi::query("UPDATE s3n_content_category SET zajimavosti = %i WHERE id_content_category = %i", $state == 'true' ? 1 : 0, $idContentCategory);
    }

    public static function setContentCategoryAktuality($idContentCategory, $state) {
        return dibi::query("UPDATE s3n_content_category SET aktuality = %i WHERE id_content_category = %i", $state == 'true' ? 1 : 0, $idContentCategory);
    }

    public static function setContentCategoryType($idContentCategory, $type) {
        dbI::query("UPDATE s3n_content_category set menu = '$type' WHERE id_content_category = %i", $idContentCategory)->result();
        return true;
    }

}
