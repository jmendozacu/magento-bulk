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


class AW_Helpdeskultimate_Model_Source_Visibility extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const VISIBLE_FOR_CUSTOMER = 1;
    const HIDDEN_FOR_CUSTOMER = 2;

    const VISIBLE_FOR_CUSTOMER_LABEL = 'Visible for Customer';
    const HIDDEN_FOR_CUSTOMER_LABEL = 'Hidden for Customer';

    /**
     * Retrive all attribute options
     *
     * @return array
     */

    public function getAllOptions()
    {
        return $this->toOptionArray();
    }

    /**
     * Converts to options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $data = array(
            self::VISIBLE_FOR_CUSTOMER => Mage::helper('helpdeskultimate')->__(self::VISIBLE_FOR_CUSTOMER_LABEL),
            self::HIDDEN_FOR_CUSTOMER  => Mage::helper('helpdeskultimate')->__(self::HIDDEN_FOR_CUSTOMER_LABEL),
        );
        return $data;
    }
}