<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Circular filter form base class.
 *
 * @package    filters
 * @subpackage Circular *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseCircularFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                    => new sfWidgetFormFilterInput(),
      'contenido'                 => new sfWidgetFormFilterInput(),
      'fecha'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'fecha_caducidad'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'numero'                    => new sfWidgetFormFilterInput(),
      'documento'                 => new sfWidgetFormFilterInput(),
      'circular_tema_id'          => new sfWidgetFormDoctrineChoice(array('model' => 'CircularCatTema', 'add_empty' => true)),
      'circular_sub_tema_id'      => new sfWidgetFormDoctrineChoice(array('model' => 'CircularSubTema', 'add_empty' => true)),
      'categoria_organismo_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaOrganismo', 'add_empty' => true)),
      'subcategoria_organismo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'add_empty' => true)),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'nombre'                    => new sfValidatorPass(array('required' => false)),
      'contenido'                 => new sfValidatorPass(array('required' => false)),
      'fecha'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_caducidad'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'numero'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'documento'                 => new sfValidatorPass(array('required' => false)),
      'circular_tema_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CircularCatTema', 'column' => 'id')),
      'circular_sub_tema_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CircularSubTema', 'column' => 'id')),
      'categoria_organismo_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CategoriaOrganismo', 'column' => 'id')),
      'subcategoria_organismo_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'SubCategoriaOrganismo', 'column' => 'id')),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('circular_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Circular';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'nombre'                    => 'Text',
      'contenido'                 => 'Text',
      'fecha'                     => 'Date',
      'fecha_caducidad'           => 'Date',
      'numero'                    => 'Number',
      'documento'                 => 'Text',
      'circular_tema_id'          => 'ForeignKey',
      'circular_sub_tema_id'      => 'ForeignKey',
      'categoria_organismo_id'    => 'ForeignKey',
      'subcategoria_organismo_id' => 'ForeignKey',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
      'deleted'                   => 'Boolean',
    );
  }
}