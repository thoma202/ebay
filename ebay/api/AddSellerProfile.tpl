<?xml version="1.0" encoding="utf-8"?>
<addSellerProfileRequest xmlns="http://www.ebay.com/marketplace/selling/v1/services">
    <WarningLevel>High</WarningLevel>

    <shippingPolicyProfile>
        <categoryGroups>
            <categoryGroup>
                <default>false</default>
                <name>ALL</name>
            </categoryGroup>
        </categoryGroups>
        <profileName>2</profileName>
        <profileType>SHIPPING</profileType>
        <shippingPolicyInfo>
            <dispatchTimeMax>0</dispatchTimeMax>
        {foreach from=$national_services key=service_name item=services}
            {foreach from=$services item=service}
                {if $service.serviceCosts !== false}

                        <domesticShippingPolicyInfoService>
                            <freeShipping>false</freeShipping>
                            <shippingService>{$service_name|escape:'htmlall':'UTF-8'}</shippingService>
                            <shippingServiceAdditionalCost>{$service.serviceAdditionalCosts|escape:'htmlall':'UTF-8'}</shippingServiceAdditionalCost>
                            <shippingServiceCost>{$service.serviceCosts|escape:'htmlall':'UTF-8'}</shippingServiceCost>

                        </domesticShippingPolicyInfoService>



                {/if}
            {/foreach}
        {/foreach}
            {if !empty($international_services)}
            {foreach from=$international_services key=service_name item=services}
                {foreach from=$services item=service}
                    {if $service.serviceCosts !== false}
                         <intlShippingPolicyInfoService>
                            <freeShipping>false</freeShipping>
                            <shippingService>{$service_name|escape:'htmlall':'UTF-8'}</shippingService>
                            <shippingServiceAdditionalCost>{$service.serviceAdditionalCosts|escape:'htmlall':'UTF-8'}</shippingServiceAdditionalCost>
                            <shippingServiceCost>{$service.serviceCosts|escape:'htmlall':'UTF-8'}</shippingServiceCost>
                             {foreach from=$service.locationsToShip item=location}
                                 <shipToLocation>{$location.id_ebay_zone|escape:'htmlall':'UTF-8'}</shipToLocation>
                             {/foreach}
                        </intlShippingPolicyInfoService>

                    {/if}
                {/foreach}
            {/foreach}
            {/if}
            <shippingPolicyCurrency>{$currency_id|escape:'htmlall':'UTF-8'}</shippingPolicyCurrency>
            <domesticShippingType>Flat</domesticShippingType>
            <intlShippingType>Flat</intlShippingType>
        </shippingPolicyInfo>

        <shippingPolicyName>{$shipping_name}</shippingPolicyName>
        <siteId>{$ebay_site_id}</siteId>
    </shippingPolicyProfile>


</addSellerProfileRequest>