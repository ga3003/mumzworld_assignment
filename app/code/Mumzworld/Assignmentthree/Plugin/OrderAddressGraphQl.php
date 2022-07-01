<?php

namespace Mumzworld\Assignmentthree\Plugin;

use Magento\Sales\Api\Data\OrderInterface;

class OrderAddressGraphQl
{
    /**
     * Plugin to add area field in Order Shipping Address GraphQL query
     * @param \Magento\SalesGraphQl\Model\Order\OrderAddress $subject
     * @param callable $proceed
     * @param OrderInterface $order
     * @return array
     * 
     */
    public function aroundGetOrderShippingAddress(
        \Magento\SalesGraphQl\Model\Order\OrderAddress $subject,
        callable $proceed,
        OrderInterface $order
    ) {
        $result = $proceed($order);

        if (!empty($result) && is_array($result)) {
            $shippingAddress = $order->getShippingAddress();
            $result['area'] = $shippingAddress->getArea();
        }

        return $result;
    }

    /**
     * Plugin to add area field in Order Billinig Address GraphQL query
     * @param \Magento\SalesGraphQl\Model\Order\OrderAddress $subject
     * @param callable $proceed
     * @param OrderInterface $order
     * @return array
     * 
     */
    public function aroundGetOrderBillingAddress(
        \Magento\SalesGraphQl\Model\Order\OrderAddress $subject,
        callable $proceed,
        OrderInterface $order
    ) {
        $result = $proceed($order);

        if (!empty($result) && is_array($result)) {
            $address = $order->getBillingAddress();
            $result['area'] = $address->getArea();
        }

        return $result;
    }
}