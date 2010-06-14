<?php

/**
 * acta actions.
 *
 * @package    extranet
 * @subpackage acta
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class asamblea_juntaActions extends sfActions
{
	
	public function executeIndex(sfWebRequest $request)
	{
	   		$this->redirect('asambleas/index?Junta_directiva=5'); 
		   	
	}
}