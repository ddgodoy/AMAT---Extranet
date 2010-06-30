<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Accion filter form base class.
 *
 * @package    filters
 * @subpackage Accion *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseAccionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'entidad_creadora'    => new sfWidgetFormChoice(array('choices' => array('' => '', 'Noticia' => 'Noticia', 'Evento' => 'Evento', 'Asamblea' => 'Asamblea'))),
      'entidad_creadora_id' => new sfWidgetFormFilterInput(),
      'entidad'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'Publico' => 'Publico', 'GrupoTrabajo' => 'GrupoTrabajo', 'ConsejoTerritorial' => 'ConsejoTerritorial', 'Organismo' => 'Organismo'))),
      'entidad_id'          => new sfWidgetFormFilterInput(),
      'accion'              => new sfWidgetFormChoice(array('choices' => array('' => '', 'ver' => 'ver'))),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'entidad_creadora'    => new sfValidatorChoice(array('required' => false, 'choices' => array('Noticia' => 'Noticia', 'Evento' => 'Evento', 'Asamblea' => 'Asamblea'))),
      'entidad_creadora_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'entidad'             => new sfValidatorChoice(array('required' => false, 'choices' => array('Publico' => 'Publico', 'GrupoTrabajo' => 'GrupoTrabajo', 'ConsejoTerritorial' => 'ConsejoTerritorial', 'Organismo' => 'Organismo'))),
      'entidad_id'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'accion'              => new sfValidatorChoice(array('required' => false, 'choices' => array('ver' => 'ver'))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('accion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Accion';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'entidad_creadora'    => 'Enum',
      'entidad_creadora_id' => 'Number',
      'entidad'             => 'Enum',
      'entidad_id'          => 'Number',
      'accion'              => 'Enum',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'deleted'             => 'Boolean',
    );
  }
}