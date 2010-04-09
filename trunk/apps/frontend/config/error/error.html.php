<?php
  $checkServerName = strtolower($_SERVER['SERVER_NAME']);
  
  header( 'Location: http://'. $checkServerName.'/seguridad/error' ) ;
?>  