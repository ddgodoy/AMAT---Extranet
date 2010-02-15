<?php

/**
 * Comunicado form.
 *
 * @package    form
 * @subpackage Comunicado
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ComunicadoForm extends BaseComunicadoForm
{
  public function configure()
  {

  	$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'nombre'            => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),			
			'detalle'           => new fckFormWidget(),			
			'en_intranet'       => new sfWidgetFormInputCheckbox(),
			'enviado'           => new sfWidgetFormInputCheckbox(),
		));

		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'Comunicado', 'column' => 'id', 'required' => false)),
			'nombre'            => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required' => 'El título es obligatorio')),
			'detalle'           => new sfValidatorString(array('required' => true), array('required' => 'El contenido es obligatorio')),
			'en_intranet'       => new sfValidatorBoolean(array('required' => false)),
			'enviado'           => new sfValidatorBoolean(array('required' => false)),
			
		));

		$this->widgetSchema->setNameFormat('comunicado[%s]');
  
  }
}