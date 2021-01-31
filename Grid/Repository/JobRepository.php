<?php

namespace MR\Grid\Repository;

use MR\Grid\Api\Data\JobInterface;
use MR\Grid\Api\Repository\JobRepositoryInterface;
use MR\Grid\Model\ResourceModel\Grid as ResourceModel;
use MR\Grid\Model\ResourceModel\Status\Collection;
use MR\Grid\Model\ResourceModel\Grid\CollectionFactory;
use MR\Grid\Model\GridFactory as ModelFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;


class JobRepository implements JobRepositoryInterface
{

    private $resource;


    private $modelFactory;


    private $collectionFactory;


    private $processor;

    private $searchResultFactory;


    public function __construct(
        ResourceModel $resource,
        ModelFactory $modeFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultFactory
    )
    {
        $this->resource = $resource;
        $this->modelFactory = $modeFactory;
        $this->collectionFactory = $collectionFactory;
        $this->processor = $collectionProcessor;
        $this->searchResultFactory = $searchResultFactory;
    }


    public function getById($id): JobInterface
    {
        $job = $this->modelFactory->create();

        $this->resource->load($job, $id);

        if (empty($job->getId())) {
            throw new NoSuchEntityException(__("Job %1 not found", $id));
        }

        return $job;
    }


    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        $this->processor->process($searchCriteria, $collection);

        $searchResult = $this->searchResultFactory->create();

        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setItems($collection->getItems());

        return $searchResult;
    }


    public function save(JobInterface $job): JobInterface
    {
        try {
            $this->resource->save($job);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__("Job could not save"));
        }

        return $job;
    }

    public function delete(JobInterface $job): JobRepositoryInterface
    {
        try {
            $this->resource->delete($job);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException("Job not delete");
        }

        return $this;
    }

    public function deleteById(int $id): JobRepositoryInterface
    {
        $job = $this->getById($id);
        $this->delete($job);

        return $this;
    }
}