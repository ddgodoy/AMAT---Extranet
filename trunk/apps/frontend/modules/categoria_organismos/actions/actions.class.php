<?php

/**
 * categoria_organismos actions.
 *
 * @package    extranet
 * @subpackage categoria_organismos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class categoria_organismosActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	$this->pager = new sfDoctrinePager('CategoriaOrganismo', 10);  	    
	$this->pager->getQuery()->from('CategoriaOrganismo')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->categoria_organismo_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->categoria_organismo = Doctrine::getTable('CategoriaOrganismo')->find($request->getParameter('id'));
    $this->forward404Unless($this->categoria_organismo);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new CategoriaOrganismoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new CategoriaOrganismoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($categoria_organismo = Doctrine::getTable('CategoriaOrganismo')->find($request->getParameter('id')), sprintf('Object categoria_organismo does not exist (%s).', $request->getParameter('id')));
    $this->form = new CategoriaOrganismoForm($categoria_organismo);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($categoria_organismo = Doctrine::getTable('CategoriaOrganismo')->find($request->getParameter('id')), sprintf('Object categoria_organismo does not exist (%s).', $request->getParameter('id')));
    $this->form = new CategoriaOrganismoForm($categoria_organismo);

    $this->processForm($request, $this->form);

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($categoria_organismo = Doctrine::getTable('CategoriaOrganismo')->find($request->getParameter('id')), sprintf('Object categoria_organismo does not exist (%s).', $request->getParameter('id')));
    
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');
    
    $categoria_organismo->delete();

    $this->redirect('categoria_organismos/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $categoria_organismo = $form->save();

      $this->redirect('categoria_organismos/index');
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
  public function executeListCategoriaOrg()
	{
		$this->arrayCategoriasOrganismos = OrganismoTable::doSelectAllCategorias('CategoriaOrganismo');

		return $this->renderPartial('categoria_organismos/LystCategoriaOrganismos');
	}
  
  public function executeListSubCategoriaOrg()
	{
		$this->idCart=$this->getRequestParameter('id');
		
		$this->subCAtOrg=SubCategoriaOrganismoTable::doSelectByCategoria($this->getRequestParameter('id'));

		return $this->renderPartial('categoria_organismos/LystSubCategori');
	}
  
  
  
  
  
}
