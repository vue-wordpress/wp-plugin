# Official WordPress Plugin for Vue WordPress

<br>

We created official WordPress plugin to make working with WordPress Rest API much easier when using it with Vue WordPress.

<br>

## Launching with Docker

<br>

To launch WordPress with the plugin installed inside the Docker container:   

<br>

### 1. Clone the plugin from GitHub

<br>

```bash
git clone https://github.com/vue-wordpress/wp-plugin.git
```

<br>

### 2. Go to the cloned directory and run:

<br>

```bash
docker-compose up
```
<br>

Your WordPress will be accessible at `http://localhost:8080`

<br>

## Endpoints

<br>

### `GET /wp-json/vuewp/v1/menus/with-items`

<br>

Returns each menu **with items** (by default it was returned without items, so we were forced to do 1 + menus_amount requests)

<br>

### `GET /wp-json/vuewp/v1/menus/certain/<id/s or slug/s>`

<br>

Returns requested menu/s by ID/s or Slug/s.

<br>

### `GET /wp-json/vuewp/v1/meta`

<br>

Returns base site's meta. It is optimization of **/wp-json** from where we were getting **title** and **description**
From **~80KB** to **0.7KB**

<br>

### `GET /wp-json/vuewp/v1/post/<id>`
  
<br>

Returns requested post (everything in WP is post - page also) by ID or Slug.

<br>

### `GET /wp-json/vuewp/v1/posts/<id>`
  
<br>

Returns requested posts (a few) by ID or Slug, separated by commas.
