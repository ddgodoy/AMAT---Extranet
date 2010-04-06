<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class NotificacionTable extends Doctrine_Table
{
	public static function getByUsuarioId($usuarioId, $type='object', $only_ids = false)
	{
		$q = Doctrine_Query::create();
		$q->from('Notificacion n');
		$q->where('n.deleted = 0');
		$q->addWhere('n.usuario_id=' . $usuarioId. '');
		
		if ($type == 'object') 		$notificaciones = $q->execute();
		else if ($type == 'array') 	$notificaciones = $q->fetchArray();
		
		if ($only_ids) {
			$notif = array();
			foreach ($notificaciones as $n) {
				if ($type == 'object') 		$notif[] = $n->getId();
				else if ($type == 'array') 	$notif[] = $n['id'];
			}
			$notificaciones = $notif;
		}
		
		return $notificaciones;
	}
	
	public static function getUltimasNotificaciones($usuarioId, $limit=null)
	{
		$q = Doctrine_Query::create();
                $q->select('n.id ,
                            n.estado ,
                            n.url ,
                            n.contenido_notificacion_id ,
                            n.usuario_id ,
                            n.entidad_id ,
                            n.tipo ,
                            n.visto ,
                            n.created_at ,
                            n.updated_at ,
                            n.deleted ,
                            c.id ,
                            c.mensaje ,
                            c.accion ,
                            c.entidad ,
                            c.created_at ,
                            c.updated_at ,
                            c.deleted ');
		$q->from('Notificacion n');
		$q->leftJoin('n.ContenidoNotificacion cn');
		$q->where('n.deleted = 0');
		$q->addWhere('n.usuario_id=' . $usuarioId. '');
		$q->addWhere('n.visto != 1');
		$q->orderBy('n.created_at DESC');
		$q->groupBy('entidad_id');
		if($limit) $q->limit($limit);

               
                

		$notificaciones = $q->execute();
		
		return $notificaciones;
	}
	
	public static function getDeleteEntidad($idEntidad, $nombre='')
	{
		$q = Doctrine_Query::create()
		     ->from('Notificacion')
		     ->where('entidad_id = '.$idEntidad);
		 if($nombre != '') 
		 {   
		     $q->andWhere("nombre = '$nombre'");
		 }   
		     
		 return $q->execute();    	
	}
	
	public static function getDeleteEntidad2($idEntidad,$nombre='')
	{

		$deleted = Doctrine_Query::create()
				  ->delete()
				  ->from('Notificacion')
				  ->andWhere('entidad_id = '.$idEntidad);
				   if($nombre != '') 
					 {   
					     $deleted->andWhere("nombre = '$nombre'");
					 }   
				  $deleted->execute();	
		return true;		  
	}	
	
	public static function DeletedByEntidad($tipo, $tabla)
	{
		
		$q=Doctrine_Query::create()
		->delete()
		->from('Notificacion') 
		->where("tipo = '$tipo'")
		->andWhere('entidad_id IN 
		  ( SELECT id 
	        FROM   '.$tabla.'
	        where deleted = 0 
	        AND fecha_caducidad <= NOW())') ;

		
		return $q->execute();
	}
	
	
}