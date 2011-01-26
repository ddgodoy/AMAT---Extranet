<?php

/**
 * Usuario form base class.
 *
 * @package    form
 * @subpackage usuario
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseUsuarioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                          => new sfWidgetFormInputHidden(),
      'login'                       => new sfWidgetFormInput(),
      'crypted_password'            => new sfWidgetFormInput(),
      'salt'                        => new sfWidgetFormInput(),
      'nombre'                      => new sfWidgetFormInput(),
      'apellido'                    => new sfWidgetFormInput(),
      'email'                       => new sfWidgetFormInput(),
      'activo'                      => new sfWidgetFormInputCheckbox(),
      'telefono'                    => new sfWidgetFormInput(),
      'remember_token'              => new sfWidgetFormInput(),
      'remember_token_expires'      => new sfWidgetFormInput(),
      'mutua_id'                    => new sfWidgetFormDoctrineChoice(array('model' => 'Mutua', 'add_empty' => false)),
      'active_at'                   => new sfWidgetFormDateTime(),
      'created_at'                  => new sfWidgetFormDateTime(),
      'updated_at'                  => new sfWidgetFormDateTime(),
      'deleted'                     => new sfWidgetFormInputCheckbox(),
      'roles_list'                  => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Rol')),
      'grupos_trabajo_list'         => new sfWidgetFormDoctrineChoiceMany(array('model' => 'GrupoTrabajo')),
      'consejos_territoriales_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'ConsejoTerritorial')),
      'organismos_list'             => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Organismo')),
      'eventos_list'                => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Evento')),
      'aplicacion_externas_list'    => new sfWidgetFormDoctrineChoiceMany(array('model' => 'AplicacionExterna')),
    ));

    $this->setValidators(array(
      'id'                          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'column' => 'id', 'required' => false)),
      'login'                       => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'crypted_password'            => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'salt'                        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'nombre'                      => new sfValidatorString(array('max_length' => 150)),
      'apellido'                    => new sfValidatorString(array('max_length' => 150)),
      'email'                       => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'activo'                      => new sfValidatorBoolean(array('required' => false)),
      'telefono'                    => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'remember_token'              => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'remember_token_expires'      => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'mutua_id'                    => new sfValidatorDoctrineChoice(array('model' => 'Mutua')),
      'active_at'                   => new sfValidatorDateTime(array('required' => false)),
      'created_at'                  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                  => new sfValidatorDateTime(array('required' => false)),
      'deleted'                     => new sfValidatorBoolean(),
      'roles_list'                  => new sfValidatorDoctrineChoiceMany(array('model' => 'Rol', 'required' => false)),
      'grupos_trabajo_list'         => new sfValidatorDoctrineChoiceMany(array('model' => 'GrupoTrabajo', 'required' => false)),
      'consejos_territoriales_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'ConsejoTerritorial', 'required' => false)),
      'organismos_list'             => new sfValidatorDoctrineChoiceMany(array('model' => 'Organismo', 'required' => false)),
      'eventos_list'                => new sfValidatorDoctrineChoiceMany(array('model' => 'Evento', 'required' => false)),
      'aplicacion_externas_list'    => new sfValidatorDoctrineChoiceMany(array('model' => 'AplicacionExterna', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuario';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['roles_list']))
    {
      $this->setDefault('roles_list', $this->object->Roles->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['grupos_trabajo_list']))
    {
      $this->setDefault('grupos_trabajo_list', $this->object->GruposTrabajo->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['consejos_territoriales_list']))
    {
      $this->setDefault('consejos_territoriales_list', $this->object->ConsejosTerritoriales->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['organismos_list']))
    {
      $this->setDefault('organismos_list', $this->object->Organismos->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['eventos_list']))
    {
      $this->setDefault('eventos_list', $this->object->Eventos->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['aplicacion_externas_list']))
    {
      $this->setDefault('aplicacion_externas_list', $this->object->AplicacionExternas->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveRolesList($con);
    $this->saveGruposTrabajoList($con);
    $this->saveConsejosTerritorialesList($con);
    $this->saveOrganismosList($con);
    $this->saveEventosList($con);
    $this->saveAplicacionExternasList($con);
  }

  public function saveRolesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['roles_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Roles->getPrimaryKeys();
    $values = $this->getValue('roles_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Roles', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Roles', array_values($link));
    }
  }

  public function saveGruposTrabajoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['grupos_trabajo_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->GruposTrabajo->getPrimaryKeys();
    $values = $this->getValue('grupos_trabajo_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('GruposTrabajo', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('GruposTrabajo', array_values($link));
    }
  }

  public function saveConsejosTerritorialesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['consejos_territoriales_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->ConsejosTerritoriales->getPrimaryKeys();
    $values = $this->getValue('consejos_territoriales_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('ConsejosTerritoriales', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('ConsejosTerritoriales', array_values($link));
    }
  }

  public function saveOrganismosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['organismos_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Organismos->getPrimaryKeys();
    $values = $this->getValue('organismos_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Organismos', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Organismos', array_values($link));
    }
  }

  public function saveEventosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['eventos_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Eventos->getPrimaryKeys();
    $values = $this->getValue('eventos_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Eventos', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Eventos', array_values($link));
    }
  }

  public function saveAplicacionExternasList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['aplicacion_externas_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->AplicacionExternas->getPrimaryKeys();
    $values = $this->getValue('aplicacion_externas_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('AplicacionExternas', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('AplicacionExternas', array_values($link));
    }
  }

}
