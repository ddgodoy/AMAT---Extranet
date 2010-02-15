<?php
class ContactoForm extends sfForm
{
	public function configure()
	{
		$categoriaAsunto = array();
		$query = CategoriaAsuntoTable::getAll();
		
//		echo '<pre>';
//		print_r($query);
//		echo '</pre>';
//		
//		exit();
		foreach($query AS $r)
		{
	      $categoriaAsunto[$r->getId()] = $r->getNombre();	
		} 
		
		$this->setWidgets(array(
			'tema'  => new sfWidgetFormChoice
										 (
										 	array('choices' => $categoriaAsunto),
											array('style'=>'width:300px;','class'=>'form_input')
											
										 ),
			'asunto' => new fckFormWidget(),
		));

		$this->setValidators(array(
			'tema' => new sfValidatorChoice
										(
											array('choices' => array_keys($categoriaAsunto), 'required' => true ),
											array('required' => 'Debe seleccionar una categoria')
										),
			'asunto' => new sfValidatorString(array('required' => true), array('required' => 'El asunto es obligatorio')),
		));

		$this->widgetSchema->setNameFormat('contacto[%s]');
	}
}