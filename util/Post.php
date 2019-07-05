<?php

  namespace VWP\Util\Post;

  function get_post($data) {

    if (is_numeric($data['id'])) {
      $post = \get_post($data['id']);
    } else {
      $post = get_page_by_path($data['id']);
    }

    if ($post == null) {
      // Search post by slug
      $args = array(
        'name' => $data['id']
      );
      $post = get_posts($args);
      $post = $post[0];
    }

    return $post;
  }

  function get_few_posts($data) {

    $pointers = explode(',', $data['id']);
    $postIn = [];
    $postNameIn = [];

    foreach($pointers as $source) {

      if (is_numeric($source)) {

        $postIn[] = intval($source);

      } else {

        $postNameIn[] = $source;

      }

    }

    $filter = [];
    $filter["numberposts"] = -1;

    if(sizeof($postIn) > 0) {

      $filter["include"] = $postIn;
      $postsById = \get_posts($filter);

    }
    if(sizeof($postNameIn) > 0) {

      $postsBySlug = \get_posts(array(
        "post_name__in" => $postNameIn
      ));
      
    }

    

    // print_r(\WP_Query::parse_query($filter));

    

    return array_merge($postsById, $postsBySlug);
  }

?>