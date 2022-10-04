<?php
class imageHelper
{
    const RESIZE_TYPE = 'resizeType';
    const MAX_PARAMS = 'maxParams';
    const MAX_WIDTH = 'maxWidth';
    const MAX_HEIGHT = 'maxHeight';

    const QUALITY = 'quality';
    const SAVE_TO_FILE = 'saveToFile';
    const CHMOD = 'chmod';

    const JPG = 'jpeg';
    const JPEG = 'jpeg';
    const GIF = 'gif';
    const PNG = 'png';

    const ANGLE = 'angle';
    const X = 'x';
    const Y = 'y';
    const COLOR = 'color';
    const FONT = 'font';
    const FONT_SIZE = 'fontSize';

    const WIDTH = 'width';
    const HEIGHT = 'height';

    const REPEAT = 'repeat';

    const BG_COLOR = 'bgColor';
    const IMAGE = 'image';
    const IMAGE_TYPE = 'imageType';

    const POSITION = 'position';
    const FIXED = 'fixed';
    const CENTER = 'center';
    const TOP = 'topMiddle';
    const LEFT = 'left';
    const RIGHT = 'right';
    const BOTTOM = 'bottomMiddle';

    const TOP_LEFT = 'topLeft';
    const TOP_RIGHT = 'topRight';
    const BOTTOM_LEFT = 'bottomLeft';
    const BOTTOM_RIGHT = 'bottomRight';

    private $_params = array();

    private $_defaultParams = array(
                                'quality' => 100,
                                'saveToFile' => true,
                                'chmod' => 0644,
                              );

    /**
     * Konstruktor
     *
     */
    public function __construct ($param = NULL)
    {
        if(is_array($param)){
            $originalWidth = $this->_getParam(self::WIDTH, $param, null, true);
            $originalHeight = $this->_getParam(self::HEIGHT, $param, null, true);
            $originalImageType = $this->_getParam(self::IMAGE_TYPE, $param, null, true);

            $image = $this->_createNewImage($originalWidth, $originalHeight, $originalImageType);

            $this->originalWidth = $originalWidth;
            $this->width = $originalWidth;
            $this->originalHeight = $originalHeight;
            $this->height = $originalHeight;
            $this->originalImageType = $originalImageType;
            $this->imageType = $originalImageType;
            $this->image = $image;

            $this->fill(self::BG_COLOR, $param);
        }else{
            if(!file_exists($param)){
                throw new Exception("Soubor '$param' neexistuje");
            }
            if(!is_file($param)){
                throw new Exception("Nejedná se o soubor ('$param')");
            }
            list($originalWidth, $originalHeight, $originalImageType) = $this->_getImageInfo($param);
            $image = $this->_createImageFromType($originalImageType, $param);

            $this->originalWidth = $originalWidth;
            $this->width = $originalWidth;
            $this->originalHeight = $originalHeight;
            $this->height = $originalHeight;
            $this->originalImageType = $originalImageType;
            $this->imageType = $originalImageType;
            $this->image = $image;
        }
    }

    public function __clone()
    {
        $image = $this->_createNewImage($this->width, $this->height, $this->imageType);
        $this->image = $this->_resampleImage($image, $this->image, 0, 0, $this->width, $this->height, $this->width, $this->height);
    }

    public function __get($name)
    {
        if(!array_key_exists($name, $this->_params)){
           if(!array_key_exists($name, $this->_defaultParams)){
               throw new Exception("Parametr '$name' neexistuje");
           }
           return $this->_defaultParams[$name];
        }
        return $this->_params[$name];
    }

    public function __set($name, $value)
    {
        return $this->_params[$name] = $value;
    }

    public function resize($type, $params)
    {
        switch ($type){
            case self::MAX_PARAMS:
                $maxWidth = $this->_getParam(self::MAX_WIDTH, $params, null, true);
                $maxHeight = $this->_getParam(self::MAX_HEIGHT, $params, null, true);
                $originalWidth = $this->originalWidth;
                $originalHeight = $this->originalHeight;
                $newWidth = $originalWidth;
                $newHeight = $originalHeight;
                $newWidth = $originalWidth;
                $newHeight = $originalHeight;
                //zjistim zda obrázek potřebuje zmenšit
                if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
                    // zjistim v jakem pomeru musi byt strany zmenseny
                    $perWidth = $originalWidth / $maxWidth;
                    $perHeight = $originalHeight / $maxHeight;
                    $newWidth = $maxWidth;
                    $newHeight = $maxHeight;
                    if ($perHeight > $perWidth) {
                         $newWidth = round($originalWidth / $perHeight);
                    } else {
                         $newHeight = round($originalHeight / $perWidth);
                    }
                }
                $newImage = $this->_createNewImage($newWidth, $newHeight, $this->imageType);
                $this->image = $this->_resampleImage($newImage, $this->image, 0, 0, $newWidth, $newHeight, $this->width, $this->height);
                $this->width = $newWidth;
                $this->height = $newHeight;
            break;
            case self::MAX_WIDTH:
                $width = $this->_getParam(self::MAX_WIDTH, $params, null, true);
                $originalWidth = $this->originalWidth;
                $originalHeight = $this->originalHeight;
                $newWidth = $originalWidth;
                $newHeight = $originalHeight;
                if($newWidth > $width){
                    $per = $originalWidth / $width;
                    $newWidth = round($originalWidth / $per);
                    $newHeight = round($originalHeight / $per);
                }

                $newImage = $this->_createNewImage($newWidth, $newHeight, $this->imageType);
                $this->image = $this->_resampleImage($newImage, $this->image, 0, 0, $newWidth, $newHeight, $this->width, $this->height);
                $this->width = $newWidth;
                $this->height = $newHeight;
            break;
            case self::MAX_HEIGHT:
                $height = $this->_getParam(self::MAX_HEIGHT, $params, null, true);
                $originalWidth = $this->originalWidth;
                $originalHeight = $this->originalHeight;
                $newWidth = $originalWidth;
                $newHeight = $originalHeight;
                if($originalHeight > $height){
                    $per = $originalHeight / $height;
                    $newWidth = round($originalWidth / $per);
                    $newHeight = round($originalHeight / $per);
                }

                $newImage = $this->_createNewImage($newWidth, $newHeight, $this->imageType);
                $this->image = $this->_resampleImage($newImage, $this->image, 0, 0, $newWidth, $newHeight, $this->width, $this->height);
                $this->width = $newWidth;
                $this->height = $newHeight;
            break;
            default:
                throw new Exception("Neznámý typ '$type'");
            break;
        }

    }

    public function addText($text, $params = array())
    {
        $angle = $this->_getParam(self::ANGLE, $params, 0);
        $x = $this->_getParam(self::X, $params, 0);
        $y = $this->_getParam(self::Y, $params, 0);
        $color = $this->_getParam(self::COLOR, $params, array(50, 50, 50));
        $font = $this->_getParam(self::FONT, $params, 'arial.ttf');
        $fontsize = $this->_getParam(self::FONT_SIZE, $params, 20);

        $color = $this->_getColor($color);

        if($this->_getParam(self::POSITION, $params, null)){
            if($params[self::POSITION] != self::FIXED){
                $bbox = imagettfbbox($fontsize, $angle, $font, $text);
                list($x, $y) = $this->_getIndent($this->width, $bbox[2] - $bbox[0] - 1, $this->height, $bbox[1] - $bbox[5] + 1, self::BOTTOM);
            }
        }

        $y = $y + $fontsize;

        imagettftext($this->image, $fontsize, $angle, $x, $y, $color, $font, $text);
    }

    public function addBackLayer(imageHelper $layer, $params = array())
    {
        $layer = clone $layer;
        $layerWidth = $layer->width;
        $layerHeight = $layer->height;
        $imageWidth = $this->width;
        $imageHeight = $this->height;
        $leftIndent = 0;
        $topIndent = 0;
        if(array_key_exists(self::POSITION, $params)){
            list($leftIndent, $topIndent) = $this->_getIndent($layerWidth, $imageWidth, $layerHeight, $imageHeight, $params[self::POSITION]);
        }

        $this->image = $this->_resampleImage($layer->image, $this->image, $leftIndent, $topIndent, $imageWidth, $imageHeight, $imageWidth, $imageHeight);
        $this->width = $layerWidth;
        $this->height = $layerHeight;
    }

    public function addFrontLayer(imageHelper $layer, $params = array())
    {
        $layer = clone $layer;
        $layerWidth = $layer->width;
        $layerHeight = $layer->height;
        $imageWidth = $this->width;
        $imageHeight = $this->height;
        $leftIndent = 0;
        $topIndent = 0;
        if(array_key_exists(self::POSITION, $params)){
            list($leftIndent, $topIndent) = $this->_getIndent($imageWidth, $layerWidth, $imageHeight, $layerHeight, $params[self::POSITION]);
        }

        $this->image = $this->_resampleImage($this->image, $layer->image, $leftIndent, $topIndent, $layerWidth, $layerHeight, $layerWidth, $layerHeight);
        $this->width = $layerWidth;
        $this->height = $layerHeight;
    }

    public function fill($type, $params = array())
    {
        switch ($type) {
            case self::BG_COLOR:
                $bgColor = $this->_getParam(self::BG_COLOR, $params, null, true);

                $color = $this->_getColor($bgColor);
                // vyplnim novy obrazek cernym pozadim
                imagefilledrectangle($this->image, 0, 0, $this->width, $this->height, $color);
            break;

            case self::IMAGE:
                $image = $this->_getParam(self::IMAGE, $params, null, true);

                list($originalWidth, $originalHeight, $originalImageType) = $this->_getImageInfo($image);
                $newImage = $this->_createImageFromType($originalImageType, $image);

                $leftIndent = 0;
                $topIndent = 0;
                if(in_array(self::REPEAT, $params)){
                    do{
                        $this->image = $this->_resampleImage($this->image, $newImage, $leftIndent, $topIndent, $originalWidth, $originalHeight, $originalWidth, $originalHeight);
                        $leftIndent += $originalWidth;
                        if($leftIndent >= $this->width){
                            $leftIndent = 0;
                            $topIndent += $originalHeight;
                        }
                    }while ($topIndent < $this->height);
                }else{
                    $this->image = $this->_resampleImage($this->image, $newImage, $leftIndent, $topIndent, $originalWidth, $originalHeight, $originalWidth, $originalHeight);
                }
            break;

            default:
                throw new Exception("Neznámý typ '$type'");
            break;
        }

    }

    public function save($fileName, $params = array())
    {
        $image = $this->image;
        $quality = $this->_getParam(self::QUALITY, $params, $this->quality);
        $saveToFile = $this->_getParam(self::SAVE_TO_FILE, $params, $this->saveToFile);
        $imageType = $this->_getParam(self::IMAGE_TYPE, $params, $this->imageType);
        $chmod = $this->_getParam(self::CHMOD, $params, $this->chmod);

        if (($imageType == self::GIF) && ! function_exists('imagegif')) {
            $imageType = self::PNG;
        }
        $quality = round($quality);
        if ($quality > 100){
            $quality = 100;
        }
        if ($quality < 0){
            $quality = 0;
        }

        switch ($imageType) {
            case self::GIF:
                if ($saveToFile) {
                    imagegif($image, $fileName);
                } else {
                    header("Content-type: image/gif");
                    imagegif($image, '');
                }
                break;
            case self::JPEG :
                if ($saveToFile) {
                    imagejpeg($image, $fileName, $quality);
                } else {
                    header("Content-type: image/jpeg");
                    imagejpeg($image, '', $quality);
                }
                break;
            case self::PNG :
                if ($saveToFile) {
                    imagepng($image, $fileName, $quality / 100);
                } else {
                    header("Content-type: image/png");
                    imagepng($image, '', $quality);
                }
                break;
        }
        if ($saveToFile && $chmod) {
            chmod($fileName, $chmod);
        }
    }

    /**
     * Vytvoří nový obrázek z url
     *
     * @param int $imageType
     * @param string  $fileName
     * @return resource
     */
    private function _createImageFromType ($imageType = NULL, $fileName = NULL)
    {
        if (is_null($imageType) || is_null($fileName)) {
            throw new Exception('Nejsou zadané potřebné údaje pro vytvoření obrázku.');
        }
        $image = null;
        switch ($imageType) {
            case self::GIF:
                $image = imagecreatefromgif($fileName);
            break;
            case self::JPEG:
                $image = imagecreatefromjpeg($fileName);
            break;
            case self::PNG:
                $image = imagecreatefrompng($fileName);
                imagesavealpha($image, true);
            break;
        }
        return $image;
    }

    private function _createNewImage ($width, $height, $imageType)
    {
        if (is_null($width) || is_null($height) || is_null($imageType)) {
            throw new Exception('Nejsou zadané potřebné údaje pro vytvoření nového obrázku.');
        }
        $width = round($width);
        $height = round($height);
        if ($imageType == self::GIF) {
            // should use this function for gifs (gifs are palette images)
            $newImage = imagecreate($width, $height);
        } else {
            // Create a new true color image
            $newImage = imagecreatetruecolor($width, $height);
        }
        if($imageType == self::PNG){
            imagesavealpha($newImage, true);
            $transparentColor = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefill($newImage, 0, 0, $transparentColor);
        }
        return $newImage;
    }


    private function _getImageInfo ($sourceFilePath = NULL)
    {
        if (is_null($sourceFilePath)) {
            throw new Exception('Nejsou zadané potřebné údaje pro zjištění informací o obrázku.');
        }
        // get source image size (width/height/type)
        // orig_img_type 1 = GIF, 2 = JPG, 3 = PNG
        list($width, $height, $imageType) =  getimagesize($sourceFilePath);
        if($imageType == 1) $imageType = self::GIF;
        if($imageType == 2) $imageType = self::JPEG;
        if($imageType == 3) $imageType = self::PNG;

        return array($width, $height, $imageType);
    }


    private function _resampleImage($newImage = NULL, $oldImage = NULL, $leftIndent = NULL, $topIndent = NULL, $resizeX = NULL, $resizeY = NULL, $originalX = NULL, $originalY = NULL)
    {
        if(is_null($newImage) || is_null($oldImage) || is_null($leftIndent) || is_null($topIndent) ||
            is_null($resizeX) || is_null($resizeY) || is_null($originalX) || is_null($originalY)){
            throw new Exception('Nejsou zadané potřebné údaje pro zmenšení obrázku.');
        }

        $topIndent = round($topIndent);
        $leftIndent = round($leftIndent);
        $resizeX = round($resizeX);
        $resizeY = round($resizeY);
        $originalX = round($originalX);
        $originalY = round($originalY);

        if (function_exists('imagecopyresampled')) {
            imagecopyresampled($newImage, $oldImage, $leftIndent, $topIndent, 0, 0, $resizeX, $resizeY, $originalX, $originalY);
        } else {
            imagecopyresized($newImage, $oldImage, $leftIndent, $topIndent, 0, 0, $resizeX, $resizeY, $originalX, $originalY);
        }
        return $newImage;
    }


    private function _getIndent($widthA, $widthB, $heightA, $heightB, $type)
    {
        switch ($type){
            case self::CENTER:
                return array(($widthA - $widthB) / 2, ($heightA - $heightB) / 2);
            break;
            case self::TOP:
                return array(($widthA - $widthB) / 2, 0);
            break;
            case self::LEFT:
                return array(0, ($heightA - $heightB) / 2);
            break;
            case self::RIGHT:
                return array($widthA - $widthB, ($heightA - $heightB) / 2);
            break;
            case self::BOTTOM:
                return array(($widthA - $widthB) / 2, $heightA - $heightB);
            break;
            case self::TOP_LEFT:
                return array(0, 0);
            break;
            case self::TOP_RIGHT:
                return array($widthA - $widthB, 0);
            break;
            case self::BOTTOM_LEFT:
                return array(0, $heightA - $heightB);
            break;
            case self::BOTTOM_RIGHT:
                return array($widthA - $widthB, $heightA - $heightB);
            break;
            default:
                return array(0, 0);
            break;
        }
    }

    private function _getColor($params)
    {
        if(count($params) == 3){
            $color = imagecolorallocate($this->image, $params[0], $params[1], $params[2]);
        }elseif(count($params) == 4){
            $color = imagecolorallocatealpha($this->image, $params[0], $params[1], $params[2], $params[3]);
        }else{
            throw new Exception('Nesprávný počet parametrů');
        }
        return $color;
    }

    /**
     * @param string $param
     * @param array $params
     * @param mixed $default
     * @param bool $throwException
     * @return mixed
     */
    private function _getParam($param, $params = array(), $default = null, $throwException = false)
    {
        if (! array_key_exists($param, $params)) {
            if ($throwException) {
                throw new Exception("Chybějící parametr '$param'");
            } else {
                return $default;
            }
        }
        return $params[$param];
    }
}