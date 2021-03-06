<?php

/**
 * EnvioComunicado form.
 *
 * @package    form
 * @subpackage EnvioComunicado
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class EnvioComunicadoForm extends BaseEnvioComunicadoForm
{
  public function configure()
  {
        sfLoader::loadHelpers('Object');
  	$idGrupoTrabajo = 0;
	## Obtengo todos los usuarios del grupo de trabajo

	$listasActivas= Doctrine::getTable('ListaComunicado')->getListasActivas();
	
	$arrListas = array();
	foreach ($listasActivas as $r) {
		$arrListas[$r->getId()] = $r->getNombre();
	}

        $tipo = TipoComunicadoTable::AllTiposComunicados();
	
	$comunicadosNoEnviados = Doctrine::getTable('Comunicado')->getNoEnviados();
	
	$arrComunicados = array();
	$arrComunicados[0] = "-- Seleccionar --";
	foreach ($comunicadosNoEnviados as $r) {
		$arrComunicados[$r->getId()] = $r->getNombre();
	}
  	
  	$this->setWidgets(array(
          'id'            		=> new sfWidgetFormInputHidden(),
          'comunicado_id'       	=> new sfWidgetFormChoice(array('choices' => $arrComunicados)),
          'tipo_comunicado_id' 		=> new sfWidgetFormChoice(array('choices' =>array('0'=>'-- Seleccionar --')+_get_options_from_objects($tipo)), array('class' => 'form_input', 'style' => 'width: 200px;')),
          'lista_comunicados_list' 	=> new sfWidgetFormSelectDoubleList(array('choices' => $arrListas, 'label_associated' => 'Seleccionados', 'label_unassociated' => 'Opciones')	)
        ));

    $this->setValidators(array(
          'id'                          => new sfValidatorDoctrineChoice(array('model' => 'EnvioComunicado', 'column' => 'id', 'required' => false)),
          'comunicado_id'       	=> new sfValidatorDoctrineChoice(array('model' => 'Comunicado', 'required' => true), array('required' => 'Debe seleccionar un comunicado', 'invalid' => 'Comunicado - Acción inválida')),
          'tipo_comunicado_id'  	=> new sfValidatorDoctrineChoice(array('model' => 'TipoComunicado', 'required' => true), array('required' => 'Debe seleccionar un tipo de comunicado', 'invalid' => 'Tipo de Comunicado - Acción inválida')),
          'lista_comunicados_list' 	=> new sfValidatorDoctrineChoiceMany(array('model' => 'ListaComunicado', 'required' => true), array('required' => 'Debe seleccionar una lista', 'invalid' => 'Acción inválida')),
        ));
    
    $this->widgetSchema->setLabels(array(
			'comunicado_id'     		=> 'Comunicado',
			'tipo_comunicado_id'		=> 'Tipo Comunicado',
			'lista_comunicados_list' 	=> 'Listas de envio',
		));

    $this->widgetSchema->setNameFormat('envio_comunicado[%s]');
  }
}