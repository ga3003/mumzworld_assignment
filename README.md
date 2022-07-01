# Assignment 1: Post Order SMS notification

- Initally we need to create Store configurations for all the credentials we need to call SMS Gateway API. Eg: Username, password, authkey, url etc. 
- Then we will create a Helper which will be responsible for API connection and wrapping logic for connection. (This can be replaced by any SMS gateway provider.)
- Then we will be having individual configuration for each order events in store configuration. It will be text field saving complete template with variables. Eg: "Thanks for placing order {order_id} with {item_counts} items."
- Helper will have one function send($mobileNumber, $event, $params). Function working:
  - Replace Variable in SMS template with params.
  - Call function responsible for API request.
  - Log response from indivdual SMS request.
  - If we want to see the Grid in admin, then we can use different approach to capture each response in DB and show in admin grid.
- To make our system faster and capable to send 1000 SMS every min, we will be using Messaging Queue to send SMS.
- Use messaging queue producers to push messages in queue from individual order events.
- Consumers will call the send function to send the SMS.


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
````
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
````

# Assignment 3: Add Area field to customer & order addresses.

This module adds area attribute in customer_address & order_address.
- Added custom customer attribute "area". After this it is visible in customer get Rest API & GraphQL query.
- Added custom columns to sales_order_address & quote_address table.
- Create quote_address & order_address extension attribute for area.
- Used extension attribute to save area in order journey from quote to order.
- Added extension_attrbute in OrderRepository to show them in RestAPI.
- Created Plugin to add area attribute in OrderAddress. Tried to achieve this by Resolver, but I guess there is miss in core code or this is limitation to not addd field in OrderAddress usiinig Resolver.
- Added step by step GraphQL queries in txt file inside module.

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
- GraphQL: 
  - subscribe_price_drop: Available in customer's query & mutation for add & edit.
  - old_price: Available in product's query.
  - Price drop can be displayed in cart page as well by using the cart or customerCart query.
