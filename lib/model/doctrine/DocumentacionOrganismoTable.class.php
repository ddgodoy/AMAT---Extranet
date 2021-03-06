<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class DocumentacionOrganismoTable extends DocumentacionTable
{
	public static function doSelectByOrganismo($organismo, $combo = '', $user = '')
	{
		if (empty($organismo)) {return false;}

		$q = Doctrine_Query::create();

		$q->from('DocumentacionOrganismo');
		$q->where('deleted = 0');
		$q->addWhere('organismo_id = ' . $organismo);
                if($user!= ''){
                $q->addWhere("owner_id = ".$user." OR estado != 'guardado'");
                }
		$q->orderBy('nombre ASC');

		$documentacion = $q->execute();
		
		return $documentacion;
	}
	
	public static function getDocumentacionOrganismo($Id_documentacion)
	{
		
		$s = Doctrine_Query::create();
		$s ->from('DocumentacionOrganismo');
		$s ->where('id = '.$Id_documentacion )->andWhere('deleted = 0');
		$retornar = $s->fetchOne();
		
		return $retornar;
		
	}
	
	public static function getAlldocumentacion()
	{
		$r = Doctrine_Query::create()->from('DocumentacionOrganismo')->where('deleted = 0');
		$alldocumentacion = $r->execute();
		
		return  $alldocumentacion;
	}
	
	
}