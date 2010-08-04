<?php
/**
 * grupos_trabajo actions.
 *
 * @package    extranet
 * @subpackage grupos_trabajo
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class grupos_trabajoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	/**/
        sfLoader::loadHelpers('Security');
            if (!validate_action('listar')) $this->redirect('seguridad/restringuido');
       /**/
  	$this->paginaActual = $this->getRequestParameter('page', 1);

        if (is_numeric($this->paginaActual)) {
        $this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
        }
  	$this->pager = new sfDoctrinePager('GrupoTrabajo', 4);
        $this->pager->getQuery()
        ->from('GrupoTrabajo gt')
        ->leftJoin('gt.UsuarioGrupoTrabajo ugt')
        ->where($this->setFiltroBusqueda());
	    
        $this->pager->getQuery()->orderBy($this->setOrdenamiento());
        $this->pager->setPage($this->paginaActual);
        $this->pager->init();

        $this->grupos_de_trabajo_list = $this->pager->getResults();
        $this->cantidadRegistros = $this->pager->getNbResults();
      
  }
  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND nombre LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$parcial="";
			$this->cajaBsq = "";
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
}