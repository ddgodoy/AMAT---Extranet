<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class GrupoTrabajoTable extends Doctrine_Table
{
	public static function getGruposTrabajoByUsuario($usuarioId)
	{
		$q = Doctrine_Query::create()
                ->from('GrupoTrabajo gt')
                ->leftJoin('gt.UsuarioGrupoTrabajo ugt')
                ->where('ugt.usuario_id ='. $usuarioId)
                ->addWhere('gt.deleted = 0')
                ->orderBy('gt.nombre ASC');

		$gruposTrabajo = $q->execute();

		return $gruposTrabajo;
	}

	public static function getUsuariosDeGrupos($usuarioId)
	{
		$usuarios = array();
		$arrGruposTrabajos = GrupoTrabajoTable::getGruposTrabajoByUsuario($usuarioId);

		foreach ($arrGruposTrabajos AS $grupoTrabajo) {
			$arrUsuarios = $grupoTrabajo->getUsusriosMiGrupo($usuarioId);

			foreach ($arrUsuarios as $usu) {
				$usuarios[] = $usu;
			}
		}
		return $usuarios;
	}
	
 	static function getAllGrupoTrabajo()
	 {
		 	$s = Doctrine_Query::create()
		 	->from('GrupoTrabajo')
		 	->where('deleted = 0')
                        ->groupBy('nombre ASC');
		 	$retorno = $s->execute();
		 	
		 	return $retorno;
	 }
	 
  public static function getGrupoTrabajo($id)
   {
   	 $r = Doctrine_Query::create()
   	 ->from('GrupoTrabajo')
   	 ->where('id = '.$id);
   	 $respuesat = $r->fetchOne();
   	 
   	 return $respuesat;
   }
}