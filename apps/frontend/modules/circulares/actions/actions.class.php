<?php
/**
 * circulares actions.
 *
 * @package    extranet
 * @subpackage circulares
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class circularesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$this->circularCoun = CircularTable::getAll()->count();
  	$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	        $this->pager = new sfDoctrinePager('Circular', 15);
		$this->pager->getQuery()->from('Circular c')
		->where($this->setFiltroBusqueda())
		->orderBy($this->setOrdenamiento());
		
		
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->circular_list = $this->pager->getResults();
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

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new CircularForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new CircularForm();
    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($circular = Doctrine::getTable('Circular')->find($request->getParameter('id')), sprintf('Object circular does not exist (%s).', $request->getParameter('id')));
    $this->form = new CircularForm($circular);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($circular = Doctrine::getTable('Circular')->find($request->getParameter('id')), sprintf('Object circular does not exist (%s).', $request->getParameter('id')));
    $this->form = new CircularForm($circular);

    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }
  
  public function executeShow(sfWebRequest $request)
	{
		$this->circular = Doctrine::getTable('Circular')->find($request->getParameter('id'));
		$this->forward404Unless($this->circular);
	}
  
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($circular = Doctrine::getTable('Circular')->find($request->getParameter('id')), sprintf('Object circular does not exist (%s).', $request->getParameter('id')));
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');
    
    
    $circular->delete();

		$this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
    $this->redirect('circulares/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {
  	
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid()) {
      $circular = $form->save();
     

//      $banderaSub     = 0;
//      $xSelectSubTema = $request->getParameter('select_sub_tema');
//      $xSelectSubOrg  = $request->getParameter('[subcategoria_organismo_id]');
//
//      if (!empty($xSelectSubTema)){ $circular->setCircularSubTemaId($xSelectSubTema); $banderaSub = 1; }
//      if (!empty($xSelectSubOrg)) { $circular->setSubcategoriaOrganismoId($xSelectSubOrg); $banderaSub = 1; }
//
//      if ($banderaSub == 1) {
//      	$circular->save();
//      }
      $strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';

      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");

      $this->redirect('circulares/index'.$strPaginaVolver);
    }
  }

   protected function getListFechas(sfWebRequest $request)
  {    
  	    $this->modulo = $request->getParameter('modulo');
  	    $this->FEcha_circulares = Circular::getRanfoDEfechas($request->getParameter('modulo'));
  	    
  	    //return $this->renderPartial('circulares/LystFecha');
  }
  
   protected function getListMes(sfWebRequest $request)
  {
  	    $this->modulo = $request->getParameter('modulo');
  	    $this->year = $this->getRequestParameter('fecha');
  	    
  	    //return $this->renderPartial('circulares/LystMes');
  }

    
  protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');
  	$parcial = '';
  	$modulo  = $this->getModuleName();
  	
//  	echo '<pre>';
//  	print_r($this->arraySubcategoria);
//  	echo '</pre>';
//  	exit();
//  	
		$this->nBsq = is_numeric($this->getRequestParameter('n_busqueda'))?$this->getRequestParameter('n_busqueda'):'';
		$this->cajaBsq = $this->getRequestParameter('caja_busqueda')?$this->getRequestParameter('caja_busqueda'):$this->getUser()->getAttribute($modulo.'_nowcaja');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda')?$this->getRequestParameter('desde_busqueda'):$this->getUser()->getAttribute($modulo.'_nowfechadesde');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda')?$this->getRequestParameter('hasta_busqueda'):$this->getUser()->getAttribute($modulo.'_nowfechahasta');
		$this->SelectCatTemaBsq = $this->getRequestParameter('select_cat_tema')?$this->getRequestParameter('select_cat_tema'):$this->getUser()->getAttribute($modulo.'_nowcattema');
		$this->SelectSubTemaBsq = $this->getRequestParameter('select_sub_tema')?$this->getRequestParameter('select_sub_tema'):$this->getUser()->getAttribute($modulo.'_nowsubtema');
		$this->SelectCatOrganismoBsq = $this->getRequestParameter('categoria_organismo_id')? $this->getRequestParameter('categoria_organismo_id'):$this->getUser()->getAttribute($modulo.'_nowcatorganismo');
		$this->SelectSubOrganismoBsq = $this->getRequestParameter('circular[subcategoria_organismo_id]')?$this->getRequestParameter('circular[subcategoria_organismo_id]'):$this->getUser()->getAttribute($modulo.'_nowsuborganismo') ;
		$this->contenidoBsq = $this->getRequestParameter('contenido_busqueda')?$this->getRequestParameter('contenido_busqueda'):$this->getUser()->getAttribute($modulo.'_nowcontenido');;
		
		if ($this->nBsq!='') {
			$parcial .= " AND c.numero = $this->nBsq";
			$this->getUser()->setAttribute($modulo.'_nownumero', $this->nBsq);
		}
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND c.nombre LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->desdeBsq)) {
			$parcial .= " AND c.fecha >='".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowfechadesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND c.fecha <= '".format_date($this->hastaBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowfechahasta', $this->hastaBsq);
		}
		if (!empty($this->SelectCatTemaBsq)) {
			$parcial .= " AND c.circular_tema_id = $this->SelectCatTemaBsq";
			$this->getUser()->setAttribute($modulo.'_nowcattema', $this->SelectCatTemaBsq);
		}
		if (!empty($this->SelectSubTemaBsq)) {
			$parcial .= " AND c.circular_sub_tema_id = $this->SelectSubTemaBsq";
			$this->getUser()->setAttribute($modulo.'_nowsubtema', $this->SelectSubTemaBsq);
		}
		if (!empty($this->SelectCatOrganismoBsq)) {
			$parcial .= " AND c.categoria_organismo_id = $this->SelectCatOrganismoBsq";
			$this->getUser()->setAttribute($modulo.'_nowcatorganismo', $this->SelectCatOrganismoBsq);
		}
		if (!empty($this->SelectSubOrganismoBsq)) {
			$parcial .= " AND c.subcategoria_organismo_id = $this->SelectSubOrganismoBsq";
			$this->getUser()->setAttribute($modulo.'_nowsuborganismo', $this->SelectSubOrganismoBsq);
		}
		if (!empty($this->contenidoBsq)) {
			$parcial .= " AND c.contenido LIKE '%$this->contenidoBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcontenido', $this->contenidoBsq);
		}


		###### set atributos ########
		
		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nownumero');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechadesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechahasta');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcattema');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubtema');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcatorganismo');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsuborganismo');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->nBsq = $this->getUser()->getAttribute($modulo.'_nownumero');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowfechadesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowfechahasta');
				$this->SelectCatTemaBsq = $this->getUser()->getAttribute($modulo.'_nowcattema');
				$this->SelectSubTemaBsq = $this->getUser()->getAttribute($modulo.'_nowsubtema');
				$this->SelectCatOrganismoBsq = $this->getUser()->getAttribute($modulo.'_nowcatorganismo');
				$this->SelectSubOrganismoBsq = $this->getUser()->getAttribute($modulo.'_nowsuborganismo');
				$this->contenidoBsq = $this->getUser()->getAttribute($modulo.'_nowcontenido');
				
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nownumero');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechadesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechahasta');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcattema');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubtema');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcatorganismo');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsuborganismo');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			$parcial="";
			$this->nBsq = '';
			$this->cajaBsq = '';
			$this->desdeBsq = '';
			$this->hastaBsq = '';
			$this->SelectCatTemaBsq = '';
			$this->SelectSubTemaBsq = '';
			$this->SelectCatOrganismoBsq = '';
			$this->SelectSubOrganismoBsq = '';
			$this->contenidoBsq = '';
		}
		
		$this->arrayCategoriasTema = CircularTable::doSelectAllCategorias('CircularCatTema');
	  	$this->arraySubcategoriasTema = $this->SelectCatTemaBsq?CircularSubTemaTable::doSelectByCategoria($this->SelectCatTemaBsq):array();
	  	$this->arrayCategoria = OrganismoTable::doSelectAllCategorias('CategoriaOrganismo');
	  	$this->arraySubcategoria = $this->SelectCatOrganismoBsq? SubCategoriaOrganismoTable::doSelectByCategoria($this->SelectCatOrganismoBsq) :array();
		
		
		
		return 'c.deleted=0'.$parcial;
  }
  
  protected function setOrdenamiento()
  {
  	
  	if($this->getRequestParameter('sort'))
  	{
	        
  		
		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc':'asc' ;
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
  		
  		return 'c.fecha desc, c.numero desc';
  	}	
  } 
  
}