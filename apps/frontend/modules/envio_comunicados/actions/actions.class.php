<?php

/**
 * envio_comunicados actions.
 *
 * @package    extranet
 * @subpackage envio_comunicados
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class envio_comunicadosActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {  	
  	ServiceLeeremail::saveLeeremails();
  	$this->paginaActual = $this->getRequestParameter('page', 1);

	if (is_numeric($this->paginaActual)) {
		$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
	}
	
  	$this->pager = new sfDoctrinePager('EnvioComunicado', 20);
	$this->pager->getQuery()->from('EnvioComunicado ec')->leftJoin('ec.Comunicado c')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->envio_comunicado_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
	
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->envio_comunicado = Doctrine::getTable('EnvioComunicado')->find($request->getParameter('id'));
    $this->forward404Unless($this->envio_comunicado);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new EnvioComunicadoForm();
    $this->verComunicados = ComunicadoTable::getNoEnviados();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new EnvioComunicadoForm();
    $this->verComunicados = ComunicadoTable::getNoEnviados();
    $this->processForm($request, $this->form);

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($envio_comunicado = Doctrine::getTable('EnvioComunicado')->find($request->getParameter('id')), sprintf('Object envio_comunicado does not exist (%s).', $request->getParameter('id')));
    $this->form = new EnvioComunicadoForm($envio_comunicado);
    $this->verComunicados = ComunicadoTable::getNoEnviados();
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($envio_comunicado = Doctrine::getTable('EnvioComunicado')->find($request->getParameter('id')), sprintf('Object envio_comunicado does not exist (%s).', $request->getParameter('id')));
    $this->form = new EnvioComunicadoForm($envio_comunicado);
    $this->verComunicados = ComunicadoTable::getNoEnviados();
    $this->processForm($request, $this->form);

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');

    $this->forward404Unless($envio_comunicado = Doctrine::getTable('EnvioComunicado')->find($request->getParameter('id')), sprintf('Object envio_comunicado does not exist (%s).', $request->getParameter('id')));
    $envio_comunicado->delete();

    $this->redirect('envio_comunicados/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $envio_comunicado = $form->save();
      
      	$comunicado = $envio_comunicado->getComunicado();
      	
		if (!$comunicado->getEnviado()) 
		{
                        $ruta = dirname(__FILE__)."/../../../../../lib/task/envioComunicadosScript.php";
                        //echo "$ruta";die();
                        exec("php $ruta ".$envio_comunicado->getId()." 0 1"." > /dev/null &");
			//$envio_comunicado->enviarMails();
			$comunicado->setEnviado(1);			
			$comunicado->save();
		}
      
      $this->redirect('envio_comunicados/index');
    }
  }
  
  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->tipoBsq = $this->getRequestParameter('tiposdecomunicadosId');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (c.nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->tipoBsq)) {
			$parcial .= " AND tipo_comunicado_id = $this->tipoBsq ";
			$this->getUser()->setAttribute($modulo.'_nowtipo', $this->tipoBsq);
		}
		
		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowtipo');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->tipoBsq = $this->getUser()->getAttribute($modulo.'_nowtipo');
			}
		} 
		
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowtipo');
			$parcial="";
			$this->cajaBsq = "";
			$this->tipoBsq ="";
			
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
                        $this->orderBy = 'nombre';
                        $this->sortType = 'asc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }
}
