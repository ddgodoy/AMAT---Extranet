<?php

/**
 * actividades actions.
 *
 * @package    extranet
 * @subpackage actividades
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class actividadesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->paginaActual = $this->getRequestParameter('page', 1);

	if (is_numeric($this->paginaActual)) {
		$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
	}
	$this->pager = new sfDoctrinePager('Actividad', 10);
	$this->pager->getQuery()->from('Actividad')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->actividad_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->actividad = Doctrine::getTable('Actividad')->find($request->getParameter('id'));
    $this->forward404Unless($this->actividad);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new ActividadForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new ActividadForm();

    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($actividad = Doctrine::getTable('Actividad')->find($request->getParameter('id')), sprintf('Object actividad does not exist (%s).', $request->getParameter('id')));
    $this->form = new ActividadForm($actividad);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($actividad = Doctrine::getTable('Actividad')->find($request->getParameter('id')), sprintf('Object actividad does not exist (%s).', $request->getParameter('id')));
    $this->form = new ActividadForm($actividad);

    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($actividad = Doctrine::getTable('Actividad')->find($request->getParameter('id')), sprintf('Object actividad does not exist (%s).', $request->getParameter('id')));
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');
    
    $actividad->delete();

    $this->redirect('actividades/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
	if ($form->isValid()) {
		
		## Files
		// Elimino si marca eliminar
		$dato=Doctrine::getTable('Actividad')->find($request->getParameter('id'));
		if ($form->getValue('imagen_delete') && $dato->getImagen()) {
	    	$dato->eliminarImagen();
	    }
		if ($form->getValue('documento_delete') && $dato->getDocumento()) {
	    	$dato->eliminarDocumento();
	    }		
		
		$cifra_dato = $form->save();

		$strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';
        $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");
		$this->redirect('actividades/index'.$strPaginaVolver);
	}
  }
    
   public function executePublicar(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		
		$clase = 'Actividad';
		$modulo = 'actividades';
		
		$this->forward404Unless($objeto = Doctrine::getTable($clase)->find($request->getParameter('id')), sprintf('Object '.$clase.' does not exist (%s).', $request->getParameter('id')));
		
		sfLoader::loadHelpers('Security'); // para usar el helper
		if (!validate_action('publicar')) $this->redirect('seguridad/restringuido');		
		
		$objeto->setEstado('publicado');
		$objeto->save();
		
		$this->getUser()->setFlash('notice', "El registro ha sido publicado correctamente");
		
		$this->redirect($modulo.'/show?id='.$objeto->getId());
	}
  
  /* Metodos para busqueda y ordenamiento */
  
  protected function setFiltroBusqueda()
  {sfLoader::loadHelpers('Date');

  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (titulo LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->desdeBsq)) {
			$parcial .= " AND fecha >= '".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowdesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND fecha <= '".format_date($this->hastaBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowhasta', $this->hastaBsq);
		}
		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
					$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowdesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowhasta');
			}
		} 
		
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			$parcial="";
			$this->cajaBsq = "";
			$this->desdeBsq = '';
			$this->hastaBsq = '';
		}
		
		return 'deleted=0'.$parcial;
  }
  
  protected function setOrdenamiento()
  {
		$this->orderBy = 'titulo';
		$this->sortType = 'asc';

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }
}
