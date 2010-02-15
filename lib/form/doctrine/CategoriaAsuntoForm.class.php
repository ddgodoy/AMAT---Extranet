<?php
/**
 * CategoriaAsunto form.
 *
 * @package    form
 * @subpackage CategoriaAsunto
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CategoriaAsuntoForm extends BaseCategoriaAsuntoForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'nombre'     => new sfWidgetFormInput(array('label'=>'Tema *'), array('style'=>'width:330px;','class'=>'form_input')),
      'email_1'    => new sfWidgetFormInput(array('label'=>'Email *'), array('style'=>'width:330px;','class'=>'form_input')),
      'activo_1'   => new sfWidgetFormInputCheckbox(array(),array('onclick'=>'desmarcar1()','value'=>1)),
      'email_2'    => new sfWidgetFormInput(array('label'=>'Email *'), array('style'=>'width:330px;','class'=>'form_input')),
      'activo_2'   => new sfWidgetFormInputCheckbox(array(),array('onclick'=>'desmarcar2()','value'=>1)),    ));

    $this->setValidators(array(
      'nombre'     => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required'=>'El Tema es obligatorio')),
      'email_1'    => new sfValidatorEmail(array('required' => false)),
      'activo_1'   => new sfValidatorInteger(array('required' => false)),
      'email_2'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'activo_2'   => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('categoria_asunto[%s]');
  }
}