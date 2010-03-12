<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class NoticiaTable extends Doctrine_Table
{
	public static function getAll($perPage, $currentPage)
	{
		$pager = new sfDoctrinePager('Noticia', $perPage);
		$pager->getQuery()->from('Noticia')->where('deleted=0');
		$pager->setPage($currentPage);
		$pager->init();
		
		return $pager;
	}
	
	public static function getUltimasNoticias($limit=null)
	{
		$q = Doctrine_Query::create();
		$q->from('Noticia n');
		$q->where('n.deleted = 0');
		$q->andWhere("n.estado = 'publicado'");
		$q->andWhere("n.fecha_publicacion <= NOW() AND (fecha_caducidad >= NOW() OR fecha_caducidad IS NULL )");
		$q->andWhere("n.destacada = 1");
		$q->orderBy('n.id DESC');
		if($limit) $q->limit($limit);
		
			
		$notificaciones = $q->execute();
		
		return $notificaciones;
	}
}