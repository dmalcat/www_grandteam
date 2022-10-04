<?php

/**
 * dbGAlleryTemplate
 * @author Error
 */
class dbGalleryTemplate extends dbBase {

	public $id;
	public $name;
	public $template_tpl;
	public $id_gallery_type;
	public $thumbnail_width;
	public $thumbnail_height;
	public $thumbnail_type;
	public $preview_width;
	public $preview_height;
	public $preview_type;
	public $detail_width;
	public $detail_height;
	public $detail_type;
	public $gallery_width;
	public $gallery_height;
	public $gallery_type;

	/**
	 * For compatibility reasons
	 * @param array $array
	 */
	public function __construct(Array $array) {
		foreach ($array as $key => $var) {
			$this->$key = $var;
		}
		$this->id = $this->id_template;
	}

	/**
	 * Vraci dbGAlleryTemplate podle id_template
	 * @param int $id
	 * @throws dbException
	 * @return dbGAlleryTemplate|false
	 */
	public static function getById($id) {
		return dbI::query("SELECT * FROM s3n_gallery_templates WHERE id_template = %i", $id)->fetch('dbGAlleryTemplate');
	}

}