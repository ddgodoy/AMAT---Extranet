<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Agenda filter form base class.
 *
 * @package    filters
 * @subpackage Agenda *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseAgendaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'           => new sfWidgetFormFilterInput(),
      'titulo'          => new sfWidgetFormFilterInput(),
      'Organizador'     => new sfWidgetFormFilterInput(),
      'url'             => new sfWidgetFormFilterInput(),
      'evento_id'       => new sfWidgetFormDoctrineChoice(array('model' => 'Evento', 'add_empty' => true)),
      'convocatoria_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Convocatoria', 'add_empty' => true)),
      'usuario_id'      => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'publico'         => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'fecha'           => new sfValidatorPass(array('required' => false)),
      'titulo'          => new sfValidatorPass(array('required' => false)),
      'Organizador'     => new sfValidatorPass(array('required' => false)),
      'url'             => new sfValidatorPass(array('required' => false)),
      'evento_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Evento', 'column' => 'id')),
      'convocatoria_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Convocatoria', 'column' => 'id')),
      'usuario_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Usuario', 'column' => 'id')),
      'publico'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('agenda_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Agenda';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'fecha'           => 'Text',
      'titulo'          => 'Text',
      'Organizador'     => 'Text',
      'url'             => 'Text',
      'evento_id'       => 'ForeignKey',
      'convocatoria_id' => 'ForeignKey',
      'usuario_id'      => 'ForeignKey',
      'publico'         => 'Number',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'deleted'         => 'Boolean',
    );
  }
}