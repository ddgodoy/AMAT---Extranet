<?php

/**
 * ArchivoDO form.
 *
 * @package    form
 * @subpackage ArchivoDO
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ArchivoDOForm extends BaseArchivoDOForm
{
  public function configure()
  {
  	
  	   $dir_upload = sfConfig::get('sf_upload_dir')."/archivos_d_o/docs/";
  	   $userId = sfContext::getInstance()->getUser()->getAttribute('userId');
  	
  		$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'nombre'            => new sfWidgetFormInput(array(), array('style' => 'width: 430px;', 'class' => 'form_input')),			
			'contenido'         => new fckFormWidget(),			
			'archivo'           => new sfWidgetFormInputFileEditable(array('file_src' => $dir_upload, 'template'  => '<div><label></label>%input%<br /><label></label>%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')),
			'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_caducidad'   => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'disponibilidad'    => new sfWidgetFormChoice(array('choices' => array('organismo' => 'organismo', 'todos' => 'todos'))),
			'owner_id'          => new sfWidgetFormInputHidden(),
		));

		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'ArchivoDO', 'column' => 'id', 'required' => false), array('required' => 'id req', 'invalid' => 'id inval' )),
			'nombre'            => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required' => 'El título es obligatorio')),
			'contenido'         => new sfValidatorString(array('required' => false)),
			'archivo'           => new sfValidatorFile(array('path' => $dir_upload, 'required' => true), array('required' => 'arch req', 'invalid' => 'arch inval' )),
			'archivo_delete'    => new sfValidatorBoolean(),
			'fecha'             => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_caducidad'   => new sfValidatorDate(array('required' => false), array('required' => 'Debes seleccionar una fecha de caducidad', 'invalid' => 'La fecha de caducidad ingresada es incorrecta')),
			'disponibilidad'    => new sfValidatorChoice(array('choices' => array('organismo' => 'organismo', 'todos' => 'todos'), 'required' => true), array('required' => 'disp req', 'invalid' => 'disp inval' )),
			'owner_id'          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
		));

		$this->setDefaults(array(
			'owner_id'          => $userId,					
		));

		$this->widgetSchema->setNameFormat('archivo_d_o[%s]');
  }
}