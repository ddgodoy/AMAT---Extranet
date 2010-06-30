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
                $usuariosSelecionados = array();
  		$idGrupoTrabajo = 0;
  		## Obtengo todos los usuarios del grupo de trabajo

		$usuariosActivos= Usuario::getArrayUsuario();

                if($this->getObject()->getId())
                {
                    $usuariosSelecionados = Usuario::getArrayUsuarioLista($this->getObject()->getId());
                }
  	
                $this->setWidgets(array(
                  'id'            => new sfWidgetFormInputHidden(),
                  'nombre'        => new sfWidgetFormInput(),
                  'usuarios_list' => new sfWidgetFormSelectDoubleList(array('choices' => $usuariosActivos, 'label_associated' => 'Seleccionados', 'label_unassociated' => 'Opciones'))
                ));

                $this->setValidators(array(
                  'id'            => new sfValidatorDoctrineChoice(array('model' => 'ListaComunicado', 'column' => 'id', 'required' => false)),
                  'nombre'        => new sfValidatorString(array('required' => false)),
                  'usuarios_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'Usuario', 'required' => false), array('invalid' => 'Acción inválida')),

                ));

                $this->widgetSchema->setLabels(array(
                                    'nombre'       => 'Nombre',
                                    'usuarios_list'=> 'Usuarios',
                            ));

                $this->setDefault('usuarios_list', $usuariosSelecionados);

                $this->widgetSchema->setNameFormat('lista_comunicado[%s]');
  }
}