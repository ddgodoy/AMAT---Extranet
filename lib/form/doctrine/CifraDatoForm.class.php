<?php
/**
 * CifraDato form.
 *
 * @package    form
 * @subpackage CifraDato
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CifraDatoForm extends BaseCifraDatoForm
{
  public function configure()
  {
		$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'titulo'            => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'autor'             => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'seccion_id'        => new sfWidgetFormDoctrineChoice(array('model' => 'CifraDatoSeccion', 'add_empty' => false), array('class' => 'form_input', 'style' => 'width: 200px;')),
			'contenido'         => new fckFormWidget(),
			'imagen'            => new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/cifras_datos/images/'.'s_'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  => '<div>%file%<br /><label></label>%input%<br /><label></label>%delete%<label> Eliminar imagen actual</label></div>', ), array('class' => 'form_input')),
			'documento'         => new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/cifras_datos/docs', 'template'  => '<div><label></label>%input%<br /><label></label>%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')),
			'link'              => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_publicacion' => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'ambito'            => new sfWidgetFormChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'))),
			'destacada'         => new sfWidgetFormInputCheckbox(),
			'mutua_id'          => new sfWidgetFormInputHidden(),
			'owner_id'          => new sfWidgetFormInputHidden(),
			'estado'            => new sfWidgetFormInputHidden(),
		));

		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'CifraDato', 'column' => 'id', 'required' => false)),
			'titulo'            => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required' => 'El título es obligatorio')),
			'autor'             => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required' => 'El autor es obligatorio')),
			'seccion_id'        => new sfValidatorDoctrineChoice(array('model' => 'CifraDatoSeccion')),
			'contenido'         => new sfValidatorString(array('required' => false)),
			'imagen'            => new sfValidatorFile(array( 'path' => 'uploads/cifras_datos/images', 'required' => false, 'validated_file_class' => 'sfResizedFile', )),
			'imagen_delete'     => new sfValidatorBoolean(),
			'documento'         => new sfValidatorFile(array('path' => 'uploads/cifras_datos/docs', 'required' => false)),
			'documento_delete'  => new sfValidatorBoolean(),
			'link'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
			'fecha'             => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_publicacion' => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha de publicación', 'invalid' => 'La fecha de publicación ingresada es incorrecta')),
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
			'ambito'            => 'web',
			'contenido'         => '<div class="noticias nuevodetalle" style="padding-top: 20px;"><img align="left" src="/uploads/image/noimage.jpg" alt="" style="margin-right: 10px; width: 124px; height: 138px;" nottit="" />Titulo<br />
									<p class="notentrada" style="font-weight: bold;">Entradilla</p>
									<p style="border-bottom: 1px dotted; margin: 10px 0px; color: rgb(204, 204, 204);">&nbsp;</p>
									<p>Desccripcion</p>
									<div class="clear">&nbsp;</div>
									</div>'
		));

		$this->widgetSchema->setNameFormat('cifra_dato[%s]');
  }
}