<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class OrganismoTable extends Doctrine_Table
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
	
	public static function doSelectByOrganismoa($id_subcategoria,$userId='')
	{
		if($userId == '')
		{
			$s=Doctrine_Query::create()
			->from('Organismo')
			->where('subcategoria_organismo_id = '.$id_subcategoria)
			->andWhere('deleted = 0');
		}
		else 
		{
			$s=Doctrine_Query::create()
			->from('Organismo o')
			->leftJoin('o.UsuarioOrganismo uo')
			->where('o.subcategoria_organismo_id = '.$id_subcategoria)
			->addWhere('uo.usuario_id = '.$userId)
			->andWhere('o.deleted = 0');
		}
		
		$subcategorias = $s->execute();
		
		return $subcategorias;
	}
	
	public static function getAllOrganismos()
	{
		$r = Doctrine_Query::create()->from('Organismo')->where('deleted = 0');
		$organismos = $r->execute();
		
		return $organismos; 
		
	}
	 public static function getOrganismo($id)
   {
   	 $r = Doctrine_Query::create()
   	 ->from('Organismo')
   	 ->where('id = '.$id);
   	 $respuesat = $r->fetchOne();
   	 
   	 return $respuesat;
   }
    public static function getOrganismoBysuer($idUser)
   {
   	 $r = Doctrine_Query::create()
   	 ->from('Organismo o')
   	 ->leftJoin('o.UsuarioOrganismo uo')
   	 ->where('uo.usuario_id = '.$idUser)
   	 ->addwhere('o.deleted = 0');
   	 
   	 $respuesat = $r->execute();
   	 
   	 return $respuesat;
   }
   public static function getUsuariosDeOrganismos($usuarioId)
	{
		$usuarios = array();
		$arrGruposTrabajos = OrganismoTable::getOrganismoBysuer($usuarioId);
		foreach ($arrGruposTrabajos AS $grupoTrabajo)
		{
			$arrUsuarios = $grupoTrabajo->getUsusriosMiOrganismo($usuarioId);
			
			foreach ($arrUsuarios as $usu)
			{
				
				$usuarios[] = $usu;
			}
			
		}
		 
		return $usuarios;
	}
	
}