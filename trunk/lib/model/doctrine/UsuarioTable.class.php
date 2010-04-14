<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class UsuarioTable extends Doctrine_Table
{
	public static function getUsuariosByRol($rolId, $exceptUserId=null)
	{
		$q = Doctrine_Query::create();
		$q->from('Usuario u');
		$q->leftJoin('u.UsuarioRol ur');
		$q->where('ur.rol_id = ' . $rolId);
		if ($exceptUserId != null) $q->addWhere('u.id != ' . $exceptUserId);
		$q->orderBy('u.apellido ASC, u.nombre ASC');
		$usuarios = $q->execute();
		
		return $usuarios;
	}
	
	public static function getUsuariosByGrupoTrabajo($grupoTrabajoId, $exceptUserId=null, $UserEX='')
	{
		$q = Doctrine_Query::create();
		$q->from('Usuario u');
		$q->leftJoin('u.UsuarioGrupoTrabajo ugt');
		$q->where('ugt.grupo_trabajo_id = ' . $grupoTrabajoId);
		if ($exceptUserId != null) $q->addWhere('u.id != ' . $exceptUserId);
		$q->orderBy('u.apellido ASC, u.nombre ASC');
		if($UserEX != '')
		{
         $q->addWhere('u.id NOT IN ('.$UserEX.')');  			
		}
		
		$usuarios = $q->execute();
		
		return $usuarios;
	}
	
	public static function getUsuariosByConsejoTerritorial($consejoTerritorialId, $exceptUserId=null, $UserEX='' )
	{
		$q = Doctrine_Query::create();
		$q->from('Usuario u');
		$q->leftJoin('u.UsuarioConsejoTerritorial uct');
		$q->where('uct.consejo_territorial_id = ' . $consejoTerritorialId);
		if ($exceptUserId != null) $q->addWhere('u.id != ' . $exceptUserId);
		$q->orderBy('u.apellido ASC, u.nombre ASC');
		if($UserEX != '')
		{
         $q->addWhere('u.id NOT IN ('.$UserEX.')');  			
		}
		$usuarios = $q->execute();
		
		return $usuarios;
	}
	
	public static function getUsuariosActivos()
	{
		$q = Doctrine_Query::create();
		$q->from('Usuario u');
		$q->where('u.deleted = 0');
		$q->orderBy('u.apellido ASC, u.nombre ASC');
		$usuarios = $q->execute();
		
		return $usuarios;
	}
	
	public static function getAplicacionesExternasByUsuario($userId)
	{
		$q = Doctrine_Query::create();
		$q->from('AplicacionExterna ae');
		$q->leftJoin('ae.UsuarioAplicacionExterna uae');
		$q->leftJoin('uae.Usuario u');
		$q->where('u.id = ' . $userId);
		$q->andWhere('ae.deleted = 0');
		$q->orderBy('ae.nombre ASC');
		$aplicaciones = $q->execute();

                
		
		return $aplicaciones;
	}
	
	public function getPermisosByUsuario ($userId)
	{
		$permisos = array();
		
		$q = Doctrine_Query::create();
		$q->select('r.codigo, a.nombre_modulo, ar.accion_alta, ar.accion_baja, ar.accion_modificar, ar.accion_listar, ar.accion_publicar ');
		$q->from('AplicacionRol ar');
		$q->leftJoin('ar.Aplicacion a');
		$q->leftJoin('ar.Rol r');
		$q->leftJoin('r.UsuarioRol ur');
		$q->leftJoin('ur.Usuario u');
		$q->where('u.id = ' . $userId);
		$q->addWhere('ar.deleted = 0');
		
		$aplicaciones_roles = $q->fetchArray();
		
		foreach ($aplicaciones_roles as $ar)
		{	
			// si no existe el permiso lo cargo en el array
			if (empty($permisos[$ar['Aplicacion']['nombre_modulo']]['alta']))
				{	$permisos[$ar['Aplicacion']['nombre_modulo']]['alta'] 		= $ar['accion_alta']; }
				else // si ya existe, no tiene permiso y en el perfil nuevo si tiene, lo modifico a true
				{ 	if ($permisos[$ar['Aplicacion']['nombre_modulo']]['alta'] == false && $ar['accion_alta'] == true) $permisos[$ar['Aplicacion']['nombre_modulo']]['alta'] = $ar['accion_alta']; }
			
			if (empty($permisos[$ar['Aplicacion']['nombre_modulo']]['baja']))
				{	$permisos[$ar['Aplicacion']['nombre_modulo']]['baja'] 		= $ar['accion_baja']; }
				else // si ya existe, no tiene permiso y en el perfil nuevo si tiene, lo modifico a true
				{ 	if ($permisos[$ar['Aplicacion']['nombre_modulo']]['baja'] == false && $ar['accion_baja'] == true) $permisos[$ar['Aplicacion']['nombre_modulo']]['baja'] = $ar['accion_baja']; }
			
			if (empty($permisos[$ar['Aplicacion']['nombre_modulo']]['modificar']))
				{	$permisos[$ar['Aplicacion']['nombre_modulo']]['modificar'] 		= $ar['accion_modificar']; }
				else // si ya existe, no tiene permiso y en el perfil nuevo si tiene, lo modifico a true
				{ 	if ($permisos[$ar['Aplicacion']['nombre_modulo']]['modificar'] == false && $ar['accion_modificar'] == true) $permisos[$ar['Aplicacion']['nombre_modulo']]['modificar'] = $ar['accion_modificar']; }
			
			if (empty($permisos[$ar['Aplicacion']['nombre_modulo']]['listar']))
				{	$permisos[$ar['Aplicacion']['nombre_modulo']]['listar'] 		= $ar['accion_listar']; }
				else // si ya existe, no tiene permiso y en el perfil nuevo si tiene, lo modifico a true
				{ 	if ($permisos[$ar['Aplicacion']['nombre_modulo']]['listar'] == false && $ar['accion_listar'] == true) $permisos[$ar['Aplicacion']['nombre_modulo']]['listar'] = $ar['accion_listar']; }
			
			if (empty($permisos[$ar['Aplicacion']['nombre_modulo']]['publicar']))
				{	$permisos[$ar['Aplicacion']['nombre_modulo']]['publicar'] 		= $ar['accion_publicar']; }
				else // si ya existe, no tiene permiso y en el perfil nuevo si tiene, lo modifico a true
				{ 	if ($permisos[$ar['Aplicacion']['nombre_modulo']]['publicar'] == false && $ar['accion_publicar'] == true) $permisos[$ar['Aplicacion']['nombre_modulo']]['publicar'] = $ar['accion_publicar']; }
				
		
		}
				
		return $permisos;
	}
	
	public static function getEmailEvento($arrayIDusuario)
	{
		$id = '';
		$d = count($arrayIDusuario);

		if ($d > 1) {
			$d--;
            $id .= '(';
			foreach ($arrayIDusuario as $k =>$idUSE) {	
		    if ($d > $k) {
			    $id .= $idUSE.',';
		    } else {
		    	$id .= $idUSE.')';
		    }
			}
		}
	
		$r = Doctrine_Query::create()->from('Usuario');

		if ($d == 1) {
		 $r->where('id ='.$arrayIDusuario);
		} else {
		  $r->where('id IN '.$id);	
		}
		return $r->execute();	
	}

        public static function getEmailEvento2($arrayIDusuario)
        {
            	$id = '';
		$d = count($arrayIDusuario);

		if ($d > 1) {
			$d--;
            $id .= '(';
			foreach ($arrayIDusuario as $k =>$idUSE) {
		    if ($d > $k) {
			    $id .= $idUSE.',';
		    } else {
		    	$id .= $idUSE.')';
		    }
			}
		}

		$r = Doctrine_Query::create()->from('Usuario');

		if ($d == 1) {
		 $r->where('id ='.$arrayIDusuario);
		} else {
		  $r->where('id IN '.$id);
		}
		return $r->fetchArray();

        }


	public static function getUsuarioByEventos($idEvento)
	{
		$e=Doctrine_Query::create()
		->from('Usuario u')
		->leftJoin('u.UsuarioEvento ue')
		->where('ue.evento_id = '.$idEvento);
		
		return $e->execute();
	}
	public static function getUsuarioByid($IdUser)
	{
		$r=Doctrine_Query::create()
		->from('Usuario')
		->where('id ='.$IdUser);
		return $r->fetchOne();
	}
	
	public static function getUsuarioByOrganismo($idOrag)
	{
		$r = Doctrine_Query::create()
		->from('Usuario u')
		->leftJoin('u.UsuarioOrganismo uo')
		->where('uo.organismo_id ='.$idOrag);
		
		return $r->execute();
	
	}
	public static function getUsuarioByOrganismoAsn($idOrag)
	{
		$r = Doctrine_Query::create()
		->from('UsuarioOrganismo uo')
		->leftJoin('uo.Usuario u')
		->where('uo.organismo_id ='.$idOrag);
		
		return $r->execute();
	
	}
	
	public static function getDirectoresGerntes()
	{
		$q = Doctrine_Query::create();
		$q->from('UsuarioRol ur');
		$q->leftJoin('ur.Usuario u');
		$q->where('ur.rol_id = 3 OR ur.rol_id = 1');
		
		return $q->execute();

	}
	
	
}