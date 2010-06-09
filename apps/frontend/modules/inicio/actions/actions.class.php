<?php

/**
 * inicio actions.
 *
 * @package    extranet
 * @subpackage inicio
 * @author     Matias Gentiletti
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class inicioActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->aplicacionesExternas = UsuarioTable::getAplicacionesExternasByUsuario(sfContext::getInstance()->getUser()->getAttribute("userId"));
	}
	
	public function executeExportar(sfWebRequest $request)
	{
			$tabla = ucfirst($request->getParameter('tabla'));
			$extencion = $this->getRequestParameter('tipo');
			$resultadoObj = '';
			$filtro = 'deleted = 0'.$this->getUser()->getAttribute($request->getParameter('filtro'));
			
			if($tabla == 'UsuarioGrupo')
			{
                            $usuario = Doctrine_Query::create()
                            ->from('Usuario u')
                            ->leftJoin('u.UsuarioGrupoTrabajo ug')
                            ->leftJoin('ug.GrupoTrabajo g')
                            ->leftJoin('u.UsuarioRol ur')
                            ->where($this->setFiltroBusqueda())
                            ->andWhere('ur.rol_id IN (4,6)');


			  $resultadoObj = $usuario->execute();
			  
			}
			if($tabla == 'UsuarioConsejoTerritorial')
			{

                          $usuario = Doctrine_query::create()
                             ->from('Usuario u')
                             ->leftJoin('u.UsuarioConsejoTerritorial uc')
                             ->leftJoin('uc.ConsejoTerritorial c')
                             ->leftJoin('u.UsuarioRol ur')
                             ->where($this->setFiltroBusqueda())
                             ->andWhere('ur.rol_id IN (5,7)')
                             ->groupBy('uc.usuario_id');
			  
	
			  $resultadoObj = $usuario->execute();
			  
			}
			if($tabla == 'UsuarioOrganismo')
			{
			  $usuario = Doctrine_Query::create()
                            ->from('Usuario u')
                            ->leftJoin('u.UsuarioOrganismo uo')
                            ->leftJoin('u.UsuarioRol ur')
                            ->leftJoin('uo.Organismo o')
                            ->where($filtro)
                            ->andWhere('ur.rol_id IN (4,6)')
                            ->groupBy('uo.usuario_id');

                          

			  $resultadoObj = $usuario->execute() ;
			  
			}
			if($tabla == 'Organismo')
			{
			  $organismos = Doctrine_Query::create()
			  ->from('Organismo o')
                          ->leftJoin('o.UsuarioOrganismo uo')
			  ->addWhere($filtro);

			  $resultadoObj = $organismos->execute();
			} 
			
			if($tabla == 'Usuario')
			{
			  $usuarios = Doctrine_Query::create()
			    ->from('Usuario u')
                            ->leftJoin('u.UsuarioGrupoTrabajo ug')
		            ->leftJoin('u.UsuarioConsejoTerritorial uc')
		            ->leftJoin('u.UsuarioRol ur')
		            ->leftJoin('u.Mutua m')
                            ->where('u.id>1')
                            ->addWhere($filtro)
                            ->groupBy('u.id');
			 
			  
			  $resultadoObj = $usuarios->execute();
			  
			 
			} 
			if($tabla == 'AsambleCombocadas')
			{
				$asambleas = Doctrine_Query::create()
				->from('Convocatoria c')
			    ->leftJoin('c.Asamblea a')
			    ->where('c.deleted = 0')
			    ->addWhere('c.usuario_id='.sfContext::getInstance()->getUser()->getAttribute('userId'));
			    $Convocatoria = $asambleas->execute();
			    $this->Convocatoria = $Convocatoria;
			}
			
			if($tabla == 'AplicacionRol')
			{
				$AplicacionRol = Doctrine_Query::create()
				->from('AplicacionRol ar')
				->leftJoin('ar.Rol r')
			    ->leftJoin('ar.Aplicacion a')
			    ->where($filtro)
			    ->andWhere('a.id != 46 AND a.id != 44');
			    
			     $resultadoObj = $AplicacionRol->execute();
			}
			
			if($tabla == 'Evento')
			{
				$AplicacionRol = Doctrine_Query::create()
				->from('Evento e')
				->leftJoin('e.UsuarioEvento ue')
			        ->where($filtro);
			    
			     $resultadoObj = $AplicacionRol->execute();
			}
			
			if($tabla == 'Avisos')
			{
				$resultadoObj = Doctrine::getTable('Notificacion')->getUltimasNotificaciones(sfContext::getInstance()->getUser()->getAttribute('userId'));
			}
                        if($tabla == 'Normativa')
			{
                                $Normativa = Doctrine_Query::create()
				->from('Normativa n')
				->leftJoin('n.CategoriaNormativa cn')
                                ->leftJoin('n.SubCategoriaNormativaN1 scn1')
                                ->leftJoin('n.SubCategoriaNormativaN2 scn2')
			        ->where($filtro);

			     $resultadoObj = $Normativa->execute();
			}
			if( $tabla != 'Evento' && $tabla != 'AplicacionRol' && $tabla != 'Organismo' && $tabla != 'Usuario' && $tabla != 'UsuarioOrganismo' && $tabla != 'UsuarioConsejoTerritorial' && $tabla != 'UsuarioGrupo' && $tabla != 'AsambleCombocadas' && $tabla != 'Avisos' )
			{
				$c = Doctrine_Query::create();
				$c->from($tabla)->where($filtro);
				$resultadoObj = $c->execute();
			}
			
			$this->resultadoObj = $resultadoObj;
			$this->extencion = $extencion; 
			$this->setLayout(false);
			
			
			
			$this->getResponse()->setContentType('application/msexcel');
	                $this->getResponse()->setHttpHeader('Content-Disposition','attachment; filename=lista'.$extencion, TRUE);



//			$this->getResponse()->setHttpHeader('Cache-Control', 'public, must-revalidate', true);
//            $this->getResponse()->setHttpHeader('Pragma', 'hack', true);
//            $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream', true);
//            $this->getResponse()->setHttpHeader('Content-Transfer-Encoding', 'binary', true);
//            $this->getResponse()->setHttpHeader('Content-Disposition','attachment; filename=lista'.$extencion, TRUE);
//            $this->getResponse()->setHttpHeader('Expires', '0', true);
            

	    
		}
		
}
