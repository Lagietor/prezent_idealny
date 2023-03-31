<?php

/**
* 2007-2023 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2023 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

require __DIR__ . '/classes/DbProductOptionsManagement.php';
require __DIR__ . '/classes/WishForm.php';
require __DIR__ . '/classes/WishValidate.php';
require __DIR__ . '/classes/DbDeliveryOptionsManagement.php';
require __DIR__ . '/classes/WishHelperList.php';

class Wishdeliveryselection extends Module
{
    protected $config_form = false;
    private $formMessage;

    public const REGISTERED_EMAIL_NAME = 'WISHDELIVERYSELECTION_REGISTERED_EMAIL';
    public const OTHER_EMAIL_NAME = 'WISHDELIVERYSELECTION_OTHER_EMAIL';
    public const SMS_NAME = 'WISHDELIVERYSELECTION_SMS';
    public const MODULE_ADMIN_CONTROLLER = 'AdminWishForm';

    public function __construct()
    {
        $this->name = 'wishdeliveryselection';
        $this->tab = 'emailing';
        $this->version = '1.0.0';
        $this->author = 'Pablo&Wiktor';
        $this->need_instance = 0;

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Wish Delivery Selection');
        $this->description = $this->l('Gives a possibility to choose in which way the wishes should be delivered');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        include(dirname(__FILE__) . '/sql/install.php');

        Configuration::updateValue(self::REGISTERED_EMAIL_NAME, 0);
        Configuration::updateValue(self::OTHER_EMAIL_NAME, 0);
        Configuration::updateValue(self::SMS_NAME, 0);

        return parent::install() &&
            $this->registerHook('displayAdminProductsExtra') &&
            $this->registerHook('actionObjectProductUpdateAfter') &&
            $this->registerHook('displayBeforeCarrier') &&
            $this->registerHook('actionCarrierProcess') &&
            $this->registerHook('actionObjectOrderAddAfter') &&
            $this->registerHook('header') &&
            $this->registerHook('actionObjectOrderAddBefore') &&
            $this->registerHook('actionPresentCart') &&
            $this->installTabs();
    }

    public function uninstall()
    {
        include(dirname(__FILE__) . '/sql/uninstall.php');

        return parent::uninstall() &&
        $this->uninstallTabs();
    }

    public function installTabs()
    {
        if (Tab::getIdFromClassName(static::MODULE_ADMIN_CONTROLLER)) {
            return true;
        }

        $tab = new Tab();
        $tab->class_name = static::MODULE_ADMIN_CONTROLLER;
        $tab->module = $this->name;
        $tab->active = true;
        $tab->id_parent = -1;
        $tab->name = array_fill_keys(
            Language::getIDs(false),
            $this->displayName
        );

        return $tab->add();
    }

    public function uninstallTabs()
    {
        $id_tab = (int) Tab::getIdFromClassName(static::MODULE_ADMIN_CONTROLLER);

        if ($id_tab) {
            $tab = new Tab($id_tab);
            return $tab->delete();
        }

        return true;
    }

    public function getContent()
    {
        Tools::redirectAdmin($this->context->link->getAdminLink(static::MODULE_ADMIN_CONTROLLER));
    }

    public function postProcess()
    {
        Configuration::updateValue(self::REGISTERED_EMAIL_NAME, Tools::getValue('registered_email'));
        Configuration::updateValue(self::OTHER_EMAIL_NAME, Tools::getValue('other_email'));
        Configuration::updateValue(self::SMS_NAME, Tools::getValue('sms'));

        $productOptions = new DbProductOptionsManagement();
        if (Tools::getValue('wishdeliveryselection_productsBox')) {
            if (
                $productOptions->setOptions(
                    Tools::getValue('wishdeliveryselection_productsBox'),
                    Tools::getValue('registered_email'),
                    Tools::getValue('other_email'),
                    Tools::getValue('sms')
                )
            ) {
                $this->formMessage = $this->displayConfirmation($this->l('Data was saved successfully'));
            }
        } else {
            $this->formMessage = $this->displayError($this->l('There is nothing to add'));
        }
    }

    public function hookHeader()
    {
        if ($this->context->controller->php_self === 'order') {
            $this->context->controller->addJS($this->_path . 'views/js/carrierformslider.js');
        }
    }

    public function hookDisplayBeforeCarrier($params)
    {
        $wishForm = new WishForm();
        $cart = new Cart($params['cart']->id);

        $productsIds = $wishForm->getInCartProductsIds($cart);
        $dbProductOptions = new DbProductOptionsManagement();
        $productsOptions = $dbProductOptions->getProductsOptions($productsIds);

        $productsOptions = $wishForm->addProductsWithNoOptions($productsIds, $productsOptions);
        $productsOptions = $wishForm->getDuplicatedValues($productsOptions);

        $this->context->smarty->assign('options', $productsOptions);
        $this->context->smarty->assign('wish_message', Configuration::get('WISH_MESSAGE'));
        $this->context->smarty->assign('email_address', Configuration::get('EMAIL_ADDRESS'));
        $this->context->smarty->assign('delivery_date', Configuration::get('DELIVERY_DATE'));
        $this->context->smarty->assign('phone_number', Configuration::get('PHONE_NUMBER'));
        $this->context->smarty->assign('wish_option', Configuration::get('WISH_OPTION'));

        return $this->display(__FILE__, '/views/templates/front/carrierwishselection.tpl');
    }

    public function hookActionCarrierProcess()
    {
        if (isset($_COOKIE['wish_error'])) {
            $this->context->controller->errors[] = $_COOKIE['wish_error'];
            setcookie('wish_error', "", time() - 3600, "/", $_SERVER['SERVER_NAME']);
            return;
        }

        // check registered_email validation (there is no validation right now)
        if (Tools::getValue('wish_form') == "1") {
            Configuration::updateValue('WISH_OPTION', Tools::getValue('wish_form'));
            Configuration::updateValue('WISH_MESSAGE', Tools::getValue('registered_email_wishes'));
        }

        // check other_email validation
        if (Tools::getValue('wish_form') == "2") {
            $this->context->smarty->assign('other_email_address_value', Tools::getValue('other_email_address'));
            $this->context->smarty->assign('other_email_datetime_value', Tools::getValue('other_email_datetime'));
            $this->context->smarty->assign('other_email_wishes_value', Tools::getValue('other_email_wishes'));

            Configuration::updateValue('WISH_OPTION', Tools::getValue('wish_form'));
            Configuration::updateValue('EMAIL_ADDRESS', Tools::getValue('other_email_address'));
            Configuration::updateValue('DELIVERY_DATE', Tools::getValue('other_email_datetime'));
            Configuration::updateValue('WISH_MESSAGE', Tools::getValue('other_email_wishes'));
        }

        // check sms validation
        if (Tools::getValue('wish_form') == "3") {
            $this->context->smarty->assign('sms_phone_number_value', Tools::getValue('sms_phone_number'));

            Configuration::updateValue('WISH_OPTION', Tools::getValue('wish_form'));
            Configuration::updateValue('PHONE_NUMBER', Tools::getValue('sms_phone_number'));
        }

        $this->validateForm();
    }

    public function hookActionObjectOrderAddBefore()
    {
        $this->validateForm();
    }

    public function hookActionObjectOrderAddAfter($params)
    {
        $dbDeliveryOptions = new DbDeliveryOptionsManagement();

        switch (Configuration::get('WISH_OPTION')) {
            case 1:
                $dbDeliveryOptions->setOptions(
                    $params['object']->id,
                    null,
                    Configuration::get('WISH_MESSAGE')
                );
                break;
            case 2:
                $dbDeliveryOptions->setOptions(
                    $params['object']->id,
                    Configuration::get('EMAIL_ADDRESS'),
                    Configuration::get('WISH_MESSAGE'),
                    null,
                    Configuration::get('DELIVERY_DATE')
                );
                break;
            case 3:
                $dbDeliveryOptions->setOptions(
                    $params['object']->id,
                    null,
                    null,
                    Configuration::get('PHONE_NUMBER')
                );
                break;
        }

        Configuration::deleteByName('WISH_MESSAGE');
        Configuration::deleteByName('EMAIL_ADDRESS');
        Configuration::deleteByName('PHONE_NUMBER');
        Configuration::deleteByName('DELIVERY_DATE');
        Configuration::deleteByName('WISH_OPTION');
    }

    public function validateForm()
    {
        // check other_email validation
        if (Configuration::get('WISH_OPTION') == "2") {
            if (!WishValidate::isEmail(Configuration::get('EMAIL_ADDRESS'))) {
                setcookie('wish_error', $this->l('Incorrect email address'), time() + 3600, "/", $_SERVER['SERVER_NAME']);
                // Tools::redirect('index.php?controller=order&step=3');
                Tools::redirect($_SERVER['HTTP_REFERER']);
            }

            if (Configuration::get('DELIVERY_DATE') && !WishValidate::isDate(Configuration::get('DELIVERY_DATE'))) {
                setcookie('wish_error', $this->l('Delivery date must be set at least one day after today'), time() + 3600, "/", $_SERVER['SERVER_NAME']);
                // Tools::redirect('index.php?controller=order&step=3');
                Tools::redirect($_SERVER['HTTP_REFERER']);
            }
        }

        // check sms validation
        if (Configuration::get('WISH_OPTION') == "3") {
            if (!WishValidate::isPhoneNumber(Configuration::get('PHONE_NUMBER'))) {
                setcookie('wish_error', $this->l('Incorrect phone number'), time() + 3600, "/", $_SERVER['SERVER_NAME']);
                // Tools::redirect('index.php?controller=order&step=3');
                Tools::redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function hookActionPresentCart()
    {
        if ($this->context->cart->getProducts() == null && Configuration::get('WISH_OPTION') != null) {
            Configuration::deleteByName('WISH_MESSAGE');
            Configuration::deleteByName('EMAIL_ADDRESS');
            Configuration::deleteByName('PHONE_NUMBER');
            Configuration::deleteByName('DELIVERY_DATE');
            Configuration::deleteByName('WISH_OPTION');
        }
    }
}
