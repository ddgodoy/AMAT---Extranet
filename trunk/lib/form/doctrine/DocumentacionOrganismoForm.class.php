<?php

/**
 * DocumentacionOrganismo form.
 *
 * @package    form
 * @subpackage DocumentacionOrganismo
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class DocumentacionOrganismoForm extends BaseDocumentacionOrganismoForm
{
  public function configure()
  {
  		$userId = sfContext::getInstance()->getUser()->getAttribute('userId');
		
  		$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'nombre'            => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
		  'contenido'         => new fckFormWidget(),			
			'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_publicacion' => new sfWidgetFormInputHidden(),
			'owner_id'          => new sfWidgetFormInputHidden(),
			'estado'            => new sfWidgetFormInputHidden(),
		));

		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'DocumentacionOrganismo', 'column' => 'id', 'required' => false)),
			'nombre'            => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required' => 'El título es obligatorio')),
			'contenido'         => new sfValidatorString(array('required' => false)),						
			'fecha'             => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_publicacion' => new sfValidatorDate(array('required' => false ), array('invalid' => 'La fecha de publicacion es incorrecta')),						
			'owner_id'          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
			'estado'            => new sfValidatorString(),
		));

		$this->setDefaults(array(
			'owner_id'          => $userId,			
			'estado'            => 'pendiente',			
		));

		$this->widgetSchema->setNameFormat('documentacion_organismo[%s]');
  }
}