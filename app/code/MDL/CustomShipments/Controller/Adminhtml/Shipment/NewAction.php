<?php
namespace MDL\CustomShipments\Controller\Adminhtml\Shipment;

class NewAction extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'MDL_CustomShipments::shipmentForm';       
    protected $resultPageFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;        
        parent::__construct($context);
    }
    
    public function execute()
    {
        return $this->resultPageFactory->create();  
    }    
}
