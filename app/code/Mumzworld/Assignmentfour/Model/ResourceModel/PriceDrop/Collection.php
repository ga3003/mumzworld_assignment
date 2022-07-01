<?php
namespace Mumzworld\Assignmentfour\Model\ResourceModel\PriceDrop;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'value_id';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Mumzworld\Assignmentfour\Model\PriceDrop', 'Mumzworld\Assignmentfour\Model\ResourceModel\PriceDrop');
	}
}