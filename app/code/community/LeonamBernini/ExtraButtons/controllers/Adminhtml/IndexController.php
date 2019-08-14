<?php

class LeonamBernini_ExtraButtons_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('extrabuttons/manage_extrabuttons')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        return $this;
    }

    public function indexAction() {
        $this->_initAction();       
        $this->_addContent($this->getLayout()->createBlock('extrabuttons/adminhtml_extrabuttons'));
        $this->renderLayout();
    }
    
    public function newAction(){
        $this->_forward('edit');
    }
    
    public function editAction(){
        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('extrabuttons/extrabuttons')->load($id);

        if ( $model->getId() || $id == 0 ) {

            Mage::register('extrabuttons_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('extrabuttons/manage_extrabuttons');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('extrabuttons/adminhtml_extrabuttons_edit'))
                 ->_addLeft($this->getLayout()->createBlock('extrabuttons/adminhtml_extrabuttons_edit_tabs'));

            $this->renderLayout();
        } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('extrabuttons')->__('Item does not exist'));
                $this->_redirect('*/*/');
        }
    }
    
    public function saveAction()
    {
        if ( $this->getRequest()->getPost() ) {
            try {
                $postData = $this->getRequest()->getPost();
                $extrabuttonsModel = Mage::getModel('extrabuttons/extrabuttons');

                $bannerPath = Mage::helper('extrabuttons')->getPath();

                if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
                    try {	

                        /* Starting upload */	
                        $uploader = new Varien_File_Uploader('filename');

                        // Any extention would work
                        $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                        $uploader->setAllowRenameFiles(true);

                        // Set the file upload mode 
                        // false -> get the file directly in the specified folder
                        // true -> get the file in the product like folders 
                        //	(file.jpg will go in something like /media/f/i/file.jpg)
                        $uploader->setFilesDispersion(false);

                        // We set media as the upload dir
                        $path = Mage::getBaseDir('media') . DS . $bannerPath ;
                        
                        $extension = pathinfo($_FILES['filename']['name'], PATHINFO_EXTENSION);
                        $result = $uploader->save($path, md5( $imageName . date('d.m.Y_H.m.i') ) . '.' . $extension );

                        //For thumb
                        Mage::helper('extrabuttons')->resizeImg($result['file'], 100, 75);
                        //For thumb ends

                        $test = $bannerPath.$result['file'];

                        if(isset($postData['filename']['delete']) && $postData['filename']['delete'] == 1)
                        {
                            unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['filename']['value']);
                            unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS . Mage::helper('extrabuttons')->getThumbsPath($postData['filename']['value']));
                        }
                        $postData['filename'] = $test;

                    } catch (Exception $e) {
                        $postData['filename'] = $_FILES['filename']['name'];
            }
            }
            else {       
                if(isset($postData['filename']['delete']) && $postData['filename']['delete'] == 1){
                    unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['filename']['value']);
                    unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .Mage::helper('extrabuttons')->getThumbsPath($postData['filename']['value']));
                    $postData['filename'] = '';
                }
                else
                    unset($postData['filename']);
            }
                if(isset($postData['stores'])) {
                    if(in_array('0',$postData['stores'])){
                        $postData['stores'] = '0';
                    }else{
                        $postData['stores'] = implode(",", $postData['stores']);
                    }
                }

                if($postData['stores'] == "")
                {
                    $postData['stores'] = '0';
                }
                
                $times = explode(" ", now());
                if ( $postData['start_time'] ) {
                    $postData['start_time'] = $postData['start_time']. " " . $times[1];
                }else{
                    $postData['start_time'] = null;
                }
                if ( $postData['end_time'] ) {
                    $postData['end_time']   = $postData['end_time'] . " " . $times[1];
                }else{
                    $postData['end_time'] = null;
                }

                $extrabuttonsModel->setId($this->getRequest()->getParam('id'))
                                ->setAttributeKey($postData['attribute_key'])
                                ->setTitle($postData['title'])
                                ->setFilename($postData['filename'])
                                ->setStatus($postData['status'])
                                ->setStores($postData['stores'])
                                ->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setExtrabuttonsData(false);

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setExtrabuttonsData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
    
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if( $id > 0 ) {
            try {
                $model = Mage::getModel('extrabuttons/extrabuttons')->load($id);
                $image = $model->getFilename();
                $model->delete();
                
                if( $image != '' && $image != null && file_exists( Mage_Core_Model_Store::URL_TYPE_MEDIA .$image ) ){
                    unlink( Mage_Core_Model_Store::URL_TYPE_MEDIA .$image );
                
                    if( file_exists( Mage_Core_Model_Store::URL_TYPE_MEDIA . Mage::helper('extrabuttons')->getThumbsPath( $image ) ) ){
                        unlink( Mage_Core_Model_Store::URL_TYPE_MEDIA . Mage::helper('extrabuttons')->getThumbsPath( $image ) );
                    }
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
    
    /**
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
                   $this->getLayout()->createBlock('extrabuttons/adminhtml_extrabuttons_grid')->toHtml()
        );
    }
}
?>