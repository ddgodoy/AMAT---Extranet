<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CifraDatoSeccionTable extends Doctrine_Table
{
   public static function getIdseccion($id_seccion)
   {
   	 $r = Doctrine_Query::create()
   	 ->from('CifraDatoSeccion')
   	 ->where('id = '.$id_seccion);
   	 $respuesat = $r->fetchOne();
   	 
   	 return $respuesat;
   }
	
	
	
}