<?php
/**
 * normativas actions.
 *
 * @package    extranet
 * @subpackage normativas
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
 
class normativasActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
        $this->normativaCoun = NormativaTable::getAll()->count();
  	$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	$this->pager = new sfDoctrinePager('Normativa', 15);
	$this->pager->getQuery()->from('Normativa')
        ->where($this->setFiltroBusqueda())
        ->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->normativa_list = $this->pager->getResults();
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
    $this->normativa = Doctrine::getTable('Normativa')->find($request->getParameter('id'));
    $this->forward404Unless($this->normativa);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new NormativaForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new NormativaForm();
    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($normativa = Doctrine::getTable('Normativa')->find($request->getParameter('id')), sprintf('Object normativa does not exist (%s).', $request->getParameter('id')));
    $this->form = new NormativaForm($normativa);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($normativa = Doctrine::getTable('Normativa')->find($request->getParameter('id')), sprintf('Object normativa does not exist (%s).', $request->getParameter('id')));
    $this->form = new NormativaForm($normativa);

    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($normativa = Doctrine::getTable('Normativa')->find($request->getParameter('id')), sprintf('Object normativa does not exist (%s).', $request->getParameter('id')));
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');
    
    $normativa->delete();

		$this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
    $this->redirect('normativas/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {      
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid()) {
    	$dato = Doctrine::getTable('Normativa')->find($request->getParameter('id'));

			if ($form->getValue('documento_delete') && $dato->getDocumento()) {	$dato->eliminarDocumento();	}
						
      $normativa = $form->save();
      $strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';
	  
      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");

      $this->redirect('normativas/index'.$strPaginaVolver);
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
		$this->publicacionDesdeBsq = $this->getRequestParameter('publicacion_busqueda_desde')?$this->getRequestParameter('publicacion_busqueda_desde'):$this->getUser()->getAttribute($modulo.'_nowpublicacion_desde');
		$this->publicacionHastaBsq = $this->getRequestParameter('publicacion_busqueda_hasta')?$this->getRequestParameter('publicacion_busqueda_hasta'):$this->getUser()->getAttribute($modulo.'_nowpublicacion_hasta');
		$this->CatNormBsq = $this->getRequestParameter('select_cat_tema')?$this->getRequestParameter('select_cat_tema'):$this->getUser()->getAttribute($modulo.'_nowcatnormativa');;
		$this->SubNormBsq1 = $this->getRequestParameter('normativa[subcategoria_normativa_uno_id]')?$this->getRequestParameter('normativa[subcategoria_normativa_uno_id]'):$this->getUser()->getAttribute($modulo.'_nowsubcatnormativa1');;
		$this->SubNormBsq2 = $this->getRequestParameter('normativa[subcategoria_normativa_dos_id]')?$this->getRequestParameter('normativa[subcategoria_normativa_dos_id]'):$this->getUser()->getAttribute($modulo.'_nowsubcatnormativa2');;
		$this->contenidoBsq = $this->getRequestParameter('contenido_busqueda')?$this->getRequestParameter('contenido_busqueda'):$this->getUser()->getAttribute($modulo.'_nowcontenido');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND n.nombre LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->desdeBsq)) {
			$parcial .= " AND n.fecha >='".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowfechadesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND n.fecha <= '".format_date($this->hastaBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowfechahasta', $this->hastaBsq);
		}
		if (!empty($this->publicacionDesdeBsq)) {
			$parcial .= " AND n.publicacion_boe >= '".format_date($this->publicacionDesdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowpublicacion_desde', $this->publicacionDesdeBsq);
		}
		if (!empty($this->publicacionHastaBsq)) {
			$parcial .= " AND n.publicacion_boe <= '".format_date($this->publicacionHastaBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowpublicacion_hasta', $this->publicacionHastaBsq);
		}
		if (!empty($this->CatNormBsq)) {
			$parcial .= " AND n.categoria_normativa_id  = $this->CatNormBsq";
			$this->getUser()->setAttribute($modulo.'_nowcatnormativa', $this->CatNormBsq);
		}
		if (!empty($this->SubNormBsq1)) {
			$parcial .= " AND n.subcategoria_normativa_uno_id = $this->SubNormBsq1";
			$this->getUser()->setAttribute($modulo.'_nowsubcatnormativa1', $this->SubNormBsq1);
		}
		if (!empty($this->SubNormBsq2)) {
			$parcial .= " AND n.subcategoria_normativa_dos_id = $this->SubNormBsq2";
			$this->getUser()->setAttribute($modulo.'_nowsubcatnormativa2', $this->SubNormBsq2);
		}
		if (!empty($this->contenidoBsq)) {
			$parcial .= " AND n.contenido LIKE '%$this->contenidoBsq%'";
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
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowpublicacion_desde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowpublicacion_hasta');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcatnormativa');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcatnormativa1');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcatnormativa2');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowfechadesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowfechahasta');
				$this->publicacionDesdeBsq = $this->getUser()->getAttribute($modulo.'_nowpublicacion_desde');
				$this->publicacionHastaBsq = $this->getUser()->getAttribute($modulo.'_nowpublicacion_hasta');
				$this->CatNormBsq = $this->getUser()->getAttribute($modulo.'_nowcatnormativa');
				$this->SubNormBsq1 = $this->getUser()->getAttribute($modulo.'_nowsubcatnormativa1');
				$this->SubNormBsq2 = $this->getUser()->getAttribute($modulo.'_nowsubcatnormativa2');
				$this->contenidoBsq = $this->getUser()->getAttribute($modulo.'_nowcontenido');
				
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechadesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechahasta');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowpublicacion_desde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowpublicacion_hasta');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcatnormativa');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcatnormativa1');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcatnormativa2');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			$parcial="";
			$this->cajaBsq = "";
			$this->desdeBsq = '';
			$this->hastaBsq = '';
			$this->publicacionDesdeBsq = '';
			$this->publicacionHastaBsq = '';
			$this->CatNormBsq = '';
			$this->SubNormBsq1 = '';
			$this->SubNormBsq2 = '';
			$this->contenidoBsq = '';
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
                        $this->orderBy = 'n.fecha';
                        $this->sortType = 'desc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }
  
  public function executeSubcategoriasn1(sfWebRequest $request)
  {
  	return $this->renderComponent('normativas','subcategoriasn1');
  }
  
  public function executeSubcategoriasn2(sfWebRequest $request)
  {
  	
    $subcategoria = SubCategoriaNormativaN2::getArraySubCategoria($request->getParameter('id_subcategoria'));
   
    $witSub = new NormativaForm();
	    
	$witSub->setWidget('subcategoria_normativa_dos_id', new sfWidgetFormChoice(array('choices' => $subcategoria),array('style'=>'width:150px;')));
    	
    return $this->renderPartial('subcategorias',array('witSub' => $witSub));
    
  } 
}