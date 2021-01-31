<?php

namespace MR\Grid\DataProvider;

use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Magento\Framework\App\Request\DataPersistorInterface;
use MR\Grid\Api\Data\JobInterface;
use MR\Grid\Model\ResourceModel\Job\Collection;
use ALevel\QuickOrder\Model\ResourceModel\Grid\CollectionFactory;


class JobProvider extends ModifierPoolDataProvider
{

    private $colleciton;


    private $dataPersistor;


    private $loadedData = [];

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $job) {
            $this->loadedData[$job->getId()] = $job->getData();
        }

        $data = $this->dataPersistor->get('description');
        if (!empty($data)) {
            $job = $this->collection->getNewEmptyItem();
            $job->setData($data);
            $this->loadedData[$job->getId()] = $job->getData();
            $this->dataPersistor->clear('description');
        }

        return $this->loadedData;
    }
}