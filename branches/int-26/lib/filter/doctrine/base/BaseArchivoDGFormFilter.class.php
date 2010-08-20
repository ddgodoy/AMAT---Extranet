<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * ArchivoDG filter form base class.
 *
 * @package    filters
 * @subpackage ArchivoDG *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseArchivoDGFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                 => new sfWidgetFormFilterInput(),
      'fecha'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'fecha_caducidad'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'contenido'              => new sfWidgetFormFilterInput(),
      'archivo'                => new sfWidgetFormFilterInput(),
      'owner_id'               => new sfWidgetFormFilterInput(),
      'disponibilidad'         => new sfWidgetFormChoice(array('choices' => array('' => '', 'Solo Grupo' => 'Solo Grupo', 'Todos' => 'Todos'))),
      'grupo_trabajo_id'       => new sfWidgetFormDoctrineChoice(array('model' => 'GrupoTrabajo', 'add_empty' => true)),
      'documentacion_grupo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'DocumentacionGrupo', 'add_empty' => true)),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'nombre'                 => new sfValidatorPass(array('required' => false)),
      'fecha'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_caducidad'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'contenido'              => new sfValidatorPass(array('required' => false)),
      'archivo'                => new sfValidatorPass(array('required' => false)),
      'owner_id'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'disponibilidad'         => new sfValidatorChoice(array('required' => false, 'choices' => array('Solo Grupo' => 'Solo Grupo', 'Todos' => 'Todos'))),
      'grupo_trabajo_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'GrupoTrabajo', 'column' => 'id')),
      'documentacion_grupo_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'DocumentacionGrupo', 'column' => 'id')),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('archivo_dg_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArchivoDG';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'nombre'                 => 'Text',
      'fecha'                  => 'Date',
      'fecha_caducidad'        => 'Date',
      'contenido'              => 'Text',
      'archivo'                => 'Text',
      'owner_id'               => 'Number',
      'disponibilidad'         => 'Enum',
      'grupo_trabajo_id'       => 'ForeignKey',
      'documentacion_grupo_id' => 'ForeignKey',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'deleted'                => 'Boolean',
    );
  }
}