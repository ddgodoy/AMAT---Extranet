<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EnviosTable extends Doctrine_Table
{

	public static function getAll()
	{
		$q = Doctrine_Query::create()
		->from('Envios');
		
		return $q->execute();
	}
	
	public static function getDeleteById($id)
	{
		$q = Doctrine_Query::create()
		->from('Envios')
		->where('id='.$id);
		$query = $q->execute();
		
		$query->delete();
		
		return true;
	}
	
	
}