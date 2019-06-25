<?php

  function vuewp_base () {
    $response = new stdClass;
    $response->title = wp_title();
    $response->description = bloginfo('description');

    return $response;
  }

?>