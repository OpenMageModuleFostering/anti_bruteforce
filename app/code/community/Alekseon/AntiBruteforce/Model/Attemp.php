<?php
/**
 * @author    Lukasz Linczewski
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */
class Alekseon_AntiBruteforce_Model_Attemp extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('alekseon_antibruteforce/attemp');
    }
}