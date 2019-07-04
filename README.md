# api-optimize
Wordpress' plugin which extends Rest API to make core plugin faster

## Docker's instructions
For launch Wordpress with plugin in the container just:   
1. Clone the plugin   
2. Go in and run **docker-compose up**   
And it will be accessible under **localhost:8080**   

## Endpoints

### GET /wp-json/vuewp/v1/menus/with-items
Returns each menu **with items** (by default it was returned without items, so we were forced to do 1 + menus_amount requests)

### GET /wp-json/vuewp/v1/menus/certain/<id/s or slug/s>
Returns requested menu/s by ID/s or Slug/s.

### GET /wp-json/vuewp/v1/meta
Returns base site's meta. It is optimization of **/wp-json** from where we were getting **title** and **description**
From **~80KB** to **0.7KB**

### GET /wp-json/vuewp/v1/page/<id/slug>
Returns requested page by ID or Slug.

### GET /wp-json/vuewp/v1/post/<id>
Returns requested post by ID or Slug.