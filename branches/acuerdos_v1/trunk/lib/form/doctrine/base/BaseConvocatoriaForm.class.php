<?php

/**
 * Convocatoria form base class.
 *
 * @package    form
 * @subpackage convocatoria
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseConvocatoriaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'nombre'      => new sfWidgetFormTextarea(),
      'detalle'     => new sfWidgetFormTextarea(),
      'asamblea_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Asamblea', 'add_empty' => true)),
      'owner_id'    => new sfWidgetFormInput(),
      'usuario_id'  => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'estado'      => new sfWidgetFormChoice(array('choices' => array('pendiente' => 'pendiente', 'aceptada' => 'aceptada', 'rechazada' => 'rechazada'))),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'deleted'     => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => 'Convocatoria', 'column' => 'id', 'required' => false)),
      'nombre'      => new sfValidatorString(array('required' => false)),
      'detalle'     => new sfValidatorString(array('required' => false)),
      'asamblea_id' => new sfValidatorDoctrineChoice(array('model' => 'Asamblea', 'required' => false)),
      'owner_id'    => new sfValidatorInteger(array('required' => false)),
      'usuario_id'  => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => false)),
      'estado'      => new sfValidatorChoice(array('choices' => array('pendiente' => 'pendiente', 'aceptada' => 'aceptada', 'rechazada' => 'rechazada'), 'required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
      'deleted'     => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('convocatoria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Convocatoria';
  }

}
