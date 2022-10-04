<?php

set_time_limit(340);

class Gallery_3n {

	var $DB;
	var $ERROR;
	var $tbl_prefix;
	var $gallery_type;
	var $galleries;

	const GALLERY_PATH = "/data/fotogalerie/";
	const GALLERY_XML_PATH = "/xml/";
	const GALLERY_IMAGE_PATH = "galleries/";
	const GALLERY_IMAGES_PATH = "images/";
	const GALLERY_WATER_IMAGES_PATH = "water_images/";
	const GALLERY_FILES_PATH = "files/";
	const GALLERY_VIDEOS_PATH = "videos/";
	const GALLERY_ICONS_PATH = "icons/";
	const THUMBSIZEX = 999;
	const THUMBSIZEY = 145;
	const IMAGEMAXSIZEX = 957;
	const IMAGEMAXSIZEY = 600;
// 	const DESC_ENCODING_IN = "WINDOWS-1250";
	const DESC_ENCODING_IN = "UTF-8";
	const DESC_ENCODING_OUT = "UTF-8";
	const CACHEDIR = ".cache";
	const CREATE_FILE_MODE = 0644;

	var $description = "";
	var $imagecount = 0;
	var $images = array();
	var $galleryPath = "";
	public static $thumbnail_width;
	public static $thumbnail_height;
	public static $thumbnail_resize_type;
	public static $preview_width;
	public static $preview_height;
	public static $preview_resize_type;
	public static $detail_width;
	public static $detail_height;
	public static $detail_resize_type;
	public static $detail_watermark_image = "";
	public static $preview_watermark_image = "";
	public static $thumbnail_watermark_image = "";
	var $gallery_image_width;
	var $gallery_image_height;
	var $gallery_image_resize_type;
	var $id_category = null;

// 	var $gallery_path = self::GALLERY_PATH;
// 	var $gallery_image_path= self::GALLERY_IMAGE_PATH;
// 	var $gallery_images_path= self::GALLERY_IMAGES_PATH;



	public function __construct($id_gallery = null, $gallery_type = null, $tbl_prefix = "s3n_") {
		global $ERROR, $DB;

		$this->DB = $DB;
		$this->tbl_prefix = $tbl_prefix;
		$this->ERROR = &$ERROR;
		if ($gallery_type) $this->gallery_type = $gallery_type;

		$this->DB->autoCommit(true);
		$this->DB->setFetchMode(DB_FETCHMODE_OBJECT);

		if ($id_gallery) {
			$this->id_gallery = $id_gallery;
			$this->get_gallery_detail($id_gallery);
		}
	}

	public function __destruct() {
		$this->DB->commit();
	}

	private function spawn_error($msg, $severity, $svrcode = ERROR::OK) {
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

	private static function url_friendly($title) {
		static $tbl = array("\xc3\xa1" => "a", "\xc3\xa4" => "a", "\xc4\x8d" => "c", "\xc4\x8f" => "d", "\xc3\xa9" => "e", "\xc4\x9b" => "e", "\xc3\xad" => "i", "\xc4\xbe" => "l", "\xc4\xba" => "l", "\xc5\x88" => "n", "\xc3\xb3" => "o", "\xc3\xb6" => "o", "\xc5\x91" => "o", "\xc3\xb4" => "o", "\xc5\x99" => "r", "\xc5\x95" => "r", "\xc5\xa1" => "s", "\xc5\xa5" => "t", "\xc3\xba" => "u", "\xc5\xaf" => "u", "\xc3\xbc" => "u", "\xc5\xb1" => "u", "\xc3\xbd" => "y", "\xc5\xbe" => "z", "\xc3\x81" => "A", "\xc3\x84" => "A", "\xc4\x8c" => "C", "\xc4\x8e" => "D", "\xc3\x89" => "E", "\xc4\x9a" => "E", "\xc3\x8d" => "I", "\xc4\xbd" => "L", "\xc4\xb9" => "L", "\xc5\x87" => "N", "\xc3\x93" => "O", "\xc3\x96" => "O", "\xc5\x90" => "O", "\xc3\x94" => "O", "\xc5\x98" => "R", "\xc5\x94" => "R", "\xc5\xa0" => "S", "\xc5\xa4" => "T", "\xc3\x9a" => "U", "\xc5\xae" => "U", "\xc3\x9c" => "U", "\xc5\xb0" => "U", "\xc3\x9d" => "Y", "\xc5\xbd" => "Z");
		$r = strtr($title, $tbl);

		preg_match_all('/[a-zA-Z0-9]+/', $r, $nt);
		$r = strtolower(implode('_', $nt[0]));
		return $r;
	}

	public function get_avail_gallery_types() {
		$r = $this->DB->getAll("
			select * from s3n_gallery_type order by id_gallery_type;
		", DB_FETCHMODE_ASSOC);
		$this->check($r);

		return $r;
	}

	public function get_gallery_type_detail($id_gallery_type = null) {
		if ($id_gallery_type) {
			$r = $this->DB->getRow("select * from s3n_gallery_type where id_gallery_type = " . $id_gallery_type);
		} else {
			$r = $this->DB->getRow("select * from s3n_gallery_type where id_gallery_type = " . $this->gallery_type);
		}
		$this->check($r);

		return $r;
	}

	public function set_gallery_type($gallery_type) {
		if (!$gallery_type) {
// 			$this->gallery_type = $this->get_default_gallery_type_seo_name();
		} else {
// 			$this->gallery_type = $gallery_type;
		}
		$this->gallery_type = $gallery_type;
	}

	private function get_gallery_type_id($gallery_type) {
// 		echo $gallery_type;
		$res = $this->DB->getOne("SELECT gt.id_gallery_type FROM s3n_gallery_type AS gt WHERE gt.seo_name = '$gallery_type'");
		$this->check($res);
		return $res;
	}

	public function get_gallery_visibility($id_gallery) {
		return $this->DB->getOne("SELECT gal.visible FROM s3n_gallery AS gal WHERE gal.id_gallery = $id_gallery");
	}

	public function set_gallery_visibility($id_gallery, $visible) {
		$r = $this->DB->query("
			update s3n_gallery set visible = ?
			where id_gallery = ?
		", array(
			$visible ? "1" : "0",
			(int) $id_gallery
		));

		$this->check($r);
		return true;
	}

	public function gallery_check_uniq_seo_name($seo_name) {
		$r = $this->DB->getOne("
			select count(*) from s3n_gallery where seo_name = ?;
		", array(
			$seo_name
		));
		$this->check($r);
		if ($r == 0) {
			return true;
		} else {
			return false;
		}
	}

	public static function gallery_images_check_uniq_seo_name($seo_name) {
		$r = dibi::fetchSingle("select count(*) from s3n_gallery_images where seo_name = %s;", $seo_name);
		if ($r == 0) {
			return true;
		} else {
			return false;
		}
	}

	public function get_default_gallery_type() {
		$sql = "SELECT id_gallery_type FROM s3n_gallery_type WHERE `default` = '1' ";
		$res = $this->DB->getone($sql);
		$this->check($res);
		return $res;
	}

	public function get_default_gallery_type_seo_name() {
		$sql = "SELECT seo_name FROM s3n_gallery_type WHERE `default` = '1' ";
		$res = $this->DB->getone($sql);
		$this->check($res);
		return $res;
	}

	public function get_templates() {
		$res = $this->DB->getAssoc("SELECT t.id_template, t.* from s3n_gallery_templates as t");
		$this->check($res);
		return $res;
	}

// 	public function gallery_add($title, $name, $description, $thumbnail_width, $thumbnail_height, $thumbnail_resize_type, $preview_width, $preview_height, $preview_resize_type, $detail_width, $detail_height, $detail_resize_type, $id_gallery_type, $visible, $id_gallery_template, $gallery_image, $gallery_image_width, $gallery_image_height, $gallery_image_resize_type) {
	public function gallery_add($title, $name, $description, $id_gallery_type, $visible, $id_gallery_template, $gallery_image) {
		if (!$name) return false;
		$tmp_name = $name . "-g";

		$seo_name = self::url_friendly($tmp_name);
		$i = 0;
		while (true) {
			$i++;
			if (!$this->gallery_check_uniq_seo_name($seo_name)) {
				$seo_name = self::url_friendly($tmp_name) . "-" . $i;
			} else {
				break;
			}
		}
// 		return false;
		$p_template = $this->DB->getRow("SELECT * FROM s3n_gallery_templates WHERE id_template = $id_gallery_template");
		// vytvoreni kategorie
		$r = $this->DB->query("
			insert into s3n_gallery (title,name,seo_name,description,thumbnail_width,thumbnail_height,thumbnail_resize_type,preview_width,preview_height,preview_resize_type,detail_width,detail_height,detail_resize_type,id_gallery_type,visible,gallery_path,id_gallery_template,gallery_image_width,gallery_image_height,gallery_image_resize_type)
			values ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
		", array(
			$title,
			$name,
			$seo_name,
			$description,
			(int) $p_template->thumbnail_width,
			(int) $p_template->thumbnail_height,
			$p_template->thumbnail_type,
			(int) $p_template->preview_width,
			(int) $p_template->preview_height,
			$p_template->preview_type,
			(int) $p_template->detail_width,
			(int) $p_template->detail_height,
			$p_template->detail_type,
			$id_gallery_type,
			$visible ? "1" : "0",
			$gallery_path = self::GALLERY_PATH . self::GALLERY_IMAGE_PATH,
			(int) $id_gallery_template,
// 			$gallery_image = self::GALLERY_PATH . self::GALLERY_IMAGE_PATH . "obrazek",
			(int) $p_template->gallery_width,
			(int) $p_template->gallery_height,
			$p_template->gallery_type
		));

		$this->check($r);
		$this->DB->commit();

		$id_gallery = $this->DB->getone("SELECT max(id_gallery) FROM s3n_gallery");

		if ($file_name = $this->upload_file($seo_name, self::GALLERY_IMAGE_PATH)) {
			copy(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGE_PATH . $file_name, PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGE_PATH . "O-" . $file_name);
			$res = $this->DB->query("
				update s3n_gallery set gallery_image = ? where id_gallery = ?;
			", array(
				$file_name,
				(int) $id_gallery
			));
			$this->check($res);
			$this->DB->commit();

			$res = $this->resize_image(self::GALLERY_IMAGE_PATH . $file_name, self::GALLERY_IMAGE_PATH . $file_name, $p_template->gallery_width, $p_template->gallery_height, $p_template->gallery_type);
			$this->update_gallery_image_props($id_gallery, $res);
		}
	}

// 	public function gallery_edit($title, $name, $description, $thumbnail_width, $thumbnail_height, $thumbnail_resize_type, $preview_width, $preview_height, $preview_resize_type, $detail_width, $detail_height, $detail_resize_type, $id_gallery_type, $visible, $id_gallery_template, $gallery_image, $gallery_image_width, $gallery_image_height, $gallery_image_resize_type) {
	public function gallery_edit($title, $name, $description, $id_gallery_type, $visible, $id_gallery_template, $gallery_image, $id_category) {
		if (!$this->id_gallery OR ! $name) return false;
		$tmp_name = $name . "_g";
		$seo_name = self::url_friendly($tmp_name);
		$i = 0;
		while (true) {
			$i++;
			if (!$this->gallery_check_uniq_seo_name($seo_name)) {
				$seo_name = self::url_friendly($tmp_name) . "-" . $i;
			} else {
				break;
			}
		}
		$p_template = $this->DB->getRow("SELECT * FROM s3n_gallery_templates WHERE id_template = $id_gallery_template");
// 		print_p($p_template);

		$r = $this->DB->query("
			update s3n_gallery set title = ?, name = ?, seo_name = ?, description = ?, thumbnail_width = ?,thumbnail_height = ?,thumbnail_resize_type = ?, preview_width = ?, preview_height = ?, preview_resize_type = ?, detail_width = ?, detail_height = ?,detail_resize_type = ?,id_gallery_type = ?,visible = ?,gallery_path = ?,id_gallery_template = ?, gallery_image_width = ?, gallery_image_height = ?, gallery_image_resize_type = ?, id_category = ?
			where id_gallery = ?
			;
		", array(
			$title,
			$name,
			$seo_name,
			$description,
			(int) $p_template->thumbnail_width,
			(int) $p_template->thumbnail_height,
			$p_template->thumbnail_type,
			(int) $p_template->preview_width,
			(int) $p_template->preview_height,
			$p_template->preview_type,
			(int) $p_template->detail_width,
			(int) $p_template->detail_height,
			$p_template->detail_type,
			(int) $id_gallery_type,
			$visible ? "1" : "0",
			$gallery_path = self::GALLERY_PATH . self::GALLERY_IMAGE_PATH,
			(int) $id_gallery_template,
// 			$gallery_image = self::GALLERY_PATH . self::GALLERY_IMAGE_PATH . "obrazek",
			(int) $p_template->gallery_width,
			(int) $p_template->gallery_height,
			$p_template->gallery_type,
			(int) $id_category,
			$this->id_gallery
		));
		$this->check($r);
		$this->DB->commit();

		if ($file_name = $this->upload_file($seo_name, self::GALLERY_IMAGE_PATH)) {
			$this->gallery_image_delete();
			copy(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGE_PATH . $file_name, PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGE_PATH . "O-" . $file_name);
			$res = $this->DB->query("
				update s3n_gallery set gallery_image = ? where id_gallery = ?;
			", array(
				$file_name,
				$this->id_gallery
			));
			$this->check($res);
			$this->DB->commit();

			$res = $this->resize_image(self::GALLERY_IMAGE_PATH . $file_name, self::GALLERY_IMAGE_PATH . $file_name, $p_template->gallery_width, $p_template->gallery_height, $p_template->gallery_type);
			$this->update_gallery_image_props($this->id_gallery, $res);
		}
// 		return $this->DB->getone("SELECT max(id_gallery) FROM s3n_gallery");
	}

	public function image_add($name, $description, $url, $priority, $visible) {
// 		echo "id_g: $id_gallery - name: $name - description: $description";
		if (!$name) return false;
		$seo_name = self::url_friendly($name);

		$i = 0;
		while (true) {
			$i++;
			if (!self::gallery_images_check_uniq_seo_name($seo_name)) {
				$seo_name = self::url_friendly($name) . "-" . $i;
			} else {
				break;
			}
		}
		// vytvoreni kategorie
		$r = $this->DB->query("
			insert into s3n_gallery_images (name,seo_name,description,url,priority,visible)
			values (?,?,?,?,?,?);
		", array(
			$name,
			$seo_name,
			$description,
			$url,
			(int) $priority,
			$visible ? "1" : "0",
		));

		$this->check($r);
		$id_image = $this->DB->getone("SELECT max(id_image) FROM s3n_gallery_images");

		$this->add_image_map_to_gallery($this->id_gallery, $id_image);


		// zjištění šablony galerie
		$sql_t = "SELECT id_gallery_template FROM s3n_gallery INNER JOIN s3n_gallery_image_map_gallery ";
		$sql_t.="ON s3n_gallery.id_gallery=s3n_gallery_image_map_gallery.id_gallery WHERE id_image=?;";
		$res_id = $this->DB->getOne($sql_t, array($id_image));
		$p_template = $this->DB->getRow("SELECT * FROM s3n_gallery_templates WHERE id_template = ?", array($res_id));

// 		if ( $file_name = $this->upload_file($seo_name."_".$id_image, "image")) {
//		send_email('info@3nicom.cz', 'info@3nicom.cz', $file, $this->upload_file($seo_name, self::GALLERY_IMAGES_PATH, "Filedata"));
		if ($file_name = $this->upload_file($seo_name, self::GALLERY_IMAGES_PATH, "Filedata")) {

			$this->update_image_props($id_image, "original", PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGES_PATH . $file_name);
// 			copy(PROJECT_DIR. self::GALLERY_PATH. self::GALLERY_IMAGES_PATH.$file_name, PROJECT_DIR. self::GALLERY_PATH. self::GALLERY_IMAGES_PATH."O-".$file_name);
			$res = $this->DB->query("
				update s3n_gallery_images set thumbnail_image = ?,  preview_image = ?,  detail_image = ?, original_image = ?, image_path = ? where id_image = ?;
			", array(
				"T-" . $file_name,
				"P-" . $file_name,
				"D-" . $file_name,
				$file_name,
				self::GALLERY_PATH . self::GALLERY_IMAGES_PATH,
				(int) $id_image
			));
			$this->check($res);
			$this->DB->commit();

// 			print_p($this);
// 			echo ($file_name);

			$res_file = $this->resize_image(self::GALLERY_IMAGES_PATH . $file_name, self::GALLERY_IMAGES_PATH . "T-" . $file_name, $p_template->thumbnail_width, $p_template->thumbnail_height, $p_template->thumbnail_type);
			if ($this->thumbnail_watermark_image) $this->water_image($res_file, $this->thumbnail_watermark_image, $this->thumbnail_width / 2);
			$this->update_image_props($id_image, "thumbnail", $res_file);
			$res_file = $this->resize_image(self::GALLERY_IMAGES_PATH . $file_name, self::GALLERY_IMAGES_PATH . "P-" . $file_name, $p_template->preview_width, $p_template->preview_height, $p_template->preview_type);
			$this->update_image_props($id_image, "preview", $res_file);
			if ($this->preview_watermark_image) $this->water_image($res_file, $this->preview_watermark_image, $this->preview_width / 2);
			$res_file = $this->resize_image(self::GALLERY_IMAGES_PATH . $file_name, self::GALLERY_IMAGES_PATH . "D-" . $file_name, $p_template->detail_width, $p_template->detail_height, $p_template->detail_type);
			$this->update_image_props($id_image, "detail", $res_file);
			if ($this->detail_watermark_image) $this->water_image($res_file, $this->detail_watermark_image, $this->detail_width / 2);
		}
	}

	public function file_add($name, $description, $url, $priority, $visible) {
		if (!$name) throw new Exception('Nen9 zadán název souboru', $code, $previous);
		$seo_name = self::url_friendly($name);

		$i = 0;
		while (true) {
			$i++;
			if (!self::gallery_images_check_uniq_seo_name($seo_name)) {
				$seo_name = self::url_friendly($name) . "-" . $i;
			} else {
				break;
			}
		}
		$r = dbI::query("INSERT INTO s3n_gallery_images (name,seo_name,description,url,priority,visible) VALUES (%s,%s,%s,%s,%i,%s);", $name, $seo_name, $description, $url, (int) $priority, $visible ? "1" : "0");

		$id_image = dbI::query("SELECT max(id_image) FROM s3n_gallery_images")->fetchSingle();
		$this->add_image_map_to_gallery($this->id_gallery, $id_image);

		if ($file_name = self::upload_file($seo_name, self::GALLERY_FILES_PATH, "file")) {
			self::update_file_props($id_image, PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_FILES_PATH, $file_name);
		}
	}

	public function file_edit($id_image, $name, $description, $url, $priority, $visible) {
		if (!$name) return false;
		$seo_name = self::url_friendly($name);

		$seo_name = dbGalleryImage::getUniqSeoName($name, $id_image);

		$r = dbI::query("update s3n_gallery_images set name = %s, seo_name = %s, description = %s, url = %s, priority = %i, visible = %s where id_image = %i ", $name, $seo_name, $description, $url, $priority, $visible ? "1" : "0", $id_image)->result();
//		echo dbI::getLastSQL(); die();
// 		$this->add_image_map_to_gallery($this->id_gallery, $id_image);
		if ($file_name = self::upload_file($seo_name, self::GALLERY_FILES_PATH, "file")) {
			self::update_file_props($id_image, PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_FILES_PATH, $file_name);
		}
	}

	public function video_edit($id_image, $name, $description, $url, $priority, $visible) {
		if (!$name) return false;
		$seo_name = self::url_friendly($name);

		$seo_name = dbGalleryImage::getUniqSeoName($name, $id_image);

		$r = dbI::query("update s3n_gallery_images set name = %s, seo_name = %s, description = %s, url = %s, priority = %i, visible = %s where id_image = %i ", $name, $seo_name, $description, $url, $priority, $visible ? "1" : "0", $id_image)->result();
//		echo dbI::getLastSQL(); die();
// 		$this->add_image_map_to_gallery($this->id_gallery, $id_image);
		if ($fileName = self::upload_video($seo_name, self::GALLERY_VIDEOS_PATH, "video")) {
			dbGalleryImage::updateVideoprops($id_image, self::GALLERY_PATH . self::GALLERY_VIDEOS_PATH . $fileName);
			dbGallery::resizeVideo($id_image);
		}
	}

	private function update_gallery_image_props($id_gallery, $image_file) {
// 		echo $image_file;
		$props = getimagesize($image_file);
		$this->check($this->DB->query("
			update s3n_gallery set
				gallery_image_width = '" . $props["0"] . "',
				gallery_image_height = '" . $props["1"] . "',
				gallery_image_size = '" . filesize($image_file) . "',
				gallery_image_type = '" . $props["mime"] . "'
				where id_gallery = $id_gallery"));
// 		echo $this->DB->last_query."<br/>";
	}

	private static function update_image_props($id_image, $image_spec, $image_file) {
		$props = getimagesize($image_file);
		return dbI::query("
			update s3n_gallery_images set
				{$image_spec}_width = '" . $props["0"] . "',
				{$image_spec}_height = '" . $props["1"] . "',
				{$image_spec}_size = '" . filesize($image_file) . "',
				{$image_spec}_type = '" . $props["mime"] . "'
				where id_image = $id_image")->result();
	}

	private static function update_file_props($id_image, $file_path, $file_name) {
		require_once 'MIME/Type.php';
		$info = pathinfo($file_name);
		$extension = $info["extension"];
// 		$mime_type = MIME_Type::autoDetect($file_path.$file_name);
//		print_p($file_path.$file_name); die();
		return $res = dbI::query("
			update s3n_gallery_images set
				original_image = '" . $file_name . "',
				original_size = '" . filesize($file_path . $file_name) . "',
				original_type = '" . $mime_type . "',
				image_path = '" . self::GALLERY_PATH . self::GALLERY_FILES_PATH . "',
				extension = '" . $extension . "'
				where id_image = $id_image")->result();
	}

	public static function image_edit($id_image, $name, $description, $url, $priority, $visible, $author = null) {
		if (!$name OR ! $id_image) return false;
		$seo_name = self::url_friendly($name);

		$i = 0;
		while (true) {
			$i++;
			if (!self::gallery_images_check_uniq_seo_name($seo_name)) {
				$seo_name = self::url_friendly($name) . "-" . $i;
			} else {
				break;
			}
		}

		$r = dbI::query("UPDATE s3n_gallery_images set name = %s, seo_name = %s, description = %s, url = %s, priority = %i, visible = %s, author = %s WHERE id_image = %i", $name, $seo_name, $description, $url, $priority, $visible ? "1" : "0", $author, $id_image)->result();
//		print_p(dibi::$sql);


		if ($_FILES['image']) {

			$file_name = self::upload_file($seo_name, self::GALLERY_IMAGES_PATH, "image");
			if (!$file_name) return false;
			self::update_image_props($id_image, "original", PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGES_PATH . $file_name);

			$p_image = dibi::fetch("SELECT * FROM s3n_gallery_images WHERE id_image = " . $id_image);
			self::file_delete(PROJECT_DIR . $p_image->image_path . $p_image->thumbnail_image);
			self::file_delete(PROJECT_DIR . $p_image->image_path . $p_image->preview_image);
			self::file_delete(PROJECT_DIR . $p_image->image_path . $p_image->detail_image);
			self::file_delete(PROJECT_DIR . $p_image->image_path . $p_image->original_image);

// 			copy(PROJECT_DIR. self::GALLERY_PATH. self::GALLERY_IMAGES_PATH.$file_name, PROJECT_DIR. self::GALLERY_PATH. self::GALLERY_IMAGES_PATH."O-".$file_name);
			$res = dibi::query("
				update s3n_gallery_images set thumbnail_image = %s,  preview_image = %s,  detail_image = %s, original_image = %s, image_path = %s where id_image = %i;
			", "T-" . $file_name, "P-" . $file_name, "D-" . $file_name, $file_name, self::GALLERY_PATH . self::GALLERY_IMAGES_PATH, (int) $id_image
			);


			$sql_t = "SELECT id_gallery_template FROM s3n_gallery INNER JOIN s3n_gallery_image_map_gallery ";
			$sql_t.="ON s3n_gallery.id_gallery=s3n_gallery_image_map_gallery.id_gallery WHERE id_image=%i;";
			$res_id = dibi::fetchSingle($sql_t, $id_image);
			$p_template = dibi::fetch("SELECT * FROM s3n_gallery_templates WHERE id_template = %i", $res_id);


			$res_file = self::resize_image(self::GALLERY_IMAGES_PATH . $file_name, self::GALLERY_IMAGES_PATH . "T-" . $file_name, $p_template->thumbnail_width, $p_template->thumbnail_height, $p_template->thumbnail_type);
			self::update_image_props($id_image, "thumbnail", $res_file);
			if (self::$thumbnail_watermark_image) self::water_image($res_file, self::$thumbnail_watermark_image, self::$thumbnail_width / 2);


			$res_file = self::resize_image(self::GALLERY_IMAGES_PATH . $file_name, self::GALLERY_IMAGES_PATH . "P-" . $file_name, $p_template->preview_width, $p_template->preview_height, $p_template->preview_type);
			self::update_image_props($id_image, "preview", $res_file);
			if (self::$preview_watermark_image) self::water_image($res_file, self::$preview_watermark_image, self::$preview_width / 2);


			$res_file = self::resize_image(self::GALLERY_IMAGES_PATH . $file_name, self::GALLERY_IMAGES_PATH . "D-" . $file_name, $p_template->detail_width, $p_template->detail_height, $p_template->detail_type);
			self::update_image_props($id_image, "detail", $res_file);
			if (self::$detail_watermark_image) self::water_image($res_file, self::$detail_watermark_image, self::$detail_width / 2);
		}
		return true;
	}

	public function rescan_gallery($id_gallery) {
		$p_detail = $this->get_gallery_detail($id_gallery);
// 		print_p($p_detail);
		$p_template = $this->DB->getRow("SELECT * FROM s3n_gallery_templates WHERE id_template = " . $p_detail->id_gallery_template);
// 		print_p($p_template);
// 		return false;
		$cnt = 0;
		foreach ($p_detail->IMAGES as $p_image) {
			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . self::GALLERY_PATH . self::GALLERY_IMAGES_PATH . $p_image->original_image)) {
				/* 				$res = $this->DB->query("
				  update s3n_gallery_images set thumbnail_image = ?,  preview_image = ?,  detail_image = ?, image_path = ? where id_image = ?;
				  ", array(
				  "", // "T-".$p_image->original_image,
				  "", // "P-".$p_image->original_image,
				  "", // "D-".$p_image->original_image,
				  "", // self::GALLERY_PATH.self::GALLERY_IMAGES_PATH,
				  (int)$p_image->id_image
				  ));
				  $this->check($res);
				  $this->DB->commit(); */
			}
			$this->file_delete(PROJECT_DIR . $p_image->image_path . $p_image->thumbnail_image);
			$this->file_delete(PROJECT_DIR . $p_image->image_path . $p_image->preview_image);
			$this->file_delete(PROJECT_DIR . $p_image->image_path . $p_image->detail_image);

			if ($cnt == 0) {
				$res_file = $this->resize_image(self::GALLERY_IMAGE_PATH . $p_detail->gallery_original_image, self::GALLERY_IMAGE_PATH . $p_detail->gallery_image, $p_template->gallery_width, $p_template->gallery_height, $p_template->gallery_type);
				$this->update_gallery_image_props($id_gallery, $res_file);
			}
// 			$this->resize_image(self::GALLERY_IMAGE_PATH.$file_name,self::GALLERY_IMAGE_PATH.$file_name,$p_template->gallery_width,$p_template->gallery_height,$p_template->gallery_type);
			$cnt++; //prvni obrazek pouzijeme jako obrazek galerie
// 			echo PROJECT_DIR.$p_image->image_path.$p_image->detail_image.'<br>';
			$res_file = $this->resize_image(self::GALLERY_IMAGES_PATH . $p_image->original_image, self::GALLERY_IMAGES_PATH . "T-" . $p_image->original_image, $p_template->thumbnail_width, $p_template->thumbnail_height, $p_template->thumbnail_type);
			$this->update_image_props($p_image->id_image, "thumbnail", $res_file);
			if ($this->thumbnail_watermark_image) $this->water_image($res_file, $this->thumbnail_watermark_image, $this->thumbnail_width / 2);

			$res_file = $this->resize_image(self::GALLERY_IMAGES_PATH . $p_image->original_image, self::GALLERY_IMAGES_PATH . "P-" . $p_image->original_image, $p_template->preview_width, $p_template->preview_height, $p_template->preview_type);
			$this->update_image_props($p_image->id_image, "preview", $res_file);
			if ($this->preview_watermark_image) $this->water_image($res_file, $this->preview_watermark_image, $this->preview_width / 2);

			$res_file = $this->resize_image(self::GALLERY_IMAGES_PATH . $p_image->original_image, self::GALLERY_IMAGES_PATH . "D-" . $p_image->original_image, $p_template->detail_width, $p_template->detail_height, $p_template->detail_type);
			$this->update_image_props($p_image->id_image, "detail", $res_file);
			if ($this->detail_watermark_image) $this->water_image($res_file, $this->detail_watermark_image, $this->detail_width / 2);
		}
	}

	public function rescan_galleries($id_gallery_type = 1) {
		$p_galleries = $this->get_galleries($limit = null, $id_gallery_type);
		foreach ($p_galleries AS $p_gallery) {
			echo $p_gallery->id_gallery . " ";
			$this->rescan_gallery($p_gallery->id_gallery);
		}
// 		print_p($p_galleries);
	}

	public static function add_image_map_to_gallery($id_gallery, $id_image) {
		return dbI::query("INSERT INTO s3n_gallery_image_map_gallery (id_gallery, id_image) values (%i,%i)", $id_gallery, $id_image)->result();
	}

	public function get_file_types_by_extension($extension = null) {
		$sql = "SELECT ft.extensions, ft.* FROM s3n_file_types AS ft ";
		if ($mime_type) $sql .= " WHERE ft.extension = '$extension'";
		$res = $this->DB->GetAssoc($sql);
		$this->check($res);
		return $res;
	}

	public function get_gallery_images($only_visible = true) {
		$sql = "SELECT * FROM s3n_gallery_images AS i, s3n_gallery_image_map_gallery AS gim WHERE gim.id_image = i.id_image AND gim.id_gallery = " . $this->id_gallery;
// 		if ($only_visible) $sql .= " AND i.visible = '1'";
		$sql .= " order by priority, name";
		$res = $this->DB->getall($sql);
		$this->check($res);

		$p_extensions = $this->get_file_types_by_extension();


		foreach ($res AS $key => $image) {
			$res[$key]->ICON_URL = $p_extensions[strtolower($image->extension)]->icon_url;
			$res[$key]->ICON_BIG_URL = $p_extensions[strtolower($image->extension)]->big_icon_url;
		}
// 		print_p($res);
		return $res;
	}

	public function get_image_detail($id_image) {
		$res = $this->DB->getrow("SELECT * from s3n_gallery_images WHERE id_image = $id_image");
		$this->check($res);
		return $res;
	}

	private static function upload_file($name, $path, $field_name = "image") {
		require_once "HTTP/Upload.php";
		$upload = new HTTP_Upload("en");
		$file = $upload->getFiles($field_name);
		if ($file->isValid()) {
			$file->setName($name . "." . $file->getProp("ext"));
			$moved = $file->moveTo(PROJECT_DIR . self::GALLERY_PATH . $path);
			if (!PEAR::isError($moved)) {
// 					echo 'File was moved to uploads' . $file->getProp('name');
				return $file->getProp('name');
			} else {
				return $moved->getMessage();
			}
		} elseif ($file->isMissing()) {
			return "No file was provided.";
		} elseif ($file->isError()) {
			return $file->errorMsg();
		}
		return $file->getProp('name');
	}

	private static function upload_video($name, $path, $field_name = "image") {
		require_once "HTTP/Upload.php";
		$upload = new HTTP_Upload("en");
		$file = $upload->getFiles($field_name);
		if ($file->isValid()) {
			$file->setName($name . "." . $file->getProp("ext"));
			$moved = $file->moveTo(PROJECT_DIR . self::GALLERY_PATH . $path);
			if (!PEAR::isError($moved)) {
// 					echo 'File was moved to uploads' . $file->getProp('name');
				return $file->getProp('name');
			} else {
				return $moved->getMessage();
			}
		} elseif ($file->isMissing()) {
			return "No file was provided.";
		} elseif ($file->isError()) {
			return $file->errorMsg();
		}
		return $file->getProp('name');
	}

	private static function resize_image($src, $dst, $width, $height, $resize_type) {
// 		echo $src."<br/>";
		require_once 'Image/Transform.php';
		//create transform driver object
		$it = Image_Transform::factory('GD');
		if (PEAR::isError($it)) {
			die($it->getMessage());
		}

		$ret = $it->load(PROJECT_DIR . self::GALLERY_PATH . $src);
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

		$ret = $it->save(PROJECT_DIR . self::GALLERY_PATH . $dst);
		if (PEAR::isError($ret)) {
			die($ret->getMessage());
		}
// 		$result["typex"] = $ret->getImageType();

		return(PROJECT_DIR . self::GALLERY_PATH . $dst);
	}

	public function get_galleries($limit = null, $id_gallery_type = null) {
		$sql = "SELECT g.*, gt.name AS template_name, gt.template_tpl , gtype.name as type_name FROM s3n_gallery as g ";
		$sql .= " left join s3n_gallery_templates AS gt on g.id_gallery_template = gt.id_template";
		$sql .= " left join s3n_gallery_type AS gtype on g.id_gallery_type = gtype.id_gallery_type";
		$sql .= " WHERE 1 ";
// 		if ($this->id_gallery) $sql .= " AND g.id_gallery = ". $this->id_gallery;
		if ($this->gallery_type) $sql .= " AND g.id_gallery_type = " . $this->get_gallery_type_id($this->gallery_type);
		if ($id_gallery_type) $sql .= " AND g.id_gallery_type = " . $id_gallery_type;
		if ($this->id_category) $sql .= " AND g.id_category = " . $this->id_category;
		$sql .= " order by id_gallery desc";
		if ($limit) $sql .= " limit 0, $limit";
		$res = $this->DB->getall($sql);
		$this->check($res);

		return $res;
	}

	public function get_gallery_id_by_seo_name($seo_name) {
		if (!$seo_name) return false;
		$sql = "SELECT id_gallery FROM s3n_gallery WHERE seo_name = '" . $seo_name . "'";
		$res = $this->DB->GetOne($sql);
		$this->check($res);
		return $res;
	}

	public function get_gallery_detail($id_gallery = null) {
		if ($id_gallery) $this->id_gallery = $id_gallery;
		if (!$this->id_gallery AND ! $id_gallery) return false;
		$sql = "SELECT * FROM s3n_gallery WHERE id_gallery = " . $this->id_gallery;
		$res = $this->DB->GetRow($sql);
		$this->check($res);

		$res->gallery_original_image = "O-" . $res->gallery_image;
// 		$res->gallery_image_path= self::GALLERY_IMAGE_PATH;
// 		$res->gallery_images_path= self::GALLERY_IMAGES_PATH;

		$this->thumbnail_width = $res->thumbnail_width;
		$this->thumbnail_height = $res->thumbnail_height;
		$this->thumbnail_resize_type = $res->thumbnail_resize_type;
		$this->preview_width = $res->preview_width;
		$this->preview_height = $res->preview_height;
		$this->preview_resize_type = $res->preview_resize_type;
		$this->detail_width = $res->detail_width;
		$this->detail_height = $res->detail_height;
		$this->detail_resize_type = $res->detail_resize_type;

		$res->GALLERY_PATH = self::GALLERY_PATH;
		$res->GALLERY_IMAGES_PATH = self::GALLERY_IMAGES_PATH;
		$res->GALLERY_FILES_PATH = self::GALLERY_FILES_PATH;
		$res->GALLERY_ICONS_PATH = self::GALLERY_ICONS_PATH;

		$res->IMAGES = $this->get_gallery_images();
// 		print_p($res);

		return $res;
	}

	public function gallery_delete() {

		$p_images = $this->get_gallery_images();
// 		print_p($p_images);
// 		return false;
		foreach ($p_images AS $image) {
			$this->file_delete(PROJECT_DIR . $image->image_path . $image->thumbnail_image);
			$this->file_delete(PROJECT_DIR . $image->image_path . $image->preview_image);
			$this->file_delete(PROJECT_DIR . $image->image_path . $image->detail_image);
			$this->file_delete(PROJECT_DIR . $image->image_path . $image->original_image);
		}
		$this->gallery_image_delete();
		$res = $this->DB->query("DELETE FROM s3n_gallery WHERE id_gallery = " . $this->id_gallery);
		$this->check($res);
		$this->DB->commit();
	}

	public function gallery_image_delete() {
		$p_gallery = $this->DB->getrow("SELECT * FROM s3n_gallery WHERE id_gallery = " . $this->id_gallery);
		$this->check($p_gallery);
// 		print_p($p_gallery);
		$this->file_delete(PROJECT_DIR . $p_gallery->gallery_path . $p_gallery->gallery_image);
		$this->file_delete(PROJECT_DIR . $p_gallery->gallery_path . "O-" . $p_gallery->gallery_image);

		$res = $this->DB->query("
			update s3n_gallery set gallery_image = ? where id_gallery = ?;
		", array(
			"",
			$this->id_gallery
		));
		$this->check($res);
		$this->DB->commit();
	}

	public static function image_delete($id_image) {
		$p_image = dibi::fetch("SELECT * FROM s3n_gallery_images WHERE id_image = " . $id_image);
		self::file_delete(PROJECT_DIR . $p_image->image_path . $p_image->thumbnail_image);
		self::file_delete(PROJECT_DIR . $p_image->image_path . $p_image->preview_image);
		self::file_delete(PROJECT_DIR . $p_image->image_path . $p_image->detail_image);
		self::file_delete(PROJECT_DIR . $p_image->image_path . $p_image->original_image);

		$res = dibi::query("DELETE FROM s3n_gallery_images where id_image = $id_image");
		return true;
	}

	public function soubor_delete($id_file) {
		$p_image = $this->DB->getrow("SELECT * FROM s3n_gallery_images WHERE id_image = " . $id_file);
		$this->check($p_image);
		// 		print_p($p_gallery);
		$this->file_delete(PROJECT_DIR . $p_image->image_path . $p_image->original_image);

		$res = $this->DB->query("DELETE FROM s3n_gallery_images where id_image = $id_file");
		$this->check($res);
	}

	private static function file_delete($file_name) {
		if (@unlink($file_name)) {
			return true;
		} else {
//			self::spawn_error("Nepodařilo se smazat soubor $file_name", ERROR::WARNING);
			return false;
		}
	}

	private static function water_image($image, $water_image, $water_width) {
		require_once 'Image/Tools.php';
		$water_image = PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_WATER_IMAGES_PATH . $water_image;
		$mark = Image_Tools::factory('watermark');
		if (PEAR::isError($mark)) {
			echo $mark->toString();
			exit;
		}
		$original = $mark->set('image', $image);
		$mark->set('mark', $water_image);

		$mark->set('width', $water_width);
// 			$mark->set('height',150);
		$mark->set('marginx', 10);
		$mark->set('marginy', 10);
		$mark->set('horipos', 0);
		$mark->set('vertpos', -1);

// 			echo ($mark->getImageSize());
// 			$mark->set('blend', 'overlay');
// 			$err = $mark->display(IMAGETYPE_JPEG);
		$mark->set('blend', 'interpolation');
// 			$err = $mark->render();
// 			$err = $mark->save($image,IMAGETYPE_JPEG);
		$err = $mark->save($image);

		if (PEAR::isError($err)) {
			echo $err->toString();
			exit;
		}
	}

	public function get_gallery_categories($only_used = false) {
		$sql = "select gc.id_category, gc.* from s3n_gallery_category as gc ";
		if ($only_used) $sql .= " inner join s3n_gallery as g on g.id_category = gc.id_category ";
		if ($this->gallery_type) $sql .= " inner join s3n_gallery as g1 on g1.id_gallery_type = " . $this->get_gallery_type_id($this->gallery_type);
		$sql .= " order by id_category";
		$res = $this->DB->getAssoc($sql);
		$this->check($res);
		return $res;
	}

	public function get_seo_names() {
		$res = $this->DB->getcol("select g.seo_name from s3n_gallery as g");
		$this->check($res);
		return $res;
	}

	public function get_id_category_by_seo_name($seo_name) {
		if (!$seo_name) return false;
		$sql = "SELECT id_category FROM s3n_gallery_category WHERE seo_name = '" . $seo_name . "'";
		$res = $this->DB->GetOne($sql);
		$this->check($res);
		return $res;
	}

	public function search_gallery($keyword, $id_category = null, $p_fields, $only_visible = true) {
		if (!$keyword) return false;
		$sql = "SELECT g.id_gallery, g.title,g.name,g.seo_name,g.description, gi.original_image,gi.name as image_name,gi.description
						FROM s3n_gallery as g
						INNER JOIN s3n_gallery_image_map_gallery as gimg ON gimg.id_gallery=g.id_gallery
						INNER JOIN s3n_gallery_images as gi ON gi.id_image=gimg.id_image
						WHERE (g.title LIKE '%$keyword%' OR g.name LIKE '%$keyword%' OR g.description LIKE '%$keyword%' OR gi.original_image LIKE '%$keyword%' OR gi.name LIKE '%$keyword%' OR gi.description LIKE '%$keyword%')
						AND g.visible=1 AND gi.visible=1
						GROUP BY g.id_gallery;";
		$res = $this->DB->getall($sql);
		$this->check($res);
// 		echo $this->DB->last_query;
		return $res;
	}

}

?>