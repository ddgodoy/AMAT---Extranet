<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class SubCategoriaAcuerdo extends BaseSubCategoriaAcuerdo
{
     public function __toString()
	{
		return $this->nombre;
	}
     public static function getRepository()
	{
		return Doctrine::getTable(__CLASS__);
	}

}