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
			  $usuario = Doctrine::getTable('Usuario')->find(sfContext::getInstance()->getUser()->getAttribute('userId'));
			  $resultadoObj = $usuario->UsuariosdeMisGrupos();
			  
			}
			if($tabla == 'UsuarioConsejoTerritorial')
			{
			  
			  $usuario = Doctrine::getTable('Usuario')->find(sfContext::getInstance()->getUser()->getAttribute('userId'));
			  $resultadoObj = $usuario->UsuariosdeMisConsejos();
			  
			}
			if($tabla == 'UsuarioOrganismo')
			{
			  
			  $usuario = Doctrine::getTable('Usuario')->find(sfContext::getInstance()->getUser()->getAttribute('userId'));
			  $resultadoObj = $usuario->UsuariosdeMisOrganismos();
			  
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
			if($tabla == 'Avisos')
			{
				$resultadoObj = Doctrine::getTable('Notificacion')->getUltimasNotificaciones(sfContext::getInstance()->getUser()->getAttribute('userId'));
			}
			if($tabla != 'Usuario' && $tabla != 'UsuarioOrganismo' && $tabla != 'UsuarioConsejoTerritorial' && $tabla != 'UsuarioGrupo' && $tabla != 'AsambleCombocadas' && $tabla != 'Avisos' )
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
