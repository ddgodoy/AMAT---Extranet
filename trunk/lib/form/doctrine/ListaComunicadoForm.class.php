<?php

/**
 * ListaComunicado form.
 *
 * @package    form
 * @subpackage ListaComunicado
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ListaComunicadoForm extends BaseListaComunicadoForm
{
  public function configure()
  {
  		$idGrupoTrabajo = 0;
  		## Obtengo todos los usuarios del grupo de trabajo

		$usuariosActivos= Doctrine::getTable('Usuario')->getUsuariosActivos();		
		
		$arrUsuarios = array();
		foreach ($usuariosActivos as $r) {
			$arrUsuarios[$r->getId()] = $r->getApellido().", ".$r->getNombre();
		}
  	
  	$this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'nombre'        => new sfWidgetFormInput(),
      'usuarios_list' => new sfWidgetFormSelectDoubleList(array('choices' => $arrUsuarios, 'label_associated' => 'Seleccionados', 'label_unassociated' => 'Opciones')	)
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorDoctrineChoice(array('model' => 'ListaComunicado', 'column' => 'id', 'required' => false)),
      'nombre'        => new sfValidatorString(array('required' => false)),
      'usuarios_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'Usuario', 'required' => false), array('invalid' => 'Acción inválida')),
      
    ));
    
    $this->widgetSchema->setLabels(array(
			'nombre'     				=> 'Nombre',
			'usuarios_list' 			=> 'Usuarios',
		));

    $this->widgetSchema->setNameFormat('lista_comunicado[%s]');
  }
}