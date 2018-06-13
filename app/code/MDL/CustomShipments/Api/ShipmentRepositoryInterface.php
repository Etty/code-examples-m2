<?php
namespace MDL\CustomShipments\Api;

use MDL\CustomShipments\Api\Data\ShipmentInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ShipmentRepositoryInterface 
{
    public function save(ShipmentInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(ShipmentInterface $page);

    public function deleteById($id);
}
