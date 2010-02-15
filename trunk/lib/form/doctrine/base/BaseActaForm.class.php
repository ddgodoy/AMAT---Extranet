<?php

/**
 * Acta form base class.
 *
 * @package    form
 * @subpackage acta
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseActaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'nombre'      => new sfWidgetFormInput(),
      'detalle'     => new sfWidgetFormTextarea(),
      'asamblea_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Asamblea', 'add_empty' => true)),
      'owner_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'deleted'     => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => 'Acta', 'column' => 'id', 'required' => false)),
      'nombre'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'detalle'     => new sfValidatorString(array('required' => false)),
      'asamblea_id' => new sfValidatorDoctrineChoice(array('model' => 'Asamblea', 'required' => false)),
      'owner_id'    => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
      'deleted'     => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('acta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Acta';
  }

}
