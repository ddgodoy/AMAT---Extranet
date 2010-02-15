<?php
/**
 * aplicaciones_externas actions.
 *
 * @package    extranet
 * @subpackage aplicaciones_externas
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class aplicaciones_externasActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
		$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		$this->pager = new sfDoctrinePager('AplicacionExterna', 10);
		$this->pager->getQuery()->from('AplicacionExterna')
								->where($this->setFiltroBusqueda())
								->orderBy($this->setOrdenamiento());

		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->aplicaciones_externas_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new AplicacionExternaForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new AplicacionExternaForm();
    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($aplicaciones_externas = Doctrine::getTable('AplicacionExterna')->find($request->getParameter('id')), sprintf('Object aplicaciones_externas does not exist (%s).', $request->getParameter('id')));
    $this->form = new AplicacionExternaForm($aplicaciones_externas);
  }

  public function executeUpdate(sfWebRequest $request)
  {  	
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($aplicaciones_externas = Doctrine::getTable('AplicacionExterna')->find($request->getParameter('id')), sprintf('Object aplicaciones_externas does not exist (%s).', $request->getParameter('id')));
    $this->form = new AplicacionExternaForm($aplicaciones_externas);

    $this->processForm($request, $this->form, 'actualizado');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($aplicaciones_externas = Doctrine::getTable('AplicacionExterna')->find($request->getParameter('id')), sprintf('Object aplicaciones_externas does not exist (%s).', $request->getParameter('id')));
    
    ## borrar imagen asociada
    @unlink(sfConfig::get('sf_upload_dir').'/aplicaciones_externas/'.$aplicaciones_externas->getImagen());

    $aplicaciones_externas->delete();

		$this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
    $this->redirect('aplicaciones_externas/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
  {
  	$imagenOld = $form->getObject()->getImagen();
  	$arrayFile = $request->getFiles('aplicacion_externa');
  	$uploadDir = sfConfig::get('sf_upload_dir').'/aplicaciones_externas/';

    $form->bind($request->getParameter('aplicacion_externa'), $arrayFile);

    if ($form->isValid()) {    	
   	  $aplicaciones_externas = $form->save();

   	  //borrado opcional de la imagen
   	  if ($request->getParameter('borrar_imagen')) {
   	  	$aplicaciones_externas->setImagen('');
   	  	$aplicaciones_externas->save();

   	  	@unlink($uploadDir.$imagenOld);
   	  }

      if (!empty($arrayFile['imagen']['tmp_name'])) {
      	$nombreImagen = $aplicaciones_externas->getImagen();

      	//eliminar en caso de imagen anterior
      	if ($imagenOld) {
      		@unlink($uploadDir.$imagenOld);
      	}
      	//redimensionar imagen original
	      $thumbnail = new sfThumbnail(150, 52, false, true, 100);
	      $thumbnail->loadFile($uploadDir.$nombreImagen);
	      $thumbnail->save($uploadDir.$nombreImagen);
      }

      $strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';
      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");

      $this->redirect('aplicaciones_externas/index'.$strPaginaVolver);
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
		
//		echo $this->orderBy . ' ' . $this->sortType;
//		exit();
		
		return $this->orderBy . ' ' . $this->sortType;
  }
}