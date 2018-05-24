<?php
namespace Malesh\Banner\Controller\Adminhtml\Banner;

use Malesh\Banner\Model\Banner as Banner;

class NewAction extends \Magento\Backend\App\Action
{
    /**
     * Edit A banner Page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();

        $bannerDatas = $this->getRequest()->getParam('banner');
        if(is_array($bannerDatas)) {
            $banner = $this->_objectManager->create(Banner::class);
            $banner->setData($bannerDatas)->save();
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index');
        }
    }
}