<?php

/**
 * Image
 * @author Error
 */
class dbImage extends dbFile {

	public $id;
	public $filename;
	public $url;
	public $id_type;
	public $size;
	public $thumbnail_url;
	public $preview_url;
	public $email_url;


	const IMG_JPEG_QUALITY = 80;
	const CREATE_FILE_MODE = 0644;

	/**
	 * For compatibility reasons
	 * @param array $array
	 */
	public function __construct(Array $array) {
		foreach ($array as $key => $var) {
			$this->$key = $var;
		}
		$this->id = $this->id_file;
	}

	public function resize($width, $height, $saveTo, $type = imageHelper::MAX_PARAMS) {
		$img = new imageHelper($this->url);
		$img->resize($type, array(
					imageHelper::MAX_WIDTH => $width,
					imageHelper::MAX_HEIGHT => $height,
					));
		$img->save($saveTo, array(
					imageHelper::QUALITY => self::IMG_JPEG_QUALITY,
					imageHelper::CHMOD => self::CREATE_FILE_MODE,
					));
		return true;
	}

	public function watermark($width, $height, $saveTo, $type = imageHelper::MAX_PARAMS) {
		$img = new imageHelper($this->url);
		$waterImage = new imageHelper(PROJECT_DIR.self::WATER_IMAGE);
		$img->addFrontLayer($waterImage);
		$img = new imageHelper($this->url);
		$img->save($this->url, array(
					imageHelper::QUALITY => self::IMG_JPEG_QUALITY,
					imageHelper::CHMOD => self::CREATE_FILE_MODE,
					));
		return true;
	}

//	/**
//	 * Vraci dbImage podle id_file
//	 * @param int $id
//	 * @throws dbException
//	 * @return dbImage|false
//	 */
//	public static function getById($id) {
//		return dbI::query("SELECT * FROM s3n_files WHERE id_file = %i", $id)->fetch('dbImage');
//	}

}