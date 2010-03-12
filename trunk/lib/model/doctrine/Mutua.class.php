<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Mutua extends BaseMutua
{
	public function __toString()
	{
		return $this->nombre;
	}
	public static function getRepository()
	{
		return Doctrine::getTable(__CLASS__);
	}
	
	public static function getArrayMutuas()
	{
		$ArrayMutuas = array();
		$ModelosMutuas = MutuaTable::getAllMutuas();
		
		foreach ($ModelosMutuas AS $m)
		{
			$ArrayMutuas[$m->getId()] = $m->getNombre();
		}
		
		return $ArrayMutuas;
	}
}