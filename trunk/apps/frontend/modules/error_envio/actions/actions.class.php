<?php

/**
 * error_envio actions.
 *
 * @package    extranet
 * @subpackage error_envio
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class error_envioActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	ServiceLeeremail::saveLeeremails();
  	$this->paginaActual = $this->getRequestParameter('page', 1);

	if (is_numeric($this->paginaActual)) {
		$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
	}
  	
	$this->pager = new sfDoctrinePager('EnvioError', 20);
	
	$this->pager->getQuery()->from('EnvioError er')
	->leftJoin('er.EnvioComunicado ec')
	->leftJoin('ec.Comunicado c')
	->leftJoin('er.Usuario u')
	->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->envio_error_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();

  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($envio_error = Doctrine::getTable('EnvioError')->find($request->getParameter('id')), sprintf('Object envio_error does not exist (%s).', $request->getParameter('id')));
    $envio_error->delete();

    $this->redirect('error_envio/index');
  }
  
  public function  executeEnviar(sfWebRequest $request)
  {
  	$id = $request->getParameter('id');
  	
  	if($id)
  	{
	  	foreach ($id AS $i)
	  	{
	    	$envio_error = Doctrine::getTable('EnvioError')->find($i);
	    	
	    	EnvioComunicado::ReenviarMail($envio_error->getEnvioId(),$envio_error->getUsuarioId());
	    	
	        $envio_error->delete();
	  	}   
      $this->redirect('error_envio/index');  	
  	}
  	 	
  	$this->getUser()->setFlash('notice', 'Selecciona un registro para enviar');
    $this->redirect('error_envio/index');  	
  }

   protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (c.nombre LIKE '%$this->cajaBsq%')";
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
		
		return 'deleted=0'.$parcial;
  }
  
  protected function setOrdenamiento()
  {
		$this->orderBy = 'er.created_at';
		$this->sortType = 'asc';

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }
}

