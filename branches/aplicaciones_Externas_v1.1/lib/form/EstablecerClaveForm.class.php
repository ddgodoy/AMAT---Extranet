<?php
class EstablecerClaveForm extends sfForm
{
	public function configure()
	{
		$this->setWidgets(array(
			'password'   => new sfWidgetFormInputPassword(array(), array('class' => 'form_input', 'style' => 'width: 200px;')),
			'repassword' => new sfWidgetFormInputPassword(array(), array('class' => 'form_input', 'style' => 'width: 200px;')),
		));

		$this->setValidators(array(
			'password'   => new sfValidatorString(array('max_length'=>150, 'required'=>true), array('required'=>'La Clave es obligatoria')),
			'repassword' => new sfValidatorString(array('required'=>true), array('required'=>'Debe repetir la Clave')),
		));
		
		$this->widgetSchema->setLabels(array(
			'password'   => 'Nueva Clave *',
			'repassword' => 'Repetir Clave *',
		));

		$this->widgetSchema->setNameFormat('establecer_clave[%s]');

		$this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'repassword', array(), array('invalid' => 'Las claves no son iguales')));
	}
}