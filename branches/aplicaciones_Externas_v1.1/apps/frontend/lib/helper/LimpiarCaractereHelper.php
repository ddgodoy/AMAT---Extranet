<?php

 function slugify($string, $separador = ' ')
        {
                //strip tags, trim, and lowercase
                $string = strtolower(trim(strip_tags($string)));

                //replace single quotes and double quotes first
                //$string = preg_replace('/[\']/i', '', $string);
                //$string = preg_replace('/["]/i', '', $string);
                //$string = preg_replace('/&/', 'y', $string);

                //replace acentos y eñes
                //$con_tilde = array('á','é','í','ó','ú','ñ');
                //$sin_tilde = array('a','e','i','o','u','n');
                //$string = str_replace($con_tilde, $sin_tilde, $string);

                //remove non-valid characters
                //$string = preg_replace('/[^-a-z0-9]/i', $separador, $string);
                //$string = preg_replace('/-[-]*/i', $separador, $string);

                //remove from beginning and end
                $string = preg_replace('/' . $separador . '$/i', '', $string);
                $string = preg_replace('/^' . $separador . '/i', '', $string);

                return $string;
        }

?>
