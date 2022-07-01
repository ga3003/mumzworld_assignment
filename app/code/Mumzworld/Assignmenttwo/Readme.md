Assignment Two

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