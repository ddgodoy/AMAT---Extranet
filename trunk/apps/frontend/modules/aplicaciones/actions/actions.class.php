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

  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo = $this->getModuleName();

		$this->cajaBsq = trim($this->getRequestParameter('caja_busqueda'));

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND nombre LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		} else {
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
		}
		if ($this->hasRequestParameter('btn_quitar')) {
			$parcial = '';
			$this->cajaBsq = '';
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
		}
  	$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);

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
        $this->orderBy = 'created_at';
				$this->sortType = 'desc';
        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
      }
    }
		return $this->orderBYSql;
  }

} // end class