<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This software is designed to work with Magento community edition and
 * its use on an edition other than specified is prohibited. aheadWorks does not
 * provide extension support in case of incorrect edition use.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Helpdeskultimate
 * @version    2.10.7
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */


class AW_Helpdeskultimate_Block_Customer_Antibot_Revalidate extends Mage_Core_Block_Template
{
    /**
     * Returns referrer url
     *
     * @return string
     */
    public function getAction()
    {
        return Mage::getSingleton('core/session')->getPostUrl();
    }

    public function getSeed()
    {
        return Mage::getModel('helpdeskultimate/antibot')->getSeed();
    }

    /**
     * Returns fail key
     *
     * @return string
     */
    public function getFailKey()
    {
        if (!$this->getData('fail_key')) {
            $this->setData('fail_key', rand(10000, 99999));
        }
        return $this->getData('fail_key');
    }

    /**
     * Returns fail key hash for check
     *
     * @return string
     */
    public function getFailKeyHash()
    {
        return md5($this->getFailKey());
    }
}
