<?php
/**
 * contenidos actions.
 *
 * @package    extranet
 * @subpackage contenidos
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class contenidosActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->viewE = false;
		$this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'), 1);

		if (Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles)) {
			$this->viewE = true;
		}
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
//
	protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo = $this->getModuleName();

		$this->cajaBsq = trim($this->getRequestParameter('caja_busqueda'));
		$this->selcBsq = trim($this->getRequestParameter('sel_estado'));

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%' OR titulo LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		} else {
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
		}
		if ($this->viewE) {
			if (!empty($this->selcBsq)) { $parcial .= " AND estado = '$this->selcBsq'"; }
		}
		if ($this->hasRequestParameter('btn_quitar')) {
			$parcial = '';
			$this->cajaBsq = '';
			$this->selcBsq = '';
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
		}
		$auxFlt = $this->viewE ? '' : "AND estado = 'publicado'";
  	$filter = " AND titulo IS NOT NULL $auxFlt $parcial";
  	$this->getUser()->setAttribute($modulo.'_nowfilter', $filter);

  	return 'deleted = 0 '.$filter;
  }
//
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
//
	public function executeNueva(sfWebRequest $request)
  {
    $this->form = new AplicacionesForm();
  }
//
	public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new AplicacionesForm();
    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }
//
	public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($aplicacion = Doctrine::getTable('Aplicacion')->find($request->getParameter('id')), sprintf('Object normativa does not exist (%s).', $request->getParameter('id')));
    $this->form = new AplicacionesForm($aplicacion);
  }
//
	public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($aplicacion = Doctrine::getTable('Aplicacion')->find($request->getParameter('id')), sprintf('Object normativa does not exist (%s).', $request->getParameter('id')));
    $this->form = new AplicacionesForm($aplicacion);

    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }
//
	public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $this->forward404Unless($aplicacion = Doctrine::getTable('Aplicacion')->find($request->getParameter('id')), sprintf('Object normativa does not exist (%s).', $request->getParameter('id')));

    $aplicacion->delete();

    $this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
    $this->redirect('contenidos/index');
  }
//
	protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {      
    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid()) {
      $aplicacion = $form->save();
      $aplicacion->setEstado($request->getParameter('frm_valor_estado'));
      $aplicacion->save();
     
      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");
      $this->redirect('contenidos/index');
    }
  }
//
	public function executeShow(sfWebRequest $request)
  {
    $this->aplicacion = Doctrine::getTable('Aplicacion')->find($request->getParameter('id'));
    $this->forward404Unless($this->aplicacion);
  }

} // end class