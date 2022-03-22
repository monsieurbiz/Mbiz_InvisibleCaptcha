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
 * Data Helper
 * @package Mbiz_InvisibleCaptcha
 */
class Mbiz_InvisibleCaptcha_Helper_Data extends Mage_Core_Helper_Abstract
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * Is the module active?
     * @return true
     */
    public function isActive()
    {
        return Mage::getStoreConfigFlag('mbiz_invisiblecaptcha/general/active');
    }

    /**
     * Retrieve the Google's secret key
     * @return string
     */
    public function getSecretKey()
    {
        return Mage::getStoreConfig('mbiz_invisiblecaptcha/general/secret_key');
    }

    /**
     * Retrieve the Google's site key
     * @return string
     */
    public function getSiteKey()
    {
        return Mage::getStoreConfig('mbiz_invisiblecaptcha/general/site_key');
    }

    /**
     * Verify the Google reCaptcha response
     * @return bool
     */
    public function verify()
    {
        if ($response = Mage::app()->getRequest()->getParam('g-recaptcha-response', null)) {
            // Make a call
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'secret' => $this->getSecretKey(),
                'response' => $response,
                'remoteip' => Mage::helper('core/http')->getRemoteAddr(),
            ]);
            $jsonResponse = curl_exec($ch);
            curl_close($ch);

            if (null !== $response = json_decode($jsonResponse, true)) {
                return isset($response['success']) ? (bool) $response['success'] : false;
            }
        }
        return false;
    }

// Monsieur Biz Tag NEW_METHOD

}
