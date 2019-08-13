<?php
/**
 * @author    Lukasz Linczewski
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */
class Alekseon_AntiBruteforce_Block_Adminhtml_Blocked extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'alekseon_antibruteforce';
        $this->_controller = 'adminhtml_blocked';
        $this->_headerText = Mage::helper('alekseon_antibruteforce')->__('Anti Bruteforce Blocked');
        parent::__construct();
        $this->removeButton('add');
    }

}