<?php

namespace MR\Grid\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;

class Add extends Action
{
    public function execute()
    {
        $this->_forward('edit');
    }
}
