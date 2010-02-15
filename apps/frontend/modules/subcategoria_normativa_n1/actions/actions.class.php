<?php

/**
 * subcategoria_normativa_n1 actions.
 *
 * @package    extranet
 * @subpackage subcategoria_normativa_n1
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class subcategoria_normativa_n1Actions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	$this->pager = new sfDoctrinePager('SubCategoriaNormativaN1', 10);  	    
	$this->pager->getQuery()->from('SubCategoriaNormativaN1')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->SubCategoriaNormativaN1 = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();  
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new SubCategoriaNormativaN1Form();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new SubCategoriaNormativaN1Form();

    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($sub_categoria_normativa_n1 = Doctrine::getTable('SubCategoriaNormativaN1')->find($request->getParameter('id')), sprintf('Object sub_categoria_normativa_n1 does not exist (%s).', $request->getParameter('id')));
    $this->form = new SubCategoriaNormativaN1Form($sub_categoria_normativa_n1);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($sub_categoria_normativa_n1 = Doctrine::getTable('SubCategoriaNormativaN1')->find($request->getParameter('id')), sprintf('Object sub_categoria_normativa_n1 does not exist (%s).', $request->getParameter('id')));
    $this->form = new SubCategoriaNormativaN1Form($sub_categoria_normativa_n1);

    $this->processForm($request, $this->form, 'editar');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($sub_categoria_normativa_n1 = Doctrine::getTable('SubCategoriaNormativaN1')->find($request->getParameter('id')), sprintf('Object sub_categoria_normativa_n1 does not exist (%s).', $request->getParameter('id')));
    $sub_categoria_normativa_n1->delete();

    $this->redirect('subcategoria_normativa_n1/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion = '')
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $sub_categoria_normativa_n1 = $form->save();

      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");
      $this->redirect('subcategoria_normativa_n1/index');		      
    }
  }
  
  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->categoriaBsq = $this->getRequestParameter('categoria');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->categoriaBsq)) {
			$parcial .= " AND categoria_normativa_id = $this->categoriaBsq ";
			$this->getUser()->setAttribute($modulo.'_nowcategoria', $this->categoriaBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowcategoria');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
			$parcial="";
			$this->cajaBsq = "";
			$this->categoriaBsq = '';
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
