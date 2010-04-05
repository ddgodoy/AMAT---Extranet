<?php

/**
 * Evento form base class.
 *
 * @package    form
 * @subpackage evento
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseEventoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'titulo'             => new sfWidgetFormTextarea(),
      'descripcion'        => new sfWidgetFormTextarea(),
      'mas_info'           => new sfWidgetFormTextarea(),
      'fecha'              => new sfWidgetFormDate(),
      'fecha_caducidad'    => new sfWidgetFormDate(),
      'imagen'             => new sfWidgetFormInput(),
      'mas_imagen'         => new sfWidgetFormInputCheckbox(),
      'documento'          => new sfWidgetFormInput(),
      'organizador'        => new sfWidgetFormInput(),
      'estado'             => new sfWidgetFormChoice(array('choices' => array('guardado' => 'guardado', 'pendiente' => 'pendiente', 'publicado' => 'publicado'))),
      'ambito'             => new sfWidgetFormChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'ambos' => 'ambos'))),
      'owner_id'           => new sfWidgetFormInput(),
      'user_id_creador'    => new sfWidgetFormInput(),
      'user_id_modificado' => new sfWidgetFormInput(),
      'user_id_publicado'  => new sfWidgetFormInput(),
      'fecha_publicado'    => new sfWidgetFormDateTime(),
      'mutua_id'           => new sfWidgetFormDoctrineChoice(array('model' => 'Mutua', 'add_empty' => false)),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'deleted'            => new sfWidgetFormInputCheckbox(),
      'usuarios_list'      => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Usuario')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => 'Evento', 'column' => 'id', 'required' => false)),
      'titulo'             => new sfValidatorString(array('required' => false)),
      'descripcion'        => new sfValidatorString(array('required' => false)),
      'mas_info'           => new sfValidatorString(array('required' => false)),
      'fecha'              => new sfValidatorDate(array('required' => false)),
      'fecha_caducidad'    => new sfValidatorDate(array('required' => false)),
      'imagen'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mas_imagen'         => new sfValidatorBoolean(array('required' => false)),
      'documento'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'organizador'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'estado'             => new sfValidatorChoice(array('choices' => array('guardado' => 'guardado', 'pendiente' => 'pendiente', 'publicado' => 'publicado'), 'required' => false)),
      'ambito'             => new sfValidatorChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'ambos' => 'ambos'), 'required' => false)),
      'owner_id'           => new sfValidatorInteger(array('required' => false)),
      'user_id_creador'    => new sfValidatorInteger(array('required' => false)),
      'user_id_modificado' => new sfValidatorInteger(array('required' => false)),
      'user_id_publicado'  => new sfValidatorInteger(array('required' => false)),
      'fecha_publicado'    => new sfValidatorDateTime(array('required' => false)),
      'mutua_id'           => new sfValidatorDoctrineChoice(array('model' => 'Mutua')),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
      'deleted'            => new sfValidatorBoolean(),
      'usuarios_list'      => new sfValidatorDoctrineChoiceMany(array('model' => 'Usuario', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('evento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Evento';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['usuarios_list']))
    {
      $this->setDefault('usuarios_list', $this->object->Usuarios->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUsuariosList($con);
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

}
