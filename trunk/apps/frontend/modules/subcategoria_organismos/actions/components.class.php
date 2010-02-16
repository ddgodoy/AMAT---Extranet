<?php
/**
 * noticias components.
 *
 * @package    extranet
 * @subpackage subcategoria_organismos
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class subcategoria_organismosComponents extends sfComponents
{
	public function executeListasubcategoria(sfWebRequest $request)
	{
		$this->name;
		$this->subcategoria_organismos_selected = 0;
		$this->arraySubcategoria = SubCategoriaOrganismoTable::doSelectByCategoria($this->getRequestParameter('id_categoria_organismo'));
		
	}
}