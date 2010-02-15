<?php

/**
 * UsuarioAsamblea form base class.
 *
 * @package    form
 * @subpackage usuario_asamblea
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseUsuarioAsambleaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'usuario_id'  => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => false)),
      'asamblea_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Asamblea', 'add_empty' => false)),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => 'UsuarioAsamblea', 'column' => 'id', 'required' => false)),
      'usuario_id'  => new sfValidatorDoctrineChoice(array('model' => 'Usuario')),
      'asamblea_id' => new sfValidatorDoctrineChoice(array('model' => 'Asamblea')),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_asamblea[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioAsamblea';
  }

}
