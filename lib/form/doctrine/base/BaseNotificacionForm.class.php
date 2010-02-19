<?php

/**
 * Notificacion form base class.
 *
 * @package    form
 * @subpackage notificacion
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseNotificacionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'estado'                    => new sfWidgetFormChoice(array('choices' => array('leido' => 'leido', 'noleido' => 'noleido'))),
      'url'                       => new sfWidgetFormInput(),
      'nombre'                    => new sfWidgetFormTextarea(),
      'contenido_notificacion_id' => new sfWidgetFormDoctrineChoice(array('model' => 'ContenidoNotificacion', 'add_empty' => true)),
      'usuario_id'                => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'entidad_id'                => new sfWidgetFormInput(),
      'visto'                     => new sfWidgetFormInput(),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
      'deleted'                   => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorDoctrineChoice(array('model' => 'Notificacion', 'column' => 'id', 'required' => false)),
      'estado'                    => new sfValidatorChoice(array('choices' => array('leido' => 'leido', 'noleido' => 'noleido'), 'required' => false)),
      'url'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'nombre'                    => new sfValidatorString(array('required' => false)),
      'contenido_notificacion_id' => new sfValidatorDoctrineChoice(array('model' => 'ContenidoNotificacion', 'required' => false)),
      'usuario_id'                => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => false)),
      'entidad_id'                => new sfValidatorInteger(array('required' => false)),
      'visto'                     => new sfValidatorInteger(array('required' => false)),
      'created_at'                => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                => new sfValidatorDateTime(array('required' => false)),
      'deleted'                   => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('notificacion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Notificacion';
  }

}
