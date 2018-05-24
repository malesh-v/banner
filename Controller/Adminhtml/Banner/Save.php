<?php
namespace Malesh\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{
    protected $uploaderFactory;
    protected $imageModel;
 
    public function __construct(
        Action\Context $context,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Malesh\Banner\Model\Banner\ImageUploader $imageModel
    )
    {
        $this->uploaderFactory = $uploaderFactory;
        $this->imageModel = $imageModel;
        parent::__construct($context);
    }
    
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Malesh_banner::banner');
    }
    
    public function getId()
    {
        return $this->getRequest()->getParam('id');
    }

    public function getCategoryData($data)
    {
         $id = $data['category_id'];
         $data['category_name'] = $this->_objectManager
             ->create('Magento\Catalog\Model\Category')
             ->load($id)
             ->getName();

        return $data;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try{
                $model = $this->_objectManager
                    ->create('Malesh\Banner\Model\Banner');

                if($data['id']) $model->load($data['id']);
                else unset($data['id']);

                if(isset($data['img'])){
                    $data['img'] = $data['img'][0]['name'];
                    if($data['img'] !== $model->getImg()) $this->imageModel->moveFileFromTmp($data['img']);
                }
                else $data['img'] = '';

                if(isset($data['category_id'])) $data = $this->getCategoryData($data);

                $model->setData($data);
                $model->save();

                $this->messageManager->addSuccess(__('Successfully saved the banner.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getId()]);
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
