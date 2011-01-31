<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * AplicacionRol filter form base class.
 *
 * @package    filters
 * @subpackage AplicacionRol *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseAplicacionRolFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'accion_alta'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'accion_baja'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'accion_modificar' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'accion_listar'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'accion_publicar'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'aplicacion_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'Aplicacion', 'add_empty' => true)),
      'rol_id'           => new sfWidgetFormDoctrineChoice(array('model' => 'Rol', 'add_empty' => true)),
      'active_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'accion_alta'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'accion_baja'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'accion_modificar' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'accion_listar'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'accion_publicar'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'aplicacion_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Aplicacion', 'column' => 'id')),
      'rol_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Rol', 'column' => 'id')),
      'active_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('aplicacion_rol_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AplicacionRol';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'accion_alta'      => 'Boolean',
      'accion_baja'      => 'Boolean',
      'accion_modificar' => 'Boolean',
      'accion_listar'    => 'Boolean',
      'accion_publicar'  => 'Boolean',
      'aplicacion_id'    => 'ForeignKey',
      'rol_id'           => 'ForeignKey',
      'active_at'        => 'Date',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'deleted'          => 'Boolean',
    );
  }
}