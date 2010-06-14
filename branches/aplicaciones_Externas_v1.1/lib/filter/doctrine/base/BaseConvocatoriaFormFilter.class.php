<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Convocatoria filter form base class.
 *
 * @package    filters
 * @subpackage Convocatoria *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseConvocatoriaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'      => new sfWidgetFormFilterInput(),
      'detalle'     => new sfWidgetFormFilterInput(),
      'asamblea_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Asamblea', 'add_empty' => true)),
      'owner_id'    => new sfWidgetFormFilterInput(),
      'usuario_id'  => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'estado'      => new sfWidgetFormChoice(array('choices' => array('' => '', 'pendiente' => 'pendiente', 'aceptada' => 'aceptada', 'rechazada' => 'rechazada'))),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'nombre'      => new sfValidatorPass(array('required' => false)),
      'detalle'     => new sfValidatorPass(array('required' => false)),
      'asamblea_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Asamblea', 'column' => 'id')),
      'owner_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'usuario_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Usuario', 'column' => 'id')),
      'estado'      => new sfValidatorChoice(array('required' => false, 'choices' => array('pendiente' => 'pendiente', 'aceptada' => 'aceptada', 'rechazada' => 'rechazada'))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('convocatoria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Convocatoria';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'nombre'      => 'Text',
      'detalle'     => 'Text',
      'asamblea_id' => 'ForeignKey',
      'owner_id'    => 'Number',
      'usuario_id'  => 'ForeignKey',
      'estado'      => 'Enum',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
      'deleted'     => 'Boolean',
    );
  }
}