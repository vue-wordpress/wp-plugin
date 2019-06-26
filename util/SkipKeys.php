<?php

  function SkipKeys (&$object, $keys) {

    $tmp = new stdClass;

    foreach($object as $key => $value) {
      if(!in_array($key, $keys)) {
        $tmp->$key = $value;
      }
    }

    $object = $tmp;

  }

?>