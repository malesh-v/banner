<?php

namespace Malesh\Banner\Model\ResourceModel\Banner;

class Collection
    extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        parent::_construct();
        $this->_init(
            'Malesh\Banner\Model\Banner',
            'Malesh\Banner\Model\ResourceModel\Banner'
        );
    }
}