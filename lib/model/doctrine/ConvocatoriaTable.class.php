<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ConvocatoriaTable extends Doctrine_Table
{
	public static function getConvocadosByAsamblea($asambleaId)
	{
		$q = Doctrine_Query::create();
		$q->from('Convocatoria c');
		$q->leftJoin('c.Usuario u');
		$q->where('c.asamblea_id = ' . $asambleaId);
		$q->addWhere('c.deleted = 0');
		$q->orderBy('u.apellido ASC, u.nombre ASC');
		$usuarios = $q->execute();
		
		return $usuarios;
	}
	
	public static function getOneByUsuarioId($usuarioId)
	{
		$q = Doctrine_Query::create();
		$q->from('Convocatoria c');
		$q->leftJoin('c.Asamblea a');
		$q->leftJoin('c.Usuario u');
		$q->where('c.usuario_id = ' . $usuarioId);
		$q->addWhere('c.deleted = 0');
		$q->limit(1);
		$usuario = $q->fetchOne();
		
		return $usuario;
	}
	
	public static function getConvocatoria($id_user,$xFiltro = '')
	{
		if ($xFiltro != '') {
			$where = 'a.deleted = 0 AND a.'.$xFiltro;
		} else {
			$where = 'a.deleted = 0';
		}
		$r = Doctrine_Query::create()
				 ->from('Convocatoria c')
				 ->leftJoin('c.Asamblea a')
				 ->where($where)
				 ->addWhere('c.usuario_id='.$id_user)
				 ->orderBy('a.fecha ASC');

                $retorno = $r->execute();

                return $retorno;
	}
}