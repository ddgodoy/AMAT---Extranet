<?php

/**
 * Actividad form.
 *
 * @package    form
 * @subpackage Actividad
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ActividadForm extends BaseActividadForm
{
  public function configure()
  {
  	$userId  = sfContext::getInstance()->getUser()->getAttribute('userId');
		$mutuaId = sfContext::getInstance()->getUser()->getAttribute('mutuaId');
		$estado  = 'pendiente';
		
		$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'titulo'            => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
		//	'autor'             => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'autor'             => new sfWidgetFormInputHidden(),
			'contenido'         => new fckFormWidget(),
			'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
		//  'fecha_publicacion' => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
		    'fecha_publicacion' => new sfWidgetFormInputHidden(),
			'ambito'            => new sfWidgetFormChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'))),
			'destacada'         => new sfWidgetFormInputCheckbox(),
			'mutua_id'          => new sfWidgetFormInputHidden(),
			'owner_id'          => new sfWidgetFormInputHidden(),
			'estado'            => new sfWidgetFormInputHidden(),
		));
		
		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'Actividad', 'column' => 'id', 'required' => false)),
			'titulo'            => new sfValidatorString(array('required' => true), array('required' => 'El título es obligatorio')),
		//	'autor'             => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required' => 'El autor es obligatorio')),
			'autor'             => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required' => '')),
			'contenido'         => new sfValidatorString(array('required' => false)),
			'fecha'             => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
		//	'fecha_publicacion' => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha de publicación', 'invalid' => 'La fecha de publicación ingresada es incorrecta')),
		    'fecha_publicacion' => new sfValidatorDate(array(), array('required' => '', 'invalid' => '')),
			'ambito'            => new sfValidatorChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'), 'required' => false)),
			'destacada'         => new sfValidatorBoolean(array('required' => false)),
			'mutua_id'          => new sfValidatorDoctrineChoice(array('model' => 'Mutua', 'required' => true)),
			'owner_id'          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
			'estado'            => new sfValidatorString(),
		));
		
		
		if($this->getObject()->getImagen())
		{
			$this->setWidget('imagen',new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/actividades/images/'.'s_'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  => '<div>%file%<br /><label></label>%input%<br /><label></label>%delete%<label> Eliminar imagen actual</label></div>', ), array('class' => 'form_input')));
			$this->setValidator('imagen',new sfValidatorFile(array( 'path' => 'uploads/actividades/images', 'required' => false, 'validated_file_class' => 'sfResizedFile', )));
			$this->setValidator('imagen_delete',new sfValidatorBoolean());	
		}
		else 
		{
		$this->setWidget('imagen',new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/actividades/images/'.'s_'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  => '<div><label></label>%input%<br /><label></label></div>', ), array('class' => 'form_input')));
		$this->setValidator('imagen',new sfValidatorFile(array( 'path' => 'uploads/actividades/images', 'required' => false, 'validated_file_class' => 'sfResizedFile', )));
		}
		
		if($this->getObject()->getDocumento())
		{
			$this->setWidget('documento', new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/actividades/docs', 'template'  => '<div><label></label>%input%<br /><label></label>%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')));
			$this->setValidator('documento', new sfValidatorFile(array('path' => 'uploads/actividades/docs', 'required' => false)));
		    $this->setValidator('documento_delete', new sfValidatorBoolean());
		}
		else 
		{
			
		$this->setWidget('documento', new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/actividades/docs', 'template'  => '<div><label></label>%input%<br /><label></label></div>', ), array('class' => 'form_input')));
		$this->setValidator('documento', new sfValidatorFile(array('path' => 'uploads/actividades/docs', 'required' => false)));

		}
		
		
		$this->setDefaults(array(
			'owner_id'          => $userId,
			'mutua_id'          => $mutuaId,
			'estado'            => $estado,
			'autor'             => sfContext::getInstance()->getUser()->getAttribute('apellido').','.sfContext::getInstance()->getUser()->getAttribute('nombre'),
			'fecha_publicacion' => '2007/01/01',
			'ambito'            => 'web',
			'contenido'         => '<div class="noticias nuevodetalle" style="padding-top: 20px;"><img align="left" src="/uploads/image/noimage.jpg" alt="" style="margin-right: 10px; width: 124px; height: 138px;" nottit="" />Titulo<br />
									<p class="notentrada" style="font-weight: bold;">Entradilla</p>
									<p style="border-bottom: 1px dotted; margin: 10px 0px; color: rgb(204, 204, 204);">&nbsp;</p>
									<p>Desccripcion</p>
									<div class="clear">&nbsp;</div>
									</div>'
		));

		$this->widgetSchema->setNameFormat('actividad[%s]');
  }
}