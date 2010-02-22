<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class SubCategoriaIniciativaTable extends Doctrine_Table
{

	public static function getSubcategiriaBycategoria($id)
	{
	   $q = Doctrine_Query::create()
	   ->from('SubCategoriaIniciativa')
	   ->where('categoria_iniciativa_id = '.$id)
	   ->andWhere('deleted = 0');
	   
	   return $q->execute();
	   
	}  
	   
	public static function getAll()
	{
	   $q = Doctrine_Query::create()
	   ->from('SubCategoriaIniciativa')
	   ->Where('deleted = 0');
	   
	   return $q->execute();
	   
	}  
	
}