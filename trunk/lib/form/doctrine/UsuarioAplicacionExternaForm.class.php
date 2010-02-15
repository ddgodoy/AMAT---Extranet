<?php

/**
 * UsuarioAplicacionExterna form.
 *
 * @package    form
 * @subpackage UsuarioAplicacionExterna
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class UsuarioAplicacionExternaForm extends BaseUsuarioAplicacionExternaForm
{
  public function configure()
  {
  	
  	$this->setWidgets(array(
      'usuario_id'            => new sfWidgetFormInputHidden(),
      'aplicacion_externa_id' => new sfWidgetFormInputHidden(),
      'login'                 => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'usuario_id'            => new sfValidatorDoctrineChoice(array('model' => 'UsuarioAplicacionExterna', 'column' => 'usuario_id', 'required' => false)),
      'aplicacion_externa_id' => new sfValidatorDoctrineChoice(array('model' => 'UsuarioAplicacionExterna', 'column' => 'aplicacion_externa_id', 'required' => false)),
      'login'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));
    
    $this->widgetSchema->setLabels(array(
		'usuario_id'     		=> 'Usuario',
		'aplicacion_externa_id' => 'Aplicación Externa',
		'login'   				=> 'Login',
	));

    $this->widgetSchema->setNameFormat('usuario_aplicacion_externa[%s]');
  }
}