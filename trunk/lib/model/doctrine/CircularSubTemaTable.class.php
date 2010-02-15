<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CircularSubTemaTable extends Doctrine_Table
{
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
}