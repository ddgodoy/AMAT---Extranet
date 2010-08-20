<?php
class NuevaClaveForm extends sfForm
{
	public function configure()
	{
               $request =sfContext::getInstance();
               if($request->getRequest()->getParameter('nueva_clave'))
                {
                  $objRq = $request->getRequest()->getParameter('nueva_clave');
                  if($objRq['email']!='')
                   {
                      $email = $objRq['email'];
                      $emailActivo = UsuarioTable::getUsuariosActivos($email,1);
                      if(!empty($emailActivo))
                      {
                        $emailusu = $emailActivo->getEmail();
                      }
                   }
                }


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

                if(!empty ($emailusu))
                {
                  $this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare('email', sfValidatorSchemaCompare::NOT_EQUAL, $emailusu, array(), array('invalid' => 'Ingrese un cuenta de correo v&aacute;lido')));
                }

		$this->widgetSchema->setNameFormat('nueva_clave[%s]');
	}
}