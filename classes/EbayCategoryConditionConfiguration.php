<?php

/*
 * 2007-2013 PrestaShop
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
 *  @copyright  2007-2013 PrestaShop SA
 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

class EbayCategoryConditionConfiguration
{
	const PS_CONDITION_NEW = 1;
	const PS_CONDITION_USED = 2;
	const PS_CONDITION_REFURBISHED = 3;

	public static function getPSConditions($condition_type = null)
	{
		$condition_types = array(
			EbayCategoryConditionConfiguration::PS_CONDITION_NEW => 'new',
			EbayCategoryConditionConfiguration::PS_CONDITION_USED => 'used',
			EbayCategoryConditionConfiguration::PS_CONDITION_REFURBISHED => 'refurbished'
		);

		if ($condition_type)
			return $condition_types[$condition_type];
		
		return $condition_types;
	}

	public static function replace($data)
	{
		foreach ($data as &$value)
			$value = pSQL($value);

		if (version_compare(_PS_VERSION_, '1.5', '>'))
			Db::getInstance()->insert('ebay_category_condition_configuration', $data, false, false, Db::REPLACE);
		else
			Db::getInstance()->execute('REPLACE INTO `'._DB_PREFIX_.'ebay_category_condition_configuration` (`'.implode('` , `', array_keys($data)).'`) VALUES (\''.implode('\', \'', $data).'\')');
	}
}