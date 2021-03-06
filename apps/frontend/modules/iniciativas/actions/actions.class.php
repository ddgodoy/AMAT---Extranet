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
        $this->inicitivaCoun = IniciativaTable::getAll()->count();
  	$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	$this->pager = new sfDoctrinePager('Iniciativa', 15);
		$this->pager->getQuery()
                ->from('Iniciativa i')
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
		$this->contenidoBsq = $this->getRequestParameter('contenido_busqueda')?$this->getRequestParameter('contenido_busqueda'):$this->getUser()->getAttribute($modulo.'_nowcontenido');;

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND i.nombre LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->desdeBsq)) {
			$parcial .= " AND i.fecha >='".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowfechadesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND i.fecha <= '".format_date($this->hastaBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowfechahasta', $this->hastaBsq);
		}
		if (!empty($this->CatInicBsq)) {
			$parcial .= " AND i.categoria_iniciativa_id = $this->CatInicBsq";
			$this->getUser()->setAttribute($modulo.'_nowcatiniciativa', $this->CatInicBsq);
		}
		if (!empty($this->SubIniBsq)) {
			$parcial .= " AND i.subcategoria_iniciativa_id = $this->SubIniBsq";
			$this->getUser()->setAttribute($modulo.'_nowsubcatiniciativa', $this->SubIniBsq);
		}	
		if (!empty($this->contenidoBsq)) {
			$parcial .= " AND i.contenido LIKE '%$this->contenidoBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcontenido', $this->contenidoBsq);
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
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowfechadesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowfechahasta');
				$this->CatInicBsq = $this->getUser()->getAttribute($modulo.'_nowcatiniciativa');
				$this->SubIniBsq = $this->getUser()->getAttribute($modulo.'_nowsubcatiniciativa');
				$this->contenidoBsq = $this->getUser()->getAttribute($modulo.'_nowcontenido');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechadesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechahasta');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcatiniciativa');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcatiniciativa');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			$parcial="";
			$this->cajaBsq = "";
			$this->desdeBsq = '';
			$this->hastaBsq = '';
			$this->CatInicBsq = '';
			$this->SubIniBsq = '';
			$this->contenidoBsq = '';
		}
		return 'i.deleted=0'.$parcial;
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
                        $this->orderBy = 'i.nombre';
                        $this->sortType = 'asc';
                        $this->orderBYSql ='i.fecha desc,'.$this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  		
  }
  
  public function executeSubcategorias(sfWebRequest $request)
  {
    $subcategoria = SubCategoriaIniciativa::getArraySubCategoria($request->getParameter('id_categoria'));
    
    $witSub = new IniciativaForm();
    $witSub->setWidget('subcategoria_iniciativa_id', new sfWidgetFormChoice(array('choices' => $subcategoria)));
    
    return $this->renderPartial('subcategorias',array('witSub' => $witSub));
    
  } 
}