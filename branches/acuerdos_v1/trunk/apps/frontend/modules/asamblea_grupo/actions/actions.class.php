<?php

/**
 * acta actions.
 *
 * @package    extranet
 * @subpackage acta
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class asamblea_grupoActions extends sfActions
{
	
	public function executeIndex(sfWebRequest $request)
	{
		$get= $this->getRequestParameter('grupo') ?'&grupodetrabajo=GrupoTrabajo_'.$this->getRequestParameter('grupo'): '';
		  	

	   	$this->redirect('asambleas/index?GrupodeTrabajo=2'.$get); 
		   	
		
		
	}
}