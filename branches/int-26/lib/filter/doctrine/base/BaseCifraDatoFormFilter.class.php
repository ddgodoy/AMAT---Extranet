<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * CifraDato filter form base class.
 *
 * @package    filters
 * @subpackage CifraDato *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseCifraDatoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'titulo'             => new sfWidgetFormFilterInput(),
      'autor'              => new sfWidgetFormFilterInput(),
      'contenido'          => new sfWidgetFormFilterInput(),
      'imagen'             => new sfWidgetFormFilterInput(),
      'documento'          => new sfWidgetFormFilterInput(),
      'link'               => new sfWidgetFormFilterInput(),
      'fecha'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'fecha_publicacion'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'ambito'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'))),
      'estado'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'pendiente' => 'pendiente', 'publicado' => 'publicado'))),
      'destacada'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'mutua_id'           => new sfWidgetFormDoctrineChoice(array('model' => 'Mutua', 'add_empty' => true)),
      'owner_id'           => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'seccion_id'         => new sfWidgetFormDoctrineChoice(array('model' => 'CifraDatoSeccion', 'add_empty' => true)),
      'user_id_creador'    => new sfWidgetFormFilterInput(),
      'user_id_modificado' => new sfWidgetFormFilterInput(),
      'user_id_publicado'  => new sfWidgetFormFilterInput(),
      'fecha_publicado'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'titulo'             => new sfValidatorPass(array('required' => false)),
      'autor'              => new sfValidatorPass(array('required' => false)),
      'contenido'          => new sfValidatorPass(array('required' => false)),
      'imagen'             => new sfValidatorPass(array('required' => false)),
      'documento'          => new sfValidatorPass(array('required' => false)),
      'link'               => new sfValidatorPass(array('required' => false)),
      'fecha'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_publicacion'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'ambito'             => new sfValidatorChoice(array('required' => false, 'choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'))),
      'estado'             => new sfValidatorChoice(array('required' => false, 'choices' => array('pendiente' => 'pendiente', 'publicado' => 'publicado'))),
      'destacada'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'mutua_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Mutua', 'column' => 'id')),
      'owner_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Usuario', 'column' => 'id')),
      'seccion_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CifraDatoSeccion', 'column' => 'id')),
      'user_id_creador'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id_modificado' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id_publicado'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha_publicado'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('cifra_dato_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CifraDato';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'titulo'             => 'Text',
      'autor'              => 'Text',
      'contenido'          => 'Text',
      'imagen'             => 'Text',
      'documento'          => 'Text',
      'link'               => 'Text',
      'fecha'              => 'Date',
      'fecha_publicacion'  => 'Date',
      'ambito'             => 'Enum',
      'estado'             => 'Enum',
      'destacada'          => 'Boolean',
      'mutua_id'           => 'ForeignKey',
      'owner_id'           => 'ForeignKey',
      'seccion_id'         => 'ForeignKey',
      'user_id_creador'    => 'Number',
      'user_id_modificado' => 'Number',
      'user_id_publicado'  => 'Number',
      'fecha_publicado'    => 'Date',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'deleted'            => 'Boolean',
    );
  }
}