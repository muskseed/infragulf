<?php
  function pre($var)
  {
    echo '<pre>';
    if(is_array($var)) {
      print_r($var);
    } else {
      var_dump($var);
    }
    echo '</pre>';
  }
?> 