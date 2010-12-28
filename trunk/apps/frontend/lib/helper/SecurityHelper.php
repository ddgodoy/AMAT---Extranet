<?php

/**
 * SecurityHelper.
 *
 * @package    Intranet
 * @subpackage helper
 * @author     Pablo Joel Peralta
 */
/*
	Parametros:
	$accion: acciones a consultar ('alta', 'baja', 'modificar', 'listar', 'publicar')
	$modulo: codigo del modulo | si no se pone nada toma el modulo actual
	return: true  ( accion válida )
	return: false ( accion inválida )
*/

function validate_action($action, $module = null, $id = null)
{
	$oInstance = sfContext::getInstance();
	$arraytablas = array('noticias'=>'Noticia', 'eventos'=>'Evento');

	if ($id != '' && key_exists($module, $arraytablas)) {
    $q = Doctrine_Query::create();
    $q->from($arraytablas[$module]);
    $q->where('id = '. $id );

    $resultado = $q->fetchOne();

    if ($resultado->getOwnerId() == $oInstance->getUser()->getAttribute('userId') && $resultado->getEstado() == 'guardado') {
			return true;
    }
	}
	$request = $oInstance->getRequest();

	if ($module == null) $module = $request->getParameter('module');

	$sfAction = $request->getParameter('action');
	$arrPermisos = $oInstance->getUser()->getAttribute('permisos');
	$arrExcepciones = Doctrine::getTable('Aplicacion')->getExcepcionesSeguridad();

	if (!empty($arrPermisos[$module][$action])) {
		return true;
	} else {
		if ($sfAction=='editar' && $action=='alta' && !empty($arrPermisos[$module]['modificar'])) {
			return true;
		}
		if (in_array($module.'_'.$sfAction, $arrExcepciones)) {
			return true;
		}
		return false;
	}
}

function validate_single_menu_element($val_list, $val_show, $link_destino)
{
	if ($val_list && $val_show) {
		return true;
	} elseif (($val_list || $val_show) && empty($link_destino)) {
		return true;
	} else {
		if ($val_list) {
			if (strpos($link_destino, '/index') !== false) { return true; }
		} else {
			if (strpos($link_destino, '/show') !== false) { return true; }
		}
	}
	return false;
}

function getArrayMenuElementsByConditions($aItems)
{
	$c = 0;
	$r = array();

	foreach ($aItems as $v_item) {
		$verList = validate_action('listar', $v_item['modulo']);
		$verShow = validate_action('publicar', $v_item['modulo']);

		if (validate_single_menu_element($verList, $verShow, $v_item['aplicacion'])) {
			$r[$c]['id']        = $v_item['id'];
			$r[$c]['nombre']    = $v_item['nombre'];
			$r[$c]['modulo']    = $v_item['modulo'];
			$r[$c]['url']       = $v_item['url'];
			$r[$c]['asambleas'] = $v_item['asambleas'];
			$r[$c]['aplicacion']= $v_item['aplicacion'];
			$r[$c]['hijos']     = $v_item['hijos'];

			$c++;
		}
	}
	return $r;
}