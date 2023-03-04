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


class Wishdeliveryselection extends Module
{
    protected $config_form = false;
    public $test;

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

        return parent::install() &&
            $this->registerHook('displayAdminProductsExtra') &&
            $this->registerHook('actionObjectProductUpdateAfter') &&
            $this->registerHook('displayBeforeCarrier') &&
            $this->registerHook('actionObjectCartUpdateBefore') &&
            $this->registerHook('header');

            // actionCarrierProcess
    }

    public function uninstall()
    {
        include(dirname(__FILE__) . '/sql/uninstall.php');

        return parent::uninstall();
    }

    public function saveProductOptions()
    {
        $dbProductOptions = new DbProductOptionsManagement();
        $dbProductOptions->setOptions($_COOKIE["id_product"], (bool)$_COOKIE['registered_email'], (bool)$_COOKIE['other_email'], (bool)$_COOKIE['sms']);

        setcookie('id_product', "", time() - 3600);
        setcookie('sms', "", time() - 3600);
        setcookie('registered_email', "", time() - 3600);
        setcookie('other_email', "", time() - 3600);
    }

    public function hookDisplayAdminProductsExtra()
    {
        if ($_COOKIE['id_product']) {
            $this->saveProductOptions();
        }

        // fuck it shit happens, this is the moment when he knew... he fucked up
        global $kernel;
        $requestStack = $kernel->getContainer()->get('request_stack');
        $request = $requestStack->getCurrentRequest();
        $idProduct = $request->get('id');

        $dbProductOptions = new DbProductOptionsManagement();
        $productOptions = $dbProductOptions->getProductOptions($idProduct);

        $this->context->smarty->assign('productOptions', $productOptions);

        $this->context->smarty->assign('test', $idProduct);
        return $this->display(__FILE__, '/views/templates/admin/productwishselection.tpl');
    }

    public function hookActionObjectProductUpdateAfter($params)
    {
        setcookie('id_product', $params['object']->id, time() + 3600);

        setcookie('registered_email', Tools::getValue('registered_email', 0), time() + 3600);
        setcookie('other_email', Tools::getValue('other_email', 0), time() + 3600);
        setcookie('sms', Tools::getValue('sms', 0), time() + 3600);
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

        return $this->display(__FILE__, '/views/templates/admin/carrierwishselection.tpl');
    }

    public function getContent()
    {
        if (Tools::isSubmit('confirmDeliveryOption')) {
            dump('dupa');
            die;
        }
    }

    public function hookActionObjectCartUpdateBefore($params)
    {
        // dump(Tools::getAllValues());
        // die;
        // dump();
        // die;
        // Tools::redirect('index.php');

        if ($this->context->controller->php_self !== 'order') {
            return;
        }

        // check other_email validation
        if (Tools::getValue('wish_form') == "1") {
            if (!WishValidate::isEmail(Tools::getValue('other_email_address'))) {
                $this->context->controller->errors[] = $this->l('Incorrect email address');
            }

            if (Tools::getValue('other_email_datetime') && !WishValidate::isDate(Tools::getValue('other_email_datetime'))) {
                $this->context->controller->errors[] = $this->l('Delivery date must be set at least one day after today');
            }
        }

        // check sms validation
        if (Tools::getValue('wish_form') == "2") {
            if (!WishValidate::isPhoneNumber(Tools::getValue('sms_phone_number'))) {
                $this->context->controller->errors[] = $this->l('Incorrect phone number');
            }
        }
    }

    public function hookHeader()
    {
        if ($this->context->controller->php_self === 'order') {
            $this->context->controller->addJS($this->_path . 'views/js/carrierformslider.js');
        }
    }
}
