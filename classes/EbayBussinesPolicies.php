<?php

Class EbayBussinesPolicies {


    public static function getPoliciesbyType($type,$id_ebay_profile){

       return Db::getInstance()->executeS('SELECT name, id_bussines_Policie FROM '._DB_PREFIX_.'Ebay_Business_Policies WHERE type ="'.$type.'" AND id_ebay_profile='.$id_ebay_profile);

    }

    public static function setBussinesPolicies($id_ebay_profile,$var){
       
        EbayConfiguration::set($id_ebay_profile,$var['type'],$var['id_bussines_Policie']);

    }

    public static function getPoliciesConfigurationbyIdCategory($id_category,$id_ebay_profile){


        return Db::getInstance()->executeS('SELECT id_return, id_payment FROM '._DB_PREFIX_.'ebay_category_business_config WHERE id_category ="'.$id_category.'" AND id_ebay_profile='.$id_ebay_profile);

    }
    
    public function resetBussinesPolicies($id_ebay_profile){

        if(Db::getInstance()->execute('DELETE FROM'._DB_PREFIX_.'Ebay_Business_Policies_configuration WHERE id_ebay_profile='.$id_ebay_profile)){
            EbayRequest::importBusinessPolicies();
        } else {
            return false;
        }
        
    }

    public static function getPoliciesbyID($id_bussines_Policie,$id_ebay_profile){
        return Db::getInstance()->executeS('SELECT name FROM '._DB_PREFIX_.'Ebay_Business_Policies WHERE id_bussines_Policie ="'.$id_bussines_Policie.'" AND id_ebay_profile='.$id_ebay_profile);

    }
    public static function getPoliciesbyName($name,$id_ebay_profile){

        return Db::getInstance()->executeS('SELECT name, id_bussines_Policie FROM '._DB_PREFIX_.'Ebay_Business_Policies WHERE name ="'.$name.'" AND id_ebay_profile='.$id_ebay_profile);

    }
    public  static function  deletePoliciesConfgbyidCategories($id_ebay_profile,$id_category){
        return Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'ebay_category_business_config WHERE id_ebay_profile = "'.$id_ebay_profile.'" AND id_category ="'.$id_category.'"');

    }

}