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
 * @package    AW_Helpdesk3
 * @version    3.3.0
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */


/**
 * Class AW_Helpdesk3_Block_Adminhtml_Ticket_Edit_Form_Thread_Renderer_Note
 * @method AW_Helpdesk3_Model_Ticket_History getEvent()
 * @method bool getIsShort()
 */
class AW_Helpdesk3_Block_Adminhtml_Ticket_Edit_Form_Thread_Renderer_Note extends Mage_Adminhtml_Block_Template
{
    protected function _toHtml()
    {
        $this->setTemplate('aw_hdu3/ticket/edit/container/thread/note/full.phtml');
        if ($this->getIsShort()) {
            $this->setTemplate('aw_hdu3/ticket/edit/container/thread/note/short.phtml');
        }
        return parent::_toHtml();
    }

    /**
     * @return string
     */
    public function getEventInitiatorName()
    {
        $agentId = $this->getEvent()->getData('initiator_department_agent_id');
        /** @var AW_Helpdesk3_Model_Department_Agent $agent */
        $agent = Mage::getModel('aw_hdu3/department_agent')->load($agentId);
        return $agent->getName();
    }

    /**
     * @return string
     */
    public function getNoteText()
    {
        $content = $this->getEvent()->getEventData('content');
        if (Mage::getStoreConfigFlag('admin/security/use_form_key')) {
            $content = $this->_replacePqQuestionEditUrl($content);
        }
        return $content;
    }

    /**
     * Attempt to find and replace the PQ question/edit URL with the freshly generated one
     * to get rid of the incorrect "secret key", which may or may not have been generated
     * under customer session.
     *
     * @param string $content
     * @return string
     */
    private function _replacePqQuestionEditUrl($content)
    {
        $pqQuestionEditRoute = Mage::getModel('core/url')
            ->setRouteName('aw_pq2_admin')
            ->setControllerName('adminhtml_question')
            ->setActionName('edit')
            ->getRoutePath();
        if (
            !empty($pqQuestionEditRoute)
            && preg_match('{href="([^"]+/'.$pqQuestionEditRoute.'id/([^/]+)/[^"]*)"}', $content, $matches)
        ) {
            $oldUrl = $matches[1];
            $questionId = $matches[2];
            $niceUrl = Mage::helper('adminhtml')
                ->getUrl('aw_pq2_admin/adminhtml_question/edit', array('id' => $questionId));
            $content = str_replace($oldUrl, $niceUrl, $content);
        }
        return $content;
    }

}
