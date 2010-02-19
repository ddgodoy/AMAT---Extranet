<?php

/**
 * Evento form.
 *
 * @package    form
 * @subpackage Evento
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class EventoForm extends BaseEventoForm
{
	public function configure()
	{
		$img_valids = array('image/jpeg','image/pjpeg','image/gif','image/png');
		$request    = sfContext::getInstance()->getUser();    		
    $usurID     = $request->getAttribute('userId');	
    $nombreUser = $request->getAttribute('nombre');
    $apellidoUser = $request->getAttribute('apellido');
    $usuario = Doctrine::getTable('Usuario')->find($usurID);
		$arrUsuarios = $usuario->UsuariosdeMisGrupos();
		$arrUsuariosGrupo = array(); 
		$arrUsuariosGrupo[$usurID] = $apellidoUser.", ".$nombreUser; 

		foreach ($arrUsuarios AS $usuario) {
			$arrUsuariosGrupo [$usuario->getId()] = $usuario->getApellido().", ".$usuario->getNombre();
		}
		$userId = sfContext::getInstance()->getUser()->getAttribute('userId');

		$this->setWidgets(array(
			'id'              => new sfWidgetFormInputHidden(),
			'titulo'          => new sfWidgetFormInput(array(), array('class' => 'form_input', 'style' => 'width:280px;')),
			'organizador'     => new sfWidgetFormInput(array(), array('class' => 'form_input', 'style' => 'width:280px;')),
			'descripcion'     => new sfWidgetFormTextarea(array(), array('rows' => '5', 'style' => 'width:840px;')),
			'mas_info'        => new fckFormWidget(),
			'fecha'           => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
//			'fecha_caducidad' => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_caducidad' => new sfWidgetFormDate(),
      		'imagen'          => new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/eventos/images/s_'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  => '<div>%file%<br /><label></label>%input%<br /><label></label>%delete%<label> Eliminar imagen actual</label></div>', ), array('class' => 'form_input')),
			'documento'       => new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/eventos/docs','template'  => '<div><br /><label></label>%input%<br /><label></label>%delete%<label> Eliminar documento actual</label><br /></div>')),
			'ambito'          => new sfWidgetFormChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'ambos' => 'ambos')), array('class' => 'form_input', 'style' => 'width:400px;')),
			'estado'          => new sfWidgetFormInputHidden(),
			'owner_id'        => new sfWidgetFormInputHidden(),
			'usuarios_list'   => new sfWidgetFormSelectDoubleList(array('choices' => $arrUsuariosGrupo, 'label_associated' => 'Seleccionados', 'label_unassociated' => 'Opciones')	)
		));
		
		$this->setValidators(array(
			'id'              => new sfValidatorDoctrineChoice(array('model' => 'Evento', 'column' => 'id', 'required' => false)),
			'titulo'          => new sfValidatorString(array('required' => true), array('required' => 'El título es obligatorio')),
			'organizador'     => new sfValidatorString(array('max_length' => 255, 'required' => false), array('required' => 'El organizador es obligatorio')),
			'descripcion'     => new sfValidatorString(array('required' => false), array('required' => 'La descripción es obligatoria')),
			'mas_info'        => new sfValidatorString(array('required' => false)),
			'fecha'           => new sfValidatorDate(array('required' => true), array('required' => 'La fecha es obligatoria', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_caducidad' => new sfValidatorDate(array('required' => false)),
			'imagen'          => new sfValidatorFile(array('path' => 'uploads/eventos/images', 'required' =>false, 'validated_file_class' => 'sfResizedFile', 'mime_types'=> $img_valids),array('mime_types'=>'Formato de imagen incorrecto, permitidos (.jpg, .gif, .png )')),
			'imagen_delete'   => new sfValidatorBoolean(),
			'documento'       => new sfValidatorFile(array('path' =>'uploads/eventos/docs','required' => false, 'mime_types'=>array('application/msword', 'application/pdf')), array('mime_types'=>'Formato de documento incorrecto, permitidos (.doc, .pdf )')),
			'ambito'          => new sfValidatorChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'ambos' => 'ambos'), 'required' => false)),
			'estado'          => new sfValidatorChoice(array('choices' => array('guardado' => 'guardado', 'pendiente' => 'pendiente', 'publicado' => 'publicado'), 'required' => true)),
			'owner_id'        => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => false)),
			'usuarios_list'   => new sfValidatorDoctrineChoiceMany(array('model' => 'Usuario', 'required' => false), array('invalid' => 'Acción inválida')),
		));
		
		$defaultInfo = '<div class="noticias nuevodetalle" style="padding-top: 20px;">'.
									 '<img align="left" src="/uploads/image/noimage.jpg" alt="" style="margin-right: 10px; width: 124px; height: 138px;" nottit="" />'.
									 'Titulo<br /><p class="notentrada" style="font-weight: bold;">Entradilla</p>'.
									 '<p style="border-bottom: 1px dotted; margin: 10px 0px; color: rgb(204, 204, 204);">&nbsp;</p>'.
									 '<p>Desccripcion</p><div class="clear">&nbsp;</div></div>';

		$this->setDefaults(array( 'usuarios_list' => $userId,
		                          'owner_id' => $userId, 
		                          'mas_info' => $defaultInfo,));

		$this->widgetSchema->setNameFormat('evento[%s]');
	}
}