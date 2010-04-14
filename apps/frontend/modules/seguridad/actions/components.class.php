<?php

/**
 * seguridad components.
 *
 * @package    extranet
 * @subpackage seguridad
 * @author     Matias Gentiletti
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class seguridadComponents extends sfComponents
{
	public function executeVerificar(sfWebRequest $request)
	{
            $arraytablas = array('noticias'=>'Noticia', 'eventos'=>'Evento');
            if($this->id != '' && key_exists($this->module, $arraytablas))
              {
                $q = Doctrine_Query::create();
                $q->from($arraytablas[$this->module]);
                $q->where('id = '. $this->id );

                echo $q->getQuery();
                exit();

                $resultado = $q->fetchOne();

                if($resultado->getOwnerId() == $this->getUser()->getAttribute('userId') && $resultado->getEstado() == 'guardado')
                {
                    return true;
                }
                else
                {
                    $this->getController()->redirect('seguridad/restringuido');
                }
              }
              else
              {
		$credenciales_array = array();
		$aplicacion_rol = Doctrine::getTable('AplicacionAccion');

		$q = Doctrine_Query::create();
		$q->select('aa.accion AS accion');
		$q->from('AplicacionAccion aa');
		$q->leftJoin('aa.Aplicacion a');
		$q->where('a.nombre_modulo= \'' . $this->module . '\'');
		$q->addWhere('aa.accion_del_modulo = \'' . $this->action . '\'');
		
		$aplicaciones_accion = $q->fetchOne();
		
		if ($aplicaciones_accion) {
			$aplicacion_rol = Doctrine::getTable('AplicacionRol');

			$q = Doctrine_Query::create();
			$q->from('AplicacionRol ar');
			$q->leftJoin('ar.Rol r');
			$q->leftJoin('ar.Aplicacion a');
			$q->where('a.nombre_modulo= \'' . $this->module . '\'');
			$q->addWhere('ar.accion_' . $aplicaciones_accion->getAccion() . ' = 1');

			$aplicaciones_rol = $q->fetchArray();

			foreach ($aplicaciones_rol as $aplicacion_rol) {
				$credenciales_array[] = $aplicacion_rol['Rol']['codigo'];
			}
		}
		//excepciones
		$arrExcepciones = Doctrine::getTable('Aplicacion')->getExcepcionesSeguridad();
		$nowModuleAction = $this->module.'_'.$this->action;

		if ($this->getUser()->getAttribute('userId'))
		{
			if (!in_array($nowModuleAction, $arrExcepciones)) {
				if ((empty($credenciales_array) || !$this->getUser()->hasCredential($credenciales_array, false)) && $this->module != 'seguridad') {
					$this->getController()->redirect('seguridad/restringuido');
				}
			}
		} else {
		 	$this->getUser()->setFlash('error', 'Sesión caducada');
		 	$this->getController()->redirect('seguridad/Seguridad') ;
		}
            }
        }
}