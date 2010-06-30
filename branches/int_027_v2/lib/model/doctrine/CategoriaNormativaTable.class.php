<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CategoriaNormativaTable extends Doctrine_Table
{
	public static  function getAll()
	{
		$q = Doctrine_Query::create()
		->from('CategoriaNormativa')
		->where('deleted = 0 ');	
		
		return $q->execute();
	}

        public static  function getCategoriaNombre($id)
	{
		$q = Doctrine_Query::create()
		->from('CategoriaNormativa')
		->where('deleted = 0 ')
                ->andWhere('id = '.$id);

		return $q->fetchOne();
	}

}