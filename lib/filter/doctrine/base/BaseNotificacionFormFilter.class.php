<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Notificacion filter form base class.
 *
 * @package    filters
 * @subpackage Notificacion *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseNotificacionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'estado'                    => new sfWidgetFormChoice(array('choices' => array('' => '', 'leido' => 'leido', 'noleido' => 'noleido'))),
      'url'                       => new sfWidgetFormFilterInput(),
      'nombre'                    => new sfWidgetFormFilterInput(),
      'contenido_notificacion_id' => new sfWidgetFormDoctrineChoice(array('model' => 'ContenidoNotificacion', 'add_empty' => true)),
      'usuario_id'                => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'entidad_id'                => new sfWidgetFormFilterInput(),
      'tipo'                      => new sfWidgetFormFilterInput(),
      'visto'                     => new sfWidgetFormFilterInput(),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'estado'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('leido' => 'leido', 'noleido' => 'noleido'))),
      'url'                       => new sfValidatorPass(array('required' => false)),
      'nombre'                    => new sfValidatorPass(array('required' => false)),
      'contenido_notificacion_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'ContenidoNotificacion', 'column' => 'id')),
      'usuario_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Usuario', 'column' => 'id')),
      'entidad_id'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tipo'                      => new sfValidatorPass(array('required' => false)),
      'visto'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('notificacion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Notificacion';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'estado'                    => 'Enum',
      'url'                       => 'Text',
      'nombre'                    => 'Text',
      'contenido_notificacion_id' => 'ForeignKey',
      'usuario_id'                => 'ForeignKey',
      'entidad_id'                => 'Number',
      'tipo'                      => 'Text',
      'visto'                     => 'Number',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
      'deleted'                   => 'Boolean',
    );
  }
}