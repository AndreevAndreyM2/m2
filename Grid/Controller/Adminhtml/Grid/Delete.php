<?php

namespace MR\Grid\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use MR\Grid\Model\Grid;

class Delete extends Action
{
    protected $gridModel;

    public function __construct(
        Action\Context $context,
        Grid $gridModel
    ) {
        parent::__construct($context);
        $this->gridModel = $gridModel;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MR_Grid::jobs');
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $model = $this->gridModel;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Job deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addError(__('Job does not exist'));

        return $resultRedirect->setPath('*/*/');
    }
}