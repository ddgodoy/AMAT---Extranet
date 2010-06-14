<?php

/**
 * AplicacionAccion form base class.
 *
 * @package    form
 * @subpackage aplicacion_accion
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseAplicacionAccionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'accion'            => new sfWidgetFormChoice(array('choices' => array('alta' => 'alta', 'baja' => 'baja', 'modificar' => 'modificar', 'listar' => 'listar', 'publicar' => 'publicar'))),
      'accion_del_modulo' => new sfWidgetFormInput(),
      'aplicacion_id'     => new sfWidgetFormDoctrineChoice(array('model' => 'Aplicacion', 'add_empty' => true)),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'deleted'           => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => 'AplicacionAccion', 'column' => 'id', 'required' => false)),
      'accion'            => new sfValidatorChoice(array('choices' => array('alta' => 'alta', 'baja' => 'baja', 'modificar' => 'modificar', 'listar' => 'listar', 'publicar' => 'publicar'), 'required' => false)),
      'accion_del_modulo' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'aplicacion_id'     => new sfValidatorDoctrineChoice(array('model' => 'Aplicacion', 'required' => false)),
      'created_at'        => new sfValidatorDateTime(array('required' => false)),
      'updated_at'        => new sfValidatorDateTime(array('required' => false)),
      'deleted'           => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('aplicacion_accion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AplicacionAccion';
  }

}
