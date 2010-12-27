<?php

/**
 * publicaciones actions.
 *
 * @package    extranet
 * @subpackage publicaciones
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class publicacionesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		$this->pager = new sfDoctrinePager('Publicacion', 10);
		$this->pager->getQuery()->from('Publicacion')
				 ->where($this->setFiltroBusqueda())
				 ->orderBy($this->setOrdenamiento());

		$this->pager->setPage($this->paginaActual);
		$this->pager->init();
	
		$this->publicacion_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->publicacion = Doctrine::getTable('Publicacion')->find($request->getParameter('id'));
    $this->forward404Unless($this->publicacion);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new PublicacionForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new PublicacionForm();
    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($publicacion = Doctrine::getTable('Publicacion')->find($request->getParameter('id')), sprintf('Object publicacion does not exist (%s).', $request->getParameter('id')));
    $this->form = new PublicacionForm($publicacion);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($publicacion = Doctrine::getTable('Publicacion')->find($request->getParameter('id')), sprintf('Object publicacion does not exist (%s).', $request->getParameter('id')));
    $this->form = new PublicacionForm($publicacion);

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
				$this->forward404Unless($cifra_dato = Doctrine::getTable('Publicacion')->find($id), sprintf('Object documentacion_grupo does not exist (%s).', $id));
  			
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
		$this->redirect('publicaciones/index');
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		if ($form->isValid()) {		
			## Files
			$dato = Doctrine::getTable('Publicacion')->find($request->getParameter('id'));

			if ($form->getValue('imagen_delete') && $dato->getImagen()) {
	    	$dato->eliminarImagen();
	    }
			if ($form->getValue('documento_delete') && $dato->getDocumento()) {
	    	$dato->eliminarDocumento();
	    }
			$cifra_dato = $form->save();
			$strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';

			$this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");
			$this->redirect('publicaciones/index'.$strPaginaVolver);
		}
  }

/* Metodos para busqueda y ordenamiento */
  
  protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');

  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq  = $this->getRequestParameter('caja_busqueda');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda');
		$this->ambitoBsq= $this->getRequestParameter('ambito_busqueda');
		
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
		if (!empty($this->ambitoBsq)) {
			$parcial .= " AND ambito = '$this->ambitoBsq'";
			$this->getUser()->setAttribute($modulo.'_nowambito', $this->ambitoBsq);
		}
		//
		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowambito');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq  = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowdesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowhasta');
				$this->ambitoBsq= $this->getUser()->getAttribute($modulo.'_nowambito');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowambito');
			$parcial = "";
			$this->cajaBsq  = '';
			$this->desdeBsq = '';
			$this->hastaBsq = '';
			$this->ambitoBsq= '';
		}
		$this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
		$finalFilter = 'deleted = 0'.$parcial;

		if (!Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles)) {
			$finalFilter .= ' AND destacada = 1';
		}
		return $finalFilter;
  }

  protected function setOrdenamiento()
  {
		$modulo = $this->getModuleName();

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy   = $this->getRequestParameter('sort');
			$this->sortType  = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
      $this->orderBYSql= $this->orderBy . ' ' . $this->sortType;

      $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
		} else {
			if ($this->getUser()->getAttribute($modulo.'_noworderBY')) {
         $this->orderBYSql = $this->getUser()->getAttribute($modulo.'_noworderBY');
         $ordenacion = explode(' ', $this->orderBYSql);
         $this->orderBy = $ordenacion[0];
         $this->sortType = $ordenacion[1];
			} else {
        $this->orderBy = 'fecha';
        $this->sortType = 'desc';
        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
    	}
    }
		return $this->orderBYSql;
  }

} // end class