<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Aplicacion filter form base class.
 *
 * @package    filters
 * @subpackage Aplicacion *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseAplicacionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'         => new sfWidgetFormFilterInput(),
      'nombre_entidad' => new sfWidgetFormFilterInput(),
      'nombre_modulo'  => new sfWidgetFormFilterInput(),
      'tipo'           => new sfWidgetFormChoice(array('choices' => array('' => '', 'front' => 'front', 'back' => 'back'))),
      'titulo'         => new sfWidgetFormFilterInput(),
      'descripcion'    => new sfWidgetFormFilterInput(),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'nombre'         => new sfValidatorPass(array('required' => false)),
      'nombre_entidad' => new sfValidatorPass(array('required' => false)),
      'nombre_modulo'  => new sfValidatorPass(array('required' => false)),
      'tipo'           => new sfValidatorChoice(array('required' => false, 'choices' => array('front' => 'front', 'back' => 'back'))),
      'titulo'         => new sfValidatorPass(array('required' => false)),
      'descripcion'    => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('aplicacion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Aplicacion';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'nombre'         => 'Text',
      'nombre_entidad' => 'Text',
      'nombre_modulo'  => 'Text',
      'tipo'           => 'Enum',
      'titulo'         => 'Text',
      'descripcion'    => 'Text',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'deleted'        => 'Boolean',
    );
  }
}