<?php
namespace MR\Grid\Model\ResourceModel\Grid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'mr_grid_jobs_collection';
    protected $_eventObject = 'grid_collection';

    protected function _construct()
    {
        $this->_init('MR\Grid\Model\Grid', 'MR\Grid\Model\ResourceModel\Grid');
    }

}