<?php

/**
 * organismos actions.
 *
 * @package    extranet
 * @subpackage organismos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class organismos_listaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
        $this->paginaActual = $this->getRequestParameter('page', 1);

        if (is_numeric($this->paginaActual)) {
                $this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
        }
  	$this->pager = new sfDoctrinePager('Organismo', 4);
	$this->pager->getQuery()
	->from('Organismo o')
	->leftJoin('o.UsuarioOrganismo uo')
        ->leftJoin('o.CategoriaOrganismo co')
        ->leftJoin('o.SubCategoriaOrganismo sco')
	->where($this->setFiltroBusqueda());
	   
	$this->pager->getQuery()->orderBy($this->setOrdenamiento());
	
	
	
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->organismo_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
  }

  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();
  	

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->categoriaBsq = $this->getRequestParameter('organismo[categoria_organismo_id]');
		$this->subcategoriaBsq = $this->getRequestParameter('organismo[subcategoria_organismo_id]');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (o.nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->categoriaBsq)) {
			$parcial .= " AND o.categoria_organismo_id = $this->categoriaBsq ";
			$this->getUser()->setAttribute($modulo.'_nowcategoria', $this->categoriaBsq);
		}
		if (!empty($this->subcategoriaBsq)) {
			$parcial .= " AND o.subcategoria_organismo_id = $this->subcategoriaBsq ";
			$this->getUser()->setAttribute($modulo.'_nowsubcategoria', $this->subcategoriaBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcategoria');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowcategoria');
				$this->subcategoriaBsq = $this->getUser()->getAttribute($modulo.'_nowsubcategoria');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcategoria');
			$parcial="";
			$this->cajaBsq = "";
			$this->categoriaBsq = '';
			$this->subcategoriaBsq = '';
		}

		
		return 'deleted=0'.$parcial;
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
  
  // accion que ejecuta el componente subcategoria_organismo para el listado de organisamos 
  public function executeListByOrganismoAct(sfWebRequest $request)
  {
  	
		return $this->renderComponent('organismos','listaorganismos',array('name'=>$request->getParameter('name')));	
  	
  }
}