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
  	    $this->pager = new sfDoctrinePager('ConsejoTerritorial', 4);
		$this->pager->getQuery()
		->from('ConsejoTerritorial ct')
		->leftJoin('ct.UsuarioConsejoTerritorial uct')
	    ->where($this->setFiltroBusqueda());
	    
	    if($this->getUser()->getAttribute('userId')!= 1 && !key_exists(1,UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1)))
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
  	
  	$this->processSelectedRecords($request, 'baja');

  }
  protected function processSelectedRecords(sfWebRequest $request, $accion)
  {
  	$toProcess = $request->getParameter('id');
  	
  	if (!empty($toProcess)) {
  		$request->checkCSRFProtection();
  		
  		$IDs = is_array($toProcess) ? $toProcess : array($toProcess);
  		
  		foreach ($IDs as $id) {
  			    $this->forward404Unless($consejos_territoriales = Doctrine::getTable('ConsejoTerritorial')->find($id), sprintf('Object documentacion_grupo does not exist (%s).', $id));
  			
  			    sfLoader::loadHelpers('Security');
				if (!validate_action($accion)) $this->redirect('seguridad/restringuido');

				if ($accion == 'publicar') {
//						$documentacion_grupo->setEstado('publicado');
//						$documentacion_grupo->save();
//			
//						ServiceNotificacion::send('creacion', 'Grupo', $documentacion_grupo->getId(), $documentacion_grupo->getNombre(),'',$documentacion_grupo->getGrupoTrabajoId());	
				} else {
					$consejos_territoriales->delete();

					$this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
				}		
  		}
  	}
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
		$modulo = $this->getModuleName();
		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
		}else {
                    if($this->getUser()->getAttribute($modulo.'_noworderBY'))
                    {
                       $this->orderBYSql = $this->getUser()->getAttribute($modulo.'_noworderBY');
                       $ordenacion = explode(' ', $this->orderBYSql);
                       $this->orderBy = $ordenacion[0];
                       $this->sortType = $ordenacion[1];
                    }
                    else
                    {
                        $this->orderBy = 'nombre';
                        $this->sortType = 'asc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }
}