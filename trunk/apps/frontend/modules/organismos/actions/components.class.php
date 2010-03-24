<?php
/**
 * noticias components.
 *
 * @package    extranet
 * @subpackage subcategoria_organismos
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class organismosComponents extends sfComponents
{
	public function executeListaorganismos(sfWebRequest $request)
	{
		$this->organismos_selected = 0;
		$this->arrayOrganismo = OrganismoTable::doSelectByOrganismoa($this->getRequestParameter('subcategoria_organismos'),$this->getUser()->getAttribute('userId'));
	}
}