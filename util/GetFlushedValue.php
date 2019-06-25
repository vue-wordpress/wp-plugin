<?php

  function GetFlushedValue ($func) {
    ob_start();
    $func();
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
  }

?>

