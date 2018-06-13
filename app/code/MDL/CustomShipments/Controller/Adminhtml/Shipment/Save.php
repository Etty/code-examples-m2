<?php
namespace MDL\CustomShipments\Controller\Adminhtml\Shipment;

use Magento\Backend\App\Action;
use MDL\CustomShipments\Model\Page;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
            
class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'MDL_CustomShipments::shipmentForm';

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = \MDL\CustomShipments\Model\Shipment::STATUS_ENABLED;
            }
            if (empty($data['mdl_customshipments_shipment_id'])) {
                $data['mdl_customshipments_shipment_id'] = null;
            }
            if (isset($data['store_id'][0])) {
                $data['store_id'] = (int)$data['store_id'][0];
            }


            /** @var \MDL\CustomShipments\Model\Shipment $model */
            $model = $this->_objectManager->create('MDL\CustomShipments\Model\Shipment');

            $id = $this->getRequest()->getParam('mdl_customshipments_shipment_id');
            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the shipment.'));
                $this->dataPersistor->clear('mdl_customshipments_shipment');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['mdl_customshipments_shipment_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }

            $this->dataPersistor->set('mdl_customshipments_shipment', $data);
            return $resultRedirect->setPath('*/*/edit', ['mdl_customshipments_shipment_id' => $this->getRequest()->getParam('mdl_customshipments_shipment_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }    
}
