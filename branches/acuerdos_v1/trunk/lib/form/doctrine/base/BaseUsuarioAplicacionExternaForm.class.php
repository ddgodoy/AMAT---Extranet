<?php

/**
 * UsuarioAplicacionExterna form base class.
 *
 * @package    form
 * @subpackage usuario_aplicacion_externa
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseUsuarioAplicacionExternaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id'            => new sfWidgetFormInputHidden(),
      'aplicacion_externa_id' => new sfWidgetFormInputHidden(),
      'login'                 => new sfWidgetFormInput(),
      'salt'                  => new sfWidgetFormInput(),
      'number_access'         => new sfWidgetFormInput(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'deleted'               => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'usuario_id'            => new sfValidatorDoctrineChoice(array('model' => 'UsuarioAplicacionExterna', 'column' => 'usuario_id', 'required' => false)),
      'aplicacion_externa_id' => new sfValidatorDoctrineChoice(array('model' => 'UsuarioAplicacionExterna', 'column' => 'aplicacion_externa_id', 'required' => false)),
      'login'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'salt'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'number_access'         => new sfValidatorInteger(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
      'updated_at'            => new sfValidatorDateTime(array('required' => false)),
      'deleted'               => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('usuario_aplicacion_externa[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioAplicacionExterna';
  }

}
