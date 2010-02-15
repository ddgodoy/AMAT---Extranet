<?php

/**
 * SecurityHelper.
 *
 * @package    Intranet
 * @subpackage helper
 * @author     Pablo Joel Peralta
 */


/**
 * Parametros:
 * $accion: acciones a consultar ('alta', 'baja', 'modificar', 'listar', 'publicar')
 * $modulo: codigo del modulo, si no se pone nada, toma el modulo actual
 */

/**
 * return: true  ( accion válida )
 * return: false ( accion inválida )
 */

function validate_action($action, $module = null)
{
	$request  = sfContext::getInstance()->getRequest();
	if ($module == null) $module = $request->getParameter('module');
	$sfAction = $request->getParameter('action');

	$arrPermisos = sfContext::getInstance()->getUser()->getAttribute('permisos');
	$arrExcepciones = Doctrine::getTable('Aplicacion')->getExcepcionesSeguridad();
	
	if (!empty($arrPermisos[$module][$action]))
	{
		return true;
	}
	else
	{
		if ($sfAction=='editar' && $action=='alta' && !empty($arrPermisos[$module]['modificar']))
		{
			return true;
		}
		if (in_array($module.'_'.$sfAction, $arrExcepciones))
		{
			return true;
		}
		return false;
	}
}