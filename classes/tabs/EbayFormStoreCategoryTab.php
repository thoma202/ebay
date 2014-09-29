<?php

/*
 * 2007-2014 PrestaShop
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
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2014 PrestaShop SA
 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

class EbayFormStoreCategoryTab extends EbayTab
{

    function getContent()
    {

		$configs = Configuration::getMultiple(array('EBAY_CATEGORY_LOADED_'.$this->ebay_profile->ebay_site_id, 'EBAY_SECURITY_TOKEN'));
        
        $template_vars = array(
			'configs' => $configs,            
			'_path' => $this->path,            
			'controller' => Tools::getValue('controller'),
			'configure' => Tools::getValue('configure'),
			'token' => Tools::getValue('token'),
			'tab_module' => Tools::getValue('tab_module'),
			'module_name' => Tools::getValue('module_name'),
			'tab' => Tools::getValue('tab'),            
//            'form_store_categories' => $categories,
			'nb_categorie' => count(Category::getCategories($this->context->cookie->id_lang, true, false)),
            'has_store_categories' => EbayStoreCategory::hasStoreCategories(),
            'ebay_store_url' => EbayCountrySpec::getProUrlBySiteId($this->ebay_profile->ebay_site_id)
        );

		return $this->display('form_store_categories.tpl', $template_vars);
    }
    
    public function postProcess()
    {
        
		// Insert and update categories
        if ($store_categories = Tools::getValue('store_category')) {
            
            // cleanup Db for this profile
            EbayStoreCategoryConfiguration::deleteByIdEbayProfile($this->ebay_profile->id);
            
            // insert rows
            foreach($store_categories as $id_category => $ebay_category_id)
                if ($ebay_category_id)
                    EbayStoreCategoryConfiguration::insert($this->ebay_profile->id, $ebay_category_id, $id_category);

        }
        
        /*
		if (Tools::getValue('ajax'))
			die('{"valid" : true}');
        */

		return $this->ebay->displayConfirmation($this->ebay->l('Settings updated'));        
    }    

}