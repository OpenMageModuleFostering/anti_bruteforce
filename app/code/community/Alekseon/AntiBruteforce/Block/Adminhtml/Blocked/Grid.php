<?php
/**
 * @author    Lukasz Linczewski
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */
class Alekseon_AntiBruteforce_Block_Adminhtml_Blocked_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


   public function __construct()
    {
        parent::__construct();
        $this->setId('anti_bruteforce_blocked_grid');
        $this->setSaveParametersInSession(true);   
        $this->setUseAjax(true);
    }

	protected function _prepareColumns()
    {
	    $this->addColumn('ip',
			array(
				'header' => Mage::helper('alekseon_antibruteforce')->__('Ip'),
				'index'  => 'ip',
                'type' => 'text',
            )
        );

		return parent::_prepareColumns();
	}

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('alekseon_antibruteforce/blocked')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('bruteforce_blocked_delete');
        $this->getMassactionBlock()->setFormFieldName('blocked_id');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('tax')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete', array('' => '')),        // public function massDeleteAction() in Mage_Adminhtml_Tax_RateController
            'confirm' => Mage::helper('tax')->__('Are you sure?')
        ));

        return $this;
    }
}
