/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
  
  
  	config.skin = 'office2013';
	config.uiColor = '#009933';
// 	config.width = 590;
	config.height = 395;

	config.filebrowserBrowseUrl = '/res/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
	config.filebrowserImageBrowseUrl = '/res/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images';
	config.filebrowserFlashBrowseUrl = '/res/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
	config.filebrowserUploadUrl = '/res/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
	config.filebrowserImageUploadUrl = '/res/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images';
	config.filebrowserFlashUploadUrl = '/res/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash';
	
	config.enterMode = CKEDITOR.ENTER_BR;
	
	config.removePlugins = 'about';

  
};
