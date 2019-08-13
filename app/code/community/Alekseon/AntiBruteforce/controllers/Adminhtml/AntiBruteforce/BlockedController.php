<?php
/**
 * @author    Lukasz Linczewski
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */
class Alekseon_AntiBruteforce_Adminhtml_AntiBruteforce_BlockedController extends Mage_Adminhtml_Controller_Action
{

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/alekseon_tools/anti_bruteforce');
    }

    public function indexAction()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }
    
        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('alekseon_antibruteforce/adminhtml_blocked_grid')->toHtml());
    }

    public function massDeleteAction()
    {
        $blockedIds = $this->getRequest()->getParam('blocked_id');      // $this->getMassactionBlock()->setFormFieldName('tax_id'); from Mage_Adminhtml_Block_Tax_Rate_Grid
        if(!is_array($blockedIds)) {
            Mage::getSingleton('adminhtml/session')->addError('Please select ip(s).');
        } else {
            try {
                $blockedModel = Mage::getModel('alekseon_antibruteforce/blocked');
                foreach ($blockedIds as $blockedId) {
                    $blockedModel->load($blockedId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('tax')->__(
                        'Total of %d record(s) have been deleted.', count($blockedIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}