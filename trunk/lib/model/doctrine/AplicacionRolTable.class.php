<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class AplicacionRolTable extends Doctrine_Table
{
   public static function getAplicacionRol($id)
   {
   	 $r = Doctrine_Query::create()
   	 ->from('Aplicacion')
   	 ->where('id = '.$id);
   	 $respuesat = $r->fetchOne();
   	 
   	 return $respuesat;
   }
   
   
   public static function getEmailPublicar($IDaplic = '', $gru = '', $cons= '', $org = '')
   {
   	 $r=Doctrine_Query::create()
   	    ->from('Usuario u');
   	 if($gru !='')
   	 {   
   	    $r->leftJoin('u.UsuarioGrupoTrabajo ugr');
   	 }  
   	 if($cons !='')
   	 { 
   	   $r->leftJoin('u.UsuarioConsejoTerritorial uct');
   	 }
   	 if($org ='')
   	 {   
   	   $r->leftJoin('u.UsuarioOrganismo uo');
   	 }  
   	   $r->leftJoin('u.UsuarioRol ur')
   	    ->leftJoin('ur.Rol r')
   	    ->leftJoin('r.AplicacionRol ar')
   	    ->where('ar.accion_publicar = 1');
   	    if($IDaplic!='')
   	    {
   	     	$r->andWhere('ar.aplicacion_id = '.$IDaplic);
   	    } 	
   	    if($gru !='')
	   	 {   
	   	    $r->andWhere('ugr.grupo_trabajo_id = '.$gru);
	   	 }  
	   	 if($cons !='')
	   	 { 
	   	   $r->andWhere('uct.consejo_territorial_id = '.$cons);
	   	 }
	   	 if($org !='')
	   	 {   
	   	   $r->andWhere('uo.organismo_id = '.$org);
	   	 }  
   	    $r->andWhere('u.deleted = 0');
   	  
   	    echo $r->getQuery();
   	    exit();
   	  return $r->execute();   
   }
   
   public static function getAplicacionByRol($idrol)
   {
   	 $r=Doctrine_Query::create()
   	    ->from('AplicacionRol ar')
   	    ->leftJoin('ar.Aplicacion a')
   	    ->andWhere('ar.rol_id = '.$idrol)
   	    ->andWhere('a.deleted = 0 AND ar.deleted = 0')
   	    ->andWhere('a.id != 44 AND a.id != 46')
   	    ->orderBy('a.nombre');
   	   
   	  return $r->execute();   
   }
   
   
   
}