<?php
/**
 * Noticia form.
 *
 * @package    form
 * @subpackage Noticia
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class NoticiaForm extends BaseNoticiaForm
{
	public function configure()
	{   
		sfLoader::loadHelpers('Security');
		
		$img_valids = array('image/jpeg','image/pjpeg','image/gif','image/png');
		$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'titulo'            => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'autor'             => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'entradilla'        => new sfWidgetFormTextarea(array(), array('style' => 'width:755px;', 'rows' => 5, 'onfocus' => "this.style.background='#D5F7FF'", 'onblur' => "this.style.background='#E1F3F7'")),
			'contenido'         => new fckFormWidget(),
			'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'ambito'            => new sfWidgetFormChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'))),
			'destacada'         => new sfWidgetFormInputCheckbox(),
			'novedad'           => new sfWidgetFormInputCheckbox(),
			'mas_imagen'        => new sfWidgetFormInputCheckbox(),
			'mutua_id'          => new sfWidgetFormInputHidden(),
			'owner_id'          => new sfWidgetFormInputHidden(),
			'estado'            => new sfWidgetFormInputHidden(),
		));
		
		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'Noticia', 'column' => 'id', 'required' => false)),
			'titulo'            => new sfValidatorString(array('required' => true), array('required' => 'El título es obligatorio')),
			'autor'             => new sfValidatorString(array('max_length' => 100, 'required' => false), array('required' => 'El autor es obligatorio')),
			'entradilla'        => new sfValidatorString(array('required' => false), array('required' => 'La entradilla es obligatoria')),
			'contenido'         => new sfValidatorString(array('required' => false)),
			'fecha'             => new sfValidatorDate(array('required' => true), array('required' => 'La fecha es obligatoria', 'invalid' => 'La fecha ingresada es incorrecta')),
			'ambito'            => new sfValidatorChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'), 'required' => false)),
			'destacada'         => new sfValidatorBoolean(array('required' => false)),
			'novedad'           => new sfValidatorBoolean(array('required' => false)),
			'mas_imagen'        => new sfValidatorBoolean(array('required' => false)),
			'mutua_id'          => new sfValidatorDoctrineChoice(array('model' => 'Mutua', 'required' => true)),
			'owner_id'          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
			'estado'            => new sfValidatorString(),
		));
		
		
		if(validate_action('publicar'))
		{
			$this->setWidget('fecha_publicacion', new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')));
			$this->setValidator('fecha_publicacion',new sfValidatorDate(array('required' => true), array('required' => 'Debes seleccionar una fecha de publicación', 'invalid' => 'La fecha de publicación ingresada es incorrecta')));			
			$this->setWidget('fecha_caducidad', new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')));
			$this->setValidator('fecha_caducidad',new sfValidatorDate(array('required' => true), array('required' => 'Debes seleccionar una fecha de caducidad', 'invalid' => 'La fecha de caducidad ingresada es incorrecta')));			
		}
		else 
		{
			$this->setWidget('fecha_publicacion', new sfWidgetFormInputHidden());
			$this->setValidator('fecha_publicacion',new sfValidatorDate(array('required' => true), array('required' => 'Debes seleccionar una fecha de publicación', 'invalid' => 'La fecha de publicación ingresada es incorrecta')));			
			$this->setWidget('fecha_caducidad', new sfWidgetFormInputHidden());
			$this->setValidator('fecha_caducidad',new sfValidatorDate(array('required' => false), array('required' => 'Debes seleccionar una fecha de caducidad', 'invalid' => 'La fecha de caducidad ingresada es incorrecta')));			
		}
		
		if($this->getObject()->getImagen())
		{
			$this->setWidget('imagen',new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/noticias/images/'.'s_'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  => '<div>%file%<br /><label></label>%input%<br /><label></label>%delete%<label> Eliminar imagen actual</label></div>', ), array('class' => 'form_input')));
			$this->setValidator('imagen',new sfValidatorFile(array( 'path' => 'uploads/noticias/images', 'required' => false, 'validated_file_class' => 'sfResizedFile', )));
			$this->setValidator('imagen_delete',new sfValidatorBoolean());	
		}
		else 
		{
		$this->setWidget('imagen',new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/noticias/images/'.'s_'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  => '<div><label></label>%input%<br /><label></label></div>', ), array('class' => 'form_input')));
		$this->setValidator('imagen',new sfValidatorFile(array( 'path' => 'uploads/noticias/images', 'required' => false, 'validated_file_class' => 'sfResizedFile', )));
		}
		
		if($this->getObject()->getDocumento())
		{
			$this->setWidget('documento', new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/noticias/docs', 'template'  => '<div><label></label>%input%<br /><label></label>%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')));
			$this->setValidator('documento', new sfValidatorFile(array('path' => 'uploads/noticias/docs', 'required' => false)));
		    $this->setValidator('documento_delete', new sfValidatorBoolean());
		}
		else 
		{
			
		$this->setWidget('documento', new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/noticias/docs', 'template'  => '<div><label></label>%input%<br /><label></label></div>', ), array('class' => 'form_input')));
		$this->setValidator('documento', new sfValidatorFile(array('path' => 'uploads/noticias/docs', 'required' => false)));

		}
		
		
		$this->setDefaults(array(
			'owner_id'          => sfContext::getInstance()->getUser()->getAttribute('userId'),
			'mutua_id'          => sfContext::getInstance()->getUser()->getAttribute('mutuaId'),
			'estado'            => 'pendiente',
			'mas_imagen'        => 1,
			'fecha_publicacion' => '2007/01/01',
			'fecha_caducidad'   => '2015/12/31',
			
		));
		
		$this->widgetSchema->setNameFormat('noticia[%s]');
	}
}