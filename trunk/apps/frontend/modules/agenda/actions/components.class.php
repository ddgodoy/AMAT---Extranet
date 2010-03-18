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
		sfLoader::loadHelpers('Security');
		## For calendar
		$this->arrayShows = array();
		$this->module = $request->getParameter('module').'/index?';
		$this->evento_list_array = array();

		$usurID  = sfContext::getInstance()->getUser()->getAttribute('userId');	
		$agenda  = Agenda::getRepository()->getEventoByUsuario(0,0,$usurID);		 
		$this->year  = $this->getRequestParameter('y', date('Y'));
		$this->month = $this->getRequestParameter('m', date('m'));
	    if(validate_action('listar','agenda'))
	    {
		 foreach ($agenda as $g) {	
				$year  = (int) date("Y", strtotime($g->getFecha()));
				$month = (int) date("m", strtotime($g->getFecha()));
				$day   = date("d", strtotime($g->getFecha()));
				
				if ($year == $this->year && $month == $this->month) {
					if (!isset($this->evento_list_array[$day]))  {
						$this->evento_list_array[$day] = $g->getTitulo();
					} else {
						$this->evento_list_array[$day] = 	$g->getTitulo() . "<br />". $this->evento_list_array[$day];
					}
				}
		  }
	    } 
	}
}