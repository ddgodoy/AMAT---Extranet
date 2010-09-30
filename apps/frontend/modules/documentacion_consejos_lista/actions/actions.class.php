<?php

/**
 * documentacion_consejos_lista actions.
 *
 * @package    extranet
 * @subpackage documentacion_consejos
 * @author     Pablo Peralta
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
 
class documentacion_consejos_listaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$modulo  = $this->getModuleName();
  	//$guardados = Common::getCantidaDEguardados('DocumentacionConsejo',$this->getUser()->getAttribute('userId'),$this->setFiltroBusqueda(),$modulo);
  	$this->Consejo = '';
    $this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		$this->pager = new sfDoctrinePager('DocumentacionConsejo', 10);
		$this->pager->getQuery()->from('DocumentacionConsejo')
		->where($this->setFiltroBusqueda())
		->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->documentacion_consejo_list = $this->pager->getResults();
                $this->cantidadRegistros = $this->pager->getNbResults();
	//	$this->cantidadRegistros = $this->pager->getNbResults() - $guardados->count();

		if ($this->consejoBsq) {
			$this->Consejo = ConsejoTerritorialTable::getConsejo($this->consejoBsq);
		}else{
                  $this->Consejo = '';
                }

                $this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);

		if (Common::array_in_array(array('1'=>'1', '2'=>'2', '7'=>'7'), $this->roles)) {
                  $this->resposable = 1;
                }else{
                  $this->resposable = '';
                }
                
  }

  public function executeShow(sfWebRequest $request)
  {
    $id = str_replace('&', '',$request->getParameter('id'));
    $this->documentacion_consejo = Doctrine::getTable('DocumentacionConsejo')->find($id);
    $this->forward404Unless($this->documentacion_consejo);
    $this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
    if (Common::array_in_array(array('1'=>'1', '2'=>'2', '7'=>'7'), $this->roles)) {
      $this->resposable = 1;
    }else{
      $this->resposable = '';
    }
  }
  
  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();
  	$this->modulo = $modulo;

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->consejoBsq = $this->getRequestParameter('consejo');
		$this->categoriaBsq = $this->getRequestParameter('categoria_buscar');
		$this->estadoBsq = $this->getRequestParameter('estado_busqueda');
		$this->contenidoBsq = $this->getRequestParameter('contenido_busqueda')?$this->getRequestParameter('contenido_busqueda'):$this->getUser()->getAttribute($modulo.'_nowcontenido');;
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->consejoBsq)) {
			$parcial .= " AND consejo_territorial_id = $this->consejoBsq ";
			$this->getUser()->setAttribute($modulo.'_nowconsejo', $this->consejoBsq);
		}
		if (!empty($this->categoriaBsq)) {
			$parcial .= " AND categoria_c_t_id = $this->categoriaBsq ";
			$this->getUser()->setAttribute($modulo.'_nowcategoria', $this->categoriaBsq);
		}
		if (!empty($this->estadoBsq)) {
			$parcial .= " AND estado = '$this->estadoBsq' ";
			$this->getUser()->setAttribute($modulo.'_nowestado', $this->estadoBsq);
		}
		if (!empty($this->contenidoBsq)) {
			$parcial .= " AND contenido LIKE '%$this->contenidoBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcontenido', $this->contenidoBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowconsejo');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowesatdo');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowconsejo');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowcategoria');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowesatdo');
				$this->contenidoBsq = $this->getUser()->getAttribute($modulo.'_nowcontenido');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')) {
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowconsejo');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowesatdo');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			$parcial="";
			$this->cajaBsq = "";
			$this->consejoBsq = '';
			$this->categoriaBsq = '';
			$this->estadoBsq = '';
			$this->contenidoBsq = '';
		}
	
		$consejosterritoriales = ConsejoTerritorial::IdDeconsejo($this->getUser()->getAttribute('userId'),1);
		$this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
		if(Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles))
		{
			return "deleted=0".$parcial." AND (owner_id = ".$this->getUser()->getAttribute('userId')." OR estado != 'guardado')";
		}
		else
    { 
		  //return "deleted=0".$parcial." AND consejo_territorial_id IN ".$consejosterritoriales." AND (owner_id = ".$this->getUser()->getAttribute('userId')." OR estado != 'guardado')";
		  return "deleted=0".$parcial." AND (owner_id = ".$this->getUser()->getAttribute('userId')." OR estado != 'guardado')";
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
                        $this->orderBy = 'nombre';
                        $this->sortType = 'asc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }
  
  ## ajax listar por categoria
  public function executeListByGrupoTrabajo()
	{
		$this->documentacion_selected = 0;
		$this->arrayDocumentacion = DocumentacionGrupoTable::doSelectByGrupoTrabajo($this->getRequestParameter('id_grupo_trabajo'));

		return $this->renderPartial('documentacion_grupos/selectByGrupoTrabajo');
	}
}