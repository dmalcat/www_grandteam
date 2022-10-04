<?php

/**
 * Image
 * @author Error
 */
class dbGalleryImage extends dbImage {

    public $id;
    public $name;
    public $description;
    public $thumbnail_image;
    public $thumbnail_width;
    public $thumbnail_height;
    public $thumbnail_type;
    public $thumbnail_size;
    public $preview_image;
    public $preview_width;
    public $preview_height;
    public $preview_type;
    public $preview_size;
    public $detail_image;
    public $detail_width;
    public $detail_height;
    public $detail_type;
    public $detail_size;
    public $original_image;
    public $original_width;
    public $original_height;
    public $original_type;
    public $original_size;
    public $visible;
    public $author;
    public $seo_name;
    public $image_path;
    public $priority;
    public $url;
    public $target;
    public $extension;
    public $pImage;
    public $tImage;
    public $dImage;
    public $oImage;
    public $dVideo;
    public $fileInfo;
    private static $cache;

    /**
     * For compatibility reasons
     * @param array $array
     */
    public function __construct(Array $array) {
        foreach ($array as $key => $var) {
            $this->$key = $var;
        }
        $this->id = $this->id_image;
        $this->gallery = dbGallery::getById($this->id_gallery);
        if ($this->gallery->id_gallery_type == dbGallery::TYPE_VIDEO) {
            $this->oImage = $this->image_path . $this->original_image;
            $this->file = $this->image_path . $this->original_image;
            $this->pImage = $this->image_path . $this->id . "/detail/" . $this->preview_image;
            $this->tImage = $this->image_path . $this->thumbnail_image;
            $this->dImage = $this->image_path . $this->id . "/detail/" . $this->detail_image;
            $this->dVideo = $this->image_path . $this->id . "/detail/" . $this->detail_image;
        } elseif ($this->gallery->id_gallery_type == dbGallery::TYPE_FOTO) {
            $this->oImage = $this->image_path . $this->original_image;
            $this->file = $this->image_path . $this->original_image;
            $this->pImage = $this->image_path . $this->preview_image;
            $this->tImage = $this->image_path . $this->thumbnail_image;
            $this->dImage = $this->image_path . $this->detail_image;
        } else {
            $this->oImage = $this->image_path . $this->original_image;
            $this->file = $this->image_path . $this->original_image;
        }


        $fileInfo = pathinfo($this->original_image);
        $this->extension = $fileInfo['extension'];
        $this->fileInfo = dbI::cachedQuery("SELECT * FROM s3n_file_types WHERE extensions = %s", $this->extension)->cache(self::$cache['fileInfo'][$this->extension])->fetch();

        $this->target = strpos($this->url, "ttp:") ? "_blank" : "";
    }

    /**
     * Vraci dbGalleryImage podle id_image
     * @param int $id
     * @throws dbException
     * @return dbGalleryImage|false
     */
    public static function getById($id) {
        return dbI::query("SELECT * FROM s3n_gallery_images WHERE id_image = %i", $id)->fetch('dbGalleryImage');
    }

    private static function checkUniqSeoName($seoName, $idGalleryImage = null) {
        if ($idGalleryImage) {
            return dbI::query("SELECT COUNT(*) FROM s3n_gallery_images WHERE seo_name = %s AND id_image <> %i", $seoName, $idGalleryImage)->fetchSingle();
        } else {
            return dbI::query("SELECT COUNT(*) FROM s3n_gallery_images WHERE seo_name = %s", $seoName)->fetchSingle();
        }
    }

    public static function getUniqSeoName($name, $idGalleryImage = null) {
        $seoName = urlFriendly($name);
        $i = 0;
        while (true) {
            $i++;
            if (self::CheckUniqSeoName($seoName, $idGalleryImage)) {
                $seoName = urlFriendly($name) . "-" . $i;
            } else {
                return $seoName;
            }
        }
    }

    public static function updateImageProps($idImage, $image_spec, $fileName) {
        $fileName = PROJECT_DIR . $fileName;
        $props = getimagesize($fileName);
        return dibi::query("
			update s3n_gallery_images set
				{$image_spec}_width = '" . $props["0"] . "',
				{$image_spec}_height = '" . $props["1"] . "',
				{$image_spec}_size = '" . filesize($fileName) . "',
				{$image_spec}_type = '" . $props["mime"] . "'
				where id_image = $idImage");
    }

    public static function updateFileprops($idImage, $fileName) {
        require_once 'MIME/Type.php';
        $fileName = PROJECT_DIR . $fileName;
        $info = pathinfo($fileName);
        $extension = $info["extension"];
// 		$mime_type = MIME_Type::autoDetect($file_path.$file_name);
        return dbI::query("
			UPDATE s3n_gallery_images SET
				original_image = '" . basename($fileName) . "',
				original_size = '" . filesize($fileName) . "',
				original_type = '" . $mime_type . "',
				image_path = '" . dbGallery::GALLERY_PATH . dbGallery::GALLERY_FILES_PATH . "',
				extension = '" . $extension . "'
				where id_image = %i", $idImage)->result();
    }

    public static function updateVideoprops($idImage, $fileName) {
        require_once 'MIME/Type.php';
        $fileName = PROJECT_DIR . $fileName;
        $info = pathinfo($fileName);
        $extension = $info["extension"];
// 		$mime_type = MIME_Type::autoDetect($file_path.$file_name);
        return dbI::query("
			UPDATE s3n_gallery_images SET
				original_image = '" . basename($fileName) . "',
				original_size = '" . filesize($fileName) . "',
				original_type = '" . $mime_type . "',
				image_path = '" . dbGallery::GALLERY_PATH . dbGallery::GALLERY_VIDEOS_PATH . "',
				extension = '" . $extension . "'
				where id_image = %i", $idImage)->result();
    }

    /**
     *
     * @return dbGallery
     */
    public function getGallery() {
        $idGallery = dbI::query("SELECT id_gallery FROM s3n_gallery_image_map_gallery WHERE id_image = %i", $this->id)->fetchSingle();
        return dbGallery::getById($idGallery);
    }

    public function getName() {
        return str_replace(".jpg", "", $this->name);
    }

}
