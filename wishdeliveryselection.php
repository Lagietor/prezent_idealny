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
            $this->registerHook('displayBackOfficeHeader');
    }

    public function uninstall()
    {
        include(dirname(__FILE__) . '/sql/uninstall.php');

        return parent::uninstall();
    }

    public function run()
    {
        $db = new DbProductOptionsManagement($_COOKIE["id_product"]);
        $db->setOptions((bool)$_COOKIE['registered_email'], (bool)$_COOKIE['other_email'], (bool)$_COOKIE['sms']);

        setcookie('id_product', "", time() - 3600);
        setcookie('sms', "", time() - 3600);
        setcookie('registered_email', "", time() - 3600);
        setcookie('other_email', "", time() - 3600);
    }

    public function hookActionAdminControllerSetMedia($params)
    {
        file_put_contents(_PS_ROOT_DIR_ . '\log.txt', print_r($params, true));
    }

    public function hookDisplayAdminProductsExtra()
    {
        if ($_COOKIE['id_product']) {
            $this->run();
        }

        // fuck it shit happens, this is the moment when he knew... he fucked up
        global $kernel;
        $requestStack = $kernel->getContainer()->get('request_stack');
        $request = $requestStack->getCurrentRequest();
        $idProduct = $request->get('id');

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

    public function hookDisplayBackOfficeHeader($params)
    {
        global $kernel;
        $requestStack = $kernel->getContainer()->get('request_stack');
        $request = $requestStack->getCurrentRequest();
        $idProduct = $request->get('id');

        // dump($idProduct);
    }

    public function hookDisplayBeforeCarrier($params)
    {
        return $this->display(__FILE__, '/views/templates/admin/carrierwishselection.tpl');
    }
}
