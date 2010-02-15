<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * DocumentacionOrganismo filter form base class.
 *
 * @package    filters
 * @subpackage DocumentacionOrganismo *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseDocumentacionOrganismoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                    => new sfWidgetFormFilterInput(),
      'contenido'                 => new sfWidgetFormFilterInput(),
      'fecha'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'categoria_organismo_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaOrganismo', 'add_empty' => true)),
      'subcategoria_organismo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'add_empty' => true)),
      'organismo_id'              => new sfWidgetFormDoctrineChoice(array('model' => 'Organismo', 'add_empty' => true)),
      'estado'                    => new sfWidgetFormChoice(array('choices' => array('' => '', 'pendiente' => 'pendiente', 'publicado' => 'publicado'))),
      'owner_id'                  => new sfWidgetFormFilterInput(),
      'modificador_id'            => new sfWidgetFormFilterInput(),
      'publicador_id'             => new sfWidgetFormFilterInput(),
      'fecha_publicacion'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'user_id_creador'           => new sfWidgetFormFilterInput(),
      'user_id_modificado'        => new sfWidgetFormFilterInput(),
      'user_id_publicado'         => new sfWidgetFormFilterInput(),
      'fecha_publicado'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'nombre'                    => new sfValidatorPass(array('required' => false)),
      'contenido'                 => new sfValidatorPass(array('required' => false)),
      'fecha'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'categoria_organismo_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CategoriaOrganismo', 'column' => 'id')),
      'subcategoria_organismo_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'SubCategoriaOrganismo', 'column' => 'id')),
      'organismo_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Organismo', 'column' => 'id')),
      'estado'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('pendiente' => 'pendiente', 'publicado' => 'publicado'))),
      'owner_id'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'modificador_id'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'publicador_id'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha_publicacion'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'user_id_creador'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id_modificado'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id_publicado'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha_publicado'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('documentacion_organismo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocumentacionOrganismo';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'nombre'                    => 'Text',
      'contenido'                 => 'Text',
      'fecha'                     => 'Date',
      'categoria_organismo_id'    => 'ForeignKey',
      'subcategoria_organismo_id' => 'ForeignKey',
      'organismo_id'              => 'ForeignKey',
      'estado'                    => 'Enum',
      'owner_id'                  => 'Number',
      'modificador_id'            => 'Number',
      'publicador_id'             => 'Number',
      'fecha_publicacion'         => 'Date',
      'user_id_creador'           => 'Number',
      'user_id_modificado'        => 'Number',
      'user_id_publicado'         => 'Number',
      'fecha_publicado'           => 'Date',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
      'deleted'                   => 'Boolean',
    );
  }
}