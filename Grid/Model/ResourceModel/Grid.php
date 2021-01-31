<?php


namespace MR\Grid\Model\ResourceModel;


class Grid extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('mr_grid_jobs', 'id');
    }

}


