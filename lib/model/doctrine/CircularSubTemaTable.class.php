<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CircularSubTemaTable extends Doctrine_Table
{
	public static function getAll()
	{
	   $q=Doctrine_Query::create()
	   ->from('CircularSubTema')
	   ->where('deleted = 0');
	   
		return $q->execute();
		
	}
	
	public static function doSelectByCategoria($categoria)
	{
		if (empty($categoria)) {return false;}

		$q = Doctrine_Query::create();

		$q->from('CircularSubTema');
		$q->where('deleted = 0');
		$q->addWhere('circular_cat_tema_id = ' . $categoria);
		$q->orderBy('nombre ASC');

		$subcategorias = $q->execute();
		
		return $subcategorias;
	}

        public static function getSubcategoria($id)
	{
	   $q=Doctrine_Query::create()
	   ->from('CircularSubTema')
	   ->where('deleted = 0')
           ->andWhere('id = '.$id);

           return $q->fetchOne();

	}
}