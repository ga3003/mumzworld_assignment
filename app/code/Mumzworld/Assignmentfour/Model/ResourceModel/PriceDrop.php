<?php
namespace Mumzworld\Assignmentfour\Model\ResourceModel;


class PriceDrop extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	
	protected function _construct()
	{
		$this->_init('price_drop_alert', 'value_id');
	}
}