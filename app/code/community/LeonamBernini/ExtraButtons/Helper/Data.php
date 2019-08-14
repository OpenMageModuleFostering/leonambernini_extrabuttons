<?php

class LeonamBernini_ExtraButtons_Helper_Data extends Mage_Core_Helper_Abstract
{
    private $path;
    private $thumbsPath;
    
    public function __construct() {
        $this->path       = '/leonam_bernini/extrabuttons/';
        $this->thumbsPath = '/leonam_bernini/extrabuttons/thumbs/';
    }


    public function getAttributes()
    {
        $attributes = Mage::getSingleton('eav/config')
                            ->getEntityType(Mage_Catalog_Model_Product::ENTITY)
                            ->getAttributeCollection()
                            ->addFieldToFilter('frontend_input', array('eq' => 'boolean'))
                            ->addSetInfo();
        $arr = array();
        $arr['unavailable'] = $this->__('Unavailable');
        foreach($attributes as $attribute){
            $arr[$attribute->getAttributeCode()] = $attribute->getFrontendLabel();
        }
        return $arr;
    }
    
    
    public function getPath()
    {
        return $this->path;
    }
    public function getThumbsPath($path = null)
    {
        if( $path == null ){
            return $this->thumbsPath;
        }else{
            return str_replace( '/extrabuttons/', '/extrabuttons/thumbs/', $path);
        }
    }

    public function resizeImg($fileName, $width, $height = '')
    {
        //$fileName = "slideshow\slides\\".$fileName;
        $folderURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
        $imageURL = $folderURL . $fileName;

        $basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $this->path. $fileName;

        $newPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $this->thumbsPath . $fileName;
        //if width empty then return original size image's URL
        if ($width != '') {
            //if image has already resized then just return URL
            if (file_exists($basePath) && is_file($basePath) && !file_exists($newPath)) {
                $imageObj = new Varien_Image($basePath);
                $imageObj->constrainOnly(TRUE);
                $imageObj->keepAspectRatio(FALSE);
                $imageObj->keepFrame(FALSE);
                $imageObj->resize($width, $height);
                $imageObj->save($newPath);
            }
            $resizedURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . "resized" . DS . $fileName;
         } else {
            $resizedURL = $imageURL;
         }
         return $resizedURL;
    }    
}