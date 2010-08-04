<?php

/**
 * DocumentacionGrupo form.
 *
 * @package    form
 * @subpackage DocumentacionGrupo
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class DocumentacionGrupoForm extends BaseDocumentacionGrupoForm
{
  public function configure()
  {
		$requets = sfContext::getInstance(); 
		$userId  = $requets->getUser()->getAttribute('userId');
		$GerupoDeTrabajoSelect = $requets->getUser()->getAttribute('documentacion_grupos_nowgrupo');

		$GruposUsuario = GrupoTrabajo::ArrayDeMigrupo($userId, 1);
		$CategodiaGruposUsuario = CategoriaDG::ArrayDECategorias();

		$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'nombre'            => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'grupo_trabajo_id'  => new sfWidgetFormChoice(array('choices' => array('0'=>'--seleccionar--')+$GruposUsuario), array('class' => 'form_input', 'style' => 'width: 200px;')),
			'categoria_d_g_id'  => new sfWidgetFormChoice(array('choices' => $CategodiaGruposUsuario), array('class' => 'form_input', 'style' => 'width: 200px;')),
			'contenido'         => new fckFormWidget(),			
			'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_publicacion' => new sfWidgetFormInputHidden(),
                        'fecha_desde'        => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
                        'fecha_hasta'        => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
                        'confidencial'       => new sfWidgetFormChoice(array('expanded' => true,'choices' => array(1 => 'Confidencial', 0 => 'No confidencial')),array('style' => 'list-style-type: none;')),
			'owner_id'          => new sfWidgetFormInputHidden(),
			'estado'            => new sfWidgetFormInputHidden(),
		));

		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'DocumentacionGrupo', 'column' => 'id', 'required' => false)),
			'nombre'            => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required' => 'El título es obligatorio')),
			'grupo_trabajo_id'  => new sfValidatorChoice(array('choices' => array_keys($GruposUsuario),'required' => true), array('required' => 'El Grupo de Trabajo es obligatorio', 'invalid'=>'Debe seleccionar un Grupo de Trabajo')),
			'categoria_d_g_id'  => new sfValidatorChoice(array('choices' => array_keys($CategodiaGruposUsuario),'required' => true),array('required' => 'La categoría es obligatorio')),
			'contenido'         => new sfValidatorString(array('required' => false)),						
			'fecha'             => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_publicacion' => new sfValidatorDate(array('required' => false ), array('invalid' => 'La fecha de publicacion es incorrecta')),
                        'fecha_desde'        => new sfValidatorDate(array('required' => false)),
                        'fecha_hasta'        => new sfValidatorDate(array('required' => false)),
                        'confidencial'       => new sfValidatorBoolean(),
			'owner_id'          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
			'estado'            => new sfValidatorString(),
		));


                if($requets->getRequest()->getParameter('documentacion_grupo[fecha_desde][day]') && $requets->getRequest()->getParameter('documentacion_grupo[fecha_hasta][day]') ){
                    $this->validatorSchema->setPostValidator(
                      new sfValidatorSchemaCompare('fecha_desde', sfValidatorSchemaCompare::LESS_THAN_EQUAL, 'fecha_hasta',
                        array(),
                        array('invalid' => 'La fecha desde debe ser anterior a la fecha hasta')
                      )
                    );
                }
                




		$this->setDefaults(array(
			'owner_id'          => $userId,			
			'estado'            => 'pendiente',			
		));
		
		if ($GerupoDeTrabajoSelect) {
			$this->setDefault('grupo_trabajo_id',$GerupoDeTrabajoSelect);
		}
		$this->widgetSchema->setNameFormat('documentacion_grupo[%s]');
  }
}