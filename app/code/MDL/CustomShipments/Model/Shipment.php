<?php
namespace MDL\CustomShipments\Model;
class Shipment extends \Magento\Framework\Model\AbstractModel implements \MDL\CustomShipments\Api\Data\ShipmentInterface,
    \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'mdl_customshipments_shipment';

    protected function _construct()
    {
        $this->_init('MDL\CustomShipments\Model\ResourceModel\Shipment');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
