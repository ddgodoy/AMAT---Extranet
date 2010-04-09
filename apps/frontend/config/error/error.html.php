<?php
  $checkServerName = strtolower($_SERVER['SERVER_NAME']);
  
  echo 'Location: http://'. $checkServerName.'/default/error';
  
  //header( 'Location: http://'. $checkServerName.'/default/error' ) ;
?>  