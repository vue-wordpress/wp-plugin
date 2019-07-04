<?php

  namespace VWP\Page;

  function fetch ($data) {

      $post = \VWP\Util\Post\get_post($data);

      
      if ($data['boost']) {
        ObtainKeys($post, [
          "ID",
          "post_date",
          "post_content",
          "post_title",
          "post_name",
          "post_modified"
        ]);
      }
  
      return $post;
  }

  function fetchFew ($data) {

    $posts = \VWP\Util\Post\get_few_posts($data);

    
    if ($data['boost']) {
      foreach($posts as &$post) {
        ObtainKeys($post, [
          "ID",
          "post_date",
          "post_content",
          "post_title",
          "post_name",
          "post_modified"
        ]);
      }
    }

    return $posts;
}

?>