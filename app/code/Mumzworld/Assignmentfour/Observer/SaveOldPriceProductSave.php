<?php

namespace Mumzworld\Assignmentfour\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveOldPriceProductSave implements ObserverInterface
{
    protected $priceDropFactory;

    public function __construct(
        \Mumzworld\Assignmentfour\Model\PriceDropFactory $priceDropFactory
    ) {
        $this->priceDropFactory = $priceDropFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {        
        $product = $observer->getProduct();
        $oldPrice = $product->getOrigData('price');
        $newPrice = $product->getData('price');

        if ($oldPrice > $newPrice) {
            $priceDrop = $this->priceDropFactory->create();
            $priceDrop->setproductId($product->getId());
            $priceDrop->setOldPrice($oldPrice);
            $priceDrop->setNewPrice($newPrice);
            $priceDrop->save();
        }
    }
}