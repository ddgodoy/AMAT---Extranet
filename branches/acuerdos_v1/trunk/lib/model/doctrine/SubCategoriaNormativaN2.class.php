<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class SubCategoriaNormativaN2 extends BaseSubCategoriaNormativaN2
{

	public function __toString()
	{
		return $this->nombre;
	}
	
	public static function getRepository()
	{
		return Doctrine::getTable(__CLASS__);
	}

	public static function getArraySubCategoria($id = '')
	{
                sfLoader::loadHelpers('Text');
		if($id != '')
		{
		   $subcategoria = SubCategoriaNormativaN2Table::getSubcategiriaBycategoria($id);
		}
		else 
		{
			$subcategoria = SubCategoriaNormativaN2Table::getAll();
		}
		
		$arraysubcategoria = array('0'=>'--seleccionar--');
		
		foreach ($subcategoria as $c)
		{
			
			$arraysubcategoria[$c->getId()] = truncate_text($c->getNombre(), 25);
			
		}
		
		return $arraysubcategoria;
	}
}