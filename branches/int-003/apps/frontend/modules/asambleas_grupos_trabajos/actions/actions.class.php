<?php

/**
 * asambleas_grupos_trabajos actions.
 *
 * @package    extranet
 * @subpackage asambleas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class asambleas_grupos_trabajosActions extends sfActions
{
		
	public function executeIndex(sfWebRequest $request)
	{  
                $this->DAtos =$this->setGruposdeTrabajo();
                $this->Grupo = '';
	
		## buscar segun el esatdo de canvocatria
		$this->tipobqd = !$this->getRequestParameter('tipo')?$this->getUser()->getAttribute('asambleas_tipo'):$this->getRequestParameter('tipo') ;

		$pendientes = 'a.estado!=\'anulada\' AND a.estado!=\'caducada\'';
		$aceptadas = 'a.estado!=\'anulada\' AND a.estado!=\'caducada\'';
		if(!empty($this->tipobqd))
		{
			if($this->tipobqd == 1)
			{
				$pendientes.= $this->setFiltroBusqueda();
				$this->getUser()->setAttribute('asambleas_tipo', $this->tipobqd);
				
			}
			if($this->tipobqd == 2)
			{
				 $aceptadas.= $this->setFiltroBusqueda();
				 $this->getUser()->setAttribute('asambleas_tipo', $this->tipobqd);
			}
		}
		else 
		{
			$pendientes.= $this->setFiltroBusqueda();
			$aceptadas.= $this->setFiltroBusqueda();
			
		}
		## Pendientes
		$this->pager1 = new sfDoctrinePager('Asamblea', 10);
		$this->pager1->getQuery()
			->from('Convocatoria c')
			->leftJoin('c.Asamblea a')
			->where('c.deleted = 0')
			->where('a.deleted = 0')
			->addWhere('c.usuario_id=' . $this->getUser()->getAttribute('userId'))
			->addWhere('c.estado=\'pendiente\'')
			->andWhere('a.fecha_caducidad >= NOW()')
			->addWhere($pendientes.' AND a.'.$this->DAtos['where'])
			->orderBy('a.fecha desc');
		$this->pager1->setPage($this->getRequestParameter('page', 1));
		$this->pager1->init();
		
		$this->convocatorias_pendientes = $this->pager1->getResults();
		
		## Aceptadas y rechazadas
		$this->pager2 = new sfDoctrinePager('Asamblea', 10);
		$this->pager2->getQuery()
			->from('Convocatoria c')
			->leftJoin('c.Asamblea a')
			->where('c.deleted=0')
			->addWhere('c.usuario_id=' . $this->getUser()->getAttribute('userId'))
			->addWhere('c.estado=\'aceptada\' OR c.estado=\'rechazada\'')
			->addWhere($aceptadas.' AND a.'.$this->DAtos['where'])
			->andWhere('a.fecha_caducidad >= NOW()')
			->andWhere('a.deleted = 0')
			->orderBy('a.fecha desc');
			
			
		$this->pager2->setPage($this->getRequestParameter('page', 1));
		$this->pager2->init();
		
		$this->convocatorias = $this->pager2->getResults();
	    
		$busqueda = explode('_',$this->grupodetrabajoBsq); 
		

		if($busqueda[0] == 'GrupoTrabajo')
			{
			  $this->Grupo = GrupoTrabajoTable::getGrupoTrabajo($busqueda[1]);
			}
		
	}
	
	public function executeVer(sfWebRequest $request)
	{    
	
		$this->DAtos =$this->setGruposdeTrabajo();
		
		 $IDcon = ''; 
		 if($this->getRequestParameter('idCon')){$IDcon = $this->getRequestParameter('idCon');}
                 else
                 {
                            ## Obtener asamblea
                            if(!$this->asambleaId = $this->getRequestParameter('id'))
                                    $this->forward404('La asamblea solicitada no existe');
                 }
                 $this->id_convocado = $request->getParameter('detalle')?$request->getParameter('detalle'):$this->getUser()->getAttribute('userId');
  
                 $this->convocado = ConvocatoriaTable::getConvocatoria($this->id_convocado,"id = $this->asambleaId ",1);

                 $this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
                 if(Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles))
                 {
                  $this->asamblea = AsambleaTable::getConvocotatiaId($this->asambleaId,'','');

		  $this->user = UsuarioTable::getUsuarioByid($this->asamblea->getOwnerId());

                 }else{
		  $this->asamblea = AsambleaTable::getConvocotatiaId($this->asambleaId,$this->getUser()->getAttribute('userId'),$IDcon);
		   
		  $this->user = UsuarioTable::getUsuarioByid($this->asamblea->getOwnerId());
                 }
		      
	}
	
	
	 protected function setFiltroBusqueda()
        {
            sfLoader::loadHelpers('Date');
            $parcial = '';
            $modulo  = $this->getModuleName();
            $this->modulo = $modulo;

                    $this->tipoasambleaBsq = $this->getRequestParameter('tipoasamblea');
                    $this->tituloBsq = $this->getRequestParameter('titulo');
                    $this->grupodetrabajoBsq = $this->getRequestParameter('grupodetrabajo');
                    $this->desdeBsq = $this->getRequestParameter('desde_busqueda');
                    $this->hastaBsq = $this->getRequestParameter('hasta_busqueda');

                    if(!empty($this->tipoasambleaBsq))
                    {
                            $parcial = " AND a.estado ='$this->tipoasambleaBsq'";
                                    $this->getUser()->setAttribute($modulo.'_nowtipoasamblea', $this->tipoasambleaBsq);
                    }
                    if(!empty($this->tituloBsq))
                    {
                            $parcial.="AND (a.titulo LIKE '%$this->tituloBsq%')";
                                    $this->getUser()->setAttribute($modulo.'_nowtitulo', $this->tituloBsq);
                    }
                    if(!empty($this->grupodetrabajoBsq))
                    {
                            $parcial.=" AND a.entidad ='$this->grupodetrabajoBsq'";
                            $this->getUser()->setAttribute($modulo.'_nowentidad', $this->grupodetrabajoBsq);
                    }
                    if (!empty($this->desdeBsq)) {
                            $parcial .= " AND a.fecha >= '".format_date($this->desdeBsq,'d')."'";
                            $this->getUser()->setAttribute($modulo.'_nowdesde', $this->desdeBsq);
                    }
                    if (!empty($this->hastaBsq)) {
                            $parcial .= " AND a.fecha <= '".format_date($this->hastaBsq,'d')."'";
                            $this->getUser()->setAttribute($modulo.'_nowhasta', $this->hastaBsq);
                    }

                    if (!empty($parcial)) {
                            $this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
                    } else {
                            if ($this->hasRequestParameter('btn_buscar')) {
                                    $this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
                                    $this->getUser()->getAttributeHolder()->remove($modulo.'_nowtipo');
                                    $this->getUser()->getAttributeHolder()->remove($modulo.'_nowtipoasamblea');
                                    $this->getUser()->getAttributeHolder()->remove($modulo.'_nowtitulo');
                                    $this->getUser()->getAttributeHolder()->remove($modulo.'_nowentidad');
                                    $this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
                                    $this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
                            } else {
                                    $parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
                                    $this->tipoasambleaBsq = $this->getUser()->getAttribute($modulo.'_nowtipoasamblea');
                                    $this->tituloBsq = $this->getUser()->getAttribute($modulo.'_nowtitulo');
                                    $this->grupodetrabajoBsq = $this->getUser()->getAttribute($modulo.'_nowentidad');
                                    $this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowdesde');
                                    $this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowhasta');
                            }
                    }

                    if ($this->hasRequestParameter('btn_quitar')){
                            $this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
                            $this->getUser()->getAttributeHolder()->remove($modulo.'_nowtipo');
                            $this->getUser()->getAttributeHolder()->remove($modulo.'_nowtipoasamblea');
                            $this->getUser()->getAttributeHolder()->remove($modulo.'_nowtitulo');
                            $this->getUser()->getAttributeHolder()->remove($modulo.'_nowentidad');
                            $this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
                            $this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
                            $parcial="";
                            $this->tipobqd = "";
                            $this->tipoasambleaBsq = '';
                            $this->tituloBsq = '';
                            $this->grupodetrabajoBsq = '';
                            $this->desdeBsq = '';
                            $this->hastaBsq = '';
                    }

                    return $parcial;
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
                        $this->orderBy = 'a.fecha';
                        $this->sortType = 'desc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }
  
  protected function setGruposdeTrabajo()
  {
		    $arraDAtos['tipo'] = 'Grupos de Trabajo';
			$arraDAtos['titulo'] = 'Convocatoria';
			$arraDAtos['busqueda'] = 'Grupos de Trabajo';
			$arraDAtos['get'] = 'GrupodeTrabajo=2' ;
			$arraDAtos['campo']= 'GrupodeTrabajo' ;
			$arraDAtos['valor']= '2' ;
			$arraDAtos['where']= "entidad LIKE '%GrupoTrabajo%'" ;
			if($this->getRequestParameter('id'))
			{  
			    $idGrupo =explode('_', AsambleaTable::getAsambleaId($this->getRequestParameter('id'),$arraDAtos['where'])->getEntidad());
			    
				$arraDAtos['usuarios'] =  UsuarioGrupoTrabajoTable::getUsreByGrupo($idGrupo[1],1);

				$arraDAtos['Entidad'] = GrupoTrabajoTable::getGrupoTrabajo($idGrupo[1])->getNombre();	
				
			}
			
	return $arraDAtos;		
  }
 	
}
