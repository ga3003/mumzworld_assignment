# Assignment 1: Post Order SMS notification

# Assignment 2: Product's Return Eligibility

This module will be responsible to manage the Return eligibility & time needed for return.
- A store configuration is added which will globally enable or disable the return label.
- A product attribute is added which will store the number of days needed for return of that product.

To disable the return label "Ex: Eligible for Returns within 7 days of delivery." follow below points:
- Initially, we need to check the store configuration. 
- If *is_returnable* is *true* then we have to show label.
    - Then check individual product
        - If the product attribute *is_returnable* > 0, then display label
        - Else return label should not be displayed for respective product.
- Else return label should not display for any product.

Use below query to get data using GraphQL

query{
  storeConfig {
    is_returnable
  }
  products(filter: {sku: {in:["24-MB01", "24-MB03"]}}){
    items{
      uid
      activity
      sku
      is_returnable
    }
    total_count
  }
}

# Assignment 3: Add Area field to customer & order addresses.

# Assignment 4: Price Drop Alert

This module will be responsible for sending alerts to the customers for the product's price drop. This work as below:
- Custom customer attribute is added, which will allow customers to enable or disable the alert.
- Custom product attribute is also added, which will allow admin to decide weather the alerts should be sent for those products or not.
- System configuration is added for managing alerts globally.
  - Status: This will globally enable/disable the price alert.
  - Threshold: This will manage threshold on which the alerts should be triggered. (Eg: When the price of product is dropped by 10%.)
  - Schedule: This will be responsible to trigger cron for the price dropped products to customers.
- Alert will be triggered to the customers who have price dropped products in their wishlist or cart.
- Created custom price_drop_alert table to keep old_price & new_price of the product. Reason to create custom table:
  - This will be having only limited data to be loaded whenever the cron is executed.
  - We can add another cron to clear old data of yesterday or according to the configuration we will create.
  - Here we can also save the perceentage change so that we can filter with threshold.
