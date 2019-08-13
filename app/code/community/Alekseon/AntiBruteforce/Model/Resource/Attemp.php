<?php
/**
 * @author    Lukasz Linczewski
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */
class Alekseon_AntiBruteforce_Model_Resource_Attemp extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('alekseon_antibruteforce/attemp', 'attemp_id');
    }
}