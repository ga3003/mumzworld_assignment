<?php

namespace Mumzworld\Assignmentthree\Observer;

use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class SaveAreaInOrderAddress implements ObserverInterface
{
    private $addressRepository;
    private $logger;

    public function __construct(
        AddressRepositoryInterface $addressRepository,
        LoggerInterface $logger
    ) {
        $this->addressRepository = $addressRepository;
        $this->logger = $logger;
    }

    /**
     * Add area values in Order billing & shiipping Address.
     * 
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $quoteShippingAddress = $observer->getQuote()->getShippingAddress();
        $quoteBillingAddress = $observer->getQuote()->getBillingAddress();
        try {
            $shippingArea = $quoteShippingAddress->getArea();
            $billingArea = $quoteBillingAddress->getArea();

            if ($shippingArea) {
                $this->updateAreaAttribute($quoteShippingAddress, $shippingArea);
                $orderShippingAddress = $observer->getOrder()->getShippingAddress();
                $orderShippingAddress->setArea($shippingArea);
            }

            if ($billingArea) {
                $orderBillingAddress = $observer->getOrder()->getBillingAddress();
                $orderBillingAddress->setArea($shippingArea);
            }
            return $this;
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }
    }

    /**
     * Update area arrtribute value in customer address if exist.
     * @param $quoteShippingAddress
     * @param $area
     * 
     */
    private function updateAreaAttribute($quoteShippingAddress, $area)
    {
        $customerAddressId = $quoteShippingAddress->getCustomerAddressId();
        if (isset($customerAddressId)) {
            $address = $this->addressRepository->getById($customerAddressId);
            $oldArea = $address->getCustomAttribute('area');
            if (!$oldArea) {
                $address->setCustomAttribute('area', $area);
                $this->addressRepository->save($address);
            }
        }
    }
}