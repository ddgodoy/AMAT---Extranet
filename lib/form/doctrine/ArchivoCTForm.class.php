<?php

/**
 * ArchivoCT form.
 *
 * @package    form
 * @subpackage ArchivoCT
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ArchivoCTForm extends BaseArchivoCTForm
{
  public function configure()
  {
  	    sfLoader::loadHelpers('Object');
  	    $userId = sfContext::getInstance()->getUser()->getAttribute('userId');
            $arrayGruposTrabajo = ConsejoTerritorial::ArrayDeMiconsejo($userId, 1);
  	    //$arrayGruposTrabajo = ArchivoCTTable::doSelectAllCategorias('ConsejoTerritorial');
  	    
  		$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'nombre'            => new sfWidgetFormInput(array(), array('style' => 'width: 430px;', 'class' => 'form_input')),			
			'contenido'         => new fckFormWidget(),			
			'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_caducidad'   => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'disponibilidad'    => new sfWidgetFormChoice(array('choices' => array('Solo Grupo' => 'solo grupo', 'Todos' => 'todos'))),
			'owner_id'          => new sfWidgetFormInputHidden(),
			'consejo_territorial_id'   => new sfWidgetFormChoice(array('choices' => (array('0'=>'-- seleccionar --') + $arrayGruposTrabajo))),
                        'documentacion_consejo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'DocumentacionConsejo', 'add_empty' => true)),
		));

		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'ArchivoCT', 'column' => 'id', 'required' => false), array('required' => 'id req', 'invalid' => 'id inval' )),
			'nombre'            => new sfValidatorString(array('required' => true), array('required' => 'El título es obligatorio')),
			'contenido'         => new sfValidatorString(array('required' => false)),
			'fecha'             => new sfValidatorDate(array('required' => true), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_caducidad'   => new sfValidatorDate(array('required' => true), array('required' => 'Debes seleccionar una fecha de caducidad', 'invalid' => 'La fecha de caducidad ingresada es incorrecta')),
			'disponibilidad'    => new sfValidatorChoice(array('choices' => array('Solo Grupo' => 'Solo Grupo', 'Todos' => 'Todos'), 'required' => true), array('required' => 'disp req', 'invalid' => 'disp inval' )),
			'owner_id'          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
			'consejo_territorial_id'   => new sfValidatorDoctrineChoice(array('model' => 'ConsejoTerritorial', 'required' => true),array('required'=>'El Consejo Territorial es obligatorio')),
                        'documentacion_consejo_id' => new sfValidatorDoctrineChoice(array('model' => 'DocumentacionConsejo', 'required' => true),array('required'=>'La documentacion es obligatoria')),
		));

		if($this->getObject()->getArchivo())
		{
			$this->setWidget('archivo', new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/archivos_c_t/docs', 'template'  => '<div><label></label>%input%<br /><label></label>%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')));
			$this->setValidator('archivo', new sfValidatorFile(array('path' => 'uploads/archivos_c_t/docs', 'required' => false)));
		    $this->setValidator('archivo_delete', new sfValidatorBoolean());
		}
		else 
		{
			
		$this->setWidget('archivo', new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/archivos_c_t/docs', 'template'  => '<div><label></label>%input%<br /><label></label></div>', ), array('class' => 'form_input')));
		$this->setValidator('archivo', new sfValidatorFile(array('path' => 'uploads/archivos_c_t/docs', 'required' => true),array('required'=>'El archivo es obligatorio')));

		}
		

		$this->setDefaults(array(
			'owner_id'          => $userId,					
		));
		$this->widgetSchema->setNameFormat('archivo_c_t[%s]');
  }
}