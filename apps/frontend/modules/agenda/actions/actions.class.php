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
		
		$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		
		$this->pager = new sfDoctrinePager('Agenda', 10);
		$this->pager->getQuery()
		->from('Agenda')
		->where('deleted = 0'.$xFiltro)
		->addWhere('usuario_id = '.$usurID)
		->orderBy($this->setOrdenamiento());
		
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();
	
		$this->agenda_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
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
	
}