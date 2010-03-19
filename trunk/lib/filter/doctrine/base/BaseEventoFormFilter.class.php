<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Evento filter form base class.
 *
 * @package    filters
 * @subpackage Evento *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseEventoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'titulo'             => new sfWidgetFormFilterInput(),
      'descripcion'        => new sfWidgetFormFilterInput(),
      'mas_info'           => new sfWidgetFormFilterInput(),
      'fecha'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'fecha_caducidad'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'imagen'             => new sfWidgetFormFilterInput(),
      'mas_imagen'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'documento'          => new sfWidgetFormFilterInput(),
      'organizador'        => new sfWidgetFormFilterInput(),
      'estado'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'guardado' => 'guardado', 'pendiente' => 'pendiente', 'publicado' => 'publicado'))),
      'ambito'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'intranet' => 'intranet', 'web' => 'web', 'ambos' => 'ambos'))),
      'owner_id'           => new sfWidgetFormFilterInput(),
      'user_id_creador'    => new sfWidgetFormFilterInput(),
      'user_id_modificado' => new sfWidgetFormFilterInput(),
      'user_id_publicado'  => new sfWidgetFormFilterInput(),
      'fecha_publicado'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'usuarios_list'      => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Usuario')),
    ));

    $this->setValidators(array(
      'titulo'             => new sfValidatorPass(array('required' => false)),
      'descripcion'        => new sfValidatorPass(array('required' => false)),
      'mas_info'           => new sfValidatorPass(array('required' => false)),
      'fecha'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_caducidad'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'imagen'             => new sfValidatorPass(array('required' => false)),
      'mas_imagen'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'documento'          => new sfValidatorPass(array('required' => false)),
      'organizador'        => new sfValidatorPass(array('required' => false)),
      'estado'             => new sfValidatorChoice(array('required' => false, 'choices' => array('guardado' => 'guardado', 'pendiente' => 'pendiente', 'publicado' => 'publicado'))),
      'ambito'             => new sfValidatorChoice(array('required' => false, 'choices' => array('intranet' => 'intranet', 'web' => 'web', 'ambos' => 'ambos'))),
      'owner_id'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id_creador'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id_modificado' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id_publicado'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha_publicado'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'usuarios_list'      => new sfValidatorDoctrineChoiceMany(array('model' => 'Usuario', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('evento_filters[%s]');

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

    $query->leftJoin('r.UsuarioEvento UsuarioEvento')
          ->andWhereIn('UsuarioEvento.usuario_id', $values);
  }

  public function getModelName()
  {
    return 'Evento';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'titulo'             => 'Text',
      'descripcion'        => 'Text',
      'mas_info'           => 'Text',
      'fecha'              => 'Date',
      'fecha_caducidad'    => 'Date',
      'imagen'             => 'Text',
      'mas_imagen'         => 'Boolean',
      'documento'          => 'Text',
      'organizador'        => 'Text',
      'estado'             => 'Enum',
      'ambito'             => 'Enum',
      'owner_id'           => 'Number',
      'user_id_creador'    => 'Number',
      'user_id_modificado' => 'Number',
      'user_id_publicado'  => 'Number',
      'fecha_publicado'    => 'Date',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'deleted'            => 'Boolean',
      'usuarios_list'      => 'ManyKey',
    );
  }
}