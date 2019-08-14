<?php

class LeonamBernini_ExtraButtons_Block_Adminhtml_Extrabuttons_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId   = 'id';
        $this->_blockGroup = 'extrabuttons';
        $this->_controller = 'adminhtml_extrabuttons';

        $this->_updateButton('save',   'label', Mage::helper('extrabuttons')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('extrabuttons')->__('Delete Item'));
    }

    public function getHeaderText()
    {
        if( Mage::registry('extrabuttons_data') && Mage::registry('extrabuttons_data')->getId() ) {
            return Mage::helper('extrabuttons')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('extrabuttons_data')->getTitle()));
        } else {
            return Mage::helper('extrabuttons')->__('Add Item');
        }
    }
}