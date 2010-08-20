<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * SubCategoriaIniciativa filter form base class.
 *
 * @package    filters
 * @subpackage SubCategoriaIniciativa *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseSubCategoriaIniciativaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                  => new sfWidgetFormFilterInput(),
      'contenido'               => new sfWidgetFormFilterInput(),
      'categoria_iniciativa_id' => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaIniciativa', 'add_empty' => true)),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'nombre'                  => new sfValidatorPass(array('required' => false)),
      'contenido'               => new sfValidatorPass(array('required' => false)),
      'categoria_iniciativa_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CategoriaIniciativa', 'column' => 'id')),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('sub_categoria_iniciativa_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SubCategoriaIniciativa';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'nombre'                  => 'Text',
      'contenido'               => 'Text',
      'categoria_iniciativa_id' => 'ForeignKey',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
      'deleted'                 => 'Boolean',
    );
  }
}