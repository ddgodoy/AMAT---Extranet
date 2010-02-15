<?php

/**
 * Mutua form.
 *
 * @package    form
 * @subpackage Mutua
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class MutuaForm extends BaseMutuaForm
{
  public function configure()
  {
  
  	$this->setWidgets(array(  	
  		'nombre'  => new sfWidgetFormInput(array(), array('class' => 'form_input', 'style' => 'width: 355px;')),
  		'detalle' => new fckFormWidget(),
  	));
  	
  	
  	$this->setValidators(array(
  		'nombre'  => new sfValidatorString(array('max_length' => 150, 'required' => true), array('required' => 'El nombre es obligatorio')),
  		'detalle' => new sfValidatorString(array('required' => true), array('required'=>'El detalle es obligatorio')),
	));
  	
	
	$this->widgetSchema->setLabels(array(
		'nombre' => 'Nombre',
		'detalle' => 'Detalle'
	));
	
	$this->widgetSchema->setNameFormat('mutua[%s]');

  }
}