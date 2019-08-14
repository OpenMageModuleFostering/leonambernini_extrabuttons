<?php

class LeonamBernini_ExtraButtons_Model_Mysql4_Extrabuttons_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        //parent::_construct();
        $this->_init('extrabuttons/extrabuttons');
    }
}