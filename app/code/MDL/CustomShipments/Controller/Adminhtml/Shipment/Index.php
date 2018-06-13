<?php
namespace MDL\CustomShipments\Controller\Adminhtml\Shipment;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'MDL_CustomShipments::shipmentForm';  
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/index/index');
        return $resultRedirect;
    }     
}
