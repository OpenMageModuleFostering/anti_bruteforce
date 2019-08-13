<?php

class Alekseon_AntiBruteforce_Block_System_Config_Form_Field_Ip
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    public function __construct()
    {
        $this->addColumn('ip', array(
            'label' => Mage::helper('adminhtml')->__('IP'),
            'style' => 'width:100px',
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add IP');
        parent::__construct();
    }
}

