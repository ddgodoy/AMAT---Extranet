<?php

/**
 * notificaciones actions.
 *
 * @package    extranet
 * @subpackage notificaciones
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class notificacionesActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		
  	    $this->pager = new sfDoctrinePager('Notificacion', 10);  	    
		$this->pager->getQuery()
		->from('Notificacion n')
		->leftJoin('n.ContenidoNotificacion cn')
		->where($this->setFiltroBusqueda())
		->andWhere('n.usuario_id ='.$this->getUser()->getAttribute('userId'))
		->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->ultimos_avisos = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
  	 	
  	
//  	$this->ultimos_avisos = Doctrine::getTable('Notificacion')->getUltimasNotificaciones($this->getUser()->getAttribute('userId'), 10);
//  	
//  	$this->cantidadRegistros = count($this->ultimos_avisos);
  }
  
  public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		
		$this->forward404Unless($notificacion = Doctrine::getTable('Notificacion')->find($request->getParameter('id')), sprintf('Object avisos does not exist (%s).', $request->getParameter('id')));
		
		$notificacion->delete();
		
		$this->getUser()->setFlash('notice', "El registro ha sido eleiminado correctamente");
		
		$this->redirect('notificaciones/index');
	}
	
	public function executeVisar(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		
		$this->forward404Unless($notificacion = Doctrine::getTable('Notificacion')->find($request->getParameter('id')), sprintf('Object avisos does not exist (%s).', $request->getParameter('id')));
		
		$notificacion->setVisto(1);
		$notificacion->save();
		
		$this->getUser()->setFlash('notice', "El registro ha sido visado");
		
		$this->redirect('notificaciones/index');
	}
	
	protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('categoria');

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND cn.id = $this->cajaBsq";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$parcial="";
			$this->cajaBsq = "";
		}
		return 'n.deleted=0'.$parcial;
  }
  protected function setOrdenamiento()
  {
		$this->orderBy = 'n.created_at';
		$this->sortType = 'desc';

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }
 
}
