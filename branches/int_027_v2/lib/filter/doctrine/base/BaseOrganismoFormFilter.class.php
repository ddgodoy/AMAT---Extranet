<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Organismo filter form base class.
 *
 * @package    filters
 * @subpackage Organismo *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseOrganismoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                    => new sfWidgetFormFilterInput(),
      'detalle'                   => new sfWidgetFormFilterInput(),
      'grupo_trabajo_id'          => new sfWidgetFormDoctrineChoice(array('model' => 'GrupoTrabajo', 'add_empty' => true)),
      'categoria_organismo_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaOrganismo', 'add_empty' => true)),
      'subcategoria_organismo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'add_empty' => true)),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'usuarios_list'             => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Usuario')),
    ));

    $this->setValidators(array(
      'nombre'                    => new sfValidatorPass(array('required' => false)),
      'detalle'                   => new sfValidatorPass(array('required' => false)),
      'grupo_trabajo_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'GrupoTrabajo', 'column' => 'id')),
      'categoria_organismo_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CategoriaOrganismo', 'column' => 'id')),
      'subcategoria_organismo_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'SubCategoriaOrganismo', 'column' => 'id')),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'usuarios_list'             => new sfValidatorDoctrineChoiceMany(array('model' => 'Usuario', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('organismo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addUsuariosListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.UsuarioOrganismo UsuarioOrganismo')
          ->andWhereIn('UsuarioOrganismo.usuario_id', $values);
  }

  public function getModelName()
  {
    return 'Organismo';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'nombre'                    => 'Text',
      'detalle'                   => 'Text',
      'grupo_trabajo_id'          => 'ForeignKey',
      'categoria_organismo_id'    => 'ForeignKey',
      'subcategoria_organismo_id' => 'ForeignKey',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
      'deleted'                   => 'Boolean',
      'usuarios_list'             => 'ManyKey',
    );
  }
}