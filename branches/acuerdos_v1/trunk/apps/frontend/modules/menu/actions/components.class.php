<?php
/**
 * noticias components.
 *
 * @package    extranet
 * @subpackage subcategoria_organismos
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class menuComponents extends sfComponents
{
	public function executeListarElementos(sfWebRequest $request)
	{		
		$grupo = $this->getRequestParameter('id_grupo')? $this->getRequestParameter('id_grupo') : $this->getUser()->getAttribute('menu_nowcaja');

		$this->Elementos_selected = $this->getUser()->getAttribute('menu_nowcajaelemento');
		$this->arrayElementos = $grupo ? MenuTable::getMenuPadre($grupo) : array();
	}

	public function executeListarSubElementos(sfWebRequest $request)
	{
		$elementos = $this->getRequestParameter('elementos_id')? $this->getRequestParameter('elementos_id') : $this->getUser()->getAttribute('menu_nowcajaelemento');
	
		$this->Elementos_sub_selected = $this->getUser()->getAttribute('menu_nowcajasubelemento');
		$this->arraySubElementos = $elementos ? MenuTable::getMenuPadre($elementos) : array();
	}
}