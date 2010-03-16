<?php

/**
 * inicio actions.
 *
 * @package    extranet
 * @subpackage inicio
 * @author     Matias Gentiletti
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class miembros_grupoActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		$gruposdetrabajo = GrupoTrabajo::iddegrupos($this->getUser()->getAttribute('userId'),1);

		$this->pager = new sfDoctrinePager('Usuario', 10);
		$this->pager->getQuery()
								->from('UsuarioGrupoTrabajo ug')
								->leftJoin('ug.Usuario u')
								->leftJoin('ug.GrupoTrabajo g')
								->where('ug.usuario_id != '.$this->getUser()->getAttribute('userId'))
								->andWhere($this->setFiltroBusqueda());

		if ($gruposdetrabajo) {
			$this->pager->getQuery()->andWhere('ug.grupo_trabajo_id IN '.$gruposdetrabajo);
		}  
		$this->pager->getQuery()->orderBy($this->setOrdenamiento());
		$this->pager->getQuery()->groupBy('ug.usuario_id');
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();
		
		$this->usuario_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
		$this->Grupo = $this->grupoBsq ? GrupoTrabajoTable::getGrupoTrabajo($this->grupoBsq) : '';
  }
	
	protected function setFiltroBusqueda()
	{
		$parcial = '';
		$modulo  = $this->getModuleName();
		$this->modulo = $modulo; 
	
		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->grupoBsq = $this->getRequestParameter('grupo');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (u.nombre LIKE '%$this->cajaBsq%' OR u.apellido LIKE '%$this->cajaBsq%' OR u.login LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->grupoBsq)) {
			$parcial .= " AND g.id = ".$this->grupoBsq ;
			$this->getUser()->setAttribute($modulo.'_nowgrupo', $this->grupoBsq);
		}

	
		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowgrupo');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->grupoBsq = $this->getUser()->getAttribute($modulo.'_nowgrupo');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowgrupo');
			$parcial="";
			$this->cajaBsq = "";
			$this->grupoBsq = "";
		}
		return 'deleted=0'.$parcial;
	}
	
	protected function setOrdenamiento()
	{
		$this->orderBy = 'u.apellido';
		$this->sortType = 'asc';
	
		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
	}
}