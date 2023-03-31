<?php

require_once(_PS_MODULE_DIR_ . '/wishdeliveryselection/wishdeliveryselection.php');
require_once(_PS_MODULE_DIR_ . '/wishdeliveryselection/classes/WishFormList.php');

class AdminWishFormController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'wishformlist';
        $this->className = 'wishFormList';
        $this->lang = false;
        $this->explicitSelect = true;
        $this->allow_export = true;
        $this->deleted = false;
        $this->identifier = 'id_product';
        $this->bulk_actions = true;
        $this->addRowAction('view');

        parent::__construct();

        $this->fields_list = array(
            'id_product' => array(
                'title' => $this->module->l('ID'),
                'width' => 120,
                'type' => 'text',
                'search' => false,
                'orderby' => false,
                'remove_onclick' => true
            ),
            'product_name' => array(
                'title' => $this->module->l('Product'),
                'width' => 120,
                'type' => 'text',
                'search' => true,
                'orderby' => false,
                'remove_onclick' => true
            ),
            'category_name' => array(
                'title' => $this->module->l('Category'),
                'width' => 140,
                'type' => 'text',
                'search' => true,
                'orderby' => false,
                'remove_onclick' => true
            ),
        );
    }

    public function init()
    {
        parent::init();
    }

    public function initContent()
    {
        parent::initContent();

        // after pressing "View" button in helperList
        if (Tools::getValue('id_product')) {
            $dbProductOptionsManagement = new DbProductOptionsManagement();
            $productOptions = $dbProductOptionsManagement->getProductOptions(Tools::getValue('id_product'));

            $this->context->smarty->assign([
                'registered_email' => $productOptions['registered_email'],
                'other_email' => $productOptions['other_email'],
                'sms' => $productOptions['sms'],
            ]);

            $content = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'wishdeliveryselection/views/templates/admin/selectedoptions.tpl');
            $this->context->smarty->assign('content', $this->content . $content);

            return;
        }

        // form under helperlist and validation
        $content = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'wishdeliveryselection/views/templates/admin/productwishselection.tpl');
        $this->context->smarty->assign([
            'content' => $this->content . $content,
            'registered_email' => Configuration::get(Wishdeliveryselection::REGISTERED_EMAIL_NAME),
            'other_email' => Configuration::get(Wishdeliveryselection::OTHER_EMAIL_NAME),
            'sms' => Configuration::get(Wishdeliveryselection::SMS_NAME),
        ]);

        if (((bool)Tools::isSubmit('submitWishdeliveryselectionModule')) == true) {
            Configuration::updateValue(Wishdeliveryselection::REGISTERED_EMAIL_NAME, Tools::getValue('registered_email'));
            Configuration::updateValue(Wishdeliveryselection::OTHER_EMAIL_NAME, Tools::getValue('other_email'));
            Configuration::updateValue(Wishdeliveryselection::SMS_NAME, Tools::getValue('sms'));

            $productOptions = new DbProductOptionsManagement();
            if (Tools::getValue('wishformlistBox')) {
                if (
                    $productOptions->setOptions(
                        Tools::getValue('wishformlistBox'),
                        Tools::getValue('registered_email'),
                        Tools::getValue('other_email'),
                        Tools::getValue('sms')
                    )
                ) {
                    $this->confirmations[] = ($this->l('Data was saved successfully'));
                }
            } else {
                $this->errors[] = ($this->l('There is nothing to add'));
            }
        }
    }
}
