<?php
namespace Malesh\Banner\Model\Banner;

use Malesh\Banner\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface as StoreManager;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $bannerCollectionFactory
     * @param StoreManager $storeManager
     * @param array $meta
     * @param array $data
     */

    private $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        StoreManager $storeManager,
        CollectionFactory $bannerCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $bannerCollectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();

        foreach ($items as $banner) {
            $this->loadedData[$banner->getId()] = $banner->getData();

            if ($banner->getImg()) {
                $image['img'][0]['name'] = $banner->getImg();
                $image['img'][0]['url'] = $this->getMediaUrl(). 'banner/img/' .$banner->getImg();
                $fullData = $this->loadedData;
                $this->loadedData[$banner->getId()] = array_merge($fullData[$banner->getId()], $image);
            }
        }
        return $this->loadedData;
    }

    public function getMediaUrl()
    {
        return $this->storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
}