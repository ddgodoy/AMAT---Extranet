<?php

/**
 * UsuarioGrupoTrabajo form base class.
 *
 * @package    form
 * @subpackage usuario_grupo_trabajo
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseUsuarioGrupoTrabajoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id'       => new sfWidgetFormInputHidden(),
      'grupo_trabajo_id' => new sfWidgetFormInputHidden(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'deleted'          => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'usuario_id'       => new sfValidatorDoctrineChoice(array('model' => 'UsuarioGrupoTrabajo', 'column' => 'usuario_id', 'required' => false)),
      'grupo_trabajo_id' => new sfValidatorDoctrineChoice(array('model' => 'UsuarioGrupoTrabajo', 'column' => 'grupo_trabajo_id', 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
      'deleted'          => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('usuario_grupo_trabajo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioGrupoTrabajo';
  }

}
