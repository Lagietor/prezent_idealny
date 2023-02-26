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
            $this->registerHook('displayBackOfficeHeader');
    }

    public function uninstall()
    {
        include(dirname(__FILE__) . '/sql/uninstall.php');

        return parent::uninstall();
    }

    public function run()
    {
        if (!$_COOKIE["TestCock"]) {
            echo "brak cookie";
        } else {
            echo $_COOKIE["TestCock"];
            $db = new DbProductOptionsManagement($_COOKIE["TestCock"]);
            $db->setOptions(true, true, true);
            setcookie("TestCock", "", time() - 3600);
        }
    }

    public function hookDisplayAdminProductsExtra($params)
    {
        $this->context->smarty->assign('test', $this->test);
        return $this->display(__FILE__, '/views/templates/admin/productwishselection.tpl');
        setcookie("TestCock2", $this->context->smarty->get_template_vars('foo'), time() + 3600);
    }

    public function hookActionObjectProductUpdateAfter($params)
    {
        setcookie("TestCock", $params['object']->id, time() + 3600);
        $myfile = fopen(_PS_ROOT_DIR_ . '\log.txt', 'a');
        // foreach() {
        //     fwrite($myfile, "test");
        //     fwrite($myfile, "\n");
        // }
        fclose($myfile);
    }

    public function hookDisplayBackOfficeHeader($params)
    {
        $this->run();
        dump($_COOKIE["TestCock2"]);
    }
}
