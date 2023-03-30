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

$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'wishdeliveryselection_product_options` (
    `id` int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `id_product` int UNIQUE NOT NULL,
    `id_category` int NOT NULL,
    `registered_email` boolean NOT NULL DEFAULT 0,
    `other_email` boolean NOT NULL DEFAULT 0,
    `sms` boolean NOT NULL DEFAULT 0
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'wishdeliveryselection_orders` (
	`id` int PRIMARY KEY AUTO_INCREMENT NOT NULL,
	`id_order` int UNIQUE KEY NOT NULL,
    `email` text,
	`wish_message` text,
	`phone_number` text,
	`delivery_date` date
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = "CREATE OR REPLACE VIEW " . _DB_PREFIX_ . "wishformlist AS
        SELECT DISTINCT
        p.id_product, pl.name as 'product_name', p.id_category_default as 'id_category', pc.name as 'category_name' 
        FROM " . _DB_PREFIX_ . "product p
        JOIN " . _DB_PREFIX_ . "product_lang pl ON p.id_product = pl.id_product
        JOIN " . _DB_PREFIX_ . "category_lang pc ON p.id_category_default = pc.id_category
        ORDER BY p.id_product ASC";

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
