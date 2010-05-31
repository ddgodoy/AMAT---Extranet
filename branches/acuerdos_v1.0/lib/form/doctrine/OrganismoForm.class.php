<?php

/**
 * Organismo form.
 *
 * @package    form
 * @subpackage Organismo
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class OrganismoForm extends BaseOrganismoForm
{
  public function configure()
  {
  	    
  		sfLoader::loadHelpers('Object');  	
  		
  		$action =sfContext::getInstance()->getActionName();
  	
  	    $userId  = sfContext::getInstance()->getUser()->getAttribute('userId');
  	
  	    $gruposTrbajo = GrupoTrabajoTable::getGruposTrabajoByUsuario($userId);
  	
  		$idGrupoTrabajo = 0;
  		## Obtengo todos los usuarios del grupo de trabajo
  		if (!$this->getObject()->isNew()) {
	  		$request= sfContext::getInstance()->getRequest();		
			$organismo = Doctrine::getTable('Organismo')->find($request->getParameter('id'));
			$idGrupoTrabajo = $organismo->getGrupoTrabajoId();
  		}
		$usuariosGrupo = Doctrine::getTable('Usuario')->getUsuariosByGrupoTrabajo($idGrupoTrabajo);		
		
		$arrUsuariosGrupo = array();
		$rolREsponsable = array();
		foreach ($usuariosGrupo as $r) {
			
			$arrUsuariosGrupo[$r->getId()] = $r->getApellido().", ".$r->getNombre();
		}
		
		$this->setWidgets(array(
			'id'                          => new sfWidgetFormInputHidden(),			
			'nombre'                      => new sfWidgetFormInput(array(), array('class' => 'form_input', 'style' => 'width: 355px;')),
			'grupo_trabajo_id'            => new sfWidgetFormChoice(array('choices' => array('0'=>'--seleccionar--')+_get_options_from_objects($gruposTrbajo)), array('class' => 'form_input', 'style' => 'width: 200px;')),
			'categoria_organismo_id'      => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaOrganismo', 'add_empty' => false), array('class' => 'form_input', 'style' => 'width: 200px;')),
			'subcategoria_organismo_id'   => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'add_empty' => false), array('class' => 'form_input', 'style' => 'width: 200px;')),
			'usuarios_list'         	  => new sfWidgetFormSelectDoubleList(array('choices' => $arrUsuariosGrupo, 'label_associated' => 'Seleccionados', 'label_unassociated' => 'Opciones')	),
			'detalle'                     => new sfWidgetFormTextarea(array('label'=>'Detalle'),array('style' => 'width:755px;', 'rows' => 5, 'onfocus' => "this.style.background='#D5F7FF'", 'onblur' => "this.style.background='#E1F3F7'")),
		));
		
		$this->setValidators(array(
			'id'                          => new sfValidatorDoctrineChoice(array('model' => 'Organismo', 'column' => 'id', 'required' => false)),			
			'nombre'                      => new sfValidatorString(array('required' => true), array('required' => 'El nombre es obligatorio')),
			'grupo_trabajo_id'            => new sfValidatorDoctrineChoice(array('model' => 'GrupoTrabajo'),array('invalid'=>'El Grupo de Trabajo es obligatorio')),
			'categoria_organismo_id'      => new sfValidatorDoctrineChoice(array('model' => 'CategoriaOrganismo'),array('invalid'=>'La Categoria es obligatoria')),
			'subcategoria_organismo_id'   => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaOrganismo'),array('invalid'=>'La SubCategoria es obligatoria')),
			'usuarios_list'         	  => new sfValidatorDoctrineChoiceMany(array('model' => 'Usuario', 'required' => false), array('invalid' => 'Acción inválida')),
			'detalle'                     => new sfValidatorString(array('required' => false)),
		));
		
		$this->widgetSchema->setLabels(array(
			'nombre'     				=> 'Nombre',
			'grupo_trabajo_id'   		=> 'Grupo Trabajo',
			'categoria_organismo_id' 	=> 'Categoría',
			'subcategoria_organismo_id' => 'Subcategoría',
			'usuarios_list' 			=> 'Usuarios',
		));
		
		
		$this->widgetSchema->setNameFormat('organismo[%s]');
  }
}