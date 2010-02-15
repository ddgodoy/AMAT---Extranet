<?php

/**
 * tipos_comunicado actions.
 *
 * @package    extranet
 * @subpackage tipos_comunicado
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class tipos_comunicadoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	
  	$this->paginaActual = $this->getRequestParameter('page', 1);

	if (is_numeric($this->paginaActual)) {
		$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
	}
	    $this->pager = new sfDoctrinePager('TipoComunicado', 20);
	$this->pager->getQuery()->from('TipoComunicado')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->tipo_comunicado_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
	
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->tipo_comunicado = Doctrine::getTable('TipoComunicado')->find($request->getParameter('id'));
    $this->forward404Unless($this->tipo_comunicado);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new TipoComunicadoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new TipoComunicadoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($tipo_comunicado = Doctrine::getTable('TipoComunicado')->find($request->getParameter('id')), sprintf('Object tipo_comunicado does not exist (%s).', $request->getParameter('id')));
    $this->form = new TipoComunicadoForm($tipo_comunicado);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($tipo_comunicado = Doctrine::getTable('TipoComunicado')->find($request->getParameter('id')), sprintf('Object tipo_comunicado does not exist (%s).', $request->getParameter('id')));
    $this->form = new TipoComunicadoForm($tipo_comunicado);

    $this->processForm($request, $this->form);

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');

    $this->forward404Unless($tipo_comunicado = Doctrine::getTable('TipoComunicado')->find($request->getParameter('id')), sprintf('Object tipo_comunicado does not exist (%s).', $request->getParameter('id')));
    $tipo_comunicado->delete();

    $this->redirect('tipos_comunicado/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()),  $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $tipo_comunicado = $form->save();

      $this->redirect('tipos_comunicado/index');
    }
  }
  
    protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%')";
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
		$this->orderBy = 'nombre';
		$this->sortType = 'asc';

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }
}
