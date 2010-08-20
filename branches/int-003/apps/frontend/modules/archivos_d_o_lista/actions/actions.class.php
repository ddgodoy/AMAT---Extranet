<?php

/**
 * archivos_d_o actions.
 *
 * @package    extranet
 * @subpackage archivos_d_o
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class archivos_d_o_listaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$organismos = Organismo::IdDeOrganismo($this->getUser()->getAttribute('userId'),1);
  	
    $this->paginaActual = $this->getRequestParameter('page', 1);

	if (is_numeric($this->paginaActual)) {
		$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
	}
	
	if($organismos)
	{ 
		$this->pager = new sfDoctrinePager('ArchivoDO', 20);
		$this->pager->getQuery()
                ->from('ArchivoDO ao')
                ->leftjoin('ao.DocumentacionOrganismo do')
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

                $this->carga = '';
                $this->getUser()->getAttributeHolder()->remove('carga_'.$this->getModuleName());
                if($this->documentacion){
                $this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
		if(Common::array_in_array(array('1'=>'1', '2'=>'2', '6'=>'6'), $this->roles))
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
	else 
	{
		$this->archivo_do_list = '';
		$this->cantidadRegistros = 0;
	}
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->archivo_do = Doctrine::getTable('ArchivoDO')->find($request->getParameter('id'));
    $this->forward404Unless($this->archivo_do);
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
			$parcial .= " AND (ao.nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->categoriaBsq)) {
			$parcial .= " AND ao.categoria_organismo_id =".$this->categoriaBsq ;
			$this->getUser()->setAttribute($modulo.'_nowcategoria', $this->categoriaBsq);
		}
		if (!empty($this->subcategoriaBsq)) {
			$parcial .= " AND ao.subcategoria_organismo_id =".$this->subcategoriaBsq ;
			$this->getUser()->setAttribute($modulo.'_nowsubcategoria', $this->subcategoriaBsq);
		}
		if (!empty($this->organismoBsq)) {
			$parcial .= " AND ao.organismo_id =".$this->organismoBsq ;
			$this->getUser()->setAttribute($modulo.'_noworganismos', $this->organismoBsq);
		}
		if (!empty($this->documentacionBsq)) {
			$parcial .= " AND ao.documentacion_organismo_id =".$this->documentacionBsq ;
			$this->getUser()->setAttribute($modulo.'_nowdocumentacion', $this->documentacionBsq);
		}
		if (!empty($this->desdeBsq)) {
			$parcial .= " AND ao.fecha >= '".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowdesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND ao.fecha <= '".format_date($this->hastaBsq,'d')."'";
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
                $this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
		if(Common::array_in_array(array('1'=>'1', '2'=>'2', '6'=>'6'), $this->roles))
		{
			return "ao.deleted=0".$parcial." AND  (do.owner_id = ".$this->getUser()->getAttribute('userId')." OR do.estado != 'guardado')";
		}
		else
		{
                         $responsables = ArchivoDO::getUSerREsponsables();
                         return "ao.deleted=0".$parcial." AND ao.organismo_id IN ".$organismos." AND (do.owner_id = ".$this->getUser()->getAttribute('userId')." OR do.estado != 'guardado') AND (ao.owner_id ".$responsables." OR  do.confidencial != 1  OR  ao.owner_id = ".$this->getUser()->getAttribute('userId').")";
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
  
  public function executeListDocumentacionAct(sfWebRequest $request)
  {
  
  	$this->documentacion_selected = 0;
       
  	$this->arrayDocumentacion = DocumentacionOrganismoTable::doSelectByOrganismo($this->getRequestParameter('documentacion_organismos'),1);

       
  	  $this->name = $request->getParameter('name');
  	
	  return $this->renderPartial('documentacion_organismos/selectByOrganismo');
       
  	
  }
}
