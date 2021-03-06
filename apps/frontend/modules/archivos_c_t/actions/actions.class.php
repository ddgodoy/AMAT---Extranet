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
  	
    $this->paginaActual = $this->getRequestParameter('page', 1);

	if (is_numeric($this->paginaActual)) {
		$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
	}
		
	$this->pager = new sfDoctrinePager('ArchivoCT', 20);
	$this->pager->getQuery()->from('ArchivoCT ac')
        ->leftjoin('ac.DocumentacionConsejo dc')
	->where($this->setFiltroBusqueda())
	->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();
	
	$this->documentacion = '';
  	if($this->documentacionBsq != '')
  	{
  		$this->documentacion = DocumentacionConsejo::getRepository()->findOneById($this->documentacionBsq);
  	}

	$this->archivo_ct_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
        
        if ($this->grupoBsq) {
	 $this->Consejo = ConsejoTerritorialTable::getConsejo($this->grupoBsq);
        }
        else {
         $this->Consejo = '';
        }

        $this->carga = '';
        $this->getUser()->getAttributeHolder()->remove('carga_'.$this->getModuleName());
        if($this->documentacion){
        $this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
        if(Common::array_in_array(array('1'=>'1', '2'=>'2', '7'=>'7'), $this->roles))
        {
          $this->carga = '1';
          $this->getUser()->setAttribute('carga_'.$this->getModuleName(), '1');
        }else{

        if($this->documentacion->getFechaDesde() && $this->documentacion->getFechaHasta()){
        if($this->documentacion->getFechaDesde()<= date('Y-m-d') && $this->documentacion->getFechaHasta() >= date('Y-m-d')){
         $this->carga = '1';
         $this->getUser()->setAttribute('carga_'.$this->getModuleName(), '1');
         }
        }elseif($this->documentacion->getFechaDesde() && $this->documentacion->getFechaHasta() == ''){
         if($this->documentacion->getFechaDesde()<= date('Y-m-d')){
         $this->carga = '1';
         $this->getUser()->setAttribute('carga_'.$this->getModuleName(), '1');
         }
        }elseif($this->documentacion->getFechaDesde()=='' && $this->documentacion->getFechaHasta()){
         if($this->documentacion->getFechaHasta()>= date('Y-m-d')){
         $this->carga = '1';
         $this->getUser()->setAttribute('carga_'.$this->getModuleName(), '1');
         }
        }elseif($this->documentacion->getFechaDesde()=='' && $this->documentacion->getFechaHasta()==''){
        $this->carga = '1';
        $this->getUser()->setAttribute('carga_'.$this->getModuleName(), '1');
        }
        }
        }



  }

  public function executeShow(sfWebRequest $request)
  {
    $id = str_replace('&', '',$request->getParameter('id'));
    $this->archivo_ct = Doctrine::getTable('ArchivoCT')->find($id);
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
    $id = str_replace('&', '',$request->getParameter('id'));
    $this->forward404Unless($archivo_ct = Doctrine::getTable('ArchivoCT')->find($id), sprintf('Object archivo_ct does not exist (%s).', $request->getParameter('id')));
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
    $toDelete = $request->getParameter('id');
    $redirecion = '';
    if(sfConfig::get('sf_environment') == 'dev'){
    if($request->getParameter('archivo_c_t[documentacion_consejo_id]') && $request->getParameter('consejo_territorial_id'))
    {
       $redirecion = '?archivo_c_t[documentacion_consejo_id]='.$request->getParameter('archivo_c_t[documentacion_consejo_id]').'&consejo_territorial_id='.$request->getParameter('consejo_territorial_id');
    }
    }else{
    if($request->getParameter('archivo_c_t%5Bdocumentacion_consejo_id%5D') && $request->getParameter('consejo_territorial_id'))
    {
       $redirecion = '?archivo_c_t[documentacion_consejo_id]='.$request->getParameter('archivo_c_t%5Bdocumentacion_consejo_id%5D').'&consejo_territorial_id='.$request->getParameter('consejo_territorial_id');
    }
    }

  	if (!empty($toDelete)) {
  		$request->checkCSRFProtection();

  		$IDs = is_array($toDelete) ? $toDelete : array($toDelete);

  		foreach ($IDs as $id) {
  			$this->forward404Unless($archivo_dg = Doctrine::getTable('ArchivoCT')->find($id), sprintf('Object archivo_dg does not exist (%s).', $id));

		    sfLoader::loadHelpers('Security');
                    if (!validate_action('baja') && $this->getUser()->getAttribute('userId') != $archivo_dg->getOwnerId())
                    {  $this->redirect('seguridad/restringuido'); }

		    $archivo_dg->delete();
  		}
  	}
    $this->redirect('archivos_c_t/index'.$redirecion);
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $redirecion = '';
    if(sfConfig::get('sf_environment') == 'dev'){
    if($request->getParameter('archivo_c_t[documentacion_consejo_id]') && $request->getParameter('consejo_territorial_id'))
    {
       $redirecion = 'archivo_c_t[documentacion_consejo_id]='.$request->getParameter('archivo_c_t[documentacion_consejo_id]').'&consejo_territorial_id='.$request->getParameter('consejo_territorial_id');
    }
    }else{
    if($request->getParameter('archivo_c_t%5Bdocumentacion_consejo_id%5D') && $request->getParameter('consejo_territorial_id'))
    {
       $redirecion = 'archivo_c_t[documentacion_consejo_id]='.$request->getParameter('archivo_c_t%5Bdocumentacion_consejo_id%5D').'&consejo_territorial_id='.$request->getParameter('consejo_territorial_id');
    }
    }
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

      $this->redirect('archivos_c_t/show?id='.$archivo_ct->getId().'&'.$redirecion);
    }
  }
  
  /* Metodos para busqueda y ordenamiento */
  
  protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');
  	$parcial = '';
  	$modulo  = $this->getModuleName();
        $this->modulo = $modulo;
  	
		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->grupoBsq = $this->getRequestParameter('consejo_territorial_id');
		$this->documentacionBsq = $this->getRequestParameter('archivo_c_t[documentacion_consejo_id]');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (ac.nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->grupoBsq)) {
			$parcial .= " AND ac.consejo_territorial_id = $this->grupoBsq ";
			$this->getUser()->setAttribute($modulo.'_nowconsejo', $this->grupoBsq);
		}
		if (!empty($this->documentacionBsq)) {
			$parcial .= " AND ac.documentacion_consejo_id = $this->documentacionBsq ";
			$this->getUser()->setAttribute($modulo.'_nowdocumentacion', $this->documentacionBsq);
		}
		if (!empty($this->desdeBsq)) {
			$parcial .= " AND ac.fecha >= '".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowdesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND ac.fecha <= '".format_date($this->hastaBsq,'d')."'";
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
		$consejosterritoriales = ConsejoTerritorial::IdDeconsejo($this->getUser()->getAttribute('userId'),1);
		$this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
		if(Common::array_in_array(array('1'=>'1', '2'=>'2','7'=>'7'), $this->roles))
		{
			return "ac.deleted=0".$parcial." AND (dc.owner_id = ".$this->getUser()->getAttribute('userId')." OR dc.estado != 'guardado')";
		}
		else
		{
                   $responsables = ArchivoCT::getUSerREsponsables();
		   return "ac.deleted=0 ".$parcial." AND ac.consejo_territorial_id IN ".$consejosterritoriales." AND (dc.owner_id = ".$this->getUser()->getAttribute('userId')." OR dc.estado != 'guardado')AND (ac.owner_id ".$responsables." OR  dc.confidencial != 1  OR  ac.owner_id = ".$this->getUser()->getAttribute('userId').")";
                }
		
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
                        $this->orderBy = 'fecha';
                        $this->sortType = 'desc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }
  
   public function executeListDocumentacion(sfWebRequest $request)
   {
   	/**/
   	$this->documentacion_selected = 0;
   	$this->arrayDocumentacion = DocumentacionConsejoTable::DocumentacionByConsejo($this->getRequestParameter('id_consejo'),1);
   	
   	return $this->renderPartial('archivos_c_t/listDocumentacion');
   	
   }
}
