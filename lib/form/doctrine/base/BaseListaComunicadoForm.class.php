<?php

/**
 * ListaComunicado form base class.
 *
 * @package    form
 * @subpackage lista_comunicado
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseListaComunicadoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'nombre'                 => new sfWidgetFormInput(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'deleted'                => new sfWidgetFormInputCheckbox(),
      'usuarios_list'          => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Usuario')),
      'envios_comunicado_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'EnvioComunicado')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorDoctrineChoice(array('model' => 'ListaComunicado', 'column' => 'id', 'required' => false)),
      'nombre'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'deleted'                => new sfValidatorBoolean(),
      'usuarios_list'          => new sfValidatorDoctrineChoiceMany(array('model' => 'Usuario', 'required' => false)),
      'envios_comunicado_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'EnvioComunicado', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lista_comunicado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaComunicado';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['usuarios_list']))
    {
      $this->setDefault('usuarios_list', $this->object->Usuarios->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['envios_comunicado_list']))
    {
      $this->setDefault('envios_comunicado_list', $this->object->EnviosComunicado->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUsuariosList($con);
    $this->saveEnviosComunicadoList($con);
  }

  public function saveUsuariosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['usuarios_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Usuarios->getPrimaryKeys();
    $values = $this->getValue('usuarios_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Usuarios', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Usuarios', array_values($link));
    }
  }

  public function saveEnviosComunicadoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['envios_comunicado_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->EnviosComunicado->getPrimaryKeys();
    $values = $this->getValue('envios_comunicado_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('EnviosComunicado', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('EnviosComunicado', array_values($link));
    }
  }

}
