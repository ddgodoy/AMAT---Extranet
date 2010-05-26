<?php

/**
 * archivos_d_g actions.
 *
 * @package    extranet
 * @subpackage archivos_d_g
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class archivos_d_gActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	
    $this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		$this->pager = new sfDoctrinePager('ArchivoDG', 10);
		$this->pager->getQuery()->from('ArchivoDG')
                ->where($this->setFiltroBusqueda())
                ->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();
		
		if ($this->documentacionBsq) {
  		$this->documentacion = DocumentacionGrupo::getRepository()->findOneById($this->documentacionBsq);
  		}	

		$this->archivo_dg_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();

		if ($this->grupoBsq) {
		  $this->Grupo = GrupoTrabajoTable::getGrupoTrabajo($this->grupoBsq);
		} else {
			$this->Grupo = '';
		}
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->archivo_dg = Doctrine::getTable('ArchivoDG')->find($request->getParameter('id'));
    $this->forward404Unless($this->archivo_dg);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new ArchivoDGForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new ArchivoDGForm();
    $this->processForm($request, $this->form);

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($archivo_dg = Doctrine::getTable('ArchivoDG')->find($request->getParameter('id')), sprintf('Object archivo_dg does not exist (%s).', $request->getParameter('id')));
    $this->form = new ArchivoDGForm($archivo_dg);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($archivo_dg = Doctrine::getTable('ArchivoDG')->find($request->getParameter('id')), sprintf('Object archivo_dg does not exist (%s).', $request->getParameter('id')));
    $this->form = new ArchivoDGForm($archivo_dg);

    $this->processForm($request, $this->form);

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $toDelete = $request->getParameter('id');

  	if (!empty($toDelete)) {
  		$request->checkCSRFProtection();

  		$IDs = is_array($toDelete) ? $toDelete : array($toDelete);

  		foreach ($IDs as $id) {
  			$this->forward404Unless($archivo_dg = Doctrine::getTable('ArchivoDG')->find($id), sprintf('Object archivo_dg does not exist (%s).', $id));

		    sfLoader::loadHelpers('Security');
				if (!validate_action('baja')) $this->redirect('seguridad/restringuido');

		    $archivo_dg->delete();
  		}
  	}
    $this->redirect('archivos_d_g/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid()) {
      $dato = Doctrine::getTable('ArchivoDG')->find($request->getParameter('id'));
		
			if ($form->getValue('archivo_delete') && $dato->getArchivo()) {
	    	$dato->eliminarDocumento();
	    }
      $archivo_dg = $form->save();
      
      $bandera     = 0;
      $xSelectDocum = $this->getRequestParameter('documentacion_grupo_id');
      $xSelectGrupo = $this->getRequestParameter('grupo_trabajo_id');
      if (!empty($xSelectDocum)){ $archivo_dg->setDocumentacionGrupoId($xSelectDocum); $bandera = 1; }
      if (!empty($xSelectGrupo)){ $archivo_dg->setGrupoTrabajoId($xSelectGrupo); $bandera = 1; }

      if ($bandera == 1) {
      	$archivo_dg->save();
      }	
      $this->redirect('archivos_d_g/show?id='.$archivo_dg->getId());
    }
  }
  
  /* Metodos para busqueda y ordenamiento */
  
  protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');
  	$parcial = '';
  	$modulo  = $this->getModuleName();
        $this->modulo = $modulo;

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->grupoBsq = $this->getRequestParameter('grupo_trabajo_id');
		$this->documentacionBsq = $this->getRequestParameter('archivo_d_g[documentacion_grupo_id]');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%' OR contenido LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->grupoBsq)) {
			$parcial .= " AND grupo_trabajo_id = $this->grupoBsq ";
			$this->getUser()->setAttribute($modulo.'_nowgrupo', $this->grupoBsq);
		}
		if (!empty($this->documentacionBsq)) {
			$parcial .= " AND documentacion_grupo_id = $this->documentacionBsq ";
			$this->getUser()->setAttribute($modulo.'_nowdocumentacion', $this->documentacionBsq);
		}
		if (!empty($this->desdeBsq)) {
			$parcial .= " AND fecha >= '".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowdesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND fecha <= '".format_date($this->hastaBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowhasta', $this->hastaBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowgrupo');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdocumentacion');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowgrupo');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowdocumentacion');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowdesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowhasta');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowgrupo');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdocumentacion');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			$parcial = "";
			$this->cajaBsq = "";
			$this->grupoBsq = '';
			$this->documentacionBsq = '';
			$this->desdeBsq = '';
			$this->hastaBsq = '';
   	}
		$gruposdetrabajo = GrupoTrabajo::iddegrupos($this->getUser()->getAttribute('userId'),1); 
		$this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
		if(Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles))
		{
			return 'deleted=0'.$parcial;
		}
		else
		{
			return 'deleted=0'.$parcial.' AND grupo_trabajo_id IN '.$gruposdetrabajo;
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
                        $this->sortType = 'desc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }
}