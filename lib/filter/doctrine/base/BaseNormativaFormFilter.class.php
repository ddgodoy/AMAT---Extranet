<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Normativa filter form base class.
 *
 * @package    filters
 * @subpackage Normativa *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseNormativaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                        => new sfWidgetFormFilterInput(),
      'contenido'                     => new sfWidgetFormFilterInput(),
      'fecha'                         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'publicacion_boe'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'categoria_normativa_id'        => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaNormativa', 'add_empty' => true)),
      'subcategoria_normativa_uno_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaNormativaN1', 'add_empty' => true)),
      'subcategoria_normativa_dos_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaNormativaN2', 'add_empty' => true)),
      'documento'                     => new sfWidgetFormFilterInput(),
      'created_at'                    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'                    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'                       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'nombre'                        => new sfValidatorPass(array('required' => false)),
      'contenido'                     => new sfValidatorPass(array('required' => false)),
      'fecha'                         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'publicacion_boe'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'categoria_normativa_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CategoriaNormativa', 'column' => 'id')),
      'subcategoria_normativa_uno_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'SubCategoriaNormativaN1', 'column' => 'id')),
      'subcategoria_normativa_dos_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'SubCategoriaNormativaN2', 'column' => 'id')),
      'documento'                     => new sfValidatorPass(array('required' => false)),
      'created_at'                    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'                       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('normativa_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Normativa';
  }

  public function getFields()
  {
    return array(
      'id'                            => 'Number',
      'nombre'                        => 'Text',
      'contenido'                     => 'Text',
      'fecha'                         => 'Date',
      'publicacion_boe'               => 'Date',
      'categoria_normativa_id'        => 'ForeignKey',
      'subcategoria_normativa_uno_id' => 'ForeignKey',
      'subcategoria_normativa_dos_id' => 'ForeignKey',
      'documento'                     => 'Text',
      'created_at'                    => 'Date',
      'updated_at'                    => 'Date',
      'deleted'                       => 'Boolean',
    );
  }
}