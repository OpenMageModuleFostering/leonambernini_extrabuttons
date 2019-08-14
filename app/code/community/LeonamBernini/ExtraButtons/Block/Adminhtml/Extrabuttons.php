<?php
class LeonamBernini_ExtraButtons_Block_Adminhtml_Extrabuttons extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_extrabuttons';
        $this->_blockGroup = 'extrabuttons';
        $this->_headerText = Mage::helper('extrabuttons')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('extrabuttons')->__('Add Item');
        parent::__construct();
    }
}
