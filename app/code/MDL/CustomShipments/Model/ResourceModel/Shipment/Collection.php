<?php
namespace MDL\CustomShipments\Model\ResourceModel\Shipment;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('MDL\CustomShipments\Model\Shipment','MDL\CustomShipments\Model\ResourceModel\Shipment');
    }
}
