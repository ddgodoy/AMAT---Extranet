<?php
/**
 * consejos_territoriales actions.
 *
 * @package    extranet
 * @subpackage consejos_territoriales
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class consejos_territorialesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	    $this->pager = new sfDoctrinePager('ConsejoTerritorial', 10);
		$this->pager->getQuery()
		->from('ConsejoTerritorial ct')
		->leftJoin('ct.UsuarioConsejoTerritorial uct')
	    ->where($this->setFiltroBusqueda());
	    if($this->getUser()->getAttribute('userId')!= 1)
	    {
	      $this->pager->getQuery()->andWhere('uct.usuario_id ='. $this->getUser()->getAttribute('userId'));
	    }   
		$this->pager->getQuery()->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->consejos_territoriales_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new ConsejoTerritorialForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new ConsejoTerritorialForm();
    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($consejos_territoriales = Doctrine::getTable('ConsejoTerritorial')->find($request->getParameter('id')), sprintf('Object consejos_territoriales does not exist (%s).', $request->getParameter('id')));
    $this->form = new ConsejoTerritorialForm($consejos_territoriales);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($consejos_territoriales = Doctrine::getTable('ConsejoTerritorial')->find($request->getParameter('id')), sprintf('Object consejos_territoriales does not exist (%s).', $request->getParameter('id')));
    $this->form = new ConsejoTerritorialForm($consejos_territoriales);

    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($consejos_territoriales = Doctrine::getTable('ConsejoTerritorial')->find($request->getParameter('id')), sprintf('Object consejos_territoriales does not exist (%s).', $request->getParameter('id')));
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');
    
    $consejos_territoriales->delete();

		$this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
    $this->redirect('consejos_territoriales/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {
    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid()) {
      $consejos_territoriales = $form->save();
      $strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';

      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");

      $this->redirect('consejos_territoriales/index'.$strPaginaVolver);
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