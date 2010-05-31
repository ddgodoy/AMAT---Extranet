<?php
/**
 * noticias components.
 *
 * @package    extranet
 * @subpackage subcategoria_organismos
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class normativasComponents extends sfComponents
{
	public function executeSubcategoriasn1(sfWebRequest $request)
	{
		$Idctegoria = '';
		$Idctegoria = $request->getParameter('id_categoria')? $request->getParameter('id_categoria') : $this->id_categoria;
		
		$subcategoria = SubCategoriaNormativaN1::getArraySubCategoria($Idctegoria);
   
     	$this->witSub = new NormativaForm();
	    
	   $this->witSub->setWidget('subcategoria_normativa_uno_id', new sfWidgetFormChoice(array('choices' => $subcategoria),array('style'=>'width:150px;')));
	   
	   if($this->id_subcategoria1)
	   {
	   	
	   	$this->witSub->setDefault('subcategoria_normativa_uno_id',$this->id_subcategoria1);
	   	
	   }
	    	
    	
  	}
  	public function executeSubcategorias(sfWebRequest $request)
	{
		$Idctegoria = '';
		$Idctegoria = $request->getParameter('id_categoria')? $request->getParameter('id_categoria') : $this->id_categoria;
		
    	$subcategoria = SubCategoriaNormativaN2::getArraySubCategoria($Idctegoria);
   
  	    $this->witSub = new NormativaForm();
	    
	    $this->witSub->setWidget('subcategoria_normativa_dos_id', new sfWidgetFormChoice(array('choices' => $subcategoria),array('style'=>'width:150px;')));   
	    
	    if($this->id_subcategoria2)
	   {
	   	
	   	$this->witSub->setDefault('subcategoria_normativa_dos_id',$this->id_subcategoria2);
	   	
	   } 	
    	
  	}
}