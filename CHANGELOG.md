## First Commit

- Set up Laravel App
- Set up env files
- Set up api.php constant file to define woocommerce constants required for API call
- Added BaseApiController for base response
- Added versioning API 

## Second commit

- Added Order and LineItem migration and model files.
- Added Constants files
- Added Controller,Service,Repository Classes for Order element.
- Updated unused migrations

## Third Commit

- Added Cron job to run every 12 am for syncing woo order
- Added command called `app:sync-woo-order` for syncing orders from Woo-Commerce API
- Updated WooCommerceService to handle pagination and per_page attributes.
- Updaated line item migration file since nullable fields are not specified
- Added woo_order_id and woo_line_item_id in order and line item table respectively for tracking woo_commerce data

## Fourth Commit

- Updated pagination in Get Order List REST API 
- Updated search in Order via `number,order_key,customer_note`
- Updated README.md for readme in github

## Fifth Commit
- Updated BaseRepository and BaseRepositoryInterface classes for order by and removed unnecessary code
- Updated .env.example and added sample for all required environment variables

## Sixth Commit
- Updated routes in README.md
- Added filter,search,order in order API