<?php
	$par_1 = "shadowbox";
	include ("../res/init.php");
	$HP_GALLERY = new Gallery_3n();
	$HP_GALLERY->id_gallery = $id_gallery;
	$p_gallery = $HP_GALLERY->get_gallery_detail();
	$p_image = $HP_GALLERY->get_image_detail($_REQUEST["id_image"]);
// 	echo $p_gallery->name;
// 	echo $p_image->name;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body style="background-color: black; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
<div style="text-align: center; color: white; background-color: black;">
	<img src="<?php echo $p_image->image_path.$p_image->detail_image;?>" height="450"/><br/>
	<div style="">
		<?php //echo $p_image->name; ?>
	</div>
	<div style="margin-top: 10px;">
		<?php echo $p_image->description; ?>
	</div>
</div>
</body>
</html>