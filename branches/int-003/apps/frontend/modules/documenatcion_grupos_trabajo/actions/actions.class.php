<?php

/**
 * documenatcion_grupos_trabajo actions.
 *
 * @package    extranet
 * @subpackage documenatcion_grupos_trabajo
 * @author     Pablo Peralta
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class documenatcion_grupos_trabajoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$modulo  = $this->getModuleName();

        $this->paginaActual = $this->getRequestParameter('page', 1);

        if (is_numeric($this->paginaActual)) {
                $this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
        }
        $this->pager = new sfDoctrinePager('DocumentacionGrupo', 10);

        $this->pager->getQuery()
        ->from('DocumentacionGrupo')
        ->where($this->setFiltroBusqueda())
        ->orderBy($this->setOrdenamiento());

        $this->pager->setPage($this->paginaActual);
        $this->pager->init();

        $this->documentacion_grupo_list = $this->pager->getResults();
        $this->cantidadRegistros = $this->pager->getNbResults();


        if ($this->grupoBsq) {
          $this->Grupo = GrupoTrabajoTable::getGrupoTrabajo($this->grupoBsq);
        } else {
                $this->Grupo = '';
        }

        $this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);

        if (Common::array_in_array(array('1'=>'1', '2'=>'2', '6'=>'6'), $this->roles)) {
          $this->resposable = 1;
        }else{
          $this->resposable = '';
        }
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->documentacion_grupo = Doctrine::getTable('DocumentacionGrupo')->find($request->getParameter('id'));
    $this->forward404Unless($this->documentacion_grupo);
    $this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
    if (Common::array_in_array(array('1'=>'1', '2'=>'2', '6'=>'6'), $this->roles)) {
      $this->resposable = 1;
    }else{
      $this->resposable = '';
    }
  } 
/* Metodos para busqueda y ordenamiento */
  
  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();
  	$this->modulo = $modulo;

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->grupoBsq = $this->getRequestParameter('grupo');
		$this->categoriaBsq = $this->getRequestParameter('categoria_busqueda');
		$this->estadoBsq = $this->getRequestParameter('estado_busqueda');
		$this->contenidoBsq = $this->getRequestParameter('contenido_busqueda')?$this->getRequestParameter('contenido_busqueda'):$this->getUser()->getAttribute($modulo.'_nowcontenido');;
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
                if (!empty($this->grupoBsq)) {
			$parcial .= " AND grupo_trabajo_id = $this->grupoBsq ";
			$this->getUser()->setAttribute($modulo.'_nowgrupo', $this->grupoBsq);
		}
		if (!empty($this->categoriaBsq)) {
			$parcial .= " AND categoria_d_g_id = '$this->categoriaBsq' ";
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
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowgrupo');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->grupoBsq = $this->getUser()->getAttribute($modulo.'_nowgrupo');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowcategoria');
				$this->estadoBsq = $this->getUser()->getAttribute($modulo.'_nowestado');
				$this->contenidoBsq = $this->getUser()->getAttribute($modulo.'_nowcontenido');
			}
		} 
		
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowgrupo');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			$parcial="";
			$this->cajaBsq = "";
			$this->grupoBsq = '';
			$this->categoriaBsq = '';
			$this->estadoBsq = '';
			$this->contenidoBsq = '';
		}
		$gruposdetrabajo = GrupoTrabajo::iddegrupos($this->getUser()->getAttribute('userId'),1); 
		$this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);

		
		return "deleted=0 ".$parcial." AND (owner_id = ".$this->getUser()->getAttribute('userId')." OR estado != 'guardado')";
		
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
		$this->arrayDocumentacion = DocumentacionGrupoTable::doSelectByGrupoTrabajo($this->getRequestParameter('id_grupo_trabajo'),1);

		return $this->renderPartial('documentacion_grupos/selectByGrupoTrabajo');
	}
}