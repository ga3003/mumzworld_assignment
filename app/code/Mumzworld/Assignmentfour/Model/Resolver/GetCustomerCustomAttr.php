<?php

namespace Mumzworld\Assignmentfour\Model\Resolver;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * Customer subscribe_price_alert field resolver
 */
class GetCustomerCustomAttr implements ResolverInterface
{
    /**
     * @var Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepositoryInterface;

    protected $logger;

    /**
     * @param Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
     */
    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($value['model'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }
        /** @var CustomerInterface $customer */
        $customer = $value['model'];
        $customerId = (int) $customer->getId();
        $customerData = $this->customerRepositoryInterface->getById($customerId);

        /* Get customer custom attribute value */
        if ($customerData->getCustomAttribute('subscribe_price_drop')) {
            $customerAttributeVal = $customerData->getCustomAttribute('subscribe_price_drop')->getValue();
        } else {
            $customerAttributeVal = null;
        }

        return $customerAttributeVal;
    }
}