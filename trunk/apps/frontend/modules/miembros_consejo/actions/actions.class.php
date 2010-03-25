<?php

/**
 * inicio actions.
 *
 * @package    extranet
 * @subpackage inicio
 * @author     Matias Gentiletti
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class miembros_consejoActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
    $this->paginaActual = $this->getRequestParameter('page', 1);

    if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		$consejosterritoriales = ConsejoTerritorial::IdDeconsejo($this->getUser()->getAttribute('userId'), 1);

		$this->pager = new sfDoctrinePager('Usuario', 10);
		$this->pager->getQuery()
				 ->from('UsuarioConsejoTerritorial uc')
				 ->leftJoin('uc.Usuario u')
				 ->leftJoin('uc.ConsejoTerritorial c')
				 ->leftJoin('u.UsuarioRol ur')
				 ->where('uc.usuario_id != '.$this->getUser()->getAttribute('userId'))
				 ->addWhere('ur.rol_id = 5');

		
		$this->pager->getQuery()->andWhere($this->setFiltroBusqueda())
		 		 ->orderBy($this->setOrdenamiento())
			 	 ->groupBy('uc.usuario_id');
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();
		
		$this->usuario_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
		$this->Consejo = $this->consejoBsq ? ConsejoTerritorialTable::getConsejo($this->consejoBsq) : '';
	}

	protected function setFiltroBusqueda()
	{
		$parcial = '';
		$modulo  = $this->getModuleName();
		$this->modulo = $modulo; 
	
		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->consejoBsq = $this->getRequestParameter('consejo');

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (u.nombre LIKE '%$this->cajaBsq%' OR u.apellido LIKE '%$this->cajaBsq%' OR u.login LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->consejoBsq)) {
			$parcial .= " AND c.id = ".$this->consejoBsq ;
			$this->getUser()->setAttribute($modulo.'_nowconsejo', $this->consejoBsq);
		}
		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowconsejo');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->consejoBsq = $this->getUser()->getAttribute($modulo.'_nowconsejo');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowconsejo');
			$parcial="";
			$this->cajaBsq = "";
			$this->consejoBsq = "";
		}
		$consejosterritoriales = ConsejoTerritorial::IdDeconsejo($this->getUser()->getAttribute('userId'),1);
		$this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
		if(Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles))
		{
			return 'deleted=0'.$parcial;
		}
		else
        { 
		  return 'deleted=0'.$parcial.' AND consejo_territorial_id IN '.$consejosterritoriales;
        }  
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