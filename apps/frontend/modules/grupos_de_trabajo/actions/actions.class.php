<?php
/**
 * grupos_de_trabajo actions.
 *
 * @package    extranet
 * @subpackage grupos_de_trabajo
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class grupos_de_trabajoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	/**/
  	sfLoader::loadHelpers('Security');
		if (!validate_action('listar')) $this->redirect('seguridad/restringuido');
		/**/
  	$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	$this->pager = new sfDoctrinePager('GrupoTrabajo', 4);
		$this->pager->getQuery()
		->from('GrupoTrabajo gt')
	    ->leftJoin('gt.UsuarioGrupoTrabajo ugt')
	    ->where($this->setFiltroBusqueda());
	    if($this->getUser()->getAttribute('userId')!= 1 && !key_exists(1,UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1)))
	    {
	     $this->pager->getQuery()->andWhere('ugt.usuario_id ='. $this->getUser()->getAttribute('userId'));
	    }   
	    $this->pager->getQuery()->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->grupos_de_trabajo_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new GrupoTrabajoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new GrupoTrabajoForm();
    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($grupos_de_trabajo = Doctrine::getTable('GrupoTrabajo')->find($request->getParameter('id')), sprintf('Object grupos_de_trabajo does not exist (%s).', $request->getParameter('id')));
    $this->form = new GrupoTrabajoForm($grupos_de_trabajo);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($grupos_de_trabajo = Doctrine::getTable('GrupoTrabajo')->find($request->getParameter('id')), sprintf('Object grupos_de_trabajo does not exist (%s).', $request->getParameter('id')));
    $this->form = new GrupoTrabajoForm($grupos_de_trabajo);

    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($grupos_de_trabajo = Doctrine::getTable('GrupoTrabajo')->find($request->getParameter('id')), sprintf('Object grupos_de_trabajo does not exist (%s).', $request->getParameter('id')));
    
    sfLoader::loadHelpers('Security'); // para usar el helper
		if (!validate_action('baja')) $this->redirect('seguridad/restringuido');
    
    $grupos_de_trabajo->delete();

		$this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
    $this->redirect('grupos_de_trabajo/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {
    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid()) {
      $grupos_de_trabajo = $form->save();
      $strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';

      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");

      $this->redirect('grupos_de_trabajo/index'.$strPaginaVolver);
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
		return 'deleted=0'.$parcial;
  }
  
  protected function setOrdenamiento()
  {
		$this->orderBy = 'nombre';
		$this->sortType = 'asc';

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }
}