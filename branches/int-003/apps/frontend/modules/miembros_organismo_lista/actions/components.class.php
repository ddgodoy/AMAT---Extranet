<?php
/**
 * noticias components.
 *
 * @package    extranet
 * @subpackage notificaciones
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class miembros_organismo_listaComponents extends sfComponents
{
	public function executeMenuOrganismos(sfWebRequest $request)
	{
            if($this->id)
            {
		$this->organismo = OrganismoTable::getOrganismosByid($this->id);
            }
            else
            {
               $this->organismo = '';
            }

	}
}