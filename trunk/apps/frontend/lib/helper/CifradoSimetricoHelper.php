<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function cifrado($texto){
    $key   = sfConfig::get('app_key_aplication');

    // Proceso de cifrado
    $iv    = 'abcdefghijklmnopqrstuvwxyz012345';
    $td = mcrypt_module_open('rijndael-256', '', 'ecb', '');
    mcrypt_generic_init($td, $key, $iv);
    $texto_cifrado = mcrypt_generic($td, $texto);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);

    // Opcionalmente codificamos en base64
    $texto_cifrado = base64_encode($texto_cifrado);

    return $texto_cifrado;
}


function decifrado($texto_cifrado){

    $key   = sfConfig::get('app_key_aplication');

    // Opcionalmente descodificamos en base64
    $texto_cifrado = base64_decode($texto_cifrado);


    // Proceso de descifrado
    $iv    = 'abcdefghijklmnopqrstuvwxyz012345';
    $td = mcrypt_module_open('rijndael-256', '', 'ecb', '');
    mcrypt_generic_init($td, $key, $iv);
    $texto = mdecrypt_generic($td, $texto_cifrado);
    $texto = trim($texto, "\0");

    return $texto;
}


?>
