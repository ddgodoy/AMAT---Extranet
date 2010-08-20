<?php

/**
 * acta actions.
 *
 * @package    extranet
 * @subpackage acta
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class asamblea_directorActions extends sfActions
{
	
	public function executeIndex(sfWebRequest $request)
	{
		if($this->getRequestParameter('DirectoresGerente')==1)
		{  
	   		$this->redirect('asambleas/index?DirectoresGerente=1'); 
		   	
		}
		
	}
}