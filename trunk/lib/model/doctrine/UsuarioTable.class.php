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
                $q->andWhere('u.deleted = 0 AND u.activo = 1');
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
                $q->andWhere('u.deleted = 0 AND u.activo = 1');
		if ($exceptUserId != null) $q->addWhere('u.id != ' . $exceptUserId);
		$q->orderBy('u.apellido ASC, u.nombre ASC');
		if($UserEX != '')
		{
                $q->addWhere('u.id NOT IN ('.$UserEX.')');
		}
		$usuarios = $q->execute();
		
		return $usuarios;
	}
	
	public static function getUsuariosActivos($email = '', $form='', $id = '')
	{
		$q = Doctrine_Query::create();
		$q->from('Usuario u');
		$q->where('u.deleted = 0');
                if($form == '')
                {
                 $q->andWhere('u.activo = 1');
                }
		$q->orderBy('u.apellido ASC, u.nombre ASC');

                if($email != '')
                {
                    $q->andWhere("u.email = '".$email."'");
                    if($id != '')
                    {
                      $q->andWhere("u.id != '".$id."'");
                    }
                    return $q->fetchOne();
                }
  
		$usuarios = $q->execute();
		
		return $usuarios;
	}

        public static function getUsuariosActivosArray()
	{
		$q = Doctrine_Query::create();
                $q->select('u.id, u.nombre, u.apellido');
		$q->from('Usuario u');
		$q->where('u.deleted = 0');
		$q->orderBy('u.apellido ASC, u.nombre ASC');
		$usuarios = $q->fetchArray();

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
	
	public function getPermisosByUsuario($userId)
	{
		$permisos = array();
		
		$q = Doctrine_Query::create();
		$q->select('r.codigo, a.nombre_modulo, ar.accion_alta, ar.accion_baja, ar.accion_modificar, ar.accion_listar, ar.accion_publicar');
		$q->from('AplicacionRol ar');
		$q->leftJoin('ar.Aplicacion a');
		$q->leftJoin('ar.Rol r');
		$q->leftJoin('r.UsuarioRol ur');
		$q->leftJoin('ur.Usuario u');
		$q->where('u.id = ' . $userId);
		$q->addWhere('ar.deleted = 0');
		
		$aplicaciones_roles = $q->fetchArray();

//		echo '<pre>';
//		print_r($aplicaciones_roles);
//		echo '</pre>';
//		exit();
		
		
		/**
		 * si no existe el permiso lo cargo en el array
		 * si ya existe pero no tiene permiso y en el perfil nuevo si tiene, lo modifico a true
		 */
		foreach ($aplicaciones_roles as $ar) {
			$appModulo = $ar['Aplicacion']['nombre_modulo'];

			// alta
			if (!isset($permisos[$appModulo]['alta'])) {
				$permisos[$appModulo]['alta']	= $ar['accion_alta'];
			} else {
				if ($ar['accion_alta'] == 1) { $permisos[$appModulo]['alta'] = 1; }
			}
			// baja
			if (!isset($permisos[$appModulo]['baja'])) {
				$permisos[$appModulo]['baja'] = $ar['accion_baja'];
			} else {
				if ($ar['accion_baja'] == 1) { $permisos[$appModulo]['baja'] = 1; }
			}
			// modificar
			if (!isset($permisos[$appModulo]['modificar'])) {
				$permisos[$appModulo]['modificar'] = $ar['accion_modificar'];
			} else {
				if ($ar['accion_modificar'] == 1) { $permisos[$appModulo]['modificar'] = 1; }
			}
			// listar
			if (!isset($permisos[$appModulo]['listar'])) {
				$permisos[$appModulo]['listar']	= $ar['accion_listar'];
			} else {
				if ($ar['accion_listar'] == 1) { $permisos[$appModulo]['listar'] = 1; }
			}
			// publicar
			if (!isset($permisos[$appModulo]['publicar'])) {
				$permisos[$appModulo]['publicar'] = $ar['accion_publicar'];
			} else {
				if ($ar['accion_publicar'] == 1) { $permisos[$appModulo]['publicar'] = 1; }
			}
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
                $r->andWhere('deleted = 0 AND activo = 1');
                
		return $r->execute();	
	}

        public static function getEmailEvento2($arrayIDusuario)
        {
            	$id = '';
		$d = count($arrayIDusuario);

		if (is_array($arrayIDusuario)) {
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

		if (!is_array($arrayIDusuario)) {
		 $r->where('id ='.$arrayIDusuario);
		} else {
		  $r->where('id IN '.$id);
		}
                $r->andWhere('deleted = 0 AND activo = 1');
		return $r->fetchArray();

        }


	public static function getUsuarioByEventos($idEvento)
	{
		$e=Doctrine_Query::create()
		->from('Usuario u')
		->leftJoin('u.UsuarioEvento ue')
		->where('ue.evento_id = '.$idEvento)
                ->andWhere('u.deleted = 0 AND u.activo = 1');
		
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
		->where('uo.organismo_id ='.$idOrag)
                ->andWhere('u.deleted = 0 AND u.activo = 1');
		
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
                $q->andWhere('u.deleted = 0 AND u.activo = 1');

		
		return $q->execute();

	}
	
	
}