<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class MutuaTable extends Doctrine_Table
{
   public static function Idmutua($id_mutua)
   {
   	 $r = Doctrine_Query::create()
   	 ->from('Mutua')
   	 ->where('id = '.$id_mutua);
   	 $respuesat = $r->fetchOne();
   	 
   	 return $respuesat;
   }
   public static function getAllMutuas()
   {
   	  $r=Doctrine_Query::create()
   	  ->from('Mutua')
   	  ->where('deleted = 0');
   	  
   	  return $r->execute();
   }
}