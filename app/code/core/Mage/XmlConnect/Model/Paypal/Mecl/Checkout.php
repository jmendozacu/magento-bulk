<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_XmlConnect
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * XmlConnect PayPal Mobile Express Checkout Library model
 *
 * @category    Mage
 * @package     Mage_XmlConnect
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_XmlConnect_Model_Paypal_Mecl_Checkout extends Mage_Paypal_Model_Express_Checkout
{
    /**
     * Payment method type
     *
     * @var string
     */
    protected $_methodType = Mage_XmlConnect_Model_Payment_Method_Paypal_Config::METHOD_WPP_MECL;

    /**
     * Set sandbox flag and get api
     *
     * @return Mage_Paypal_Model_Api_Nvp
     */
    protected function _getApi()
    {
        $this->_setSandboxFlag();
        return parent::_getApi();
    }

    /**
     * Set sandbox flag
     *
     * @return Mage_XmlConnect_Model_Paypal_Mecl_Checkout
     */
    protected function _setSandboxFlag()
    {
        $this->_config->sandboxFlag = Mage::helper('payment')
            ->getMethodInstance(Mage_XmlConnect_Model_Payment_Method_Paypal_Config::METHOD_WPP_EXPRESS)
            ->getConfigData('sandbox_flag');
        return $this;
    }
}
