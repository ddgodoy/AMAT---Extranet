<?php

/**
 * ContenidoNotificacion form base class.
 *
 * @package    form
 * @subpackage contenido_notificacion
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseContenidoNotificacionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'titulo'     => new sfWidgetFormTextarea(),
      'mensaje'    => new sfWidgetFormInput(),
      'accion'     => new sfWidgetFormChoice(array('choices' => array('creacion' => 'creacion', 'lectura' => 'lectura', 'modificacion' => 'modificacion', 'eliminacion' => 'eliminacion', 'invitacion' => 'invitacion'))),
      'entidad'    => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'ContenidoNotificacion', 'column' => 'id', 'required' => false)),
      'titulo'     => new sfValidatorString(array('required' => false)),
      'mensaje'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'accion'     => new sfValidatorChoice(array('choices' => array('creacion' => 'creacion', 'lectura' => 'lectura', 'modificacion' => 'modificacion', 'eliminacion' => 'eliminacion', 'invitacion' => 'invitacion'), 'required' => false)),
      'entidad'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted'    => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('contenido_notificacion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContenidoNotificacion';
  }

}
