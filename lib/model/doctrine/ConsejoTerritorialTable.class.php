<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ConsejoTerritorialTable extends Doctrine_Table
{
	public static function getConsejosTerritorialesByUsuario($usuarioId)
	{
		$q = Doctrine_Query::create()
			->from('ConsejoTerritorial ct')
			->leftJoin('ct.UsuarioConsejoTerritorial uct')
			->where('uct.usuario_id = ' . $usuarioId)
			->orderBy('ct.nombre ASC');
		$consejosTerritoriales = $q->execute();
		
		return $consejosTerritoriales;
	}
	
	public static function getAllconsejo()
	{
		$s = Doctrine_Query::create()
		->from('ConsejoTerritorial')
		->where('deleted = 0');
		$retornar = $s->execute();
		return $retornar;
	}
	public static function getConsejo($id)
   {
   	 $r = Doctrine_Query::create()
   	 ->from('ConsejoTerritorial')
   	 ->where('id = '.$id);
   	 $respuesat = $r->fetchOne();
   	 
   	 return $respuesat;
   }
   
   public static function getUsuariosDeConsejo($usuarioId)
	{
		$usuarios = array();
		$arrGruposTrabajos = ConsejoTerritorialTable::getConsejosTerritorialesByUsuario($usuarioId);
		foreach ($arrGruposTrabajos AS $grupoTrabajo)
		{
			$arrUsuarios = $grupoTrabajo->getUsusriosMiConsejo($usuarioId);
			
			foreach ($arrUsuarios as $usu)
			{
				
				$usuarios[] = $usu;
			}
			
		}
		 
		return $usuarios;
	}
   
   
}