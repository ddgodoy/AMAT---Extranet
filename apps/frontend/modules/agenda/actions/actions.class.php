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
		$this->evento_list = array();

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
			$xFiltro .= "fecha >= '"."$xYear-$xMes-$xDia"."'";
			$this->fechaSeleccionada = "$xDia/$xMes/$xYear";
		}
		
//		$this->paginaActual = $this->getRequestParameter('page', 1);
//
//		if (is_numeric($this->paginaActual)) {
//			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
//		}
////		
////		##### eventos ###### 
////		if ($xFiltro != '') {
////			$where = 'e.deleted = 0 AND ue.usuario_id = '.$usurID.' AND e.'.$xFiltro;
////		} else {
////			$where = 'e.deleted = 0 AND ue.usuario_id = '.$usurID;
////		}
////		
////  		$this->pagerevntos = new sfDoctrinePager('Evento', 5);  
////		$this->pagerevntos->getQuery()
////				->from('Usuario u')
////				->leftJoin('u.UsuarioEvento ue')
////				->leftJoin('u.UsuarioEvento ue')
////				->where($where)
////				->orderBy('fecha DESC');
////		$this->pagerevntos->setPage($this->paginaActual);
////		$this->pagerevntos->init();		
////				
////		#######################################
		
		
		
		
		
		$this->Arrayevento = EventoTable::getEventoFecha($usurID, $xFiltro);
		$this->Arraycombocatoria = ConvocatoriaTable::getConvocatoria($usurID, $xFiltro);

		$this->evento_list[1] = $this->Arrayevento;
		$this->evento_list[2] = $this->Arraycombocatoria;

		$this->cantidadRegistros = $this->Arrayevento->count() + $this->Arraycombocatoria->count() ;
	}
}