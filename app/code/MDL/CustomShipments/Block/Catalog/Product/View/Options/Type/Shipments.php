<?php
namespace MDL\CustomShipments\Block\Catalog\Product\View\Options\Type;

use MDL\CustomShipments\Model\ShipmentRepository;

class Shipments extends \Magento\Catalog\Block\Product\View\AbstractView
{
    /** @var ShipmentRepository */
    protected $shipmentRepository;


    /**
     * Shipments constructor.
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Stdlib\ArrayUtils $arrayUtils
     * @param array $data
     * @param ShipmentRepository $shipmentRepository
     */
    public function __construct(\Magento\Catalog\Block\Product\Context $context,
                                \Magento\Framework\Stdlib\ArrayUtils $arrayUtils,
                                array $data = [],
                                ShipmentRepository $shipmentRepository
    )
    {
        $this->shipmentRepository = $shipmentRepository;
        parent::__construct($context, $arrayUtils, $data);
    }

    /**
     * Determines if current product has chosen shipments
     * @return int
     */
    public function hasShippingOptions()
    {
        $product = $this->getProduct();
        return strlen($product->getMdlShipments());
    }

    /**
     * Return html for control element
     *
     * @return string
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function getValuesHtml()
    {
        $product = $this->getProduct();


        $selectHtml = '<div class="options-list nested" id="options-shipment-' . $product->getId() . '-list">';

        $options = explode(',', $product->getMdlShipments());
        $i = 0;
        foreach ($options as $option) {
            $optionInfo = $optionLabel = $this->shipmentRepository
                ->getByCode($option, $this->_storeManager->getStore()->getId());
            $optionLabel = $optionInfo->getName();
            $selectHtml .= '<div class="field choice admin__field admin__field-option required">' .
                '<input type="radio" id="shipment_' .
                $product->getId() . '_' . $i .
                '" class="'

                . 'radio admin__control-radio  required product-custom-option" name="shipment_' .
                $product->getId()
                .
                '" data-selector="shipment_' . $product->getId() . '"' .
                ' value="' 
                . $optionLabel 
                . '--'
                . $option 
                . '--'
                . $optionInfo->getBillingAddressTopLabel()
                . '--'
                . $optionInfo->getShippingAddressTopLabel()
                . '--'
                . $optionInfo->getIsSameAsBilling()
                . '"  /><label class="label admin__field-label" for="shipment_' .
                $product->getId() . '_' . $i .
                '">
                '
                . $optionLabel . '</span></label></div>';

            $i++;
        }
        $selectHtml .= '</div>';
        return $selectHtml;

    }
}