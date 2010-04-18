<?php

$dir_script=dirname(__FILE__).'/../../lib/task/envioComunicadosScript.php';
$tamanio_paquete=25;

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
sfContext::createInstance($configuration);
 
// Borra las dos líneas siguientes si no utilizas una base de datos
$databaseManager = new sfDatabaseManager($configuration);
$databaseManager->loadConfiguration();


function logEnvios($text)
{
  $time = date("d-M-Y H:i");
  exec("echo [$time] $text >> ".dirname(__FILE__)."/../../log/envio_comunicados.txt");
}

if($argc != 4)
{
  $text= "Use: ${argv[0]} id start packet";
  logEnvios($text);
  exit;
}

$id_envio=$argv[1];
$start=$argv[2];
$packet=$argv[3];

$envio_comunicado = Doctrine::getTable('EnvioComunicado')->find($argv[1]);

if (!$envio_comunicado) 
{
  $text= "No existe envio_comunicado con el id=".$id_envio;
  logEnvios($text);
  exit();
}

if ($packet==1)
{$text= "Comienzo de envio_comunicado con el id=".$id_envio;
 logEnvios($text);
}
 
$text= "__Packete $packet envio_comunicado con el id=".$id_envio;
logEnvios($text);


$usuarios = EnvioComunicadoTable::getUsuariosDeListasLimitArray($id_envio,$start,$tamanio_paquete);

$i=0;
$_SERVER["SERVER_NAME"] = 'stageintranet.amat.es';

foreach ($usuarios as $usuario)
{
      if ($usuario['email'])
      {         
          if ($envio_comunicado->envioMail($usuario['email'], $envio_comunicado->getTipoComunicado()->getImagen(), $envio_comunicado->getComunicado()->getDetalle(), $envio_comunicado->getComunicado()->getNombre(),$envio_comunicado->getId(),$usuario['id'])) 
          { logEnvios("____Enviado email a ".$usuario['email']." numero de email $i del paquete $packet");
          } else { logEnvios("____ERROR!!! Al Enviar email a ".$usuario['email']." numero de email $i del paquete $packet");
                 }
          sleep(2);       
      }
      $i++;
}     

if ($i == $tamanio_paquete)
{
  $new_start= $start + $tamanio_paquete;
  $packet++;
  sleep(6);
  exec("php $dir_script $id_envio $new_start $packet > /dev/null &");
}
else {
       $text= "FIN de envio_comunicado con el id=".$id_envio;
       logEnvios($text);
       logEnvios("----------------------------------------------------");
}

exit();
?>