<?php
/*
Plugin Name: Vue-Wordpress Optimizer
Version: 0.0.1
Description: Optimize endpoints for Vue-Wordpress module
Author: Filip Jędrasik
Author URI: https://github.com/Fifciu
*/

require_once "util/GetFlushedValue.php";
require_once "util/ObtainKeys.php";
require_once "util/BuildTree.php";

require_once "modules/Menu.php";
require_once "modules/Meta.php";
require_once "modules/Page.php";

function vueWpPageList () {
    $data = GetFlushedValue(function () {
        wp_list_pages('title');
    });

    $response = new WP_REST_Response($data);
    $response->set_status(200);

    return $response;
}

add_action('rest_api_init', function () {

    // Getting all menus with items
    register_rest_route('vuewp/v1', '/menus/with-items', array(
        'methods' => 'GET',
        'callback' => 'VWP\Menu\withItems',
    ) );

    register_rest_route('vuewp/v1', '/menus/certain/(?P<id>.*)', array(
        'methods' => 'GET',
        'callback' => 'VWP\Menu\fewItems',
    ) );

    // wp-json optimized
    register_rest_route('vuewp/v1', '/meta', array(
        'methods' => 'GET',
        'callback' => 'VWP\Meta\baseMeta',
    ) );

    register_rest_route('vuewp/v1', '/page/(?P<id>[a-zA-Z0-9_-]+)', array(
        'methods' => 'GET',
        'callback' => 'VWP\Page\fetch',
    ) );

    register_rest_route('vuewp/v1', '/post/(?P<id>[a-zA-Z0-9_-]+)', array(
        'methods' => 'GET',
        'callback' => 'VWP\Page\fetch',
    ) );
} );