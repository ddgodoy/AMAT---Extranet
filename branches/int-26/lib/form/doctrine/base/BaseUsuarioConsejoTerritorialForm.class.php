<?php

/**
 * UsuarioConsejoTerritorial form base class.
 *
 * @package    form
 * @subpackage usuario_consejo_territorial
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseUsuarioConsejoTerritorialForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id'             => new sfWidgetFormInputHidden(),
      'consejo_territorial_id' => new sfWidgetFormInputHidden(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'deleted'                => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'usuario_id'             => new sfValidatorDoctrineChoice(array('model' => 'UsuarioConsejoTerritorial', 'column' => 'usuario_id', 'required' => false)),
      'consejo_territorial_id' => new sfValidatorDoctrineChoice(array('model' => 'UsuarioConsejoTerritorial', 'column' => 'consejo_territorial_id', 'required' => false)),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'deleted'                => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('usuario_consejo_territorial[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioConsejoTerritorial';
  }

}
