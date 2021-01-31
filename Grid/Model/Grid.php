<?php

namespace MR\Grid\Model;

use MR\Grid\Api\Data\JobInterface;
use Magento\Framework\Model\AbstractModel;
use MR\Grid\Model\ResourceModel\Grid as ResourceModel;


class Grid extends AbstractModel implements JobInterface
{

    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }


    public function getId()
    {
        return $this->_getData(self::ID);
    }


    public function setId($id)
    {
        $this->setData(self::ID, $id);
    }


    public function getName()
    {
        return $this->_getData(self::NAME);
    }

    public function setName($name)
    {
        $this->setData(self::NAME, $name);
    }


    public function getDescription()
    {
        return $this->_getData(self::DESCRIPTION);
    }


    public function setDescription($description)
    {
        $this->setData(self::DESCRIPTION, $description);
    }


    public function getShortDescription()
    {
        return $this->_getData(self::SHORT_DESCRIPTION);
    }


    public function setShortDescription($short_description)
    {
        $this->setData(self::SHORT_DESCRIPTION, $short_description);
    }


}