<?php
namespace MDL\CustomShipments\Model\ResourceModel;
class Shipment extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('mdl_customshipments_shipment','mdl_customshipments_shipment_id');
    }
}
