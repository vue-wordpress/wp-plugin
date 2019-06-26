<?php

  namespace VWP\Meta;

  /**
  * Get title and description
  * @return Object with title and description
  */

  function baseMeta () {
    $data = new \stdClass;
    $data->title = GetFlushedValue(function () {
        bloginfo('title');
    });
    $data->description = GetFlushedValue(function () {
        bloginfo('description');
    });

    $response = new \WP_REST_Response($data);
    $response->set_status(200);

    return $response;
  }

?>