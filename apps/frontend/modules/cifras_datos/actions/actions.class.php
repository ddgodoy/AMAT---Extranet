<?php

/**
 * cifras_datos actions.
 *
 * @package    extranet
 * @subpackage cifras_datos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */

/**
 * Modificaciones de seguridad en el modulo (Pablo Peralta)
 * 
 * - Se agrega accion publicar si corresponde al abm
 * - Se agrega proteccion en la accion delete con el helper security
 * - Se modifica plantilla indexSuccess.php agregando el helper Security al comienzo y usando validate_action() donde corresponde
 * - Se modifica plantilla showSuccess.php agregando el helper Security al comienzo y usando validate_action() donde corresponde
 * - En showSuccess.php agregar linea para notificar las modificaciones en show.
 * - Se modifica plantilla _form.php agregando el helper Security al comienzo y usando validate_action() donde corresponde.
 *   Tener en cuenta las modificaciones en los script de javascript de estado de publicacion
 */

class cifras_datosActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->paginaActual = $this->getRequestParameter('page', 1);

	if (is_numeric($this->paginaActual)) {
		$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
	}
	    $this->pager = new sfDoctrinePager('CifraDato', 10);
	$this->pager->getQuery()->from('CifraDato')
	->where($this->setFiltroBusqueda())
	->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->cifra_dato_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->cifra_dato = Doctrine::getTable('CifraDato')->find($request->getParameter('id'));
    $this->forward404Unless($this->cifra_dato);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new CifraDatoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new CifraDatoForm();

    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($cifra_dato = Doctrine::getTable('CifraDato')->find($request->getParameter('id')), sprintf('Object cifra_dato does not exist (%s).', $request->getParameter('id')));
    $this->form = new CifraDatoForm($cifra_dato);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($cifra_dato = Doctrine::getTable('CifraDato')->find($request->getParameter('id')), sprintf('Object cifra_dato does not exist (%s).', $request->getParameter('id')));
	
    $this->form = new CifraDatoForm($cifra_dato);
	      
    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }
  
  public function executePublicar(sfWebRequest $request)
  {
	$this->processSelectedRecords($request, 'publicar');	
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
	  			    $this->forward404Unless($cifra_dato = Doctrine::getTable('CifraDato')->find($id), sprintf('Object documentacion_grupo does not exist (%s).', $id));
	  			
	  			    sfLoader::loadHelpers('Security');
					if (!validate_action($accion)) $this->redirect('seguridad/restringuido');
	
					if ($accion == 'publicar') {
						$cifra_dato->setEstado('publicado');
						$cifra_dato->save();
					} else {
						
    					$cifra_dato->delete();
					}		
	  		}
	  	}
	 $this->redirect('cifras_datos/index');
  }
  
  

  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {
    
	$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

	if ($form->isValid()) {
		## Files
		// Elimino si marca eliminar
		$dato=Doctrine::getTable('CifraDato')->find($request->getParameter('id'));
		if ($form->getValue('imagen_delete') && $dato->getImagen()) {
	    	$dato->eliminarImagen();
	    }
		if ($form->getValue('documento_delete') && $dato->getDocumento()) {
	    	$dato->eliminarDocumento();
	    }		
		
		$cifra_dato = $form->save();
		$strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';
		
    	$this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");
		$this->redirect('cifras_datos/index'.$strPaginaVolver);
	}
  }
  
  /* Metodos para busqueda y ordenamiento */
  
  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (titulo LIKE '%$this->cajaBsq%')";
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
		$this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
		if(Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles))
		{
			return 'deleted=0'.$parcial;
		}
		else 
		{
			return 'deleted=0 AND destacada = 1'.$parcial;
		}
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
                        $this->orderBy = 'fecha';
                        $this->sortType = 'asc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }
}
