<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EnvioComunicadoTable extends Doctrine_Table
{
	public function getUsuariosDeListas($idEnvio)
	{		
		$q = Doctrine_Query::create();
		$q->from('Usuario u');
		$q->leftJoin('u.UsuarioListaComunicado ulc');
		$q->leftJoin('ulc.ListaComunicado lc');
		$q->leftJoin('lc.ListaComunicadoEnvio lce');
		$q->leftJoin('lce.EnvioComunicado ec');
		$q->where('u.deleted = 0');
		$q->andWhere('ec.id = '.$idEnvio);
		$q->orderBy('u.nombre ASC');
		$usuarios = $q->execute();		

		return $usuarios;
	}

  public function getUsuariosDeListasArray($idEnvio)
	{
		$q = Doctrine_Query::create();
    $q->select('u.id, u.email');
		$q->from('Usuario u');
		$q->leftJoin('u.UsuarioListaComunicado ulc');
		$q->leftJoin('ulc.ListaComunicado lc');
		$q->leftJoin('lc.ListaComunicadoEnvio lce');
		$q->leftJoin('lce.EnvioComunicado ec');
		$q->where('u.deleted = 0 
                           AND ulc.deleted = 0
                           AND lc.deleted = 0
                           AND lce.deleted = 0
                           AND ec.deleted = 0 ');
		$q->andWhere('ec.id = '.$idEnvio);
		$q->orderBy('u.nombre ASC');
		$usuarios = $q->fetchArray();

		return $usuarios;
	}

  public function getUsuariosDeListasLimitArray($idEnvio,$start,$limit)
  {
    $q = Doctrine_Query::create();
    $q->select('u.id, u.email');
    $q->from('Usuario u');
    $q->leftJoin('u.UsuarioListaComunicado ulc');
    $q->leftJoin('ulc.ListaComunicado lc');
    $q->leftJoin('lc.ListaComunicadoEnvio lce');
    $q->leftJoin('lce.EnvioComunicado ec');
    $q->where('u.deleted = 0 
                           AND ulc.deleted = 0
                           AND lc.deleted = 0
                           AND lce.deleted = 0
                           AND ec.deleted = 0 ');
    $q->andWhere('ec.id = '.$idEnvio);
    $q->orderBy('u.nombre ASC');
    $q->limit($limit);
    $q->offset($start);

    $usuarios = $q->fetchArray();

    return $usuarios;
  }

	
	public static function getComunicadosTipos($id_tipo)
	{
		$e = Doctrine_Query::create()
		->from('EnvioComunicado')
		->where('tipo_comunicado_id ='.$id_tipo);
		$retorno = $e->execute();
		
		return $retorno;
	}
}