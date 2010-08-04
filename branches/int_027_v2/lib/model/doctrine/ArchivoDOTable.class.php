<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ArchivoDOTable extends Doctrine_Table
{
	public static function doSelectAllCategorias($tabla)
	{
		$q = Doctrine_Query::create();

		$q->from($tabla);
		$q->where('deleted = 0');
		$q->orderBy('nombre ASC');

		$categorias = $q->execute();

		return $categorias;
	}
	
	public static function doSelectArchivos($id_organismo)
	{
		
		$s = Doctrine_Query::create();
		$s->from('ArchivoDO');
		$s->where('organismo_id ='.$id_organismo );
		
		$retorno = $s->execute();
		
		return  $retorno;
	}
	
	public static function getAll()
	{
		
		$s = Doctrine_Query::create();
		$s->from('ArchivoDO');
		$s->where('deleted = 0' );
		$retorno = $s->execute();
		
		return  $retorno;
	}
	
	public static function getAllByDocumentacion($id)
	{
		$q = Doctrine_Query::create()
		->from('ArchivoDO')
		->where('documentacion_organismo_id = '.$id)
		->addWhere('deleted = 0');
		
		return $q->execute();
	}

         public static function getAllByDocumentacionConfidencial($id, $userREs, $user)
	{
		$q = Doctrine_Query::create()
		->from('ArchivoDO')
		->where('documentacion_organismo_id = '.$id)
                ->andWhere('owner_id '.$userREs.' OR owner_id = '.$user)
		->addWhere('deleted = 0');

		return $q->execute();
	}
}