<?php
/**
 * noticias components.
 *
 * @package    extranet
 * @subpackage categoria_organisamos
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class categoria_organismosComponents extends sfComponents
{
	public function executeListacategoria(sfWebRequest $request)
	{
		$this->name; 
		$modulo = $this->getContext()->getModuleName();

		if (!$this->getUser()->getAttribute($modulo.'_nowcategoria') || $this->getContext()->getActionName() == 'nueva')
		{
		  $this->categoria_organismos_selected = $this->categoria;
		}

		if($this->getContext()->getActionName() == 'editar' || $this->getContext()->getActionName() == 'create' || $this->getContext()->getActionName() == 'update' ) 
		{
                        $id = str_replace('&', '',$request->getParameter('id'));
			$this->categoria_organismos_selected = $this->categoria ? $this->categoria : DocumentacionOrganismoTable::getDocumentacionOrganismo($id)->getCategoriaOrganismoId();
		}

		if($this->getUser()->getAttribute($modulo.'_nowcategoria') && $this->getContext()->getActionName() != 'editar' && $this->getContext()->getActionName() != 'nueva' )
		{
			$this->categoria_organismos_selected = $this->getUser()->getAttribute($modulo.'_nowcategoria');
		}

		$this->arrayCategoria = OrganismoTable::doSelectAllCategorias('CategoriaOrganismo');		
	}
}