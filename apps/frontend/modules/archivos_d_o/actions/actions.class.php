<?php

/**
 * archivos_d_o actions.
 *
 * @package    extranet
 * @subpackage archivos_d_o
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class archivos_d_oActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	
    $this->paginaActual = $this->getRequestParameter('page', 1);

	if (is_numeric($this->paginaActual)) {
		$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
	}
	    $this->pager = new sfDoctrinePager('ArchivoDO', 20);
	$this->pager->getQuery()->from('ArchivoDO')
	->where($this->setFiltroBusqueda())
	->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();
	
	$this->documentacion = '';
  	if($this->documentacionBsq)
  	{
  		$this->documentacion = DocumentacionOrganismo::getRepository()->findOneById($this->documentacionBsq);
  	}

	$this->archivo_do_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->archivo_do = Doctrine::getTable('ArchivoDO')->find($request->getParameter('id'));
    $this->forward404Unless($this->archivo_do);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new ArchivoDOForm();
    $this->verLadocumentacion = DocumentacionOrganismoTable::getAlldocumentacion()->count();
    
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new ArchivoDOForm();

    $this->processForm($request, $this->form);

    
    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($archivo_do = Doctrine::getTable('ArchivoDO')->find($request->getParameter('id')), sprintf('Object archivo_do does not exist (%s).', $request->getParameter('id')));
    $this->form = new ArchivoDOForm($archivo_do);
    $this->verSubcategoria = SubCategoriaOrganismoTable::doSelectByCategoria($archivo_do->getCategoriaOrganismoID());
    $this->idSubcategoria = $archivo_do->getSubcategoriaOrganismoId();
    $this->verOrganisamos = OrganismoTable::doSelectByOrganismoa($this->idSubcategoria);
    $this->idOrganismos = $archivo_do->getOrganismoId();
    $this->verDocumentacion = DocumentacionOrganismoTable::doSelectByOrganismo($this->idOrganismos);
    $this->idDocumentacion = $archivo_do->getDocumentacionOrganismoId();
   
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($archivo_do = Doctrine::getTable('ArchivoDO')->find($request->getParameter('id')), sprintf('Object archivo_do does not exist (%s).', $request->getParameter('id')));
    $this->form = new ArchivoDOForm($archivo_do);
    $this->verSubcategoria = SubCategoriaOrganismoTable::doSelectByCategoria($archivo_do->getCategoriaOrganismoID());
    $this->idSubcategoria = $archivo_do->getSubcategoriaOrganismoId();
    $this->verOrganisamos = OrganismoTable::doSelectByOrganismoa($this->idSubcategoria);
    $this->idOrganismos = $archivo_do->getOrganismoId();
    $this->verDocumentacion = DocumentacionOrganismoTable::doSelectByOrganismo($this->idOrganismos);
    $this->idDocumentacion = $archivo_do->getDocumentacionOrganismoId();

    $this->processForm($request, $this->form);

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($archivo_do = Doctrine::getTable('ArchivoDO')->find($request->getParameter('id')), sprintf('Object archivo_do does not exist (%s).', $request->getParameter('id')));
    
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');
    
    $archivo_do->delete();

    $this->redirect('archivos_d_o/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
	    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
	    if ($form->isValid())
	    {	    	
	    	
//	    	$dato=Doctrine::getTable('ArchivoDO')->find($request->getParameter('id'));
//		
//			if ($form->getValue('archivo_delete') && $dato->getArchivo()) {
//		    	$dato->eliminarDocumento();
//		    }
			    	
	    	$archivo_do = $form->save();  
	    	
	    	
	    	$bandera     = 0;
	      $xSelectCategoria = $this->getRequestParameter('categoria_organismo_id');
	      $xSelectSubcategoria = $this->getRequestParameter('subcategoria_organismo_id');
	      $xSelectOrganisamos = $this->getRequestParameter('organismoidsub');
	      $xSelectDocumento = $this->getRequestParameter('documentacion_organismo_id');
	      
	    
	      if (!empty($xSelectCategoria)){ $archivo_do->setCategoriaOrganismoId($xSelectCategoria); $bandera = 1; }
	      if (!empty($xSelectSubcategoria)){ $archivo_do->setSubcategoriaOrganismoId($xSelectSubcategoria); $bandera = 1; }
	      if (!empty($xSelectOrganisamos)){ $archivo_do->setOrganismoId($xSelectOrganisamos); $bandera = 1; }
	      if (!empty($xSelectDocumento)){ $archivo_do->setDocumentacionOrganismoId($xSelectDocumento); $bandera = 1; }
	
	      if ($bandera == 1)
	       {
	      	$archivo_do->save();
	       }	
	       
	       $this->getUser()->setFlash('notice', 'El Archivo ha sido actualizado correctamente');
	       $this->redirect('archivos_d_o/show?id='.$archivo_do->getId());
		    	
		 }
	       
  }
  
  /* Metodos para busqueda y ordenamiento */
  
  protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->categoriaBsq = $this->getRequestParameter('archivo_d_o[categoria_organismo_id]');
		$this->subcategoriaBsq = $this->getRequestParameter('archivo_d_o[subcategoria_organismo_id]');
		$this->organismoBsq = $this->getRequestParameter('archivo_d_o[organismo_id]');
		$this->documentacionBsq = $this->getRequestParameter('archivo_d_o[documentacion_organismo_id]');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda');
		

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->categoriaBsq)) {
			$parcial .= " AND categoria_organismo_id =".$this->categoriaBsq ;
			$this->getUser()->setAttribute($modulo.'_nowcategoria', $this->categoriaBsq);
		}
		if (!empty($this->subcategoriaBsq)) {
			$parcial .= " AND subcategoria_organismo_id =".$this->subcategoriaBsq ;
			$this->getUser()->setAttribute($modulo.'_nowsubcategoria', $this->subcategoriaBsq);
		}
		if (!empty($this->organismoBsq)) {
			$parcial .= " AND organismo_id =".$this->organismoBsq ;
			$this->getUser()->setAttribute($modulo.'_noworganismos', $this->organismoBsq);
		}
		if (!empty($this->documentacionBsq)) {
			$parcial .= " AND documentacion_organismo_id =".$this->documentacionBsq ;
			$this->getUser()->setAttribute($modulo.'_nowdocumentacion', $this->documentacionBsq);
		}
		if (!empty($this->desdeBsq)) {
			$parcial .= " AND fecha >= '".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowdesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND fecha <= '".format_date($this->hastaBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowhasta', $this->hastaBsq);
		}


		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcategoria');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_noworganismos');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdocumentacion');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowdesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowhasta');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowcategoria');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowsubcategoria');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_noworganismos');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowdocumentacion');
			}
		} 

		
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcategoria');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_noworganismos');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdocumentacion');
			$parcial="";
			$this->cajaBsq = "";
			$this->categoriaBsq = '';
			$this->subcategoriaBsq = '';
			$this->organismoBsq = '';
			$this->documentacionBsq = '';
			$this->desdeBsq = '';
			$this->hastaBsq = '';
		}
		
		$organismos = Organismo::IdDeOrganismo($this->getUser()->getAttribute('userId'),1);
		if($organismos)
		{
		   return 'deleted=0'.$parcial.' AND organismo_id IN '.$organismos;
		} 
		else 
		{
			return 'deleted=0'.$parcial;	
		}
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
  
  public function executeListDocumentacionAct(sfWebRequest $request)
  {
  
  	$this->documentacion_selected = 0;
  	$this->arrayDocumentacion = DocumentacionOrganismoTable::doSelectByOrganismo($this->getRequestParameter('documentacion_organismos'));
  	
  	$this->name = $request->getParameter('name');
  	
	return $this->renderPartial('documentacion_organismos/selectByOrganismo');	
  	
  }
}
