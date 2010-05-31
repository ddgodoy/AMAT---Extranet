<?php

/**
 * Accion form base class.
 *
 * @package    form
 * @subpackage accion
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseAccionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'entidad_creadora'    => new sfWidgetFormChoice(array('choices' => array('Noticia' => 'Noticia', 'Evento' => 'Evento', 'Asamblea' => 'Asamblea'))),
      'entidad_creadora_id' => new sfWidgetFormInput(),
      'entidad'             => new sfWidgetFormChoice(array('choices' => array('Publico' => 'Publico', 'GrupoTrabajo' => 'GrupoTrabajo', 'ConsejoTerritorial' => 'ConsejoTerritorial', 'Organismo' => 'Organismo'))),
      'entidad_id'          => new sfWidgetFormInput(),
      'accion'              => new sfWidgetFormChoice(array('choices' => array('ver' => 'ver'))),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'deleted'             => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => 'Accion', 'column' => 'id', 'required' => false)),
      'entidad_creadora'    => new sfValidatorChoice(array('choices' => array('Noticia' => 'Noticia', 'Evento' => 'Evento', 'Asamblea' => 'Asamblea'), 'required' => false)),
      'entidad_creadora_id' => new sfValidatorInteger(array('required' => false)),
      'entidad'             => new sfValidatorChoice(array('choices' => array('Publico' => 'Publico', 'GrupoTrabajo' => 'GrupoTrabajo', 'ConsejoTerritorial' => 'ConsejoTerritorial', 'Organismo' => 'Organismo'), 'required' => false)),
      'entidad_id'          => new sfValidatorInteger(array('required' => false)),
      'accion'              => new sfValidatorChoice(array('choices' => array('ver' => 'ver'), 'required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
      'deleted'             => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('accion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Accion';
  }

}
