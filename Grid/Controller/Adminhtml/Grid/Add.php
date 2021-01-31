<?php

namespace MR\Grid\Controller\Adminhtml\Grid;
use Magento\Framework\Controller\ResultFactory;
class Add extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Add New Job'));
        return $resultPage;
    }
}