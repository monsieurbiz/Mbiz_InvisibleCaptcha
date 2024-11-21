<?php
/**
 * This file is part of Mbiz_InvisibleCaptcha for Magento.
 *
 * @license proprietary
 * @author Jacques Bodin-Hullin <j.bodinhullin@monsieurbiz.com> <@jacquesbh>
 * @category Mbiz
 * @package Mbiz_InvisibleCaptcha
 * @copyright Copyright (c) 2018 Monsieur Biz (https://monsieurbiz.com/)
 */

/**
 * Observer Model
 * @package Mbiz_InvisibleCaptcha
 */
class Mbiz_InvisibleCaptcha_Model_Observer extends Mage_Core_Model_Abstract
{

    /**
     * Verify Google reCATPCHA response
     * Unset form_key parameter in the request to avoid pass the security CSRF check.
     */
    public function verifyResponse(Varien_Event_Observer $observer)
    {
        $doRedirect = false;
        $redirectPath = null;
        switch ($observer->getEvent()->getName()) {
            case 'controller_action_predispatch_contacts_index_post':
                $configPath = 'mbiz_invisiblecaptcha/active_for/contacts';
                $doRedirect = true;
                $urlToRedirect = Mage::getUrl('contacts', ['_current' => true]);
                break;
            case 'controller_action_predispatch_customer_account_createpost':
                $configPath = 'mbiz_invisiblecaptcha/active_for/customer_creation';
                $urlToRedirect = Mage::getUrl('customer/account/create', ['_current' => true]);
                break;
           case 'controller_action_predispatch_newsletter_subscriber_new':
               $configPath = 'mbiz_invisiblecaptcha/active_for/newsletter_subscription';
               $urlToRedirect = Mage::getUrl('', ['_current' => true]);
               break;
            default:
                return;
        }

        if (Mage::helper('mbiz_invisiblecaptcha')->isActive() && Mage::getStoreConfigFlag($configPath)) {
            Mage::app()->getRequest()->setPost('enabled-captcha', true);
            if (!Mage::helper('mbiz_invisiblecaptcha')->verify()) {
                if ($doRedirect || !Mage::getStoreConfigFlag('admin/security/validate_formkey_checkout')) {
                    Mage::getSingleton('customer/session')->addError(Mage::helper('mbiz_invisiblecaptcha')->__('Unable to submit your request.'));
                    Mage::app()->getResponse()
                        ->setRedirect($urlToRedirect)
                        ->sendHeaders();
                    exit;
                } else {
                    Mage::app()->getRequest()->setParam('form_key', -1);
                    Mage::app()->getRequest()->setPost('valid-captcha', false);
                }
            } else {
                Mage::app()->getRequest()->setPost('valid-captcha', true);
            }
        }
    }

}
