<?php

namespace MR\Grid\Model\Jobs;

use MR\Grid\Model\ResourceModel\Grid\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $request;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        RequestInterface $request,
        DataPersistorInterface $dataPersistor,
        Registry $registry,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $contactCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->request = $request;
        $this->registry = $registry;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = [];
        $this->dataPersistor->set('name', $this->request->getParam('name'));
        foreach ($items as $item) {
            $tmp = $item->getData();
            $tmp['name'] = $this->request->getParam('name');
            $this->loadedData[$item->getId()]['job'] = $item->getData();
        }

        return $this->loadedData;

    }
}