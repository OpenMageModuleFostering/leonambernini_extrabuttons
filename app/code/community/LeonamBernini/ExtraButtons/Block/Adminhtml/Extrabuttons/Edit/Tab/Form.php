<?php

class LeonamBernini_ExtraButtons_Block_Adminhtml_Extrabuttons_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('extrabuttons_form', array('legend'=>Mage::helper('extrabuttons')->__('Item information')));
        
        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('extrabuttons')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('stores', 'multiselect', array(
                'name'      => 'stores[]',
                'label'     => Mage::helper('extrabuttons')->__('Select Store'),
                'title'     => Mage::helper('extrabuttons')->__('Select Store'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        }
        else {
            $fieldset->addField('stores', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
        }

        $fieldset->addField('filename', 'image', array(
            'label'     => Mage::helper('extrabuttons')->__('Image File'),
            'name'      => 'filename',
        ));

        $fieldset->addField('attribute_key', 'select', array(
            'label'     => Mage::helper('extrabuttons')->__('Attribute Code'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'attribute_key',
            'values'    => Mage::helper('extrabuttons')->getAttributes(), 
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('extrabuttons')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('extrabuttons')->__('Active'),
                ),

                array(
                    'value' => 0,
                    'label' => Mage::helper('extrabuttons')->__('Inactive'),
                ),
            ),
        ));

        if ( Mage::getSingleton('adminhtml/session')->getExtrabuttonsData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getExtrabuttonsData());
            Mage::getSingleton('adminhtml/session')->setExtrabuttonsData(null);
        } elseif ( Mage::registry('extrabuttons_data') ) {
            $form->setValues(Mage::registry('extrabuttons_data')->getData());
        }
        return parent::_prepareForm();
    }
}