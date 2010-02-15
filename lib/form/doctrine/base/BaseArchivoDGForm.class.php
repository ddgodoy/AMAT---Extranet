<?php

/**
 * ArchivoDG form base class.
 *
 * @package    form
 * @subpackage archivo_dg
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseArchivoDGForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'nombre'                 => new sfWidgetFormInput(),
      'fecha'                  => new sfWidgetFormDate(),
      'fecha_caducidad'        => new sfWidgetFormDate(),
      'contenido'              => new sfWidgetFormTextarea(),
      'archivo'                => new sfWidgetFormInput(),
      'owner_id'               => new sfWidgetFormInput(),
      'disponibilidad'         => new sfWidgetFormChoice(array('choices' => array('Solo Grupo' => 'Solo Grupo', 'Todos' => 'Todos'))),
      'grupo_trabajo_id'       => new sfWidgetFormDoctrineChoice(array('model' => 'GrupoTrabajo', 'add_empty' => true)),
      'documentacion_grupo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'DocumentacionGrupo', 'add_empty' => true)),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'deleted'                => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorDoctrineChoice(array('model' => 'ArchivoDG', 'column' => 'id', 'required' => false)),
      'nombre'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fecha'                  => new sfValidatorDate(),
      'fecha_caducidad'        => new sfValidatorDate(array('required' => false)),
      'contenido'              => new sfValidatorString(array('required' => false)),
      'archivo'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'owner_id'               => new sfValidatorInteger(array('required' => false)),
      'disponibilidad'         => new sfValidatorChoice(array('choices' => array('Solo Grupo' => 'Solo Grupo', 'Todos' => 'Todos'), 'required' => false)),
      'grupo_trabajo_id'       => new sfValidatorDoctrineChoice(array('model' => 'GrupoTrabajo', 'required' => false)),
      'documentacion_grupo_id' => new sfValidatorDoctrineChoice(array('model' => 'DocumentacionGrupo', 'required' => false)),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'deleted'                => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('archivo_dg[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArchivoDG';
  }

}
