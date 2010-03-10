<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Noticia filter form base class.
 *
 * @package    filters
 * @subpackage Noticia *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseNoticiaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'titulo'             => new sfWidgetFormFilterInput(),
      'autor'              => new sfWidgetFormFilterInput(),
      'entradilla'         => new sfWidgetFormFilterInput(),
      'contenido'          => new sfWidgetFormFilterInput(),
      'imagen'             => new sfWidgetFormFilterInput(),
      'documento'          => new sfWidgetFormFilterInput(),
      'fecha'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'fecha_publicacion'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'fecha_caducidad'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'ambito'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'))),
      'estado'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'guardado' => 'guardado', 'pendiente' => 'pendiente', 'publicado' => 'publicado'))),
      'destacada'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'novedad'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'mas_imagen'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'mutua_id'           => new sfWidgetFormDoctrineChoice(array('model' => 'Mutua', 'add_empty' => true)),
      'owner_id'           => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
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
      'entradilla'         => new sfValidatorPass(array('required' => false)),
      'contenido'          => new sfValidatorPass(array('required' => false)),
      'imagen'             => new sfValidatorPass(array('required' => false)),
      'documento'          => new sfValidatorPass(array('required' => false)),
      'fecha'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_publicacion'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_caducidad'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'ambito'             => new sfValidatorChoice(array('required' => false, 'choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'))),
      'estado'             => new sfValidatorChoice(array('required' => false, 'choices' => array('guardado' => 'guardado', 'pendiente' => 'pendiente', 'publicado' => 'publicado'))),
      'destacada'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'novedad'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'mas_imagen'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'mutua_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Mutua', 'column' => 'id')),
      'owner_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Usuario', 'column' => 'id')),
      'user_id_creador'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id_modificado' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id_publicado'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha_publicado'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('noticia_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Noticia';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'titulo'             => 'Text',
      'autor'              => 'Text',
      'entradilla'         => 'Text',
      'contenido'          => 'Text',
      'imagen'             => 'Text',
      'documento'          => 'Text',
      'fecha'              => 'Date',
      'fecha_publicacion'  => 'Date',
      'fecha_caducidad'    => 'Date',
      'ambito'             => 'Enum',
      'estado'             => 'Enum',
      'destacada'          => 'Boolean',
      'novedad'            => 'Boolean',
      'mas_imagen'         => 'Boolean',
      'mutua_id'           => 'ForeignKey',
      'owner_id'           => 'ForeignKey',
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