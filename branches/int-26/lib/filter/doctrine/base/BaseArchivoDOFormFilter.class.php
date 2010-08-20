<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * ArchivoDO filter form base class.
 *
 * @package    filters
 * @subpackage ArchivoDO *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseArchivoDOFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                     => new sfWidgetFormFilterInput(),
      'fecha'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'fecha_caducidad'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'contenido'                  => new sfWidgetFormFilterInput(),
      'archivo'                    => new sfWidgetFormFilterInput(),
      'owner_id'                   => new sfWidgetFormFilterInput(),
      'disponibilidad'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'organismo' => 'organismo', 'todos' => 'todos'))),
      'categoria_organismo_id'     => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaOrganismo', 'add_empty' => true)),
      'subcategoria_organismo_id'  => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'add_empty' => true)),
      'organismo_id'               => new sfWidgetFormDoctrineChoice(array('model' => 'Organismo', 'add_empty' => true)),
      'documentacion_organismo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'DocumentacionOrganismo', 'add_empty' => true)),
      'created_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'                    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'nombre'                     => new sfValidatorPass(array('required' => false)),
      'fecha'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_caducidad'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'contenido'                  => new sfValidatorPass(array('required' => false)),
      'archivo'                    => new sfValidatorPass(array('required' => false)),
      'owner_id'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'disponibilidad'             => new sfValidatorChoice(array('required' => false, 'choices' => array('organismo' => 'organismo', 'todos' => 'todos'))),
      'categoria_organismo_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CategoriaOrganismo', 'column' => 'id')),
      'subcategoria_organismo_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'SubCategoriaOrganismo', 'column' => 'id')),
      'organismo_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Organismo', 'column' => 'id')),
      'documentacion_organismo_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'DocumentacionOrganismo', 'column' => 'id')),
      'created_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('archivo_do_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArchivoDO';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'nombre'                     => 'Text',
      'fecha'                      => 'Date',
      'fecha_caducidad'            => 'Date',
      'contenido'                  => 'Text',
      'archivo'                    => 'Text',
      'owner_id'                   => 'Number',
      'disponibilidad'             => 'Enum',
      'categoria_organismo_id'     => 'ForeignKey',
      'subcategoria_organismo_id'  => 'ForeignKey',
      'organismo_id'               => 'ForeignKey',
      'documentacion_organismo_id' => 'ForeignKey',
      'created_at'                 => 'Date',
      'updated_at'                 => 'Date',
      'deleted'                    => 'Boolean',
    );
  }
}