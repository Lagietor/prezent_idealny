<?php

// class WishHelperList
// {
//     private $module;

//     public function __construct($module)
//     {
//         $this->module = $module;
//     }

//     public function renderList()
//     {
//         $fields_list = array(
//             'id_product' => array(
//                 'title' => $this->module->l('ID'),
//                 'width' => 120,
//                 'type' => 'text',
//                 'search' => false,
//                 'orderby' => false,
//             ),
//             'product_name' => array(
//                 'title' => $this->module->l('Product'),
//                 'width' => 120,
//                 'type' => 'text',
//                 'search' => true,
//                 'orderby' => false
//             ),
//             'category_name' => array(
//                 'title' => $this->module->l('Category'),
//                 'width' => 140,
//                 'type' => 'text',
//                 'search' => true,
//                 'orderby' => false
//             ),
//         );

//         $helper = new HelperList();

//         $helper->simple_header = false;

//         $helper->bulk_actions = true;
//         $helper->identifier = 'id_product';
//         $helper->show_toolbar = true;
//         $helper->title = $this->module->l('Choose products');
//         $helper->table = $this->module->name . '_products';

//         $helper->token = Tools::getAdminTokenLite('AdminModules');
//         $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->module->name;

//         $productName = (Tools::getValue('wishdeliveryselection_productsFilter_product_name'))
//         ? Tools::getValue('wishdeliveryselection_productsFilter_product_name') : null;

//         $categoryName = Tools::getValue('wishdeliveryselection_productsFilter_category_name')
//         ? Tools::getValue('wishdeliveryselection_productsFilter_category_name') : null;

//         if ((bool)Tools::isSubmit('submitResetwishdeliveryselection_products')) {
//             $query = $this->queryBuilder();
//         } else {
//             $query = $this->queryBuilder($productName, $categoryName);
//         }

//         $result = Db::getInstance()->executeS($query);
//         return $helper->generateList($result, $fields_list);
//     }

//     private function queryBuilder(string $productName = null, string $categoryName = null): string
//     {
//         $query = "SELECT DISTINCT
//         p.id_product, pl.name as 'product_name', p.id_category_default as 'id_category', pc.name as 'category_name' 
//         FROM " . _DB_PREFIX_ . "product p
//         JOIN " . _DB_PREFIX_ . "product_lang pl ON p.id_product = pl.id_product ";

//         if (isset($productName)) {
//             $query .= "AND pl.name LIKE '%$productName%' ";
//         }

//         $query .= 'JOIN ' . _DB_PREFIX_ . 'category_lang pc ON p.id_category_default = pc.id_category ';

//         if (isset($categoryName)) {
//             $query .= "AND pc.name LIKE '%$categoryName%' ";
//         }

//         $query .= 'ORDER BY p.id_product ASC';
//         return $query;
//     }
// }
