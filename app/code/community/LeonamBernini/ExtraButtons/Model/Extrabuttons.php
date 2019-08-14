<?php

class LeonamBernini_ExtraButtons_Model_Extrabuttons extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('extrabuttons/extrabuttons');
    }
}