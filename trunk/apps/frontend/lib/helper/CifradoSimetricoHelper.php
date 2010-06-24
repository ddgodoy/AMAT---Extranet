<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function cifrado($string){
   $key   = sfConfig::get('app_key_aplication');

   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return utf8_decode($result);
}


function decifrado($string){

    $key   = sfConfig::get('app_key_aplication');

   $result = '';
   $string = utf8_decode($string);;
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
}


?>
