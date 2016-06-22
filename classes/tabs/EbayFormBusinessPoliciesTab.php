<?php

class EbayFormBusinessPoliciesTab extends EbayTab
{
    public function getContent()
    {
        $url_vars = array(
            'id_tab' => '77',
            'section' => 'parameters'
        );
        if (version_compare(_PS_VERSION_, '1.5', '>')) {
            $url_vars['controller'] = Tools::getValue('controller');
        } else {
            $url_vars['tab'] = Tools::getValue('tab');
        }

        $url = $this->_getUrl($url_vars);
        $is_one_dot_five = version_compare(_PS_VERSION_, '1.5', '>');

                    
        $template_vars = array(
            'url_categories' => $url,
            'PAYEMENTS' => EbayBussinesPolicies::getPoliciesbyType('PAYMENT',$this->ebay_profile->id),
            'RETURN_POLICY' => EbayBussinesPolicies::getPoliciesbyType('RETURN_POLICY',$this->ebay_profile->id),
            'ebay_token' => Configuration::get('EBAY_SECURITY_TOKEN'),
            'isOneDotFive' => $is_one_dot_five,
            'id_tab' => Tools::getValue('id_tab'),
            'controller' => Tools::getValue('controller'),
            'tab' => Tools::getValue('tab'),
            'configure' => Tools::getValue('configure'),
            'tab_module' => Tools::getValue('tab_module'),
            'module_name' => Tools::getValue('module_name'),
            'token' => Tools::getValue('token'),
            'activation_bussines' =>  EbayConfiguration::get($this->ebay_profile->id,'EBAY_BUSINESS_POLICIES'),
            'ebay_categories' => EbayCategoryConfiguration::getEbayCategories($this->ebay_profile->id),
            'id_ebay_profile' => $this->ebay_profile->id,
        );
       

        return $this->display('form_business_policies.tpl', $template_vars);
        
    }

    public function postProcess()
    {
        // Save specifics
        if (Tools::getValue('payement') && Tools::getValue('return_policies')) {
           $var[] = array(
               'type' => 'EBAY_PAYMENT_POLICY',
               'id_bussines_Policie' => Tools::getValue('payement'),
           );
            $var[] = array(
                'type' => 'EBAY_RETURN_POLICY',
                'id_bussines_Policie' => Tools::getValue('return_policies'),
            );

            foreach ($var as $data){
                EbayBussinesPolicies::setBussinesPolicies($this->ebay_profile->id,$data);
            }
        }

        $ebay_categories = EbayCategoryConfiguration::getEbayCategories($this->ebay_profile->id);
        $payment = Tools::getValue('payement');
        $return = Tools::getValue('return_policies');
        foreach ($ebay_categories as $category){
            $data = array(
                'id_ebay_profile' => $this->ebay_profile->id,
                'id_category' => $category['id'],
                'id_return' => $return[$category['id']],
                'id_payment' => $payment[$category['id']],
            );
            EbayBussinesPolicies::deletePoliciesConfgbyidCategories($this->ebay_profile->id,$category['id']);

            if (version_compare(_PS_VERSION_, '1.5', '>')) {
                Db::getInstance()->insert('ebay_category_business_config', $data);
            } else{
                Db::getInstance()->autoExecute(_DB_PREFIX_.'ebay_category_specific', $data, 'INSERT');
            }
        }





        return $this->ebay->displayConfirmation($this->ebay->l('Settings updated'));
    }
    
    
    
    
}