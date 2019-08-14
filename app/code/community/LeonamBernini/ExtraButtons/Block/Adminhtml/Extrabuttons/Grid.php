<?php

class LeonamBernini_ExtraButtons_Block_Adminhtml_Extrabuttons_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    
    private $categories;
    
    public function __construct()
    {
        parent::__construct();
        $this->setId('ExtraButtonsGrid');
        // This is the primary key of the database
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('extrabuttons/extrabuttons')->getCollection();
        foreach($collection as $link){
            if($link->getStores() && $link->getStores() != 0 ){
                $link->setStores(explode(',',$link->getStores()));
            }
            else{
                $link->setStores(array('0'));
            }
            $link->setCategoryName($this->getCategory($link->getCategory()));
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('extrabuttons')->__('ID'),
            'align'     =>'center',
            'width'     => '50px',
            'index'     => 'id',
        ));

        $this->addColumn('filename', array(
            'header' => Mage::helper('extrabuttons')->__('Image'),
            'align' => 'left',
            'index' => 'filename',
            'renderer' => 'extrabuttons/adminhtml_grid_renderer_image',
            'width'	=> '130px',
            'align'	=> 'center',
            'escape'    => true,
            'sortable'  => false,
            'filter'    => false,
        )); 
        
        $this->addColumn('title', array(
            'header'    => Mage::helper('extrabuttons')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));
        
        $this->addColumn('attribute_key', array(
            'header'    => Mage::helper('extrabuttons')->__('Attribute ID'),
            'align'     =>'left',
            'index'     => 'attribute_key',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('stores', array(
                'header'        => Mage::helper('extrabuttons')->__('Store'),
                'index'         => 'stores',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback'
                                => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('status', array(
            'header'    => Mage::helper('extrabuttons')->__('Status'),
            'align'     => 'center',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => Mage::helper('extrabuttons')->__('Active'),
                0 => Mage::helper('extrabuttons')->__('Inactive'),
            ),
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getGridUrl()
    {
      return $this->getUrl('*/*/grid', array('_current'=>true));
    }

}