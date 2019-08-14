<?php

class LeonamBernini_ExtraButtons_Block_Adminhtml_Extrabuttons_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('extrabuttons_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('extrabuttons')->__('Button Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('extrabuttons')->__('Item Information'),
            'title'     => Mage::helper('extrabuttons')->__('Item Information'),
            'content'   => $this->getLayout()->createBlock('extrabuttons/adminhtml_extrabuttons_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}