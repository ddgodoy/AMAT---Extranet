<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CategoriaAsuntoTable extends Doctrine_Table
{

	public static function getAll()
	{
		$q = Doctrine_Query::create()
		->from('CategoriaAsunto')
		->where('deleted = 0');
		
	    return  $q->execute();
	}
	
}