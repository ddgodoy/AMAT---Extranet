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
		
		$img_valids = array('image/jpeg','image/pjpeg','image/gif','image/png');
		$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'titulo'            => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'autor'             => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'entradilla'        => new sfWidgetFormTextarea(array(), array('style' => 'width:755px;', 'rows' => 5, 'onfocus' => "this.style.background='#D5F7FF'", 'onblur' => "this.style.background='#E1F3F7'")),
			'contenido'         => new fckFormWidget(),
			'imagen'            => new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/noticias/images'), array('class' => 'form_input')),
			'documento'         => new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/noticias/docs')),
			'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_publicacion' => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_caducidad'   => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'ambito'            => new sfWidgetFormChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'))),
			'destacada'         => new sfWidgetFormInputCheckbox(),
			'mutua_id'          => new sfWidgetFormInputHidden(),
			'owner_id'          => new sfWidgetFormInputHidden(),
			'estado'            => new sfWidgetFormInputHidden(),
		));
		
		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'Noticia', 'column' => 'id', 'required' => false)),
			'titulo'            => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required' => 'El título es obligatorio')),
			'autor'             => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required' => 'El autor es obligatorio')),
			'entradilla'        => new sfValidatorString(array(), array('required' => 'La entradilla es obligatoria')),
			'contenido'         => new sfValidatorString(array('required' => false)),
			'imagen'            => new sfValidatorFile(array('path' => 'uploads/noticias/images', 'required' =>false, 'validated_file_class' => 'sfResizedFile', 'mime_types'=> $img_valids),array('mime_types'=>'Formato de imagen incorrecto, permitidos (.jpg, .gif, .png )')),
			'imagen_delete'     => new sfValidatorBoolean(),
			'documento'         => new sfValidatorFile(array('path' =>'uploads/noticias/docs','required' => false, 'mime_types'=>array('application/msword', 'application/pdf')), array('mime_types'=>'Formato de documento incorrecto, permitidos (.doc, .pdf )')),
			'fecha'             => new sfValidatorDate(array('required' => true), array('required' => 'La fecha es obligatoria', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_publicacion' => new sfValidatorDate(array('required' => true), array('required' => 'Debes seleccionar una fecha de publicación', 'invalid' => 'La fecha de publicación ingresada es incorrecta')),
			'fecha_caducidad'   => new sfValidatorDate(array('required' => true), array('required' => 'Debes seleccionar una fecha de caducidad', 'invalid' => 'La fecha de caducidad ingresada es incorrecta')),
			'ambito'            => new sfValidatorChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'), 'required' => false)),
			'destacada'         => new sfValidatorBoolean(array('required' => false)),
			'mutua_id'          => new sfValidatorDoctrineChoice(array('model' => 'Mutua', 'required' => true)),
			'owner_id'          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
			'estado'            => new sfValidatorString(),
		));
		
		$this->setDefaults(array(
			'owner_id'          => sfContext::getInstance()->getUser()->getAttribute('userId'),
			'mutua_id'          => sfContext::getInstance()->getUser()->getAttribute('mutuaId'),
			'estado'            => 'pendiente',
			'contenido'         => '<div class="noticias nuevodetalle" style="padding-top: 20px;"><img align="left" src="/uploads/image/noimage.jpg" alt="" style="margin-right: 10px; width: 124px; height: 138px;" nottit="" />Titulo<br />
									<p class="notentrada" style="font-weight: bold;">Entradilla</p>
									<p style="border-bottom: 1px dotted; margin: 10px 0px; color: rgb(204, 204, 204);">&nbsp;</p>
									<p>Desccripcion</p>
									<div class="clear">&nbsp;</div>
									</div>'
		));
		
		$this->widgetSchema->setNameFormat('noticia[%s]');
	}
}