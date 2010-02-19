<?php

/**
 * CategoriaDG form.
 *
 * @package    form
 * @subpackage CategoriaDG
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CategoriaDGForm extends BaseCategoriaDGForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'nombre'     => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'CategoriaDG', 'column' => 'id', 'required' => false)),
      'nombre'     => new sfValidatorString(array('required' => true),array('required' => 'Ingrese el Titulo')),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted'    => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('categoria_dg[%s]');
  }
  	
}