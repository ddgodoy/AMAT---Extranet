<?php

/**
 * UsuarioEvento form base class.
 *
 * @package    form
 * @subpackage usuario_evento
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseUsuarioEventoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'usuario_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => false)),
      'evento_id'  => new sfWidgetFormDoctrineChoice(array('model' => 'Evento', 'add_empty' => false)),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'UsuarioEvento', 'column' => 'id', 'required' => false)),
      'usuario_id' => new sfValidatorDoctrineChoice(array('model' => 'Usuario')),
      'evento_id'  => new sfValidatorDoctrineChoice(array('model' => 'Evento')),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_evento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioEvento';
  }

}
