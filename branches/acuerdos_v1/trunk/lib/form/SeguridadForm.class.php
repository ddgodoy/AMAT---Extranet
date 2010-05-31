<?php

class SeguridadForm extends sfForm
{
	public function configure()
	{
		$this->setWidgets(array(
			'id'                          => new sfWidgetFormInputHidden(),
			'login'                       => new sfWidgetFormInput(array(), array('class' => 'form_input', 'style' => 'width: 320px;')),
			'password'                    => new sfWidgetFormInputPassword(array(), array('class' => 'form_input', 'style' => 'width: 320px;')),
		));
		
		$this->setValidators(array(
			'id'                          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'column' => 'id', 'required' => false)),
			'login'                       => new sfValidatorString(array('max_length' => 150, 'required' => true), array('required' => 'El usuario es obligatorio')),
			'password'                    => new sfValidatorString(array('max_length' => 150, 'required' => true), array('required' => 'La Contraseña es obligatoria')),
		));
		
		$this->widgetSchema->setLabels(array(
			'login'        					=> 'Usuario',
			'password'     					=> 'Clave',
		));
		
		$this->widgetSchema->setNameFormat('seguridad[%s]');
	}
}