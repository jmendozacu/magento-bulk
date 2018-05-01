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

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
$installer->run("
    ALTER TABLE {$this->getTable('helpdeskultimate/department')} ADD `primary_store_id` INT(4) NOT NULL;
    ALTER TABLE {$this->getTable('helpdeskultimate/department')} ADD INDEX ( `primary_store_id` );
    ALTER TABLE {$this->getTable('helpdeskultimate/ticket')} ADD `locked_by` INT(4) NOT NULL;
    ALTER TABLE {$this->getTable('helpdeskultimate/ticket')} ADD `locked_at` datetime NOT NULL;
    ALTER TABLE {$this->getTable('helpdeskultimate/ticket')} ADD INDEX ( `locked_by` );
    ALTER TABLE {$this->getTable('helpdeskultimate/ticket')} ADD INDEX ( `locked_at` );
");
$installer->endSetup();
