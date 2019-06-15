# api-optimize
Wordpress' plugin which extends Rest API to make core plugin faster

## Endpoints

### GET /wp-json/vuewp/v1/menus/with-items
Returns each menu **with items** (by default it was returned without items, so we were forced to do 1 + menus_amount requests)