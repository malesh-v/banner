<?php
namespace Malesh\Banner\Model;

class Banner extends \Magento\Framework\Model\AbstractModel
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'ml_banner_records';

    /**
     * @var string
     */
    protected $_cacheTag = 'ml_banner_records';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'ml_banner_records';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Malesh\Banner\Model\ResourceModel\Banner');
    }

}