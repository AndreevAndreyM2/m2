<?php


namespace MR\Grid\Api\Repository;

use MR\Grid\Api\Data\JobInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;


interface JobRepositoryInterface
{

    public function getById(int $id): JobInterface;

    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    public function save(JobInterface $job): JobRepositoryInterface;

    public function delete(JobInterface $job): JobRepositoryInterface;

    public function deleteById(int $id): JobRepositoryInterface;
}