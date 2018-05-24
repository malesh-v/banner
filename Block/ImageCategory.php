<?php
namespace Malesh\Banner\Block;

use Magento\Framework\View\Element\Template;
use Malesh\Banner\Model\ResourceModel\Banner\CollectionFactory;

class ImageCategory extends \Magento\Framework\View\Element\Template
{
    protected $bannerCollection;
    protected $mediaUrl;
    protected $html;
    protected $scopeConfig;

    public function __construct
    (
        Template\Context $context,
        CollectionFactory $bannerCollectionFactory,
        \Malesh\Banner\Model\Banner\ImageUploader $imageUploader,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->mediaUrl = $imageUploader->getBaseUrl();
        $this->bannerCollection = $bannerCollectionFactory->create();
        parent::__construct($context, $data);
    }

    public function getCategoryId()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $currentCategory = $objectManager
            ->get('Magento\Framework\Registry')
            ->registry('current_category');
        return $currentCategory->getId();
    }

    public function getImages()
    {
        $bannerCollection = $this->bannerCollection
            ->addFieldToSelect('img')
            ->addFieldToFilter('category_id', $this->getCategoryId())
            ->load();

        foreach ($bannerCollection as $banner){
            if($banner->getImg()){
                $this->html .= '<img src="'. $this->mediaUrl . 'banner/img/' . $banner->getImg() . '">';
            }
        }

        return $this->getStatus() ? $this->html : null;
    }
    
    public function getStatus()
    {
        return $this->scopeConfig->getValue('bannerset/general/enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}