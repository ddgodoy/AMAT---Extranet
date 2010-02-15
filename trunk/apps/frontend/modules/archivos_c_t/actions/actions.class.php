<?php

/*
 * archivos_c_t actions.
 *
 * @package    extranet
 * @subpackage archivos_c_t
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class archivos_c_tActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$this->documentacion = '';
  	if($request->getParameter('documentacion_consejo_id'))
  	{
  		$this->documentacion = DocumentacionConsejo::getRepository()->findOneById($request->getParameter('documentacion_consejo_id'));
  	}
  	
    $this->paginaActual = $this->getRequestParameter('page', 1);

	if (is_numeric($this->paginaActual)) {
		$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
	}
	    $this->pager = new sfDoctrinePager('ArchivoCT', 20);
	$this->pager->getQuery()->from('ArchivoCT')
	->where($this->setFiltroBusqueda())
	->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->archivo_ct_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->archivo_ct = Doctrine::getTable('ArchivoCT')->find($request->getParameter('id'));
    $this->forward404Unless($this->archivo_ct);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new ArchivoCTForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new ArchivoCTForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($archivo_ct = Doctrine::getTable('ArchivoCT')->find($request->getParameter('id')), sprintf('Object archivo_ct does not exist (%s).', $request->getParameter('id')));
    $this->form = new ArchivoCTForm($archivo_ct);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($archivo_ct = Doctrine::getTable('ArchivoCT')->find($request->getParameter('id')), sprintf('Object archivo_ct does not exist (%s).', $request->getParameter('id')));
    $this->form = new ArchivoCTForm($archivo_ct);

    $this->processForm($request, $this->form);

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($archivo_ct = Doctrine::getTable('ArchivoCT')->find($request->getParameter('id')), sprintf('Object archivo_ct does not exist (%s).', $request->getParameter('id')));
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');
    
    $archivo_ct->delete();

    $this->redirect('archivos_c_t/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
  	
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $dato=Doctrine::getTable('ArchivoCT')->find($request->getParameter('id'));
		
	  if ($form->getValue('archivo_delete') && $dato->getArchivo()) {
	    	$dato->eliminarDocumento();
	  }
	    
      $archivo_ct = $form->save();
      
      $bandera = 0;
      $xSelectDocum = $this->getRequestParameter('documentacion_consejo_id');
      $xSelectGrupo = $this->getRequestParameter('consejo_territorial_id');
      if (!empty($xSelectDocum)){ $archivo_ct->setDocumentacionConsejoId($xSelectDocum); $bandera = 1; }
      if (!empty($xSelectGrupo)){ $archivo_ct->setConsejoTerritorialId($xSelectGrupo); $bandera = 1; }
     
      if ($bandera == 1) {
      	$archivo_ct->save();
      }	

      $this->redirect('archivos_c_t/show?id='.$archivo_ct->getId());
    }
  }
  
  /* Metodos para busqueda y ordenamiento */
  
  protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->grupoBsq = $this->getRequestParameter('consejo_territorial_id');
		$this->documentacionBsq = $this->getRequestParameter('documentacion_consejo_id');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->grupoBsq)) {
			$parcial .= " AND consejo_territorial_id = $this->grupoBsq ";
			$this->getUser()->setAttribute($modulo.'_nowconsejo', $this->grupoBsq);
		}
		if (!empty($this->documentacionBsq)) {
			$parcial .= " AND documentacion_consejo_id = $this->documentacionBsq ";
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
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowconsejo');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdocumentacion');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowconsejo');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowdocumentacion');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowdesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowhasta');
			}
		} 
		
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowconsejo');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdocumentacion');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			$parcial="";
			$this->cajaBsq = "";
			$this->grupoBsq = '';
			$this->documentacionBsq = '';
			$this->desdeBsq = '';
			$this->hastaBsq = '';
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
  
   public function executeListDocumentacion(sfWebRequest $request)
   {
   	/**/
   	$this->documentacion_selected = 0;
   	$this->arrayDocumentacion = DocumentacionConsejoTable::DocumentacionByConsejo($this->getRequestParameter('id_consejo'));
   	
   	return $this->renderPartial('archivos_c_t/listDocumentacion');
   	
   }
}
