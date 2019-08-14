<?php
class LeonamBernini_ExtraButtons_Block_Extrabuttons extends Mage_Catalog_Block_Product_Abstract
{
    public function getButtons()
    {
        $buttons = Mage::getModel('extrabuttons/extrabuttons')
                        ->getCollection()
                        ->addFieldToFilter(
                                array('stores', 'stores'),
                                array(
                                        array('finset'=>Mage::app()->getStore()->getId()), 
                                        array('eq'=>'0'))
                        )
                        ->addFieldToFilter('status', array('eq' => '1'))
                        ->setOrder("id","ASC");
        if( count( $buttons ) > 0 ){
            return $buttons;
        }else{
            return false;
        }
    }
}