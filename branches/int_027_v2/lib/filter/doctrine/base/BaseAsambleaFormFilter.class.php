<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Asamblea filter form base class.
 *
 * @package    filters
 * @subpackage Asamblea *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseAsambleaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'titulo'          => new sfWidgetFormFilterInput(),
      'direccion'       => new sfWidgetFormFilterInput(),
      'fecha'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'fecha_caducidad' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'horario'         => new sfWidgetFormFilterInput(),
      'contenido'       => new sfWidgetFormFilterInput(),
      'estado'          => new sfWidgetFormChoice(array('choices' => array('' => '', 'activa' => 'activa', 'anulada' => 'anulada', 'pendiente' => 'pendiente', 'caducada' => 'caducada'))),
      'entidad'         => new sfWidgetFormFilterInput(),
      'owner_id'        => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'titulo'          => new sfValidatorPass(array('required' => false)),
      'direccion'       => new sfValidatorPass(array('required' => false)),
      'fecha'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_caducidad' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'horario'         => new sfValidatorPass(array('required' => false)),
      'contenido'       => new sfValidatorPass(array('required' => false)),
      'estado'          => new sfValidatorChoice(array('required' => false, 'choices' => array('activa' => 'activa', 'anulada' => 'anulada', 'pendiente' => 'pendiente', 'caducada' => 'caducada'))),
      'entidad'         => new sfValidatorPass(array('required' => false)),
      'owner_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Usuario', 'column' => 'id')),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('asamblea_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Asamblea';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'titulo'          => 'Text',
      'direccion'       => 'Text',
      'fecha'           => 'Date',
      'fecha_caducidad' => 'Date',
      'horario'         => 'Text',
      'contenido'       => 'Text',
      'estado'          => 'Enum',
      'entidad'         => 'Text',
      'owner_id'        => 'ForeignKey',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'deleted'         => 'Boolean',
    );
  }
}