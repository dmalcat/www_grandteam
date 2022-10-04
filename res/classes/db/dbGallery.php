<?php

/**
 * Gallery
 * @author Error
 */
class dbGallery extends dbBase {

    public $id;
    public $title;
    public $name;
    public $seo_name;
    public $annotation;
    public $description;
    public $thumbnail_width;
    public $thumbnail_height;
    public $thumbnail_resize_type;
    public $preview_width;
    public $preview_height;
    public $preview_resize_type;
    public $detail_width;
    public $detail_height;
    public $detail_resize_type;
    public $id_gallery_type;
    public $visible;
    public $gallery_path;
    public $id_gallery_template;
    public $gallery_image;
    public $gallery_image_width;
    public $gallery_image_height;
    public $gallery_image_resize_type;
    public $id_category;
    public $position;
    public $itemsCount;
    public $galleryImage;

    const POSITION_TOP = 'top';
    const POSITION_MIDDLE = 'middle';
    const POSITION_BOTTOM = 'bottom';
    const DEFAULT_POSITION = self::POSITION_BOTTOM;
    const DEFAULT_PRIORITY = 100;
    const TYPE_FOTO = 1;
    const TYPE_FILES = 2;
    const TYPE_VIDEO = 3;
    const GALLERY_PATH = "/data/fotogalerie/";
    const GALLERY_XML_PATH = "/xml/";
    const GALLERY_IMAGE_PATH = "galleries/";
    const GALLERY_IMAGES_PATH = "images/";
    const GALLERY_WATER_IMAGES_PATH = "water_images/";
    const GALLERY_FILES_PATH = "files/";
    const GALLERY_VIDEOS_PATH = "videos/";
    const GALLERY_ICONS_PATH = "icons/";
    const VIDEO_PREVIEW_SIZEX = 120;
    const VIDEO_PREVIEW_SIZEY = 90;
    const VIDEO_PREVIEW_4_3_SIZEY = 90;
    const VIDEO_PREVIEW_1_1_SIZEY = 120;
    const VIDEO_PREVIEW_16_9_SIZEY = 90;
    const VIDEO_DETAIL_SIZEX = 720;
    const VIDEO_DETAIL_SIZEY = 450;
    const VIDEO_DETAIL_4_3_SIZEY = 450;
    const VIDEO_DETAIL_1_1_SIZEY = 600;
//     const VIDEO_DETAIL_16_9_SIZEY = 338;
    const VIDEO_DETAIL_16_9_SIZEY = 404;

    private static $cache;

    /**
     * For compatibility reasons
     * @param array $array
     */
    public function __construct(Array $array) {
        foreach ($array as $key => $var) {
            $this->$key = $var;
        }
        $this->id = $this->id_gallery;
        $this->seoname = $this->seo_name;
        $this->template = dbGalleryTemplate::getById($this->id_gallery_template);
        $this->itemsCount = dbI::cachedQuery("SELECT COUNT(id_map) FROM s3n_gallery_image_map_gallery WHERE id_gallery = %i", $this->id)->cache(self::$cache['itemsCount'][$this->id])->fetchSingle();
        if ($this->gallery_image) {
            $this->galleryImage = $this->gallery_path . $this->gallery_image;
        }
    }

    /**
     * Vraci dbGallery podle id_gallery
     * @param int $id
     * @throws dbException
     * @return dbGallery|false
     */
    public static function getById($id) {
        return dbI::cachedQuery("SELECT * FROM s3n_gallery WHERE id_gallery = %i", $id)->cache(self::$cache['getById'][$id])->fetch('dbGallery');
    }

    /**
     * Vraci vsechny dbGallery podle typu 1|2
     * @param int $idGalleryType
     * @throws dbException
     * @return array dbGallery|false
     */
    public static function getAll($idGalleryType = dbGallery::TYPE_FOTO, $onlyParents = true) {
        $res = dbI::query("SELECT * FROM s3n_gallery WHERE id_gallery_type = %i ORDER BY name", $idGalleryType)->fetchAssoc('dbGallery', 'id_gallery');
        return $res;
    }

//    public function getSubGalleries() {
//        return dbI::query("SELECT * FROM s3n_gallery WHERE id_parent = %i ORDER BY name", $this->id)->fetchAll("dbGallery");
//    }

    /**
     * Vrati vsechny obrazky v galerii
     * @throws dbException
     * @return array dbGalleryImage|false
     */
    public function getImages($onlyVisible = true, $limit = NULL) {
        if (!$limit) {
            $limit = 100;
        }
        if ($onlyVisible)
            $visibleCond = " AND gi.visible = '1' ";
// 		return dbI::query("SELECT * FROM s3n_gallery_images gi INNER JOIN  s3n_gallery_image_map_gallery gimg ON gimg.id_image = gi.id_image  WHERE gimg.id_gallery = %i $visibleCond ORDER BY gi.priority, gi.name", $this->id)->fetchAssoc('dbGalleryImage', 'id_image');
        return dbI::query("SELECT * FROM s3n_gallery_images gi INNER JOIN  s3n_gallery_image_map_gallery gimg ON gimg.id_image = gi.id_image  WHERE gimg.id_gallery = %i $visibleCond ORDER BY gi.priority, gi.description, gi.name LIMIT 0, %i", $this->id, $limit)->fetchAssoc('dbGalleryImage', 'id_image');
    }

    public function getFirstImage() {
        return dbI::query("SELECT * FROM s3n_gallery_images gi INNER JOIN  s3n_gallery_image_map_gallery gimg ON gimg.id_image = gi.id_image  WHERE gimg.id_gallery = %i $visibleCond ORDER BY gi.priority, gi.description, gi.name LIMIT 0,1", $this->id)->fetch('dbGalleryImage');
    }

    /**
     * Zmeni pozici pripojene galerie
     * @param string $position
     * @throws dbException
     * @return true|false
     */
    public function changeGalleryPosition($position) {
        return dbI::query("UPDATE s3n_content_category_map_gallery SET `position` = %s WHERE id_gallery = %i", $position, $this->id)->result();
    }

    private static function checkUniqSeoName($seoName, $idGallery = null) {
        if ($idGallery) {
            return dbI::query("SELECT COUNT(*) FROM s3n_gallery WHERE seo_name = %s AND id_gallery <> %i", $seoName, $idGallery)->fetchSingle();
        } else {
            return dbI::query("SELECT COUNT(*) FROM s3n_gallery WHERE seo_name = %s", $seoName)->fetchSingle();
        }
    }

    private static function getUniqSeoName($name, $idGallery = null) {
        $seoName = urlFriendly($name);
        $i = 0;
        while (true) {
            $i++;
            if (self::CheckUniqSeoName($seoName, $idGallery)) {
                $seoName = urlFriendly($name) . "-" . $i;
            } else {
                return $seoName;
            }
        }
    }

    /**
     * Zalozi fotogalerii
     * @throws dbException
     * @return idGAllery|false
     */
    public static function add($title, $name, $annotation, $description, $id_gallery_type, $visible, $id_gallery_template, $id_category = null, $datum = null, $visibleFrom = null, $visibleTo = null) { // TODO dodelat
        if (!$name)
            throw new Exception("Neni zadan nazev galerie");
        $seoName = self::getUniqSeoName($name . "-g");

        $pTemplate = dbI::query("SELECT * FROM s3n_gallery_templates WHERE id_template = %i", $id_gallery_template)->fetch();
        $r = dbI::query("INSERT INTO s3n_gallery (title,name, annotation, seo_name,description,thumbnail_width,thumbnail_height,thumbnail_resize_type,preview_width,preview_height,preview_resize_type,detail_width,detail_height,detail_resize_type,id_gallery_type,visible,gallery_path,id_gallery_template,gallery_image_width,gallery_image_height,gallery_image_resize_type, datum, visible_from, visible_to, id_category)
			VALUES ( %s, %s, %s, %s, %s, %i, %i, %s, %i, %i, %s, %i, %i, %s, %i, %s, %s, %i, %i, %i, %s, %t, %t, %t, %i);
		", $title, $name, $annotation, $seoName, $description, $pTemplate->thumbnail_width, $pTemplate->thumbnail_height, $pTemplate->thumbnail_type, $pTemplate->preview_width, $pTemplate->preview_height, $pTemplate->preview_type, $pTemplate->detail_width, $pTemplate->detail_height, $pTemplate->detail_type, $id_gallery_type, $visible ? "1" : "0", self::GALLERY_PATH . self::GALLERY_IMAGE_PATH, (int) $id_gallery_template,
// 			$gallery_image = self::GALLERY_PATH . self::GALLERY_IMAGE_PATH . "obrazek",
                        $pTemplate->gallery_width, $pTemplate->gallery_height, $pTemplate->gallery_type, $datum ? $datum : NULL, $visibleFrom ? $visibleFrom : NULL, $visibleTo ? $visibleTo : NULL, $id_category
                )->result();
        if ($r) {
            $idGallery = dbI::query("SELECT max(id_gallery) FROM s3n_gallery")->fetchSingle();
            $dbGallery = self::getById($idGallery);
        } else {
            throw new Exception('Nepodarilo se zalozit galerii', $code, $previous);
        }

        if ($_FILES["image"]["tmp_name"]) {
            $image = new imageHelper($_FILES["image"]["tmp_name"]);
            $image->save(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGE_PATH . "O-" . $_FILES["image"]["name"], array(
                imageHelper::QUALITY => dbImage::IMG_JPEG_QUALITY,
                imageHelper::CHMOD => dbImage::CREATE_FILE_MODE,
            ));
            $image->resize(imageHelper::MAX_WIDTH, array(
                imageHelper::MAX_WIDTH => $dbGallery->template->gallery_width,
                imageHelper::MAX_HEIGHT => $dbGallery->template->gallery_height,
            ));
            $image->save(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGE_PATH . "P-" . $_FILES["image"]["name"], array(
                imageHelper::QUALITY => dbImage::IMG_JPEG_QUALITY,
                imageHelper::CHMOD => dbImage::CREATE_FILE_MODE,
            ));
            dbI::query("UPDATE s3n_gallery SET gallery_image = %s WHERE id_gallery = %i;", "O-" . $_FILES["image"]["name"], $idGallery)->result();

            $props = getimagesize(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGE_PATH . "O-" . $_FILES["image"]["name"]);
            dbI::query("
				UPDATE s3n_gallery SET
				gallery_image_width = '" . $props["0"] . "',
				gallery_image_height = '" . $props["1"] . "'
				WHERE id_gallery = " . $dbGallery->id)->result();
        }
        return $dbGallery->id;
    }

    /**
     * Upravi fotogalerii
     * @throws dbException
     * @return true|false
     */
    public function edit($title, $name, $annotation, $description, $id_gallery_type, $visible, $id_gallery_template, $id_category = null, $datum = null, $visibleFrom = null, $visibleTo = null) { // TODO dodelat
        if (!$name)
            throw new Exception("Neni zadan nazev galerie");
        $seoName = self::getUniqSeoName($name . "-g");
        $pTemplate = dbI::query("SELECT * FROM s3n_gallery_templates WHERE id_template = %i", $id_gallery_template)->fetch();
        dbI::query("UPDATE s3n_gallery SET
			title = %s,
			`name` = %s,
			annotation = %s,
			seo_name = %s,
			description = %s,
			thumbnail_width = %i,
			thumbnail_height = %i,
			thumbnail_resize_type = %i,
			preview_width = %i,
			preview_height = %i,
			preview_resize_type = %i,
			detail_width = %i,
			detail_height = %i,
			detail_resize_type = %i,
			id_gallery_type = %i,
			visible = %s,
			gallery_path = %s,
			id_gallery_template = %i,
			gallery_image_width = %i,
			gallery_image_height = %i,
			gallery_image_resize_type = %i,
			id_category = %i,
			datum = %t,
			visible_from = %t,
			visible_to = %t
			WHERE id_gallery = %i", $title, $name, $annotation, $seoName, $description, $pTemplate->thumbnail_width, $pTemplate->thumbnail_height, $pTemplate->thumbnail_type, $pTemplate->preview_width, $pTemplate->preview_height, $pTemplate->preview_type, $pTemplate->detail_width, $pTemplate->detail_height, $pTemplate->detail_type, $id_gallery_type, $visible ? "1" : "0", self::GALLERY_PATH . self::GALLERY_IMAGE_PATH, $id_gallery_template,
// 			$gallery_image = self::GALLERY_PATH . self::GALLERY_IMAGE_PATH . "obrazek",
                $pTemplate->gallery_width, $pTemplate->gallery_height, $pTemplate->gallery_type, $id_category, $datum ? $datum : NULL, $visibleFrom ? $visibleFrom : NULL, $visibleTo ? $visibleTo : NULL, $this->id)->result();

        if ($_FILES["image"]["tmp_name"]) {
            $image = new imageHelper($_FILES["image"]["tmp_name"]);
            $image->resize(imageHelper::MAX_WIDTH, array(imageHelper::MAX_WIDTH => $pTemplate->gallery_width, imageHelper::MAX_HEIGHT => $pTemplate->gallery_height));
            $image->save(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGE_PATH . "O-" . $_FILES["image"]["name"], array(imageHelper::QUALITY => dbImage::IMG_JPEG_QUALITY, imageHelper::CHMOD => dbImage::CREATE_FILE_MODE));
            dbI::query("UPDATE s3n_gallery SET gallery_image = %s WHERE id_gallery = %i;", "O-" . $_FILES["image"]["name"], $this->id)->result();

            $props = getimagesize(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGE_PATH . "O-" . $_FILES["image"]["name"]);
            dbI::query("
				UPDATE s3n_gallery SET
				gallery_image_width = '" . $props["0"] . "',
				gallery_image_height = '" . $props["1"] . "'
				WHERE id_gallery = " . $this->id)->result();
        }
    }

    public static function delete($idGallery) {
        $dbGallery = self::getById($idGallery);
        if (is_file(PROJECT_DIR . $dbGallery->galleryImage))
            unlink(PROJECT_DIR . $dbGallery->galleryImage);
        foreach ((array) $dbGallery->getImages() AS $image) {
            if (is_file(PROJECT_DIR . $image->pImage))
                unlink(PROJECT_DIR . $image->pImage);
            if (is_file(PROJECT_DIR . $image->tImage))
                unlink(PROJECT_DIR . $image->tImage);
            if (is_file(PROJECT_DIR . $image->dImage))
                unlink(PROJECT_DIR . $image->dImage);
            if (is_file(PROJECT_DIR . $image->oImage))
                unlink(PROJECT_DIR . $image->oImage);
        }
        return dbI::query("DELETE FROM s3n_gallery WHERE id_gallery = %i", $idGallery)->result();
    }

    public static function searchFull($text) {
        return dbI::query("SELECT * FROM s3n_gallery WHERE name LIKE '%$text%' OR title LIKE '%$text%'")->fetchAll('dbGallery', 'id_gallerz');
    }

    /**
     * Srovna razeni tak aby slo po jednicce za sebou 1,2,3 ...
     * @throws dbException
     * @return true|false
     */
    public function sortImages() {
        $cnt = 1;
        foreach ($this->getImages() AS $dbGalleryImage) {
            dbI::query("UPDATE s3n_gallery_images SET priority = %i WHERE id_image = %i", $cnt, $dbGalleryImage->id)->result();
            $cnt++;
        }
        return true;
    }

    /**
     * Posune obrazek nahoru
     * @throws dbException
     * @return true|false
     */
    public function sortImageUp($idGalleryImage) {
        $this->sortImages();
        $dbGalleryImage = dbGalleryImage::getById($idGalleryImage);
        $upperImage = dbI::query("SELECT gi.* FROM s3n_gallery_images gi, s3n_gallery_image_map_gallery gimg WHERE gi.id_image = gimg.id_image AND gimg.id_gallery = %i AND  gi.priority < %i ", $this->id, $dbGalleryImage->priority)->fetch('dbGalleryImage');
        if ($upperImage) {
            dbI::query("UPDATE s3n_gallery_images SET priority = %i WHERE id_image = %i", $upperImage->priority, $dbGalleryImage->id)->result();
            dbI::query("UPDATE s3n_gallery_images SET priority = %i WHERE id_image = %i", $dbGalleryImage->priority, $upperImage->id_image)->result();
            return array("type" => "success", "swap" => array($dbGalleryImage->id_image, $upperImage->id_image));
        }
        return false;
    }

    /**
     * Posune obrazek dolu
     * @throws dbException
     * @return true|false
     */
    public function sortImageDown($idGalleryImage) {
        $this->sortImages();
        $dbGalleryImage = dbGalleryImage::getById($idGalleryImage);
        $lowerImage = dbI::query("SELECT gi.* FROM s3n_gallery_images gi, s3n_gallery_image_map_gallery gimg WHERE gi.id_image = gimg.id_image AND gimg.id_gallery = %i AND  gi.priority > %i ", $this->id, $dbGalleryImage->priority)->fetch('dbGalleryImage');
        if ($lowerImage) {
            dbI::query("UPDATE s3n_gallery_images SET priority = %i WHERE id_image = %i", $lowerImage->priority, $dbGalleryImage->id)->result();
            dbI::query("UPDATE s3n_gallery_images SET priority = %i WHERE id_image = %i", $dbGalleryImage->priority, $lowerImage->id_image)->result();
            return array("type" => "success", "swap" => array($dbGalleryImage->id, $lowerImage->id_image));
        }
        return false;
    }

    public function setVisibility($visibility) {
        return dbI::query("UPDATE s3n_gallery set visible = %s WHERE id_gallery = %i", $visibility == "true" ? 1 : 0, $this->id)->result();
    }

    public function videoAdd($name, $description, $url, $priority, $visible) {
        if (!$name)
            throw new Exception('Není zadán název souboru', $code, $previous);
        $seoName = dbGalleryImage::getUniqSeoName($name);
        $idImage = dbI::query("INSERT INTO s3n_gallery_images (name,seo_name,description,url,priority,visible) VALUES (%s,%s,%s,%s,%i,%s);", $name, $seoName, $description, $url, $priority, $visible ? "1" : "0")->insert();
//		$idImage = dbI::query("SELECT max(id_image) FROM s3n_gallery_images")->fetchSingle();
        $this->mapImage($idImage);

        $fileName = self::uploadFile($seoName, self::GALLERY_VIDEOS_PATH, "file");
        if ($fileName) {
            dbGalleryImage::updateVideoprops($idImage, self::GALLERY_PATH . self::GALLERY_VIDEOS_PATH . $fileName);
            self::resizeVideo($idImage);
            return true;
        }

        return false;
    }

    public function fileAdd($name, $description, $url, $priority, $visible) {
        if (!$name)
            throw new Exception('Není zadán název souboru', $code, $previous);
        $seoName = dbGalleryImage::getUniqSeoName($name);
        $r = dbI::query("INSERT INTO s3n_gallery_images (name,seo_name,description,url,priority,visible) VALUES (%s,%s,%s,%s,%i,%s);", $name, $seoName, $description, $url, $priority, $visible ? "1" : "0")->result();

        $idImage = dbI::query("SELECT max(id_image) FROM s3n_gallery_images")->fetchSingle();
        $this->mapImage($idImage);


        $fileName = self::uploadFile($seoName, self::GALLERY_FILES_PATH, "file");
        if ($fileName) {
            dbGalleryImage::updateFileProps($idImage, self::GALLERY_PATH . self::GALLERY_FILES_PATH . $fileName);
            return true;
        }
        return false;
    }

    public function imageAdd($name, $description, $url, $priority, $visible) {
        if (!$name)
            throw new Exception('Není zadán název souboru', $code, $previous);
        $seoName = dbGalleryImage::getUniqSeoName($name);

        dbI::query("INSERT INTO s3n_gallery_images (name,seo_name,description,url,priority,visible) VALUES (%s,%s,%s,%s,%i,%s)", $name, $seoName, $description, $url, $priority, $visible ? "1" : "0")->result();

        $idImage = dbI::query("SELECT max(id_image) FROM s3n_gallery_images")->fetchSingle();
        $this->mapImage($idImage);

        $fileName = self::uploadFile($seoName, self::GALLERY_IMAGES_PATH, "image");

        if ($fileName) {
            dbGalleryImage::updateFileProps($idImage, self::GALLERY_PATH . self::GALLERY_IMAGES_PATH . $fileName);
            $res = dbI::query("UPDATE s3n_gallery_images set thumbnail_image = %s,  preview_image = %s,  detail_image = %s, original_image = %s, image_path = %s where id_image = %i;", "T-" . $fileName, "P-" . $fileName, "D-" . $fileName, $fileName, self::GALLERY_PATH . self::GALLERY_IMAGES_PATH, $idImage)->result();

            $image = new imageHelper(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGES_PATH . $fileName);
            $image->resize(imageHelper::MAX_WIDTH, array(imageHelper::MAX_WIDTH => $this->template->detail_width, imageHelper::MAX_HEIGHT => $this->template->detail_height));
            $image->save(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGES_PATH . "D-" . $fileName, array(imageHelper::QUALITY => dbImage::IMG_JPEG_QUALITY, imageHelper::CHMOD => dbImage::CREATE_FILE_MODE));
            dbGalleryImage::updateImageProps($idImage, "detail", self::GALLERY_PATH . self::GALLERY_IMAGES_PATH . "D-" . $fileName);

            $image = new imageHelper(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGES_PATH . $fileName);
            $image->resize(imageHelper::MAX_WIDTH, array(imageHelper::MAX_WIDTH => $this->template->preview_width, imageHelper::MAX_HEIGHT => $this->template->preview_height));
            $image->save(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGES_PATH . "P-" . $fileName, array(imageHelper::QUALITY => dbImage::IMG_JPEG_QUALITY, imageHelper::CHMOD => dbImage::CREATE_FILE_MODE));
            dbGalleryImage::updateImageProps($idImage, "preview", self::GALLERY_PATH . self::GALLERY_IMAGES_PATH . "P-" . $fileName);

            $image = new imageHelper(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGES_PATH . $fileName);
            $image->resize(imageHelper::MAX_WIDTH, array(imageHelper::MAX_WIDTH => $this->template->thumbnail_width, imageHelper::MAX_HEIGHT => $this->template->thumbnail_height));
            $image->save(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_IMAGES_PATH . "T-" . $fileName, array(imageHelper::QUALITY => dbImage::IMG_JPEG_QUALITY, imageHelper::CHMOD => dbImage::CREATE_FILE_MODE));
            dbGalleryImage::updateImageProps($idImage, "thumbnail", self::GALLERY_PATH . self::GALLERY_IMAGES_PATH . "T-" . $fileName);

//			$res_file = $this->resize_image(self::GALLERY_IMAGES_PATH.$file_name,self::GALLERY_IMAGES_PATH."T-".$file_name, $p_template->thumbnail_width, $p_template->thumbnail_height, $p_template->thumbnail_type);
//			if ($this->thumbnail_watermark_image) $this->water_image($res_file, $this->thumbnail_watermark_image, $this->thumbnail_width / 2);
//			$res_file = $this->resize_image(self::GALLERY_IMAGES_PATH.$file_name,self::GALLERY_IMAGES_PATH."P-".$file_name, $p_template->preview_width, $p_template->preview_height, $p_template->preview_type);
//			$this->update_image_props($id_image, "preview", $res_file);
//			if ($this->preview_watermark_image) $this->water_image($res_file, $this->preview_watermark_image, $this->preview_width / 2);
//			$res_file = $this->resize_image(self::GALLERY_IMAGES_PATH.$file_name,self::GALLERY_IMAGES_PATH."D-".$file_name, $p_template->detail_width, $p_template->detail_height, $p_template->detail_type);
//			$this->update_image_props($id_image, "detail", $res_file);
//			if ($this->detail_watermark_image) $this->water_image($res_file, $this->detail_watermark_image, $this->detail_width / 2);
            return true;
        }
        return false;
    }

    private function mapImage($idGalleryImage) {
        return dbI::query("INSERT INTO s3n_gallery_image_map_gallery (id_gallery, id_image) values (%i,%i)", $this->id, $idGalleryImage)->result();
    }

    private static function uploadFile($name, $path, $field_name = "image") {
        require_once "HTTP/Upload.php";
        $upload = new HTTP_Upload("en");
        $file = $upload->getFiles($field_name);
// 			return false;
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

//    public function setParent($idParent) {
//        if (!$idParent)
//            $idParent = NULL;
//        return dbI::query("UPDATE s3n_gallery SET id_parent = %i WHERE id_gallery = %i", $idParent, $this->id)->result();
//    }

    public function getUrl() {
        switch ($this->id_gallery_type) {
            case 1:
                return "/foto/" . $this->seoname;
                break;
            case 2:
                return "/dokumenty/" . $this->seoname;
                break;
            case 3:
                return "/video/" . $this->seoname;
                break;

            default:
                break;
        }
    }

    public static function getBySeoName($seo) {
        return dbI::query("SELECT * FROM s3n_gallery WHERE seo_name = %s", $seo)->fetch("dbGallery");
    }

    public static function resizeVideo($idImage, $createStoryBoard = false) {
        $dbImage = dbGalleryImage::getById($idImage);
        $source = PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_VIDEOS_PATH . $dbImage->original_image;
        $sourceParts = pathinfo($source);

        Helper_FileSystem::checkDir(PROJECT_DIR . self::GALLERY_PATH);
        Helper_FileSystem::checkDir(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_VIDEOS_PATH);
        Helper_FileSystem::checkDir(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_VIDEOS_PATH . $dbImage->id);
        Helper_FileSystem::checkDir(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_VIDEOS_PATH . $dbImage->id . "/detail");
        Helper_FileSystem::checkDir(PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_VIDEOS_PATH . $dbImage->id . "/detail/thumbs");

        if (Registry::isProductionMode()) {
            define('FFMPEG_DATABASE', 'mysql://ffmpeg:mayqraxvxkiej387@mysql/ffmpeg_encode'); // connection string do DB
        } else {
            define('FFMPEG_DATABASE', 'mysql://root:error5037@localhost/ffmpeg_encode'); // connection string do DB
        }
        $DB_FFMPEG = & DB::connect(FFMPEG_DATABASE);
        if (PEAR::isError($DB_FFMPEG)) {
            throw new Exception($DB_FFMPEG->getMessage());
        }
        $DB_FFMPEG->setFetchMode(DB_FETCHMODE_ASSOC);
        $DB_FFMPEG->query("SET names 'utf8'");
        if (PEAR::isError($DB_FFMPEG)) {
            throw new Exception($DB_FFMPEG->getMessage());
        }


        $format = self::getMovieFormat($source);
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

        $destination = PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_VIDEOS_PATH . $dbImage->id . "/detail/" . $sourceParts["filename"] . ".mp4";
        $command = ' -i ' . $source . ' -vcodec libx264 ' . $destination;
        $res_ffmpeg = $DB_FFMPEG->query("INSERT INTO queue set ffmppar = '$command', state = 'new', id_content_category = '$idImage', host = '" . HOST . "'  ");
        if (PEAR::isError($res_ffmpeg)) {
            throw new Exception($res_ffmpeg->getMessage());
        }
        dbI::query("UPDATE s3n_gallery_images SET detail_image = %s WHERE id_image = %i", basename($destination), $idImage)->result();

        $destination = PROJECT_DIR . self::GALLERY_PATH . self::GALLERY_VIDEOS_PATH . $dbImage->id . "/detail/" . $sourceParts["filename"] . ".png";
        $command = " -i " . $source . "  -ss 00:00:06 -t 00:00:01 -f image2 -s " . $detailX . "x" . $detailY . " -vframes 1 " . $destination;
        $res_ffmpeg = $DB_FFMPEG->query("INSERT INTO queue set ffmppar = '$command', state = 'new', id_content_category = '$idImage' , host = '" . HOST . "' ");
        if (PEAR::isError($res_ffmpeg)) {
            throw new Exception($res_ffmpeg->getMessage());
        }
        dbI::query("UPDATE s3n_gallery_images SET preview_image = %s WHERE id_image = %i", basename($destination), $idImage)->result();

        if ($createStoryBoard) {
            $dir = PROJECT_DIR . self::VIDEOS_PATH . $id_content_category . "/" . $resize_prefix . "/story_board/";
            if (!file_exists($dir)) {
                if (!mkdir($dir)) {
                    $this->spawn_error("Nele vytvorit adresar pro upload videa 4 ($dir ) !", ERROR::CRIT);
                }
            }
            chmod($dir, self::CREATE_DIR_MODE);
            $command = (' -i ' . PROJECT_DIR . self::VIDEOS_PATH . $id_content_category . "/" . $source . ' -y -r 0.1 -ss 00:00:16 -f image2 -s ' . $width . 'x' . $height . ' ' . $dir . $destination . ".flv" . '%02d.png');
            $res_ffmpeg = $DB_FFMPEG->query("INSERT INTO queue set ffmppar = '$command', state = 'new', id_content_category = '$idImage' ,  host = '" . HOST . "' ");
            if (PEAR::isError($res_ffmpeg)) {
                throw new Exception($res_ffmpeg->getMessage());
            }
// 			$count = count(glob("" . $dir . "*.png"));
        }
        return($res);
    }

    private static function getMovieFormat($fileName) {
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

}
