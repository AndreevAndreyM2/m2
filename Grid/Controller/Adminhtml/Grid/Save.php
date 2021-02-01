<?php

namespace MR\Grid\Controller\Adminhtml\Grid;

use MR\Grid\Api\Data\JobInterfaceFactory;
use MR\Grid\Api\Repository\JobRepositoryInterface;
use MR\Grid\Model\Grid;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;


class Save extends Action
{

    private $repository;

    private $modelFactory;

    private $dataPersistor;

    private $logger;


    public function __construct(
        Context $context,
        JobRepositoryInterface $repository,
        JobInterfaceFactory $modelFactory,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger
    )
    {
        $this->repository = $repository;
        $this->modelFactory = $modelFactory;
        $this->dataPersistor = $dataPersistor;
        $this->logger = $logger;

        parent::__construct($context);
    }


    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getPostValue()['job'];
        if ($data) {
            $model = $this->modelFactory->create();

            $id = $this->getRequest()->getParam('id');


            $model->setDescription(strip_tags($data['description']));
            $model->setName(strip_tags($data['name']));
            $model->setShortDescription(strip_tags($data['short_description']));

            try {
                $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the job.'));
                $this->dataPersistor->clear('id');
                return $this->processReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the job.'));
            }

            $this->dataPersistor->set('id', $data);
            return $resultRedirect->setPath('*/*/', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    private function processReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/', ['id' => $model->getId()]);
        } else if ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
