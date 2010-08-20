<?php
/**
 * noticias components.
 *
 * @package    extranet
 * @subpackage subcategoria_organismos
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class acuerdoComponents extends sfComponents
{
	public function executeSubcategorias(sfWebRequest $request)
	{
		$id_categoria =  $this->id_categoria? $this->id_categoria : $request->getParameter('id_categoria') ;
	
		sfLoader::loadHelpers('Object');
                $subcategoria = SubCategoriaAcuerdoTable::getSubcategiriaBycategoria($request->getParameter('id_categoria'));

                $this->witSub = new AcuerdoForm();
                $this->witSub->setWidget('subcategoria_acuerdo_id', new sfWidgetFormChoice(array('choices' => array('0'=>'--seleccionar--')+_get_options_from_objects($subcategoria))));

   		$this->witSub->setDefault('subcategoria_acuerdo_id', $this->id_subcategoria);
   		
	}
}