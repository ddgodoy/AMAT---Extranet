<?php

/**
 * Publicacion form.
 *
 * @package    form
 * @subpackage Publicacion
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class PublicacionForm extends BasePublicacionForm
{
  public function configure()
  {
		$img_valids = array('image/jpeg','image/pjpeg','image/gif');
		$userId  = sfContext::getInstance()->getUser()->getAttribute('userId');
		$mutuaId = sfContext::getInstance()->getUser()->getAttribute('mutuaId');
		$mutuas = Mutua::getArrayMutuas(); 
		$estado  = 'pendiente';

		$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'titulo'            => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'autor'             => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'contenido'         => new fckFormWidget(),
			'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_publicacion' => new sfWidgetFormInputHidden(),
			'fecha_caducidad'   => new sfWidgetFormInputHidden(),
			'ambito'            => new sfWidgetFormChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'))),
			'mutua_id'          => new sfWidgetFormChoice(array('choices' => $mutuas), array('class' => 'form_input', 'style' => 'width: 200px;')),
			'destacada'         => new sfWidgetFormInputCheckbox(),
//			'mutua_id'          => new sfWidgetFormInputHidden(),
			'owner_id'          => new sfWidgetFormInputHidden(),
			'estado'            => new sfWidgetFormInputHidden(),
		));
		
		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'Publicacion', 'column' => 'id', 'required' => false)),
			'titulo'            => new sfValidatorString(array('required' => true), array('required' => 'El título es obligatorio')),
			'autor'             => new sfValidatorString(array('max_length' => 100, 'required' => false), array('required' => 'El autor es obligatorio')),
			'contenido'         => new sfValidatorString(array('required' => false)),
			'fecha'             => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_publicacion' => new sfValidatorDate(array('required' => true), array('required' => 'Debes seleccionar una fecha de publicación', 'invalid' => 'La fecha de publicación ingresada es incorrecta')),
			'fecha_caducidad'   => new sfValidatorDate(array('required' => true), array('required' => 'Debes seleccionar una fecha de caducidad', 'invalid' => 'La fecha de caducidad ingresada es incorrecta')),
			'ambito'            => new sfValidatorChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'), 'required' => false)),
			'destacada'         => new sfValidatorBoolean(array('required' => false)),
			'mutua_id'          => new sfValidatorDoctrineChoice(array('model' => 'Mutua', 'required' => true)),
			'owner_id'          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
			'estado'            => new sfValidatorString(),
		));		
		
		if($this->getObject()->getImagen())
		{
			$this->setWidget('imagen',new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/publicaciones/images/'.'s_'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  => '<div>%file%<br /><label></label>%input%<br /><label></label>%delete%<label> Eliminar imagen actual</label></div>', ), array('class' => 'form_input')));
//			$this->setValidator('imagen',new sfValidatorFile(array( 'path' => 'uploads/publicaciones/images', 'required' => false, 'validated_file_class' => 'sfResizedFile', )));
			$this->setValidator('imagen',new sfValidatorFile(array( 'path' => 'uploads/publicaciones/images', 'required' => false, 'validated_file_class' => 'sfResizedFile', 'mime_types'=> $img_valids),array('invalid' => 'Invalid file.','mime_types'=>'Formato de imagen incorrecto, permitidos (.jpg, .gif, .png )')));
			$this->setValidator('imagen_delete',new sfValidatorBoolean());	
		}
		else 
		{
		$this->setWidget('imagen',new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/publicaciones/images/'.'s_'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  => '<div><label></label>%input%<br /><label></label></div>', ), array('class' => 'form_input')));
//		$this->setValidator('imagen',new sfValidatorFile(array( 'path' => 'uploads/publicaciones/images', 'required' => false, 'validated_file_class' => 'sfResizedFile', )));
		$this->setValidator('imagen',new sfValidatorFile(array( 'path' => 'uploads/publicaciones/images', 'required' => false, 'validated_file_class' => 'sfResizedFile', 'mime_types'=> $img_valids),array('invalid' => 'Invalid file.' ,'mime_types'=>'Formato de imagen incorrecto, permitidos (.jpg, .gif, .png )')));
		}
		
		if($this->getObject()->getDocumento())
		{
			$this->setWidget('documento', new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/publicaciones/docs', 'template'  => '<div><label></label>%input%<br /><label></label>%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')));
			$this->setValidator('documento', new sfValidatorFile(array('path' => 'uploads/publicaciones/docs', 'required' => false)));
		    $this->setValidator('documento_delete', new sfValidatorBoolean());
		}
		else 
		{
			
		$this->setWidget('documento', new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/publicaciones/docs', 'template'  => '<div><label></label>%input%<br /><label></label></div>', ), array('class' => 'form_input')));
		$this->setValidator('documento', new sfValidatorFile(array('path' => 'uploads/publicaciones/docs', 'required' => false)));

		}
		
		
		
		
		
		$this->setDefaults(array(
			'owner_id'          => $userId,
			'mutua_id'          => sfContext::getInstance()->getUser()->getAttribute('mutuaId'),
//			'mutua_id'          => $mutuaId,
			'estado'            => $estado,
			'fecha_publicacion' => '2007-01-01',
			'fecha_caducidad'   => '2020-01-01',
			'ambito'            => 'web',
			));

		$this->widgetSchema->setNameFormat('publicacion[%s]');
  }
}