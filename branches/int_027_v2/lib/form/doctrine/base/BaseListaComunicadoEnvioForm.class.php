<?php

/**
 * ListaComunicadoEnvio form base class.
 *
 * @package    form
 * @subpackage lista_comunicado_envio
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseListaComunicadoEnvioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'envio_comunicado_id' => new sfWidgetFormInputHidden(),
      'lista_comunicado_id' => new sfWidgetFormInputHidden(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'deleted'             => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'envio_comunicado_id' => new sfValidatorDoctrineChoice(array('model' => 'ListaComunicadoEnvio', 'column' => 'envio_comunicado_id', 'required' => false)),
      'lista_comunicado_id' => new sfValidatorDoctrineChoice(array('model' => 'ListaComunicadoEnvio', 'column' => 'lista_comunicado_id', 'required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
      'deleted'             => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('lista_comunicado_envio[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaComunicadoEnvio';
  }

}
