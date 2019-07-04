<?php

  namespace VWP\Page;

  function fetch ($data) {

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

?>