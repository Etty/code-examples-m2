<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MDL\CustomShipments\Model\Checkout;

use Magento\Catalog\Helper\Product\ConfigurationPool;
use Magento\Checkout\Helper\Data as CheckoutHelper;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Model\Url as CustomerUrlManager;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Locale\FormatInterface as LocaleFormat;
use Magento\Framework\UrlInterface;
use Magento\Quote\Api\CartItemRepositoryInterface as QuoteItemRepository;
use Magento\Quote\Api\CartTotalRepositoryInterface;
use Magento\Quote\Api\ShippingMethodManagementInterface as ShippingMethodManager;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Store\Model\ScopeInterface;


class DefaultConfigProvider extends \Magento\Checkout\Model\DefaultConfigProvider
{
    /**
     * @var ConfigurationPool
     */
    private $configurationPool;
    
    public function __construct(CheckoutHelper $checkoutHelper, 
                                CheckoutSession $checkoutSession,
                                CustomerRepository $customerRepository,
                                CustomerSession $customerSession, 
                                CustomerUrlManager $customerUrlManager,
                                HttpContext $httpContext, 
                                \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
                                QuoteItemRepository $quoteItemRepository, 
                                ShippingMethodManager $shippingMethodManager,
                                ConfigurationPool $configurationPool, 
                                QuoteIdMaskFactory $quoteIdMaskFactory, 
                                LocaleFormat $localeFormat, 
                                \Magento\Customer\Model\Address\Mapper $addressMapper, 
                                \Magento\Customer\Model\Address\Config $addressConfig,
                                FormKey $formKey, 
                                \Magento\Catalog\Helper\Image $imageHelper, 
                                \Magento\Framework\View\ConfigInterface $viewConfig, 
                                \Magento\Directory\Model\Country\Postcode\ConfigInterface $postCodesConfig,
                                \Magento\Checkout\Model\Cart\ImageProvider $imageProvider,
                                \Magento\Directory\Helper\Data $directoryHelper, 
                                CartTotalRepositoryInterface $cartTotalRepository, 
                                ScopeConfigInterface $scopeConfig, 
                                \Magento\Shipping\Model\Config $shippingMethodConfig, 
                                \Magento\Store\Model\StoreManagerInterface $storeManager, 
                                \Magento\Quote\Api\PaymentMethodManagementInterface $paymentMethodManagement, 
                                UrlInterface $urlBuilder)
    {
        $this->configurationPool = $configurationPool;
        parent::__construct($checkoutHelper, $checkoutSession, $customerRepository, $customerSession, $customerUrlManager, $httpContext, $quoteRepository, $quoteItemRepository, $shippingMethodManager, $configurationPool, $quoteIdMaskFactory, $localeFormat, $addressMapper, $addressConfig, $formKey, $imageHelper, $viewConfig, $postCodesConfig, $imageProvider, $directoryHelper, $cartTotalRepository, $scopeConfig, $shippingMethodConfig, $storeManager, $paymentMethodManagement, $urlBuilder);
    }

    /**
     * Retrieve formatted item options view
     *
     * @param \Magento\Quote\Api\Data\CartItemInterface $item
     * @return array
     */
    protected function getFormattedOptionValue($item)
    {
        $optionsData = [];
        $options = $this->configurationPool->getByProductType($item->getProductType())->getOptions($item);
        foreach ($options as $index => $optionValue) {
            /* @var $helper \Magento\Catalog\Helper\Product\Configuration */
            $helper = $this->configurationPool->getByProductType('default');
            $params = [
                'max_length' => 55,
                'cut_replacer' => ' <a href="#" class="dots tooltip toggle" onclick="return false">...</a>'
            ];
            $option = $helper->getFormattedOptionValue($optionValue, $params);
            $optionsData[$index] = $option;
            $optionsData[$index]['label'] = $optionValue['label'];
            if (isset($optionValue['code'])) {
                $optionsData[$index]['code'] = $optionValue['code'];
            }
            if (isset($optionValue['billing_address_top_label'])) {
                $optionsData[$index]['billing_address_top_label'] = $optionValue['billing_address_top_label'];
            }
            if (isset($optionValue['shipping_address_top_label'])) {
                $optionsData[$index]['shipping_address_top_label'] = $optionValue['shipping_address_top_label'];
            }
            if (isset($optionValue['is_same_as_billing'])) {
                $optionsData[$index]['is_same_as_billing'] = $optionValue['is_same_as_billing'];
            }
        }
        return $optionsData;
    }
}
