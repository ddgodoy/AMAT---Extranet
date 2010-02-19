<?php

/**
 * Aplicacion form.
 *
 * @package    form
 * @subpackage Aplicacion
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class AplicacionForm extends BaseAplicacionForm
{
  public function configure()
  {
  		$userId = sfContext::getInstance()->getUser()->getAttribute('userId');
		$mutuaId = sfContext::getInstance()->getUser()->getAttribute('mutuaId');
		$estado = 'pendiente';
		
		//$userId = 1;
		//$mutuaId = 1;
		
		$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'titulo'            => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'autor'             => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'contenido'         => new fckFormWidget(),
			'imagen'            => new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/actividades/images/'.'s_'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  => '<div>%file%<br /><label></label>%input%<br /><label></label>%delete%<label> Eliminar imagen actual</label></div>', ), array('class' => 'form_input')),
			'documento'         => new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/actividades/docs', 'template'  => '<div><label></label>%input%<br /><label></label>%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')),
			'fecha'             => new sfWidgetFormDate(),
			'fecha_publicacion' => new sfWidgetFormDate(),
			'ambito'            => new sfWidgetFormChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'))),
			'destacada'         => new sfWidgetFormInputCheckbox(),
			'mutua_id'          => new sfWidgetFormInputHidden(),
			'owner_id'          => new sfWidgetFormInputHidden(),
			'estado'            => new sfWidgetFormInputHidden(),
		));
		
		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'Actividad', 'column' => 'id', 'required' => false)),
			'titulo'            => new sfValidatorString(array('required' => true), array('required' => 'El título es obligatorio')),
			'autor'             => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required' => 'El autor es obligatorio')),
			'contenido'         => new sfValidatorString(array('required' => false)),
			'imagen'            => new sfValidatorFile(array( 'path' => 'uploads/actividades/images', 'required' => false, 'validated_file_class' => 'sfResizedFile', )),
			'imagen_delete'     => new sfValidatorBoolean(),
			'documento'         => new sfValidatorFile(array('path' => 'uploads/actividades/docs', 'required' => false)),
			'documento_delete'  => new sfValidatorBoolean(),
			'fecha'             => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_publicacion' => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha de publicación', 'invalid' => 'La fecha de publicación ingresada es incorrecta')),
			'ambito'            => new sfValidatorChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'), 'required' => false)),
			'destacada'         => new sfValidatorBoolean(array('required' => false)),
			'mutua_id'          => new sfValidatorDoctrineChoice(array('model' => 'Mutua', 'required' => true)),
			'owner_id'          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
			'estado'            => new sfValidatorString(),
		));
		// 'imagen'            => new sfValidatorFile(array('path' => 'uploads/cifras_datos/images', 'required' => false, )),
		
		$this->setDefaults(array(
			'owner_id'          => $userId,
			'mutua_id'          => $mutuaId,
			'estado'            => $estado,
			'ambito'            => 'web',
		));
		
		
		
		$this->widgetSchema->setNameFormat('actividad[%s]');
  }
  
}