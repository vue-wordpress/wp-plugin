<?php

  namespace VWP\Menu;

  /**
 * Get all registered menus
 * @param request Could contains "boost"
 * which defines if 
 * Plugin should reduce weight of response by 
 * bypassing useless attributes?
 * @return array List of menus with slug and description
 */
function withItems ($request) {
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
 * Get a few menus by slug or ID
 * @return array List of menus with slug and description
 */
function fewItems ( $data ) {

    $menus = [];
    $sources = explode(',', $data['id']);

    foreach ($sources as $source) {
        if (has_nav_menu($source)) {

            $el = [];
            $el['id'] = $source;
            $menu = wp_api_v2_locations_get_menu_data($el);

        } else if (is_nav_menu($source)) {

            if (is_int($source)) {
                $id = $source;
            } else {
                $id = wp_get_nav_menu_object($source);
            }
            $menu = get_term($id);
            $menu->items = wp_api_v2_menus_get_menu_items($id, $data['boosted']);
        } else {
            return new WP_Error( 'not_found', 'No menu has been found with this id or slug: `'.$data['id'].'`. Please ensure you passed an existing menu ID, menu slug, location ID or location slug.', array( 'status' => 404 ) );
        }

        $menus[] = $menu;
    }

    return $menus;

}

// HELPERS

/**
 * Retrieve items for a specific menu
 * @param $id Menu id
 * @return array List of menu items
 */
function wp_api_v2_menus_get_menu_items ($id, $boosted) {

    $menu_items = wp_get_nav_menu_items($id);
    buildTree($boosted, $menu_items);

    return $menu_items;

}

/**
 * Get menu's data from his id
 * @param  array $data WP REST API data variable
 * @return object Menu's data with his items
 */
function wp_api_v2_locations_get_menu_data ( $data ) {
    // Create default empty object
    $menu = new stdClass;
    // this could be replaced with `if (has_nav_menu($data['id']))`
    if (($locations = get_nav_menu_locations()) && isset($locations[$data['id']])) {
        // Replace default empty object with the location object
        $menu = get_term( $locations[ $data['id'] ] );
        $menu->items = wp_api_v2_menus_get_menu_items($locations[$data['id']]);
    } else {
        return new WP_Error( 'not_found', 'No location has been found with this id or slug: `'.$data['id'].'`. Please ensure you passed an existing location ID or location slug.', array( 'status' => 404 ) );
    }
    return $menu;
}

?>