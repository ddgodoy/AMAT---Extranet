<?php

/**
 * EnvioError form base class.
 *
 * @package    form
 * @subpackage envio_error
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseEnvioErrorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'envio_id'   => new sfWidgetFormDoctrineChoice(array('model' => 'EnvioComunicado', 'add_empty' => true)),
      'usuario_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'error'      => new sfWidgetFormTextarea(),
      'estado'     => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'EnvioError', 'column' => 'id', 'required' => false)),
      'envio_id'   => new sfValidatorDoctrineChoice(array('model' => 'EnvioComunicado', 'required' => false)),
      'usuario_id' => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => false)),
      'error'      => new sfValidatorString(array('required' => false)),
      'estado'     => new sfValidatorInteger(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted'    => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('envio_error[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EnvioError';
  }

}
