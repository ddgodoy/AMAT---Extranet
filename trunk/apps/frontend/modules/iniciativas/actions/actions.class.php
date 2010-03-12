<?php
/**
 * iniciativas actions.
 *
 * @package    extranet
 * @subpackage iniciativas
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class iniciativasActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	$this->pager = new sfDoctrinePager('Iniciativa', 15);
		$this->pager->getQuery()->from('Iniciativa')
		->where($this->setFiltroBusqueda())
		->orderBy($this->setOrdenamiento());
		
	
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->iniciativa_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
		
		############ navegacion giada años #################
		$this->months = '';
	  	$this->year = '';
		
		$this->modulo = $this->getModuleName();
  	
	  	$this->FEcha_circulares = Common::getListFechas($this->getModuleName());
	  	
	  	if($this->desdeBsq &&  $this->hastaBsq) 
	  	{ 
	  		$desdeBsq = explode('/',$this->desdeBsq);
	  		$hastaBsq = explode('/',$this->hastaBsq);
	  		if($desdeBsq[1] == $hastaBsq[1])
	  		{
	  			$this->months = $desdeBsq[1];
	  		}	
	  		$this->year = $desdeBsq[2];
	  	}	
	  	
		
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $this->iniciativa = Doctrine::getTable('Iniciativa')->find($request->getParameter('id'));
    $this->forward404Unless($this->iniciativa);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new IniciativaForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new IniciativaForm();
    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($iniciativa = Doctrine::getTable('Iniciativa')->find($request->getParameter('id')), sprintf('Object iniciativa does not exist (%s).', $request->getParameter('id')));
    $this->form = new IniciativaForm($iniciativa);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($iniciativa = Doctrine::getTable('Iniciativa')->find($request->getParameter('id')), sprintf('Object iniciativa does not exist (%s).', $request->getParameter('id')));
    $this->form = new IniciativaForm($iniciativa);

    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $toDelete = $request->getParameter('id');

  	if (!empty($toDelete)) {
  		$request->checkCSRFProtection();

  		$IDs = is_array($toDelete) ? $toDelete : array($toDelete);

  		foreach ($IDs as $id) {
  			$this->forward404Unless($iniciativa = Doctrine::getTable('Iniciativa')->find($id), sprintf('Object iniciativa does not exist (%s).', $id));

		    sfLoader::loadHelpers('Security');
				if (!validate_action('baja')) $this->redirect('seguridad/restringuido');

		    $iniciativa->delete();
  		}
  	}
    $this->redirect('iniciativas/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    
    if ($form->isValid()) {
    	$dato=Doctrine::getTable('Iniciativa')->find($request->getParameter('id'));
		if ($form->getValue('documento_delete') && $dato->getDocumento()) {	$dato->eliminarDocumento();	}
		
      $iniciativa = $form->save();
      $strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';

      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");

      $this->redirect('iniciativas/index'.$strPaginaVolver);
    }
  }

  protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda')?$this->getRequestParameter('desde_busqueda'):$this->getUser()->getAttribute($modulo.'_nowfechadesde');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda')?$this->getRequestParameter('hasta_busqueda'):$this->getUser()->getAttribute($modulo.'_nowfechahasta');
		$this->CatInicBsq = $this->getRequestParameter('select_cat_tema')?$this->getRequestParameter('select_cat_tema'):$this->getUser()->getAttribute($modulo.'_nowcatiniciativa');
		$this->SubIniBsq = $this->getRequestParameter('iniciativa[subcategoria_iniciativa_id]')?$this->getRequestParameter('select_cat_tema'):$this->getUser()->getAttribute($modulo.'_nowsubcatiniciativa');

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND nombre LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->desdeBsq)) {
			$parcial .= " AND fecha >='".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowfechadesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND fecha <= '".format_date($this->hastaBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowfechahasta', $this->hastaBsq);
		}
		if (!empty($this->CatInicBsq)) {
			$parcial .= " AND categoria_iniciativa_id = $this->CatInicBsq";
			$this->getUser()->setAttribute($modulo.'_nowcatiniciativa', $this->CatInicBsq);
		}
		if (!empty($this->SubIniBsq)) {
			$parcial .= " AND subcategoria_iniciativa_id = $this->SubIniBsq";
			$this->getUser()->setAttribute($modulo.'_nowsubcatiniciativa', $this->SubIniBsq);
		}	

			
		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechadesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechahasta');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcatiniciativa');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcatiniciativa');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowfechadesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowfechahasta');
				$this->CatInicBsq = $this->getUser()->getAttribute($modulo.'_nowcatiniciativa');
				$this->SubIniBsq = $this->getUser()->getAttribute($modulo.'_nowsubcatiniciativa');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechadesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechahasta');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcatiniciativa');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcatiniciativa');
			$parcial="";
			$this->cajaBsq = "";
			$this->desdeBsq = '';
			$this->hastaBsq = '';
			$this->CatInicBsq = '';
			$this->SubIniBsq = '';
		}
		return 'deleted=0'.$parcial;
  }
  
  protected function setOrdenamiento()
  {
  	if($this->getRequestParameter('sort'))
  	{
		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		else 
		{
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type');
		}
		return $this->orderBy . ' ' . $this->sortType;
  	}
  	else 
  	{
  		$this->orderBy = '';
		$this->sortType = 'asc';
  		
  		return 'fecha desc, nombre asc ';
  	}
  		
  }
  
  public function executeSubcategorias(sfWebRequest $request)
  {
    $subcategoria = SubCategoriaIniciativa::getArraySubCategoria($request->getParameter('id_categoria'));
    
    $witSub = new IniciativaForm();
    $witSub->setWidget('subcategoria_iniciativa_id', new sfWidgetFormChoice(array('choices' => $subcategoria)));
    
    return $this->renderPartial('subcategorias',array('witSub' => $witSub));
    
  } 
}