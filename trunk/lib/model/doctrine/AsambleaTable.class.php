<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class AsambleaTable extends Doctrine_Table
{
	public static function getConvocotatiaId($idAsamblea,$idusuario,$idConvocatoria = '')
	{
		$q = Doctrine_Query::create()
		->from('Convocatoria c')
		->leftJoin('c.Usuario u')
		->leftJoin('c.Asamblea a');
	  if($idConvocatoria == '')
		 {
			$q->where('a.id ='.$idAsamblea);
			$q->andWhere('c.usuario_id ='.$idusuario);
		 }		
	  else 
	     {
	     	$q->where('c.id ='.$idConvocatoria);
	     	
	     }	
		
		return $q->fetchOne();
	}
	
	public static function getAsambleaId($id,$dato)
	{
		$q = Doctrine_Query::create()
		->from('Asamblea')
		->where('id ='.$id)
		->andWhere($dato);
		
		return $q->fetchOne();
		
	}
	
}