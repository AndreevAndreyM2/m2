<?php

namespace MR\Grid\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use MR\Grid\Model\Grid;
use Magento\Backend\Model\Session;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends Action
{
    protected $session;
    protected $gridModel;

    public function __construct(
        Context $context,
        Grid $gridModel,
        Session $session,
        DataPersistorInterface $dataPersistor
    )
    {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->gridModel = $gridModel;
        $this->session = $session;
    }

    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getPostValue('grid');
        $model = $this->gridModel;
        $nameId = $this->dataPersistor->get('name');
        $data['name'] = $nameId;

        try {
            $this->session->setFormData($data);

            if (!$data['name']) {
                throw new \Exception(__('select a name.'));
            }

            $model->setData($data)->save();

            $this->messageManager->addSuccess(__('Saved.'));

            $this->session->setFormData(false);

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), 'name' => $data['name'], '_current' => true]);
            }

        } catch (\Exception $e) {
            $this->messageManager->addException($e, __($e->getMessage()));
            return $resultRedirect->setUrl($this->_redirect->getRefererUrl());;
        }

        return $resultRedirect->setPath('*/*/', ['name' => $data['name'], '_current' => true]);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MR_Grid::jobs');
    }
}