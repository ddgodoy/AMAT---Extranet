<?php

/**
 * DocumentacionGrupo form base class.
 *
 * @package    form
 * @subpackage documentacion_grupo
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseDocumentacionGrupoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'nombre'             => new sfWidgetFormTextarea(),
      'contenido'          => new sfWidgetFormTextarea(),
      'fecha'              => new sfWidgetFormDate(),
      'grupo_trabajo_id'   => new sfWidgetFormDoctrineChoice(array('model' => 'GrupoTrabajo', 'add_empty' => false)),
      'categoria_d_g_id'   => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaDG', 'add_empty' => false)),
      'estado'             => new sfWidgetFormChoice(array('choices' => array('guardado' => 'guardado', 'pendiente' => 'pendiente', 'publicado' => 'publicado'))),
      'owner_id'           => new sfWidgetFormInput(),
      'modificador_id'     => new sfWidgetFormInput(),
      'publicador_id'      => new sfWidgetFormInput(),
      'fecha_publicacion'  => new sfWidgetFormDate(),
      'user_id_creador'    => new sfWidgetFormInput(),
      'user_id_modificado' => new sfWidgetFormInput(),
      'user_id_publicado'  => new sfWidgetFormInput(),
      'fecha_publicado'    => new sfWidgetFormDateTime(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'deleted'            => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => 'DocumentacionGrupo', 'column' => 'id', 'required' => false)),
      'nombre'             => new sfValidatorString(array('required' => false)),
      'contenido'          => new sfValidatorString(array('required' => false)),
      'fecha'              => new sfValidatorDate(),
      'grupo_trabajo_id'   => new sfValidatorDoctrineChoice(array('model' => 'GrupoTrabajo')),
      'categoria_d_g_id'   => new sfValidatorDoctrineChoice(array('model' => 'CategoriaDG')),
      'estado'             => new sfValidatorChoice(array('choices' => array('guardado' => 'guardado', 'pendiente' => 'pendiente', 'publicado' => 'publicado'), 'required' => false)),
      'owner_id'           => new sfValidatorInteger(array('required' => false)),
      'modificador_id'     => new sfValidatorInteger(array('required' => false)),
      'publicador_id'      => new sfValidatorInteger(array('required' => false)),
      'fecha_publicacion'  => new sfValidatorDate(array('required' => false)),
      'user_id_creador'    => new sfValidatorInteger(array('required' => false)),
      'user_id_modificado' => new sfValidatorInteger(array('required' => false)),
      'user_id_publicado'  => new sfValidatorInteger(array('required' => false)),
      'fecha_publicado'    => new sfValidatorDateTime(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
      'deleted'            => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('documentacion_grupo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocumentacionGrupo';
  }

}
