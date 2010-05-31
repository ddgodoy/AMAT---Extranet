<?php

/**
 * acta actions.
 *
 * @package    extranet
 * @subpackage acta
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class asamblea_organismoActions extends sfActions
{
	
	public function executeIndex(sfWebRequest $request)
	{
		    $get= $this->getRequestParameter('organismo') ?'&grupodetrabajo=Organismo_'.$this->getRequestParameter('organismo'): '';
	   		$this->redirect('asambleas/index?Organismo=4'.$get); 
		
	}
}