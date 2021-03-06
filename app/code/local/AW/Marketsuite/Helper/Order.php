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
 * @package    AW_Marketsuite
 * @version    2.1.0
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */


class AW_Marketsuite_Helper_Order extends Mage_Core_Helper_Data
{
    public function getOrderCount()
    {
        return Mage::getResourceModel('sales/order_collection')->getSize();
    }

    public function getUpdatedOrderIdList($date)
    {
        $orderCollection = Mage::getResourceModel('sales/order_collection')->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns(array('entity_id', 'customer_id'))
            ->where("updated_at >= ?", $date)
        ;

        $orders = array();
        foreach ($orderCollection as $order) {
            $orders[] = array(
                'order_id'    => $order->getData('entity_id'),
                'customer_id' => $order->getData('customer_id'),
            );
        }

        return $orders;
    }

    public function getAllIds(Zend_Db_Select $select)
    {
        $orderCollection = Mage::getResourceModel('sales/order_collection');
        $idsSelect = clone $select;
        $idsSelect->reset(Zend_Db_Select::COLUMNS);
        $idsSelect->columns($orderCollection->getResource()->getIdFieldName(), 'main_table');
        return $orderCollection->getConnection()->fetchCol($idsSelect);
    }
}