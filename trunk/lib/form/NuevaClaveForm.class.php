<?php
class NuevaClaveForm extends sfForm
{
	public function configure()
	{
		$this->setWidgets(array(
			'email' => new sfWidgetFormInput(array('label'=>'Email *'), array('class' => 'form_input', 'style' => 'width: 280px;')),
			'captcha' => new sfWidgetFormPHPCaptcha
											 (
											 	array('label'=>'Caracteres *'),
											 	array('class'=>'form_input', 'style'=>'width:100px;margin-right:20px;')
											 ),
		));

		$this->setValidators(array(
			'email' => new sfValidatorEmail
      					(
      					 array('required' => true), 
      					 array('required'=>'La cuenta de correo es obligatoria', 'invalid'=>'Ingrese un cuenta de correo v&aacute;lido')
      					),
			'captcha' => new sfValidatorPHPCaptcha
											(
												array('required' => true),
												array(
															'required'=> 'Debe ingresar los caracteres de la imagen',
															'invalid' => 'Los caracteres ingresados no son correctos'
														 )
											),
		));

		$this->widgetSchema->setNameFormat('nueva_clave[%s]');
	}
}