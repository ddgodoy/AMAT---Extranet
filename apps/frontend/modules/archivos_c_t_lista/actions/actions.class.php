<?php

/*
 * archivos_c_t_lista actions.
 *
 * @package    extranet
 * @subpackage archivos_c_t
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class archivos_c_t_listaActions extends sfActions
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
		   //return "ac.deleted=0 ".$parcial." AND ac.consejo_territorial_id IN ".$consejosterritoriales." AND (dc.owner_id = ".$this->getUser()->getAttribute('userId')." OR dc.estado != 'guardado')AND (ac.owner_id ".$responsables." OR  dc.confidencial != 1  OR  ac.owner_id = ".$this->getUser()->getAttribute('userId').")";
		   return "ac.deleted=0".$parcial." AND (dc.owner_id = ".$this->getUser()->getAttribute('userId')." OR dc.estado != 'guardado')";
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
