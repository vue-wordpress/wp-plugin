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

/**
 * Get title and description
 * @return Object with title and description
 */

function vueWpBaseMeta () {
    $data = new stdClass;
    $data->title = GetFlushedValue(function () {
        bloginfo('title');
    });
    $data->description = GetFlushedValue(function () {
        bloginfo('description');
    });

    $response = new WP_REST_Response($data);
    $response->set_status(200);

    return $response;
  }
  
/**
 * Get all registered menus
 * @return array List of menus with slug and description
 */
function vueWpMenuWithItems ($request) {
    $menus = get_terms('nav_menu', array('hide_empty' => true ) );
    foreach($menus as $key => $menu) {
        // check if there is acf installed

        if ($request['boost']) {
            unset($menus[$key]->term_group);
            unset($menus[$key]->term_taxonomy_id);
            unset($menus[$key]->taxonomy);
            unset($menus[$key]->parent);
            unset($menus[$key]->count);
            unset($menus[$key]->filter);
        }

        if( class_exists('acf') ) {
            $fields = get_fields($menu);
            if(!empty($fields)) {
                foreach($fields as $field_key => $item) {
                    // add all acf custom fields
                    $menus[$key]->$field_key = $item;
                }
            }
        }

        $menus[$key]->items = wp_api_v2_menus_get_menu_items($menus[$key]->term_id, $request['boost']);
    }

    return $menus;
}

/**
 * Retrieve items for a specific menu
 * @param $id Menu id
 * @return array List of menu items
 */
function wp_api_v2_menus_get_menu_items ($id, $boosted) {
    $menu_items = wp_get_nav_menu_items($id);
    // wordpress does not group child menu items with parent menu items
    $child_items = [];
    // pull all child menu items into separate object

    // ObtainKeys($menu_items[$key], [
        //         //     "ID",
        //         //     "child_items",
        //         //     "menu_item_parent",
        //         //     "classes",
        //         //     "description",
        //         //     "attr_title"
        //         // ]);

    buildTree($menu_items);

    return $menu_items;
}


add_action('rest_api_init', function () {
    register_rest_route('vuewp/v1', '/menus/with-items', array(
        'methods' => 'GET',
        'callback' => 'vueWpMenuWithItems',
    ) );
    register_rest_route('vuewp/v1', '/menus/(?P<id>[a-zA-Z0-9_-]+)', array(
        'methods' => 'GET',
        'callback' => 'wp_api_v2_menus_get_menu_data',
    ) );

    // wp-json optimized
    register_rest_route('vuewp/v1', '/meta', array(
        'methods' => 'GET',
        'callback' => 'vueWpBaseMeta',
    ) );
} );