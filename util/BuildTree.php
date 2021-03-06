<?php

  require_once "ObtainKeys.php";
  require_once "SkipKeys.php";

  function buildTree($boost, $elements, $parentId = 0) {
    $branch = array();

    foreach ($elements as $key => $element) {
        if ($element->menu_item_parent == $parentId) {

            $children = buildTree($boost, $elements, $element->ID);

            if ($children) {
                
                $element->child_items = $children;

                if ($boost) {
                  foreach($elements[$key]->child_items as $k => $v) {
                    ObtainKeys($elements[$key]->child_items[$k], [
                      "ID",
                      "child_items",
                      "menu_item_parent",
                      "classes",
                      "description",
                      "attr_title"
                    ]);
                  }
                }
            }
            $branch[] = $element;
        }
    }

    return $branch;
  }

?>