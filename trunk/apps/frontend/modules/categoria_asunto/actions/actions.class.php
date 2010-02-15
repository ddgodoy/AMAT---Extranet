<?php
/**
 * categoria_asunto actions.
 *
 * @package    extranet
 * @subpackage categoria_asunto
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class categoria_asuntoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	$this->pager = new sfDoctrinePager('CategoriaAsunto', 10);  	    
		$this->pager->getQuery()->from('CategoriaAsunto')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->categoria_asunto_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new CategoriaAsuntoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new CategoriaAsuntoForm();
    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($categoria_asunto = Doctrine::getTable('CategoriaAsunto')->find($request->getParameter('id')), sprintf('Object categoria_asunto does not exist (%s).', $request->getParameter('id')));
    $this->form = new CategoriaAsuntoForm($categoria_asunto);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($categoria_asunto = Doctrine::getTable('CategoriaAsunto')->find($request->getParameter('id')), sprintf('Object categoria_asunto does not exist (%s).', $request->getParameter('id')));
    $this->form = new CategoriaAsuntoForm($categoria_asunto);

    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($categoria_asunto = Doctrine::getTable('CategoriaAsunto')->find($request->getParameter('id')), sprintf('Object categoria_asunto does not exist (%s).', $request->getParameter('id')));
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');
    
    
    $categoria_asunto->delete();

		$this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
    $this->redirect('categoria_asunto/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {
    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid()) {
     
      $categoria_asunto = $form->save();
      $strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';

      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");

      $this->redirect('categoria_asunto/index'.$strPaginaVolver);
    }
  }

  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%' OR email_2 LIKE '%$this->cajaBsq%' OR email_1 LIKE '%$this->cajaBsq%')";
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

		if ($this->hasRequestParameter('sort')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }
}