<?php

/**
 * organismos actions.
 *
 * @package    extranet
 * @subpackage organismos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class organismosActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
        $this->paginaActual = $this->getRequestParameter('page', 1);

        if (is_numeric($this->paginaActual)) {
                $this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
        }
  	$this->pager = new sfDoctrinePager('Organismo', 4);
	$this->pager->getQuery()
	->from('Organismo o')
	->leftJoin('o.UsuarioOrganismo uo')
        ->leftJoin('o.CategoriaOrganismo co')
        ->leftJoin('o.SubCategoriaOrganismo sco')
	->where($this->setFiltroBusqueda());
	if($this->getUser()->getAttribute('userId')!= 1 && !key_exists(1,UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1)))
	    {
	     $this->pager->getQuery()->andWhere('uo.usuario_id ='. $this->getUser()->getAttribute('userId'));
	    }   
	$this->pager->getQuery()->orderBy($this->setOrdenamiento());
	
	
	
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->organismo_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->organismo = Doctrine::getTable('Organismo')->find($request->getParameter('id'));
    $this->forward404Unless($this->organismo);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new OrganismoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new OrganismoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($organismo = Doctrine::getTable('Organismo')->find($request->getParameter('id')), sprintf('Object organismo does not exist (%s).', $request->getParameter('id')));
    $this->form = new OrganismoForm($organismo);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($organismo = Doctrine::getTable('Organismo')->find($request->getParameter('id')), sprintf('Object organismo does not exist (%s).', $request->getParameter('id')));
    $this->form = new OrganismoForm($organismo);

    $this->processForm($request, $this->form);

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

                         $this->forward404Unless($organismo = Doctrine::getTable('Organismo')->find($id), sprintf('Object organismo does not exist (%s).', $id));
                         sfLoader::loadHelpers('Security');
				if (!validate_action($accion)) $this->redirect('seguridad/restringuido');

				if ($accion == 'publicar') {
//						$documentacion_grupo->setEstado('publicado');
//						$documentacion_grupo->save();
//
//						ServiceNotificacion::send('creacion', 'Grupo', $documentacion_grupo->getId(), $documentacion_grupo->getNombre(),'',$documentacion_grupo->getGrupoTrabajoId());
				} else {

				      $organismo->delete();

					$this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
				}
  		}
    
    
    
          }
     $this->redirect('organismos/index');
   }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
  	
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
            
      $organismo = $form->save();
        
        if($this->getActionName() == 'create')
        {
	        $usuariosGrupo = UsuarioTable::getUsuariosByGrupoTrabajo($organismo->getGrupoTrabajoId());		
			foreach ($usuariosGrupo as $r) {
				 $roles = UsuarioRol::getRepository()->getRolesByUser($r->getId(),1); 
				if(Common::array_in_array(array('1'=>'1', '2'=>'2', '6'=>'6'), $roles))
				{
					$usuarioOrganismo = new UsuarioOrganismo();
					$usuarioOrganismo->setUsuarioId($r->getId()); 	
					$usuarioOrganismo->setOrganismoId($organismo->getId()); 	
					$usuarioOrganismo->save();
				}
	
			}
        }	        
      
//      $bandera     = 0;
//      $xSelectSubcat = $this->getRequestParameter('organismo[subcategoria_organismo_id]');
//      $xSelectCat = $this->getRequestParameter('organismo[categoria_organismo_id]');
//      
//      if (!empty($xSelectSubcat)){ $organismo->setSubcategoriaOrganismoId($xSelectSubcat); $bandera = 1; }
//      if (!empty($xSelectCat)){ $organismo->setCategoriaOrganismoId($xSelectCat); $bandera = 1; }
//
//      if ($bandera == 1) {
//      	$organismo->save();
//      }
      
     if($this->actionName == 'create')
     {
	      $this->getUser()->setFlash('notice', "Ingrese los usuarios del Organismo: ".$organismo->getNombre());
	      $this->redirect('organismos/editar?id='.$organismo->getId());
     }
     else 
     {
      $this->getUser()->setFlash('notice', "Los datos del Organismo: ".$organismo->getNombre()." fueron registrados ");
      $this->redirect('organismos/index');
     } 
    }
  }
  
  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();
  	

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->categoriaBsq = $this->getRequestParameter('organismo[categoria_organismo_id]');
		$this->subcategoriaBsq = $this->getRequestParameter('organismo[subcategoria_organismo_id]');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (o.nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->categoriaBsq)) {
			$parcial .= " AND o.categoria_organismo_id = $this->categoriaBsq ";
			$this->getUser()->setAttribute($modulo.'_nowcategoria', $this->categoriaBsq);
		}
		if (!empty($this->subcategoriaBsq)) {
			$parcial .= " AND o.subcategoria_organismo_id = $this->subcategoriaBsq ";
			$this->getUser()->setAttribute($modulo.'_nowsubcategoria', $this->subcategoriaBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcategoria');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowcategoria');
				$this->subcategoriaBsq = $this->getUser()->getAttribute($modulo.'_nowsubcategoria');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcategoria');
			$parcial="";
			$this->cajaBsq = "";
			$this->categoriaBsq = '';
			$this->subcategoriaBsq = '';
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
  
  // accion que ejecuta el componente subcategoria_organismo para el listado de organisamos 
  public function executeListByOrganismoAct(sfWebRequest $request)
  {
  	
		return $this->renderComponent('organismos','listaorganismos',array('name'=>$request->getParameter('name')));	
  	
  }
}