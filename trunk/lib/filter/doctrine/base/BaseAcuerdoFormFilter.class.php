<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Acuerdo filter form base class.
 *
 * @package    filters
 * @subpackage Acuerdo *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseAcuerdoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                  => new sfWidgetFormFilterInput(),
      'contenido'               => new sfWidgetFormFilterInput(),
      'fecha'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'categoria_acuerdo_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaAcuerdo', 'add_empty' => true)),
      'subcategoria_acuerdo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaAcuerdo', 'add_empty' => true)),
      'documento'               => new sfWidgetFormFilterInput(),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'nombre'                  => new sfValidatorPass(array('required' => false)),
      'contenido'               => new sfValidatorPass(array('required' => false)),
      'fecha'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'categoria_acuerdo_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CategoriaAcuerdo', 'column' => 'id')),
      'subcategoria_acuerdo_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'SubCategoriaAcuerdo', 'column' => 'id')),
      'documento'               => new sfValidatorPass(array('required' => false)),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('acuerdo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Acuerdo';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'nombre'                  => 'Text',
      'contenido'               => 'Text',
      'fecha'                   => 'Date',
      'categoria_acuerdo_id'    => 'ForeignKey',
      'subcategoria_acuerdo_id' => 'ForeignKey',
      'documento'               => 'Text',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
      'deleted'                 => 'Boolean',
    );
  }
}