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
  	$this->processSelectedRecords($request, 'baja');
 
  }

  protected function processSelectedRecords(sfWebRequest $request, $accion)
  {
  	$toProcess = $request->getParameter('id');
  	
  	if (!empty($toProcess)) {
  		$request->checkCSRFProtection();
  		
  		$IDs = is_array($toProcess) ? $toProcess : array($toProcess);
  		
  		foreach ($IDs as $id) {
  			    $this->forward404Unless($grupos_de_trabajo = Doctrine::getTable('GrupoTrabajo')->find($id), sprintf('Object documentacion_grupo does not exist (%s).', $id));
  			
  			    sfLoader::loadHelpers('Security');
				if (!validate_action($accion)) $this->redirect('seguridad/restringuido');

				if ($accion == 'publicar') {
//						$documentacion_grupo->setEstado('publicado');
//						$documentacion_grupo->save();
//			
//						ServiceNotificacion::send('creacion', 'Grupo', $documentacion_grupo->getId(), $documentacion_grupo->getNombre(),'',$documentacion_grupo->getGrupoTrabajoId());	
				} else {
					
				    $grupos_de_trabajo->delete();
				
					$this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
				}		
  		}
  	}
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