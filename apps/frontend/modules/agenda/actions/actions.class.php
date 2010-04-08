<?php
/**
 * agenda actions.
 *
 * @package    extranet
 * @subpackage agenda
 * @author     Matias Gentiletti
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class agendaActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$usurID = sfContext::getInstance()->getUser()->getAttribute('userId');

		$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}		
		$this->pager = new sfDoctrinePager('Agenda', 10);
		$this->pager->getQuery()
				 ->from('Agenda')
				 ->where($this->setFiltroBusqueda())
				 ->addWhere('usuario_id = '.$usurID.' OR publico = 1')
				 ->orderBy($this->setOrdenamiento());

		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->agenda_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
	}

	protected function setFiltroBusqueda()
	{		
		$this->year  = $this->getRequestParameter('y', date('Y'));
		$this->month = $this->getRequestParameter('m', date('m'));
		$this->day   = $this->getRequestParameter('d', date('d'));
		$this->date  = $this->year . '-' . $this->month . '-' . $this->day;

		## filtro fecha calendario y usuario
		$xFiltro = '';
		$this->fechaSeleccionada = '';

		$xYear= $this->getRequestParameter('y');
		$xMes = $this->getRequestParameter('m');
		$xDia = $this->getRequestParameter('d');

		if (!empty($xYear) && !empty($xMes) && !empty($xDia)) {
			$xFiltro .= " AND fecha >= '"."$xYear-$xMes-$xDia"."'";
			$this->fechaSeleccionada = "$xDia/$xMes/$xYear";
		}
		
	  	sfLoader::loadHelpers('Date');
	
	  	$parcial = $xFiltro;
	  	$modulo = $this->getModuleName();
	
			$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
			$this->desdeBsq = $this->getRequestParameter('desde_busqueda');
			$this->hastaBsq = $this->getRequestParameter('hasta_busqueda');
			$this->ambitoBQ = $this->getRequestParameter('ambito');
			$this->estadoBq = $this->getRequestParameter('estado');
	
			if (!empty($this->cajaBsq)) {
				$parcial .= " AND titulo LIKE '%$this->cajaBsq%'";
				$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
			}
			if (!empty($this->desdeBsq)) {
				$parcial .= " AND fecha >= '".$this->FormatData($this->desdeBsq)."'";
				$this->getUser()->setAttribute($modulo.'_nowdesde', $this->desdeBsq);
			}
			if (!empty($this->hastaBsq)) {
				$parcial .= " AND fecha <= '".$this->FormatData($this->hastaBsq)."'";
				$this->getUser()->setAttribute($modulo.'_nowhasta', $this->hastaBsq);
			}
			if (!empty($this->estadoBq)) {
				if($this->estadoBq >= 0)
				{
					$parcial .= " AND evento_id > 0 AND convocatoria_id = 0";
				}
				else 
				{
					$parcial .= " AND evento_id == 0 AND convocatoria_id > 0";
				}
				
				$this->getUser()->setAttribute($modulo.'_nowestado', $this->estadoBq);
			}
	
			if (!empty($parcial)) {
				$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
			} else {
				if ($this->hasRequestParameter('btn_buscar')) {
					$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
					$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
					$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
					$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
					$this->getUser()->getAttributeHolder()->remove($modulo.'_nowambito');
					$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
				} else {
					$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
					$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
					$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowdesde');
					$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowhasta');
					$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowambito');
					$this->estadoBq = $this->getUser()->getAttribute($modulo.'_nowestado');
				}
			}
			if ($this->hasRequestParameter('btn_quitar')){
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowambito');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
				$parcial="";
				$this->cajaBsq = "";
				$this->desdeBsq = '';
				$this->hastaBsq = '';
				$this->ambitoBQ = '';
				$this->estadoBq = '';
			}
			return 'deleted=0'.$parcial;
	  }
	protected function setOrdenamiento()
  {
		$this->orderBy = 'fecha';
		$this->sortType = 'asc';

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }
  
  protected function FormatData($date)
  {
  	$Formadate = explode('/',$date);
  	
  	return $Formadate[2].'-'.$Formadate[1].'-'.$Formadate[0];

  }
	
}