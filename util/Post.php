<?php

  namespace VWP\Util\Post;

  function get_post($data) {

    if (is_numeric($data['id'])) {
      $post = get_post($data['id']);
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
    if(sizeof($postIn) > 0) {

      $filter["post_in"] = $postIn;

    }
    if(sizeof($postNameIn) > 0) {

      $filter["post_name_in"] = $postNameIn;
      
    }

    print_r($filter);

    $posts = get_posts($filter);

    return $posts;
  }

?>