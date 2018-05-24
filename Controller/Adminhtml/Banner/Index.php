<?php
namespace Malesh\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
/**
* Index action
*
* @return void
*/

    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Malesh_Banner::banner');
        $resultPage->addBreadcrumb(__('Banner banners'), __('Banners'));
        $resultPage->addBreadcrumb(__('Manage Banner banners'), __('Manage banners'));
        $resultPage->getConfig()->getTitle()->prepend(__('Banner'));

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Malesh_Banner::banner');
    }
}