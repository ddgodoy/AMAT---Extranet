<?php

/**
 * acta actions.
 *
 * @package    extranet
 * @subpackage acta
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class asamblea_consejosActions extends sfActions
{
	
	public function executeIndex(sfWebRequest $request)
	{
		
		    $get= $this->getRequestParameter('consejo') ?'&grupodetrabajo=ConsejoTerritorial_'.$this->getRequestParameter('consejo'): '';
		    
	   		$this->redirect('asambleas/index?ConsejoTerritorial=3'.$get); 
		
	}
}