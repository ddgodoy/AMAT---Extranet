<?php

/**
 * categoria_iniciativa actions.
 *
 * @package    extranet
 * @subpackage categoria_iniciativa
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class categoria_iniciativaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {  
    $this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	$this->pager = new sfDoctrinePager('CategoriaIniciativa', 10);  	    
	$this->pager->getQuery()->from('CategoriaIniciativa')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->CategoriaIniciativa = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();     
      
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new CategoriaIniciativaForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new CategoriaIniciativaForm();

    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($categoria_iniciativa = Doctrine::getTable('CategoriaIniciativa')->find($request->getParameter('id')), sprintf('Object categoria_iniciativa does not exist (%s).', $request->getParameter('id')));
    $this->form = new CategoriaIniciativaForm($categoria_iniciativa);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($categoria_iniciativa = Doctrine::getTable('CategoriaIniciativa')->find($request->getParameter('id')), sprintf('Object categoria_iniciativa does not exist (%s).', $request->getParameter('id')));
    $this->form = new CategoriaIniciativaForm($categoria_iniciativa);

    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($categoria_iniciativa = Doctrine::getTable('CategoriaIniciativa')->find($request->getParameter('id')), sprintf('Object categoria_iniciativa does not exist (%s).', $request->getParameter('id')));
    $categoria_iniciativa->delete();

    $this->redirect('categoria_iniciativa/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {
  	
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $categoria_iniciativa = $form->save();

      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");
      $this->redirect('categoria_iniciativa/index');
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
