<?php

/**
 * Envios form base class.
 *
 * @package    form
 * @subpackage envios
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseEnviosForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'envio_id'   => new sfWidgetFormDoctrineChoice(array('model' => 'EnvioComunicado', 'add_empty' => true)),
      'usuario_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'message_id' => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'Envios', 'column' => 'id', 'required' => false)),
      'envio_id'   => new sfValidatorDoctrineChoice(array('model' => 'EnvioComunicado', 'required' => false)),
      'usuario_id' => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => false)),
      'message_id' => new sfValidatorString(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted'    => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('envios[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Envios';
  }

}
