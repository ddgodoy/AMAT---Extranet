<?php

/**
 * Asamblea form base class.
 *
 * @package    form
 * @subpackage asamblea
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseAsambleaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'titulo'          => new sfWidgetFormInput(),
      'direccion'       => new sfWidgetFormInput(),
      'fecha'           => new sfWidgetFormDate(),
      'fecha_caducidad' => new sfWidgetFormDate(),
      'horario'         => new sfWidgetFormInput(),
      'contenido'       => new sfWidgetFormTextarea(),
      'estado'          => new sfWidgetFormChoice(array('choices' => array('activa' => 'activa', 'anulada' => 'anulada', 'pendiente' => 'pendiente', 'caducada' => 'caducada'))),
      'entidad'         => new sfWidgetFormInput(),
      'owner_id'        => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'deleted'         => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => 'Asamblea', 'column' => 'id', 'required' => false)),
      'titulo'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'direccion'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fecha'           => new sfValidatorDate(array('required' => false)),
      'fecha_caducidad' => new sfValidatorDate(array('required' => false)),
      'horario'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'contenido'       => new sfValidatorString(array('required' => false)),
      'estado'          => new sfValidatorChoice(array('choices' => array('activa' => 'activa', 'anulada' => 'anulada', 'pendiente' => 'pendiente', 'caducada' => 'caducada'), 'required' => false)),
      'entidad'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'owner_id'        => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
      'deleted'         => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('asamblea[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Asamblea';
  }

}
