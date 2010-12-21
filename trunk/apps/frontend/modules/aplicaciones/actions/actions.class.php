<?php
/**
 * normativas actions.
 *
 * @package    extranet
 * @subpackage normativas
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class aplicacionesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		
  	$this->pager = new sfDoctrinePager('Aplicacion', 10);
	$this->pager->getQuery()->from('Aplicacion')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->aplicaciones_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $this->aplicacion = Doctrine::getTable('Aplicacion')->find($request->getParameter('id'));
    $this->forward404Unless($this->aplicacion);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new AplicacionesForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new AplicacionesForm();
    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($aplicacion = Doctrine::getTable('Aplicacion')->find($request->getParameter('id')), sprintf('Object normativa does not exist (%s).', $request->getParameter('id')));
    $this->form = new AplicacionesForm($aplicacion);
  }
  
  public function executeEditar_internal(sfWebRequest $request)
  {
  	$this->error = '';
  	$this->id = $this->getRequestParameter('id');
  	$this->paginaActual = $this->getRequestParameter('page', 1);

    $this->forward404Unless($this->aplicacion = Doctrine::getTable('Aplicacion')->find($this->id), sprintf('Object normativa does not exist (%s).', $this->id));
		$this->field_nombre = $this->aplicacion->getNombre();

    if ($request->getMethod() == 'POST') {
    	$this->field_nombre = trim($this->getRequestParameter('field_nombre'));

    	if (!empty($this->field_nombre)) {
    		$this->aplicacion->setNombre($this->field_nombre);
    		$this->aplicacion->save();

    		$this->redirect('aplicaciones/index');
    	} else {
    		$this->error = 'Ingrese el nombre';
    	}
    }
  }
  
  public function executeUsuarios(sfWebRequest $request)
  {
  	$this->id_aplicacion = $this->getRequestParameter('id');
  	$this->paginaActual  = $this->getRequestParameter('page', 1);
  	$this->aplicacion    = Doctrine::getTable('Aplicacion')->find($this->id_aplicacion);

  	$this->pager = Aplicacion::getRepository()->getUsuariosByAplicacion($this->id_aplicacion, $this->paginaActual, 15);
  	$this->usuarios_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($aplicacion = Doctrine::getTable('Aplicacion')->find($request->getParameter('id')), sprintf('Object normativa does not exist (%s).', $request->getParameter('id')));
    $this->form = new AplicacionesForm($aplicacion);

    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($aplicacion = Doctrine::getTable('Aplicacion')->find($request->getParameter('id')), sprintf('Object normativa does not exist (%s).', $request->getParameter('id')));

    ## not delete internal application
    if (!$aplicacion->getTitulo() && !$aplicacion->getDescripcion()) {
    	$this->redirect('aplicaciones/index');
    }
    $menu = Doctrine::getTable('Menu')->findOneByAplicacionId($aplicacion->getId());

    sfLoader::loadHelpers('Security'); // para usar el helper

		if (!validate_action('baja')) $this->redirect('seguridad/restringuido');

    if ($menu->count()> 0) {
      $menu->delete();
    }
    $aplicacion->delete();

    $this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
    $this->redirect('aplicaciones/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {      
    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid()) {
      $aplicacion = $form->save();
     
      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");

      $this->redirect('aplicaciones/index');
    }
  }

  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND nombre LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$parcial="";
			$this->cajaBsq = "";
		}		
//		return 'titulo != "" AND descripcion != ""  AND deleted = 0 '.$parcial;
		return 'deleted = 0 '.$parcial;
  }

  protected function setOrdenamiento()
  {
		$modulo = $this->getModuleName();

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
      $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
      $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
		} else {
      if ($this->getUser()->getAttribute($modulo.'_noworderBY')) {
         $this->orderBYSql = $this->getUser()->getAttribute($modulo.'_noworderBY');
         $ordenacion = explode(' ', $this->orderBYSql);
         $this->orderBy = $ordenacion[0];
         $this->sortType = $ordenacion[1];
      } else {
//        $this->orderBy = 'created_at';
//				$this->sortType = 'desc';
        $this->orderBy = 'titulo';
        $this->sortType = 'desc';
        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
      }
    }
		return $this->orderBYSql;
  }

} // end class