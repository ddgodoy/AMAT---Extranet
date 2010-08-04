<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ConsejoTerritorial extends BaseConsejoTerritorial
{
	public function __toString()
	{
		return $this->nombre;
	}
	
	public static function getRepository()
	{
		return Doctrine::getTable(__CLASS__);
	}
	
	public function getUsusriosMiconsejo($usuarioId)
	{
		$s = Doctrine_Query::create();
		$s->select('u.*');
		$s->from('Usuario u');
		$s->leftJoin('u.UsuarioConsejoTerritorial uct');
		$s->where('uct.consejo_territorial_id = '.$this->getId() );
		$s->andWhere('u.id != '.$usuarioId);
                $s->andWhere('u.deleted = 0 AND u.activo=1');
		
		$usuarios = $s->execute();
		
		return $usuarios;
	}
	public static  function ArrayDeconsejo($id_usuario)
	{
		$consejos = ConsejoTerritorialTable::getConsejosTerritorialesByUsuario($id_usuario);
		$base = 'ConsejoTerritorial_';
		$presentacion = array();
		foreach ( $consejos AS $consejosid )
		{
			$armado = $base.$consejosid['id'];
			$presentacion[$armado] = 'Consejo - '.$consejosid['nombre'];
			
		}
		
		return $presentacion; 
	}
	
	public static  function ArrayDeMiconsejo($id_usuario, $choices='')
	{
		$consejos = ConsejoTerritorialTable::getConsejosTerritorialesByUsuario($id_usuario);
		$base = 'ConsejoTerritorial_';
		$presentacion = array();
		foreach ( $consejos AS $consejosid )
		{
                        if ($choices == '') {
			  $armado = $base.$consejosid['id'];
			} else {
			  $armado = $consejosid['id'];
			}
			$presentacion[$armado] = $consejosid['nombre'];
		}
		
		return $presentacion; 
	}
	
	public static  function IdDeconsejo($id_usuario,$misuser='')
	{
		$consejos = ConsejoTerritorialTable::getConsejosTerritorialesByUsuario($id_usuario,$consojo='');
		
		if(count($consejos)>0)
		{
			if($misuser=='')
			{
				$armado =" AND am.entidad IN (";
				$base = 'ConsejoTerritorial_';
			}	
			else 
			{
				$armado ="(";
				$base = '';
			}
			$rt = 0;
			foreach ( $consejos AS $gruposid )
			{ 
				$rt++;
				if($rt != count($consejos))
				{
				  $armado .= "'".$base.$gruposid->getId()."',";
				}
				else 
				{
				  $armado .= "'".$base.$gruposid->getId()."')";
				}
				
				
			}
		}
		else 
		{
			$armado='(0)';
		}
		
	   return 	$armado;
	}
}