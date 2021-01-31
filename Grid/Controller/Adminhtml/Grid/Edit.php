<?php

namespace MR\Grid\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use MR\Grid\Model\Grid;
use Magento\Backend\Model\Session;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\App\Action
{
    protected $_coreRegistry = null;
    protected $resultPageFactory;
    protected $gridModel;
    protected $session;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        Grid $gridModel,
        Session $session
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->session = $session;
        $this->gridModel = $gridModel;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MR_Grid::jobs');
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MR_Grid::jobs')
            ->addBreadcrumb(__('Career'), __('Career'))
            ->addBreadcrumb(__('Jobs'), __('Jobs'))
            ->addBreadcrumb(__('Edit'), __('Edit'));

        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->gridModel;

        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->session->getFormData();

        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('job_item', $model);
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Career'));
        $resultPage->getConfig()->getTitle()->prepend(__('Jobs'));
        $resultPage->getConfig()->getTitle()->prepend(__('Edit'));

        return $resultPage;
    }
}
