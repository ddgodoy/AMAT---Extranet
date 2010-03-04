<?php

/**
 * ConsejoTerritorial form.
 *
 * @package    form
 * @subpackage ConsejoTerritorial
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ConsejoTerritorialForm extends BaseConsejoTerritorialForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'nombre'  => new sfWidgetFormInput(array('label'=>'Nombre *'),array('style'=>'width:400px;','class'=>'form_input')),
      'detalle' => new fckFormWidget(array('label'=>'Descripción *'),array('style'=>'width:400px;height:200px;','class'=>'form_input')),
    ));

    $this->setValidators(array(
      'nombre'  => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required'=>'El Nombre es obligatorio')),
      'detalle' => new sfValidatorString(array('required' => true), array('required' => 'La descripción es obligatoria')),
    ));
    
    

    $this->widgetSchema->setNameFormat('consejo_territorial[%s]');
  }
}