<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class UsuarioConsejoTerritorialTable extends Doctrine_Table
{
   public static function getUsreByConse($id)
	{
		$q=Doctrine_Query::create()
		->from('UsuarioConsejoTerritorial uc')
		->leftJoin('uc.Usuario u')
		->leftJoin('uc.ConsejoTerritorial ct')
		->where('uc.consejo_territorial_id  ='.$id)
                ->andWhere('uc.deleted = 0')
                ->andWhere('u.deleted = 0 AND u.activo = 1')
                ->andWhere('ct.deleted = 0');
		
		return $q->execute();
	}
	
	
}