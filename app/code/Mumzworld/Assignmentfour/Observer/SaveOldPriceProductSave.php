<?php

namespace Mumzworld\Assignmentfour\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Mumzworld\Assignmentfour\Model\PriceDropFactory;
use Magento\Store\Model\ScopeInterface;

class SaveOldPriceProductSave implements ObserverInterface
{
    /**
     * @var PriceDropFactory $priceDropFactory
     * 
     */
    protected $priceDropFactory;

    /**
     * @var ScopeConfigInterface $scopeConfig
     * 
     */
    protected $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        PriceDropFactory $priceDropFactory
    ) {
        $this->priceDropFactory = $priceDropFactory;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Observer for the product save.
     * This will save old price & new price in the database table price_drop_alert
     * @param Observer $observer
     * 
     * @return void
     */
    public function execute(Observer $observer) {
        $priceDropStatus = $this->scopeConfig->getValue('catalog/price_drop/enable', ScopeInterface::SCOPE_STORE);
        // Check global configuration for price drop.
        if ($priceDropStatus) {
            return;
        }

        $product = $observer->getProduct();
        $productPriceDropStatus = $product->getData('price_drop_alert');
        // Check product level status for price drop.
        if ($productPriceDropStatus != 0) {
            return;
        }

        $oldPrice = $product->getOrigData('price');
        $newPrice = $product->getData('price');

        if ($oldPrice > $newPrice) {
            $priceDrop = $this->priceDropFactory->create();
            $priceDrop->setproductId($product->getId());
            $priceDrop->setOldPrice($oldPrice);
            $priceDrop->setNewPrice($newPrice);
            $priceDrop->setStoreId($product->getStoreId());
            $priceDrop->save();
        }
    }
}