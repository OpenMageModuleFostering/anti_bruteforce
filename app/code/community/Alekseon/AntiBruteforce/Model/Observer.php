<?php
/**
 * @author    Lukasz Linczewski
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */
class Alekseon_AntiBruteforce_Model_Observer
{
    public function handleAttemp(){
        if(!Mage::getStoreConfig('alekseon_antibruteforce/anti_bruteforce/enabled')){
            return;
        }
        $ip = Mage::helper('core/http')->getRemoteAddr();
        if($ip == '127.0.0.1' || $this->_isWhiteListed($ip)){
            return;
        }

        $this->_addAttemp($ip);
        $this->_checkIfBlock($ip);
    }

    private function _addAttemp($ip){
        $attemp = Mage::getModel('alekseon_antibruteforce/attemp');
        $attemp->setData(array(
                'ip'            => $ip,
                'created_at'    => Mage::getModel('core/date')->gmtDate()
            )
        );
        $attemp->save();
    }

    private function _checkIfBlock($ip){
        $time = time();
        $to = date('Y-m-d H:i:s', $time);
        $hours = (int)Mage::getStoreConfig('alekseon_antibruteforce/anti_bruteforce/hours_of_attemping');
        $seconds = 60*60*$hours; //TODO Make 5 it dynamic configuration
        $lastTime = $time - $seconds;
        $from = date('Y-m-d H:i:s', $lastTime);

        $collection = Mage::getModel('alekseon_antibruteforce/attemp')->getCollection()
            ->addFieldToFilter('ip', $ip)
            ->addFieldToFilter('created_at', array('from' => $from, 'to' => $to));
        $count = $collection->count();
        
        $numberOfTries = (int)Mage::getStoreConfig('alekseon_antibruteforce/anti_bruteforce/number_of_attemps');
        if($count > $numberOfTries){
            $this->_blockUser($ip);
        }
        return;
    }
    
    private function _blockUser($ip){
        $model = Mage::getModel('alekseon_antibruteforce/blocked');
        $model->setIp($ip);
        $model->save();
    }

    public function checkIfBlocked(){
        if(!Mage::getStoreConfig('alekseon_antibruteforce/anti_bruteforce/enabled')){
            return;
        }
        $ip = Mage::helper('core/http')->getRemoteAddr();
        if($this->_isWhiteListed($ip)){
            return;
        }
        $blocked = Mage::getModel('alekseon_antibruteforce/blocked')->getCollection()
            ->addFieldToFilter('ip', $ip)
            ->getFirstItem();
        if($blocked->getId()){
            throw new Mage_Core_Exception(Mage::helper('enterprise_pci')->__('This IP is locked by Alekseon AntiBruteForce module'));
        }
    }
    
    private function _isWhiteListed($ip){
        $whiteList = unserialize(Mage::getStoreConfig('alekseon_antibruteforce/anti_bruteforce/white_list'));
        foreach($whiteList as $whiteIp){
            if(trim($whiteIp['ip']) == $ip){
                return true;
            }
        }
        return false;
    }
}