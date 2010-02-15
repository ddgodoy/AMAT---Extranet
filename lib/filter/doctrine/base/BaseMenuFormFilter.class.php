<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Menu filter form base class.
 *
 * @package    filters
 * @subpackage Menu *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseMenuFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'padre_id'      => new sfWidgetFormFilterInput(),
      'nombre'        => new sfWidgetFormFilterInput(),
      'descripcion'   => new sfWidgetFormFilterInput(),
      'aplicacion_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Aplicacion', 'add_empty' => true)),
      'url_externa'   => new sfWidgetFormFilterInput(),
      'posicion'      => new sfWidgetFormFilterInput(),
      'habilitado'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'padre_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nombre'        => new sfValidatorPass(array('required' => false)),
      'descripcion'   => new sfValidatorPass(array('required' => false)),
      'aplicacion_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Aplicacion', 'column' => 'id')),
      'url_externa'   => new sfValidatorPass(array('required' => false)),
      'posicion'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'habilitado'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('menu_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Menu';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'padre_id'      => 'Number',
      'nombre'        => 'Text',
      'descripcion'   => 'Text',
      'aplicacion_id' => 'ForeignKey',
      'url_externa'   => 'Text',
      'posicion'      => 'Number',
      'habilitado'    => 'Boolean',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
      'deleted'       => 'Boolean',
    );
  }
}