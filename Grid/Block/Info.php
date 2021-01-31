<?php
namespace MR\Grid\Block;

class Info extends \Magento\Framework\View\Element\Template

{
    protected $_gridFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \MR\Grid\Model\GridFactory $gridFactory
    )
    {
        $this->_gridFactory = $gridFactory;
        parent::__construct($context);
    }


    public function getGridCollection()
    {
        $post = $this->_gridFactory->create();
        return $post->getCollection();
    }
}
