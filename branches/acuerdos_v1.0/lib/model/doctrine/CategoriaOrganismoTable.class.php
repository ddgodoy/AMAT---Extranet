<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CategoriaOrganismoTable extends Doctrine_Table
{

	public static function getCategoriaOrganismo($id)
   {
   	 $r = Doctrine_Query::create()
   	 ->from('CategoriaOrganismo')
   	 ->where('id = '.$id);
   	 $respuesat = $r->fetchOne();
   	 
   	 return $respuesat;
   }
	
	public static function getAllcategoriaorg()
	{
		
		$s= Doctrine_Query::create()
		->from('CategoriaOrganismo')
		->where('deleted = 0');
		$respuesta = $s->execute();
		
		return $respuesta;
		
	}
}