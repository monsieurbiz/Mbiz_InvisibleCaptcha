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
 * Script Block
 * @package Mbiz_InvisibleCaptcha
 */
class Mbiz_InvisibleCaptcha_Block_Script extends Mage_Core_Block_Abstract
{

    /**
     * To HTML
     * @return string
     */
    protected function _toHtml()
    {
        if (Mage::helper('mbiz_invisiblecaptcha')->isActive()) {
            return PHP_EOL . '<script src="https://www.google.com/recaptcha/api.js?render=explicit" async defer></script>' . PHP_EOL;
        }
        return '';
    }

}