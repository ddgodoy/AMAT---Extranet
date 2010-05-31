<?php
/**
 * noticias components.
 *
 * @package    extranet
 * @subpackage subcategoria_organismos
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class inicioComponents extends sfComponents
{
	public function executeExportar(sfWebRequest $request)
	{
		$this->arrayExportacion = array('1'=>'Excel','2'=>'CSV','3'=>'XML');		
	}
}