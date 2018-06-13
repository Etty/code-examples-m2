<?php

namespace MDL\CustomShipments\Observer;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class CheckoutCartProductAddAfterObserver implements ObserverInterface
{
    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $_layout;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    protected $_request;
    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\View\LayoutInterface $layout
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\LayoutInterface $layout,
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $this->_layout = $layout;
        $this->_storeManager = $storeManager;
        $this->_request = $request;
    }
    /**
     * Add shipment info from custom option to cart
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        /* @var \Magento\Quote\Model\Quote\Item $item */
        $item = $observer->getQuoteItem();
        $additionalOptions = array();
        if ($additionalOption = $item->getOptionByCode('additional_options')){
            $additionalOptions = (array) unserialize($additionalOption->getValue());
        }
        $post = $this->_request->getParam('shipment_'.$item->getProduct()->getId());
        if ($post) {
            $values = explode('--', $post);
            $additionalOptions[] = [
                'label' => (string)__('Select Shipping Method'),
                'value' => $values[0],
                'code' => $values[1],
                'billing_address_top_label' => $values[2],
                'shipping_address_top_label' => $values[3],
                'is_same_as_billing' => $values[4],
            ];
        }

        if(count($additionalOptions) > 0)
        {
            $item->addOption(array(
                'code' => 'additional_options',
                'value' => serialize($additionalOptions),
                'product_id' => $item->getProduct()->getId()
            ));
        }
    }
}