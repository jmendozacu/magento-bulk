<?php

class Wyomind_Googletrustedstores_Block_Adminhtml_System_Config_Form_Field_Shipmentlink extends Mage_Adminhtml_Block_System_Config_Form_Field {

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {

        $html = "";
        
        $code = Mage::app()->getRequest()->getParam('website');
        if (!empty($code)) {
            $website = Mage::app()->getWebsite(Mage::getConfig()->getNode('websites/' . $code)->system->website->id->asArray());
            
            $html .= "<input type='hidden' value='".$website->getConfig("googletrustedstores/feed_update/gts_dynamic_link")."' id='googletrustedstores_feed_update_gts_dynamic_link'/>";
            
        } else {
            $websites = Mage::app()->getWebsites();
            $ws = array();
            foreach ($websites as $website) {
                if (count($website->getStores()) > 0) {
                    $ws[] = $website;
                }
            }
            if (count($ws) == 1) {
                $tmp = $ws[0];
                $website = Mage::app()->getWebsite($tmp->getId());
                $code = $tmp->getCode();
            } else {
                return "Please select a website in the configuration scope";
            }
        }
        $base_url = $website->getConfig('web/unsecure/base_url');

        $file = $website->getConfig("googletrustedstores/shipments_settings/filename");
        $file = $code . "_" . $file;

        $path = $website->getConfig("googletrustedstores/shipments_settings/filepath");

        $url = $base_url . $path . '/' . $file;

        $io = new Varien_Io_File();


        $realPath = $io->getCleanPath(Mage::getBaseDir() . '/' . $path . '/' . $file);

        if (!$io->fileExists($realPath, false)) {
            $html .= "$url<br/><b>" . Mage::helper('googletrustedstores')->__('The data feed has not been generated yet') . "</b>";
        } else {
            $html .= "<a target=\_blank\" href=\"$url\">$url</a><br/><b>" . Mage::helper('googletrustedstores')->__('last update : ') . Mage::getStoreConfig("googletrustedstores/schedule/last_update") . "</b>";
        }

        $url_ship = Mage::helper("adminhtml")->getUrl('googletrustedstores/adminhtml_googletrustedstores/previewshipments', array('website' => $website->getId()));
        $url_ship_dl = Mage::helper("adminhtml")->getUrl('googletrustedstores/adminhtml_googletrustedstores/previewshipments', array('dl' => true, 'website' => $website->getId()));
        $html .= "<br/><button onclick='javascript:window.open(\"$url_ship\");return false;'>" . Mage::helper('googletrustedstores')->__('Test feed') . "</button>&nbsp;"
                . "<button onclick='javascript:window.open(\"$url_ship_dl\");return false;'>" . Mage::helper('googletrustedstores')->__('Download feed') . "</button>";


        return $html;
    }

}
