<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CategoriaDGTable extends Doctrine_Table
{
		static  function getAllcategoria()
		{
			$s = Doctrine_Query::create();
			$s->from('CategoriaDG');
			$s->where('deleted = 0');
			$roles = $s->execute();
			return $roles;
		}
		
		 public static function getCategoriaDG($id)
   {
   	 $r = Doctrine_Query::create()
   	 ->from('CategoriaDG')
   	 ->where('id = '.$id);
   	 $respuesat = $r->fetchOne();
   	 
   	 return $respuesat;
   }
}