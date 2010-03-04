<?php

/**
 * Aplicacion form base class.
 *
 * @package    form
 * @subpackage aplicacion
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class AplicacionesForm extends BaseAplicacionForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'nombre'         => new sfWidgetFormInput(),
      'nombre_entidad' => new sfWidgetFormInputHidden(),
      'nombre_modulo'  => new sfWidgetFormInputHidden(),
      'tipo'           => new sfWidgetFormInputHidden(),
      'titulo'         => new sfWidgetFormInput(),
      'descripcion'    => new fckFormWidget(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'deleted'        => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => 'Aplicacion', 'column' => 'id', 'required' => false)),
      'nombre'         => new sfValidatorString(array('max_length' => 150, 'required' => true), array('required' => 'Ingrese el nombre')),
      'nombre_entidad' => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'nombre_modulo'  => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'tipo'           => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'titulo'         => new sfValidatorString(array('max_length' => 150, 'required' => true), array('required' => 'Ingrese el Titulo')),
      'descripcion'    => new sfValidatorString(array('required' => true),array('required' => 'Ingrese la Descripcion')),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
      'deleted'        => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('aplicaciones[%s]');
    
    $this->setDefaults(array(     'nombre_entidad'=>'aplicacion',
		                          'nombre_modulo' => 'aplicaciones', 
		                          'tipo' => 'front',));

  }
}
