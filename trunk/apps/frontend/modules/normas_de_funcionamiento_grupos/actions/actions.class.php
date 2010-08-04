<?php

/**
 * normas_de_funcionamiento_grupos actions.
 *
 * @package    extranet
 * @subpackage normas_de_funcionamiento_grupos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class normas_de_funcionamiento_gruposActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	    $arraDAtos = array();
  	    $arraDAtos['busqueda'] = 'Grupos de Trabajo'; 
  	    $this->DAtos = $arraDAtos;
  	       
  	 
            $this->paginaActual = $this->getRequestParameter('page', 1);
 
		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		$this->pager = new sfDoctrinePager('NormasDeFuncionamiento', 10);
		$this->pager->getQuery()
		->from('NormasDeFuncionamiento')
		->where($this->setFiltroBusqueda())
		->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();
  	    
		$this->normas_de_funcionamiento_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
  	
		if($this->grupo)
			{
			  $this->Grupo = GrupoTrabajoTable::getGrupoTrabajo($this->grupo);
			}
			else 
			{
			  $this->Grupo = '';
			}
   }
   public function executeShow(sfWebRequest $request)
	{
		
		$this->modulo = $this->getModuleName();
		
		$this->Normas = Doctrine::getTable('NormasDeFuncionamiento')->find($request->getParameter('id'));
		$this->forward404Unless($this->Normas);
		
		if($this->Normas->getGrupoTrabajoId())
			{
			  $this->Grupo = GrupoTrabajoTable::getGrupoTrabajo($this->Normas->getGrupoTrabajoId());
			}
			else 
			{
			  $this->Grupo = '';
			}
		
	}
  protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');

  	$parcial = '';
  	$modulo = $this->getModuleName();
  	$this->modulo = $modulo;

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->grupo = $this->getRequestParameter('grupo');

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND titulo LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		 if(!empty($this->grupo))
		{
			$parcial.=" AND  grupo_trabajo_id =$this->grupo";
			$this->getUser()->setAttribute($modulo.'_nowentidad', $this->grupo);
		}
		

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowentidad');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->grupo = $this->getUser()->getAttribute($modulo.'_nowentidad');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowentidad');
			$parcial="";
			$this->cajaBsq = "";
			$this->grupo = '';
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
                        $this->orderBy = 'titulo';
                        $this->sortType = 'desc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }	

}
