<?php

namespace Mumzworld\Assignmentfour\Cron;

class PriceDropAlert
{
    protected $priceDropCollection;

    public function __construct(
        \Mumzworld\Assignmentfour\Model\ResourceModel\PriceDrop\CollectionFactory $priceDropCollection
    ) {
       $this->priceDropCollection = $priceDropCollection;
    }

    /**
     * Calls when Cron for Price Drop is executed.
     * This will push alerts to the customers who have either wishlisted products or have products in active cart.
     *
     * @return void
     */
    public function pushAlert() {
        
    }
}