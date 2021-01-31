<?php
namespace MR\Grid\Model;

use Magento\Framework\Model\AbstractModel;

class Grid extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'mr_grid_jobs';

    protected $_cacheTag = 'mr_grid_jobs';

    protected $_eventPrefix = 'mr_grid_jobs';

    protected function _construct()
    {
        $this->_init('MR\Grid\Model\ResourceModel\Grid');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}