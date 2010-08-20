<?php
/**
 * noticias components.
 *
 * @package    extranet
 * @subpackage subcategoria_organismos
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class iniciativasComponents extends sfComponents
{
	public function executeSubcategorias(sfWebRequest $request)
	{
		$id_categoria =  $this->id_categoria? $this->id_categoria : $request->getParameter('id_categoria') ;
	
		$subcategoria = SubCategoriaIniciativa::getArraySubCategoria($id_categoria);
    
   		$this->witSub = new IniciativaForm();
    
   		$this->witSub->setWidget('subcategoria_iniciativa_id', new sfWidgetFormChoice(array('choices' => $subcategoria)));
   		
   		$this->witSub->setDefault('subcategoria_iniciativa_id', $this->id_subcategoria);
   		
	}
}