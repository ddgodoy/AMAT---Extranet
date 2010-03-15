<?php

/**
 * Rol form.
 *
 * @package    form
 * @subpackage Rol
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class RolForm extends BaseRolForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'nombre'        => new sfWidgetFormInput(array(), array('class' => 'form_input', 'style' => 'width:280px;')),
      'detalle'       => new sfWidgetFormTextarea(array(), array('rows' => '5', 'style' => 'width:280px;')),
      'codigo'        => new sfWidgetFormInput(array(), array('class' => 'form_input', 'style' => 'width:280px;')),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'deleted'       => new sfWidgetFormInputCheckbox(),
      'usuarios_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Usuario')),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorDoctrineChoice(array('model' => 'Rol', 'column' => 'id', 'required' => false)),
      'nombre'        => new sfValidatorString(array('required' => false)),
      'detalle'       => new sfValidatorString(array('required' => false)),
      'codigo'        => new sfValidatorString(array('max_length' => 32)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'updated_at'    => new sfValidatorDateTime(array('required' => false)),
      'deleted'       => new sfValidatorBoolean(),
      'usuarios_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'Usuario', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('rol[%s]');
  }
}