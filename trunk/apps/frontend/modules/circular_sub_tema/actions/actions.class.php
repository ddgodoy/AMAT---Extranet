<?php
/**
 * circular_sub_tema actions.
 *
 * @package    extranet
 * @subpackage circular_sub_tema
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class circular_sub_temaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {  	
  	$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		$this->pager = new sfDoctrinePager('CircularSubTema', 10);
		$this->pager->getQuery()
							  ->from('CircularSubTema s')
							  ->leftJoin('s.CircularCatTema c')
							  ->where($this->setFiltroBusqueda())
							  ->orderBy($this->setOrdenamiento());

		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->circular_sub_tema_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
		$this->circularCategoria = CircularCatTemaTable::getAllCircularCat();
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new CircularSubTemaForm();
    $this->circularCategoria = CircularCatTemaTable::getAllCircularCat();
    
  }

  public function executeCreate(sfWebRequest $request)
  {
//  	var_dump($request->getPostParameters('circular_sub_tema_circular_cat_tema_id'));
//    exit();
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new CircularSubTemaForm();
    $this->processForm($request, $this->form, 'creado');
    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($circular_sub_tema = Doctrine::getTable('CircularSubTema')->find($request->getParameter('id')), sprintf('Object circular_sub_tema does not exist (%s).', $request->getParameter('id')));
    $this->form = new CircularSubTemaForm($circular_sub_tema);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($circular_sub_tema = Doctrine::getTable('CircularSubTema')->find($request->getParameter('id')), sprintf('Object circular_sub_tema does not exist (%s).', $request->getParameter('id')));
    $this->form = new CircularSubTemaForm($circular_sub_tema);

    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($circular_sub_tema = Doctrine::getTable('CircularSubTema')->find($request->getParameter('id')), sprintf('Object circular_sub_tema does not exist (%s).', $request->getParameter('id')));
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('publicar')) $this->redirect('seguridad/restringuido');
    
    $circular_sub_tema->delete();

    $this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
    $this->redirect('circular_sub_tema/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {
    $form->bind($request->getParameter($form->getName()));
    
    if ($form->isValid()) {
    	
    
      $circular_sub_tema = $form->save();
      $strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';
      
      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");

      $this->redirect('circular_sub_tema/index'.$strPaginaVolver);
    }
  }

  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

  	$idCategoriaTema     = $this->getRequestParameter('cat');
		$this->cajaBsqNombre = $this->getRequestParameter('caja_buscar_nombre');
		$this->cajaBsqCat    = $this->getRequestParameter('caja_buscar_cat');

		if (!empty($idCategoriaTema)) {
			$this->cajaBsqCat = Doctrine::getTable('CircularCatTema')->find($idCategoriaTema)->getNombre();
		}
		if (!empty($this->cajaBsqNombre)) {
			$parcial .= " AND s.nombre LIKE '%$this->cajaBsqNombre%'";
			$this->getUser()->setAttribute($modulo.'_nowcajaNombre', $this->cajaBsqNombre);
		}
		if (!empty($this->cajaBsqCat)) {
			$parcial .= " AND s.circular_cat_tema_id =".$idCategoriaTema;
			$this->getUser()->setAttribute($modulo.'_nowcajaCat', $this->cajaBsqCat);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajaNombre');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajaCat');
			} else {
				$parcial             = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsqNombre = $this->getUser()->getAttribute($modulo.'_nowcajaNombre');
				$this->cajaBsqCat    = $this->getUser()->getAttribute($modulo.'_nowcajaCat');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajaNombre');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajaCat');
			$parcial="";
			$this->cajaBsqNombre = "";
			$this->cajaBsqCat = "";
		}
		return 's.deleted=0'.$parcial;
  }
  
  protected function setOrdenamiento()
  {
		$this->orderBy = 's.nombre';
		$this->sortType = 'asc';

		if ($this->hasRequestParameter('sort')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }

  ## ajax listar por categoria
  public function executeListByCategoria()
	{
		$this->sub_tema_selected = 0;
		$this->arraySubcategoriasTema = CircularSubTemaTable::doSelectByCategoria($this->getRequestParameter('id_categoria'));

		return $this->renderPartial('circular_sub_tema/selectByCategoria');
	}
}