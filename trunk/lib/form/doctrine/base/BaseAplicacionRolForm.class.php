<?php

/**
 * AplicacionRol form base class.
 *
 * @package    form
 * @subpackage aplicacion_rol
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseAplicacionRolForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'accion_alta'      => new sfWidgetFormInputCheckbox(),
      'accion_baja'      => new sfWidgetFormInputCheckbox(),
      'accion_modificar' => new sfWidgetFormInputCheckbox(),
      'accion_listar'    => new sfWidgetFormInputCheckbox(),
      'accion_publicar'  => new sfWidgetFormInputCheckbox(),
      'aplicacion_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'Aplicacion', 'add_empty' => true)),
      'rol_id'           => new sfWidgetFormDoctrineChoice(array('model' => 'Rol', 'add_empty' => true)),
      'active_at'        => new sfWidgetFormDateTime(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'deleted'          => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => 'AplicacionRol', 'column' => 'id', 'required' => false)),
      'accion_alta'      => new sfValidatorBoolean(array('required' => false)),
      'accion_baja'      => new sfValidatorBoolean(array('required' => false)),
      'accion_modificar' => new sfValidatorBoolean(array('required' => false)),
      'accion_listar'    => new sfValidatorBoolean(array('required' => false)),
      'accion_publicar'  => new sfValidatorBoolean(array('required' => false)),
      'aplicacion_id'    => new sfValidatorDoctrineChoice(array('model' => 'Aplicacion', 'required' => false)),
      'rol_id'           => new sfValidatorDoctrineChoice(array('model' => 'Rol', 'required' => false)),
      'active_at'        => new sfValidatorDateTime(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
      'deleted'          => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('aplicacion_rol[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AplicacionRol';
  }

}
