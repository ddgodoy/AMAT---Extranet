<?php

/**
 * categorias_d_g actions.
 *
 * @package    extranet
 * @subpackage categorias_d_g
 * @author     Pablo Peralta
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class categorias_d_gActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
	  $this->pager = new sfDoctrinePager('CategoriaDG', 20);
		$this->pager->getQuery()->from('CategoriaDG')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();
	
		$this->categoria_dg_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new CategoriaDGForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new CategoriaDGForm();
    
    $this->processForm($request, $this->form);

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($categoria_dg = Doctrine::getTable('CategoriaDG')->find($request->getParameter('id')), sprintf('Object categoria_dg does not exist (%s).', $request->getParameter('id')));
    $this->form = new CategoriaDGForm($categoria_dg);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($categoria_dg = Doctrine::getTable('CategoriaDG')->find($request->getParameter('id')), sprintf('Object categoria_dg does not exist (%s).', $request->getParameter('id')));
    $this->form = new CategoriaDGForm($categoria_dg);

    $this->processForm($request, $this->form);

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $toDelete = $request->getParameter('id');

  	if (!empty($toDelete)) {
  		$request->checkCSRFProtection();

  		$IDs = is_array($toDelete) ? $toDelete : array($toDelete);

  		foreach ($IDs as $id) {
  			$this->forward404Unless($categoria_dg = Doctrine::getTable('CategoriaDG')->find($id), sprintf('Object categoria_dg does not exist (%s).', $id));

		    sfLoader::loadHelpers('Security');
				if (!validate_action('baja')) $this->redirect('seguridad/restringuido');

		    $categoria_dg->delete();
  		}
  	}
    $this->redirect('categorias_d_g/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $categoria_dg = $form->save();
      
      $this->redirect('categorias_d_g/index');
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
