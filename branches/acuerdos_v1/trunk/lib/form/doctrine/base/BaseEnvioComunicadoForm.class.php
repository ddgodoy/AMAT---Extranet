<?php

/**
 * EnvioComunicado form base class.
 *
 * @package    form
 * @subpackage envio_comunicado
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseEnvioComunicadoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'comunicado_id'          => new sfWidgetFormDoctrineChoice(array('model' => 'Comunicado', 'add_empty' => true)),
      'tipo_comunicado_id'     => new sfWidgetFormDoctrineChoice(array('model' => 'TipoComunicado', 'add_empty' => true)),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'deleted'                => new sfWidgetFormInputCheckbox(),
      'lista_comunicados_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'ListaComunicado')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorDoctrineChoice(array('model' => 'EnvioComunicado', 'column' => 'id', 'required' => false)),
      'comunicado_id'          => new sfValidatorDoctrineChoice(array('model' => 'Comunicado', 'required' => false)),
      'tipo_comunicado_id'     => new sfValidatorDoctrineChoice(array('model' => 'TipoComunicado', 'required' => false)),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'deleted'                => new sfValidatorBoolean(),
      'lista_comunicados_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'ListaComunicado', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('envio_comunicado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EnvioComunicado';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['lista_comunicados_list']))
    {
      $this->setDefault('lista_comunicados_list', $this->object->ListaComunicados->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveListaComunicadosList($con);
  }

  public function saveListaComunicadosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['lista_comunicados_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->ListaComunicados->getPrimaryKeys();
    $values = $this->getValue('lista_comunicados_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('ListaComunicados', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('ListaComunicados', array_values($link));
    }
  }

}
