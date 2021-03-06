<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * AplicacionAccion filter form base class.
 *
 * @package    filters
 * @subpackage AplicacionAccion *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseAplicacionAccionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'accion'            => new sfWidgetFormChoice(array('choices' => array('' => '', 'alta' => 'alta', 'baja' => 'baja', 'modificar' => 'modificar', 'listar' => 'listar', 'publicar' => 'publicar'))),
      'accion_del_modulo' => new sfWidgetFormFilterInput(),
      'aplicacion_id'     => new sfWidgetFormDoctrineChoice(array('model' => 'Aplicacion', 'add_empty' => true)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'accion'            => new sfValidatorChoice(array('required' => false, 'choices' => array('alta' => 'alta', 'baja' => 'baja', 'modificar' => 'modificar', 'listar' => 'listar', 'publicar' => 'publicar'))),
      'accion_del_modulo' => new sfValidatorPass(array('required' => false)),
      'aplicacion_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Aplicacion', 'column' => 'id')),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('aplicacion_accion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AplicacionAccion';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'accion'            => 'Enum',
      'accion_del_modulo' => 'Text',
      'aplicacion_id'     => 'ForeignKey',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
      'deleted'           => 'Boolean',
    );
  }
}