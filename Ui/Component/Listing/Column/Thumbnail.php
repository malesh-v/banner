<?php
namespace Malesh\Banner\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{

    private $_getModel;

    private $imageHelper;

    public $urlBuilder;
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Malesh\Banner\Model\Banner\ImageUploader $imageHelper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Malesh\Banner\Model\Banner\ImageUploader $imageHelper,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Malesh\Banner\Model\Banner $model,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->imageHelper = $imageHelper;
        $this->urlBuilder = $urlBuilder;
        $this->_getModel = $model;
    }

/**
 * Prepare Data Source
 *
 * @param array $dataSource
 * @return array
 */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if($item['img']){
                    $filename = $item['img'];

                    $item[$fieldName . '_src'] = $this->imageHelper->getBaseUrl() .
                        $this->imageHelper->getBasePath() . '/' . $filename;
                    $item[$fieldName . '_link'] = $this->urlBuilder->getUrl('malesh/banner/edit/', ['id' => $item['id']] );
                    $item[$fieldName . '_orig_src'] = $this->imageHelper->getBaseUrl() .
                        $this->imageHelper->getBasePath() . '/' . $filename;
                }
            }
        }
        return $dataSource;
    }
}