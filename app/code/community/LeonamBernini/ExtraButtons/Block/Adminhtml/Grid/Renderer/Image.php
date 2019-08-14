<?php
class LeonamBernini_ExtraButtons_Block_Adminhtml_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        if($row->getData($this->getColumn()->getIndex())==""){
            return "";
        }
        else{
            $html = '<img ';
            $html .= 'id="img-' . $this->getColumn()->getId() . '" ';
            $html .= 'alt="' . $this->getColumn()->getTitle() . '" ';
            $html .= 'title="' . $this->getColumn()->getTitle() . '" ';
            $html .= 'width="100" ';
            $html .= 'height="50" ';
            $html .= 'src="' . Mage::getBaseUrl("media") . Mage::helper('extrabuttons')->getThumbsPath( $row->getData( $this->getColumn()->getIndex() ) ) . '"';
            $html .= 'class="grid-image ' . $this->getColumn()->getInlineCss() . '"/>';
            
            return $html;
        }
    }
} 