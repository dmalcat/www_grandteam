<?php

class Resize {
	var $img;
	
	function __construct($imgfile)	{
		$imageinfo = getimagesize($imgfile);

		switch ($imageinfo["mime"]) {
			case "image/jpeg":
				$this->img["src"] = imagecreatefromjpeg($imgfile);
				break;
			case "image/gif":
				$this->img["src"] = imagecreatefromgif($imgfile);
				break;
			case "image/png":
				$this->img["src"] = imagecreatefrompng($imgfile);
				break;
		}

		$this->img["width"] = imagesx($this->img["src"]);
		$this->img["height"] = imagesy($this->img["src"]);
		//default quality jpeg
		$this->img["quality"]=80;
	}

	function size_height($size=100) {
		//height
		$this->img["height_thumb"]=$size;
		$this->img["width_thumb"] = ($this->img["height_thumb"]/$this->img["height"])*$this->img["width"];
	}

	function size_width($size=100) {
		//width
		$this->img["width_thumb"]=$size;
		$this->img["height_thumb"] = ($this->img["width_thumb"]/$this->img["width"])*$this->img["height"];
	}
	
	function sizeAutoBothDimensions($width, $height) {
		$this->size_width($width);
		if ($this->img["height_thumb"] > $height) {
			$this->size_height($height);
		}
	}

	function size_auto($size=100) {
		//size
		if ($this->img["width"]>=$this->img["height"]) {
			$this->img["width_thumb"]=$size;
			$this->img["height_thumb"] = ($this->img["width_thumb"]/$this->img["width"])*$this->img["height"];
		} else {
			$this->img["height_thumb"]=$size;
			$this->img["width_thumb"] = ($this->img["height_thumb"]/$this->img["height"])*$this->img["width"];
		}
	}

	function setJpegQuality($quality) {
		$this->img["quality"] = $quality;
	}


	function save($save="", $frame = false) {
		//save thumb
		if (empty($save)) $save=strtolower("./thumb.".$this->img["format"]);

		$this->img["des"] = ImageCreateTrueColor($this->img["width_thumb"],$this->img["height_thumb"]);
		@imagecopyresampled($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["width_thumb"], $this->img["height_thumb"], $this->img["width"], $this->img["height"]);

		if ($frame) {
			$vodotisk = imagecreatefrompng("./ramecek.png");
			imagecopy($this->img["des"], $vodotisk, 0, 0, 0, 0, imagesx($vodotisk), imagesy($vodotisk));
		}

		touch($save);
		imageJPEG($this->img["des"],"$save",$this->img["quality"]);

	}
}
?>