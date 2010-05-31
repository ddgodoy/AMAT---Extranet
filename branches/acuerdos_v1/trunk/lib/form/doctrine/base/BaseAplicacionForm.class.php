<?php

/**
 * Aplicacion form base class.
 *
 * @package    form
 * @subpackage aplicacion
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseAplicacionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'nombre'         => new sfWidgetFormTextarea(),
      'nombre_entidad' => new sfWidgetFormInput(),
      'nombre_modulo'  => new sfWidgetFormInput(),
      'tipo'           => new sfWidgetFormChoice(array('choices' => array('front' => 'front', 'back' => 'back'))),
      'titulo'         => new sfWidgetFormInput(),
      'descripcion'    => new sfWidgetFormTextarea(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'deleted'        => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => 'Aplicacion', 'column' => 'id', 'required' => false)),
      'nombre'         => new sfValidatorString(array('required' => false)),
      'nombre_entidad' => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'nombre_modulo'  => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'tipo'           => new sfValidatorChoice(array('choices' => array('front' => 'front', 'back' => 'back'), 'required' => false)),
      'titulo'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'descripcion'    => new sfValidatorString(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
      'deleted'        => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('aplicacion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Aplicacion';
  }

}
