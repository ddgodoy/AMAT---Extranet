<?php

/**
 * Agenda form base class.
 *
 * @package    form
 * @subpackage agenda
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseAgendaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'fecha'           => new sfWidgetFormTextarea(),
      'titulo'          => new sfWidgetFormTextarea(),
      'Organizador'     => new sfWidgetFormTextarea(),
      'url'             => new sfWidgetFormTextarea(),
      'evento_id'       => new sfWidgetFormDoctrineChoice(array('model' => 'Evento', 'add_empty' => true)),
      'convocatoria_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Convocatoria', 'add_empty' => true)),
      'usuario_id'      => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'deleted'         => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => 'Agenda', 'column' => 'id', 'required' => false)),
      'fecha'           => new sfValidatorString(array('required' => false)),
      'titulo'          => new sfValidatorString(array('required' => false)),
      'Organizador'     => new sfValidatorString(array('required' => false)),
      'url'             => new sfValidatorString(array('required' => false)),
      'evento_id'       => new sfValidatorDoctrineChoice(array('model' => 'Evento', 'required' => false)),
      'convocatoria_id' => new sfValidatorDoctrineChoice(array('model' => 'Convocatoria', 'required' => false)),
      'usuario_id'      => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
      'deleted'         => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('agenda[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Agenda';
  }

}
