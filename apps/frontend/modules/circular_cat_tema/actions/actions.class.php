<?php
/**
 * circular_cat_tema actions.
 *
 * @package    extranet
 * @subpackage circular_cat_tema
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class circular_cat_temaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		$this->pager = new sfDoctrinePager('CircularCatTema', 10);
		$this->pager->getQuery()->from('CircularCatTema')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->circular_cat_tema_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new CircularCatTemaForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new CircularCatTemaForm();
    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($circular_cat_tema = Doctrine::getTable('CircularCatTema')->find($request->getParameter('id')), sprintf('Object circular_cat_tema does not exist (%s).', $request->getParameter('id')));
    $this->form = new CircularCatTemaForm($circular_cat_tema);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($circular_cat_tema = Doctrine::getTable('CircularCatTema')->find($request->getParameter('id')), sprintf('Object circular_cat_tema does not exist (%s).', $request->getParameter('id')));
    $this->form = new CircularCatTemaForm($circular_cat_tema);

    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($circular_cat_tema = Doctrine::getTable('CircularCatTema')->find($request->getParameter('id')), sprintf('Object circular_cat_tema does not exist (%s).', $request->getParameter('id')));
    
     sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');
    
    $circular_cat_tema->delete();

    $this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
    $this->redirect('circular_cat_tema/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {
    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid()) {
      $circular_cat_tema = $form->save();
      $strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';
      
      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");

      $this->redirect('circular_cat_tema/index'.$strPaginaVolver);
    }
  }
  
  protected function setFiltroBusqueda()
  {
		$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND nombre LIKE '%$this->cajaBsq%'";
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
                        $this->orderBy = 'nombre';
                        $this->sortType = 'asc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }
  
  ## ajax listar  categoria
  public function executeListCategoria(sfWebRequest $request)
	{
		$this->tabla = $request->getParameter('tabla');
		$this->modulo = $request->getParameter('modulo');
		
		$this->arrayCategoriasTema = CircularTable::doSelectAllCategorias($this->tabla);

		return $this->renderPartial('circular_cat_tema/LystCategoria');
	}
  
  public function executeListSubCategoria(sfWebRequest $request)
	{
		$this->id = $this->getRequestParameter('id');
		$this->tabla = $request->getParameter('tabla');
		$this->modulo = $request->getParameter('modulo');
		if($this->tabla == 'CircularCatTema' )
		{	
     		$this->subCAtTem = CircularSubTemaTable::doSelectByCategoria($this->getRequestParameter('id'));
		}
		if($this->tabla == 'CategoriaIniciativa' )	
		{
			$this->subCAtTem = SubCategoriaIniciativaTable::getSubcategiriaBycategoria($this->id);
		}
		if($this->tabla == 'CategoriaNormativa' )	
		{
			$this->subCAtTem = SubCategoriaNormativaN1Table::getSubcategiriaBycategoria($this->id);
		}
		
 
		return $this->renderPartial('circular_cat_tema/LystSubCategoria');
	}
	
  public function executeListSubCategoria2(sfWebRequest $request)
	{
		$this->id = $this->getRequestParameter('id_sub1');
		$this->tabla = $request->getParameter('tabla');
		$this->modulo = $request->getParameter('modulo');
		$this->categoria = $request->getParameter('categoria');
		
		if($this->tabla == 'CategoriaNormativa' )	
		{
			$this->subCAtTem = SubCategoriaNormativaN2Table::getSubcategiriaBycategoria($this->id);
		}
		
 
		return $this->renderPartial('circular_cat_tema/LystSubCategoria2');
	}	
  
  
}