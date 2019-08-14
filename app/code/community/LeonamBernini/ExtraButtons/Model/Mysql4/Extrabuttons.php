<?php

class LeonamBernini_ExtraButtons_Model_Mysql4_Extrabuttons extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('extrabuttons/extrabuttons', 'id');
    }
}