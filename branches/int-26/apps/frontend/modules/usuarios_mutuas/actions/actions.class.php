<?php
/**
 * usuarios actions.
 *
 * @package    extranet
 * @subpackage usuarios
 * @author     Matias Gentiletti
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class usuarios_mutuasActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		## Nota: el filtro id>1 es para que no se muestre el super admin
		$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		
		$this->pager = new sfDoctrinePager('Usuario', 10);
		$this->pager->getQuery()
                ->from('Usuario u')
                ->leftJoin('u.UsuarioGrupoTrabajo ug')
                ->leftJoin('u.UsuarioConsejoTerritorial uc')
                ->leftJoin('u.UsuarioRol ur')
		->Where($this->setFiltroBusqueda())
		->orderBy($this->setOrdenamiento());
		
		$this->pager->setPage($this->getRequestParameter('page', 1));
		$this->pager->init();


		$this->usuario_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
	}

	protected function setFiltroBusqueda()
	{
		$parcial = '';
		$modulo  = $this->getModuleName();
	
                $mutua = $this->getUser()->getAttribute('mutuaId');

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->cajaGruBsq = $this->getRequestParameter('grupo');
		$this->cajaConBsq = $this->getRequestParameter('consejo');
	

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (u.nombre LIKE '%$this->cajaBsq%' OR u.apellido LIKE '%$this->cajaBsq%') ";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		
		if (!empty($this->cajaGruBsq)) {

                    $cadenaGrupo = '';
                         foreach ($this->cajaGruBsq AS $k=>$g){
                          $cadenaGrupo .= $g.',';
                         }
                    $cadenaGrupo = substr($cadenaGrupo,0,-1);
                   
                    $parcial .= " AND ug.grupo_trabajo_id IN (".$cadenaGrupo.")";
                    $this->getUser()->setAttribute($modulo.'_nowcaja_gru', $this->cajaGruBsq);
		}
		if (!empty($this->cajaConBsq)) {

                    $cadenaConsejo = '';
                         foreach ($this->cajaConBsq AS $L=>$c){
                          $cadenaConsejo .= $c.',';
                         }
                    $cadenaConsejo = substr($cadenaConsejo,0,-1);

                    $parcial .= " AND uc.consejo_territorial_id  IN  (".$cadenaConsejo.")";
                    $this->getUser()->setAttribute($modulo.'_nowcaja_con', $this->cajaConBsq);
		} 
		
		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_gru');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_con');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja_gru');
				$this->subcategoriaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja_con');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_gru');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_con');
			$parcial="";
			$this->cajaBsq = "";
			$this->cajaGruBsq = '';
			$this->cajaConBsq = '';
		}
			
		return "u.deleted=0 AND ( ug.usuario_id != '' OR uc.usuario_id != '' ) AND u.mutua_id = '".$mutua."'".$parcial;
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
                       $this->orderBy = 'u.apellido, u.nombre';
                       $this->sortType = 'asc';
                       $this->orderBYSql = $this->orderBy . ' ' . $this->sortType; 
                    }
                    else
                    {
                        $this->orderBy = 'u.nombre';
                        $this->sortType = 'asc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
	}
}