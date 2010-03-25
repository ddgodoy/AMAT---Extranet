<?php

/**
 * inicio actions.
 *
 * @package    extranet
 * @subpackage inicio
 * @author     Matias Gentiletti
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class miembros_organismoActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
//		$this->forward404Unless( $usuario = Doctrine::getTable('Usuario')->find(sfContext::getInstance()->getUser()->getAttribute('userId')) , sprintf('Object usuario does not exist.'));
//		
//		$this->usuario_list = $miembros =$usuario->UsuariosdeMisGrupos();
//
//		$this->cantidadRegistros = count($miembros);
//		$this->setFiltroBusqueda();
     
         $this->paginaActual = $this->getRequestParameter('page', 1);
         if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}

		 
         $organismos = Organismo::IdDeOrganismo($this->getUser()->getAttribute('userId'),1);
         if($organismos)
         {
         
	        $this->pager = new sfDoctrinePager('Usuario', 10);  	    
			$this->pager->getQuery()
			->from('UsuarioOrganismo uo')
			->leftJoin('uo.Usuario u')
			->leftJoin('uo.Organismo o')
			->Where($this->setFiltroBusqueda())
			->orderBy($this->setOrdenamiento())
			->groupBy('uo.usuario_id');
			$this->pager->setPage($this->paginaActual);
			$this->pager->init();
	
			$this->usuario_list = $this->pager->getResults();
			$this->cantidadRegistros = $this->pager->getNbResults();
       
        
        if($this->organismosBsq )
			{
			  $this->Organismos = OrganismoTable::getOrganismo($this->organismosBsq);
			}
			else 
			{
			  $this->Organismos = '';
			}
         }
         else 
         {
         	$this->usuario_list = '';
			$this->cantidadRegistros = 0;
        	
         }
         
	}
	
	protected function setFiltroBusqueda()
	{
		$parcial = '';
		$modulo  = $this->getModuleName();
		$this->modulo = $modulo;
	
		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->organismosBsq = $this->getRequestParameter('organismo');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (u.nombre LIKE '%$this->cajaBsq%' OR u.apellido LIKE '%$this->cajaBsq%' OR u.login LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		
		if (!empty($this->organismosBsq)) {
			$parcial .= " AND o.id =".$this->organismosBsq;
			$this->getUser()->setAttribute($modulo.'_noworganismo', $this->organismosBsq);
		}
	
		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_noworganismo');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->organismosBsq = $this->getUser()->getAttribute($modulo.'_noworganismo');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_noworganismo');
			$parcial="";
			$this->cajaBsq = "";
			$this->organismosBsq = '';
		}
		
		$organismos = Organismo::IdDeOrganismo($this->getUser()->getAttribute('userId'),1);
		$this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
	
		if(Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles))
		{
			return 'o.deleted=0'.$parcial;
		}
		else
		{
		   return 'o.deleted=0'.$parcial.' AND uo.organismo_id IN '.$organismos;
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