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
  
  public function executeShow(sfWebRequest $request)
	{
		$this->error_envio = EnvioErrorTable::getEmailError($request->getParameter('id'));
		
		$this->forward404Unless($this->error_envio);
	}


  public function executeDelete(sfWebRequest $request)
  {$id = $request->getParameter('id');
  	
  	if($id)
  	{
	  	foreach ($id AS $i)
	  	{
	    	$envio_error = Doctrine::getTable('EnvioError')->find($i);
	    	
	        $envio_error->delete();
	  	}   
	  $this->getUser()->setFlash('notice', 'Los registro se Eliminaron');	
      $this->redirect('error_envio/index');  	
  	}
  	 	
  	$this->getUser()->setFlash('notice', 'Selecciona un registro para Eliminar');
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
	    $this->getUser()->setFlash('notice', 'Los registros se Enviaron');
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
                $modulo = $this->getModuleName();
		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
		}else {
                    if($this->getUser()->getAttribute($modulo.'_noworderBY'))
                    {
                       $this->orderBYSql = $this->getUser()->getAttribute($modulo.'_noworderBY');
                       $ordenacion = explode(' ', $this->orderBYSql);
                       $this->orderBy = $ordenacion[0];
                       $this->sortType = $ordenacion[1];
                    }   
                    else
                    {
                        $this->orderBy = 'er.created_at';
                        $this->sortType = 'desc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql); 
                    }    
                    
                }

		return $this->orderBYSql;
  }
}

