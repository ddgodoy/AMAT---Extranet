<?php
/**
 * agenda components.
 *
 * @package    extranet
 * @subpackage agenda
 * @author     Matias Gentiletti
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class agendaComponents extends sfComponents
{
	public function executeAgenda(sfWebRequest $request)
	{
		## For calendar
		$this->arrayShows = array();
		$this->module = $request->getParameter('module').'/index?';
		$this->evento_list_array = array();
//		$this->all_evento_list = EventoTable::getByUsuarioId($this->getUser()->getAttribute('userId'), false); ****ET***
		$usurID  = sfContext::getInstance()->getUser()->getAttribute('userId');	
		$this->all_evento_list = EventoTable::getAll($usurID,1);
		$this->all_convocatoria_list =ConvocatoriaTable::getConvocatoria($usurID);
		$this->arrayShows[1] = $this->all_evento_list;
		$this->arrayShows[2] = $this->all_convocatoria_list;
		 
		
		$this->year = $this->getRequestParameter('y', date('Y'));
		$this->month = $this->getRequestParameter('m', date('m'));
		
		
		
	 foreach ($this->arrayShows as $g=>$shows)
	  {	
	  	
		foreach ($shows as $k => $evento)
		{
			if($g == 1)
			{
				$FEchas = $evento->getFecha();
				$Titulo = $evento->getTitulo();
			}
			else 
			{
				$FEchas = $evento->Asamblea->getFecha();
				$Titulo = $evento->Asamblea->getTitulo();
			}
			
			$year  = (int) date("Y", strtotime($FEchas));
			$month = (int) date("m", strtotime($FEchas));
			$day   = date("d", strtotime($FEchas));
			
			if ($year == $this->year && $month == $this->month) {
				if (!isset($this->evento_list_array[$day])) 
				{
					$this->evento_list_array[$day] = $Titulo;
				} 
				else 
				{
					$this->evento_list_array[$day] = 	$Titulo . "<br />". $this->evento_list_array[$day];
				}
			}
		}
	  }
	  
	}	 
}