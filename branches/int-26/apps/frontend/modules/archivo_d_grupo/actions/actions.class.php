<?php

/**
 * archivo_d_grupo actions.
 *
 * @package    extranet
 * @subpackage archivo_d_grupo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class archivo_d_grupoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	
    $this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		$this->pager = new sfDoctrinePager('ArchivoDG', 10);
		$this->pager->getQuery()->from('ArchivoDG ag')
                ->leftjoin('ag.DocumentacionGrupo dg')
                ->where($this->setFiltroBusqueda())
                ->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();
		
		if ($this->documentacionBsq) {
  		$this->documentacion = DocumentacionGrupo::getRepository()->findOneById($this->documentacionBsq);
  		}	

		$this->archivo_dg_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();

		if ($this->grupoBsq) {
		  $this->Grupo = GrupoTrabajoTable::getGrupoTrabajo($this->grupoBsq);
		} else {
			$this->Grupo = '';
		}

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

  public function executeShow(sfWebRequest $request)
  {
    $this->archivo_dg = Doctrine::getTable('ArchivoDG')->find($request->getParameter('id'));
    $this->forward404Unless($this->archivo_dg);
  }
  
  /* Metodos para busqueda y ordenamiento */
  
  protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');
  	$parcial = '';
  	$modulo  = $this->getModuleName();
        $this->modulo = $modulo;

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->grupoBsq = $this->getRequestParameter('grupo_trabajo_id');
		$this->documentacionBsq = $this->getRequestParameter('archivo_d_g[documentacion_grupo_id]');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (ag.nombre LIKE '%$this->cajaBsq%' OR contenido LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->grupoBsq)) {
			$parcial .= " AND ag.grupo_trabajo_id = $this->grupoBsq ";
			$this->getUser()->setAttribute($modulo.'_nowgrupo', $this->grupoBsq);
		}
		if (!empty($this->documentacionBsq)) {
			$parcial .= " AND ag.documentacion_grupo_id = $this->documentacionBsq ";
			$this->getUser()->setAttribute($modulo.'_nowdocumentacion', $this->documentacionBsq);
		}
		if (!empty($this->desdeBsq)) {
			$parcial .= " AND ag.fecha >= '".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowdesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND ag.fecha <= '".format_date($this->hastaBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowhasta', $this->hastaBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowgrupo');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdocumentacion');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowgrupo');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowdocumentacion');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowdesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowhasta');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowgrupo');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdocumentacion');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			$parcial = "";
			$this->cajaBsq = "";
			$this->grupoBsq = '';
			$this->documentacionBsq = '';
			$this->desdeBsq = '';
			$this->hastaBsq = '';
   	}
		$gruposdetrabajo = GrupoTrabajo::iddegrupos($this->getUser()->getAttribute('userId'),1); 
		
		return "ag.deleted=0".$parcial." AND  (dg.owner_id = ".$this->getUser()->getAttribute('userId')." OR dg.estado != 'guardado')";
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
}