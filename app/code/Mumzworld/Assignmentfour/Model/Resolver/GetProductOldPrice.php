<?php

namespace Mumzworld\Assignmentfour\Model\Resolver;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mumzworld\Assignmentfour\Model\PriceDropFactory;

/**
 * Class to resolve custom old_price field in product GraphQL query
 */
class GetProductOldPrice implements ResolverInterface
{
    protected $priceDropFactory;

    protected $logger;

    public function __construct(
        PriceDropFactory $priceDropFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->priceDropFactory = $priceDropFactory;
        $this->logger = $logger;
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($value['model']) || !isset($value['entity_id'])) {
            throw new LocalizedException(__('"model" & "entity_id" value should be specified'));
        }

        $oldPrice = null;
        $priceDrop = $this->priceDropFactory->create()->load($value['entity_id'], 'product_id');
        if (!empty($priceDrop)) {
            $oldPrice = $priceDrop->getOldPrice();
        }

        return $oldPrice;
    }
}
