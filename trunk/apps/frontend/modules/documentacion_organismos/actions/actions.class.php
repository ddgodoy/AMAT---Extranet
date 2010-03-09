<?php

/**
 * documentacion_organismos actions.
 *
 * @package    extranet
 * @subpackage documentacion_organismos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class documentacion_organismosActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		$this->pager = new sfDoctrinePager('DocumentacionOrganismo', 20);
		$this->pager->getQuery()->from('DocumentacionOrganismo')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->documentacion_organismo_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
	
	 	if ($this->organismoBsq ) {
			$this->Organismos = OrganismoTable::getOrganismo($this->organismoBsq);
		} else {
			$this->Organismos = '';
		}
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->documentacion_organismo = Doctrine::getTable('DocumentacionOrganismo')->find($request->getParameter('id'));
    $this->forward404Unless($this->documentacion_organismo);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new DocumentacionOrganismoForm();
    $this->verLosOrganismos = OrganismoTable::getAllOrganismos()->count();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new DocumentacionOrganismoForm();
    $this->processForm($request, $this->form);
    
    $this->verLosOrganismos = OrganismoTable::getAllOrganismos()->count();

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($documentacion_organismo = Doctrine::getTable('DocumentacionOrganismo')->find($request->getParameter('id')), sprintf('Object documentacion_organismo does not exist (%s).', $request->getParameter('id')));
    $this->form = new DocumentacionOrganismoForm($documentacion_organismo);

    $this->verSubcategoria = SubCategoriaOrganismoTable::doSelectByCategoria($documentacion_organismo->getCategoriaOrganismoID());
    $this->idSubcategoria  = $documentacion_organismo->getSubcategoriaOrganismoId();
    $this->verOrganisamos  = OrganismoTable::doSelectByOrganismoa($this->idSubcategoria);
    $this->idOrganismos    = $documentacion_organismo->getOrganismoId();
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($documentacion_organismo = Doctrine::getTable('DocumentacionOrganismo')->find($request->getParameter('id')), sprintf('Object documentacion_organismo does not exist (%s).', $request->getParameter('id')));
    $this->form = new DocumentacionOrganismoForm($documentacion_organismo);

    $this->processForm($request, $this->form);

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
  			$this->forward404Unless($documentacion_organismo = Doctrine::getTable('DocumentacionOrganismo')->find($id), sprintf('Object documentacion_organismo does not exist (%s).', $id));
  			
  			sfLoader::loadHelpers('Security');
				if (!validate_action($accion)) $this->redirect('seguridad/restringuido');

				if ($accion == 'publicar') {
					$documentacion_organismo->setEstado('publicado');
					$documentacion_organismo->save();
				if($documentacion_organismo->getEstado()) {
				if ($documentacion_organismo->getOrganismoId()) {
					$enviar = true;
					$grupo  = OrganismoTable::getOrganismo($documentacion_organismo->getOrganismoId());
					$email  = UsuarioTable::getUsuarioByOrganismo($documentacion_organismo->getOrganismoId());
					$tema   = 'Documento registrado para el Organismos: '.$grupo->getNombre();
				}
				if ($documentacion_organismo->getEstado()=='publicado') {
				  ServiceNotificacion::send('creacion', 'Organismo', $documentacion_organismo->getId(), $documentacion_organismo->getNombre(),'',$documentacion_organismo->getOrganismoId());
				}  
			}

			## envia el email tendria que haber echo un servicio pero bue es lo que salio 	
			if($enviar)	{
				foreach ($email AS $emailPublic) {
					if($emailPublic->getEmail()) {
				    $mailTema = $emailPublic->getEmail();
	    		    $nombreEvento = $documentacion_organismo->getNombre();
	    		    $organizador  = $this->getUser()->getAttribute('apellido').','.$this->getUser()->getAttribute('nombre') ;
	    		    $descripcion  = $documentacion_organismo->getContenido();

					$mailer = new Swift(new Swift_Connection_NativeMail());
					$message = new Swift_Message('Contacto desde Extranet de Asociados AMAT');
		
					$mailContext = array('tema' => $tema,
					                     'evento' => $nombreEvento,
					                     'organizador' => $organizador,    
															'descripcio' => $descripcion,
															);
					$message->attach(new Swift_Message_Part($this->getPartial('eventos/mailHtmlBody', $mailContext), 'text/html'));
					$message->attach(new Swift_Message_Part($this->getPartial('eventos/mailTextBody', $mailContext), 'text/plain'));
	
					$mailer->send($message, $mailTema, sfConfig::get('app_default_from_email'));
					$mailer->disconnect();		
					}
				}
			}
     	
			}
			else
			{
				$documentacion_organismo->delete();
			}
  		}
  	}
  	$this->redirect('documentacion_organismos/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid()) 
    {
         $documentacion_organismo = $form->save();
    
   
## Notificar y enviar email a los destinatarios 
			if($documentacion_organismo->getEstado()) {
				if ($documentacion_organismo->getOrganismoId()) {
					$enviar = true;
					$grupo  = OrganismoTable::getOrganismo($documentacion_organismo->getOrganismoId());
					$email  = UsuarioTable::getUsuarioByOrganismo($documentacion_organismo->getOrganismoId());
					$tema   = 'Documento registrado para el Organismos: '.$grupo->getNombre();
				}
				if ($documentacion_organismo->getEstado()=='publicado') {
				  ServiceNotificacion::send('creacion', 'Organismo', $documentacion_organismo->getId(), $documentacion_organismo->getNombre(),'',$documentacion_organismo->getOrganismoId());
				}  
			}
			if($documentacion_organismo->getEstado() == 'pendiente')
   			{ 
				$enviar = true;
				$grupo = OrganismoTable::getOrganismo($documentacion_organismo->getOrganismoId());
				$email = AplicacionRolTable::getEmailPublicar('33','','',$grupo->getId());
				$tema = 'Documento registrado para el Organismos: '.$grupo->getNombre();
			}	

			## envia el email tendria que haber echo un servicio pero bue es lo que salio 	
			if($enviar)	{
				foreach ($email AS $emailPublic) {
					if($emailPublic->getEmail()) {
				    $mailTema = $emailPublic->getEmail();
	    		    $nombreEvento = $documentacion_organismo->getNombre();
	    		    $organizador  = $this->getUser()->getAttribute('apellido').','.$this->getUser()->getAttribute('nombre') ;
	    		    $descripcion  = $documentacion_organismo->getContenido();

					$mailer = new Swift(new Swift_Connection_NativeMail());
					$message = new Swift_Message('Contacto desde Extranet de Asociados AMAT');
		
						$mailContext = array('tema' => $tema,
						                     'evento' => $nombreEvento,
						                     'organizador' => $organizador,    
																'descripcio' => $descripcion,
																);
						$message->attach(new Swift_Message_Part($this->getPartial('eventos/mailHtmlBody', $mailContext), 'text/html'));
						$message->attach(new Swift_Message_Part($this->getPartial('eventos/mailTextBody', $mailContext), 'text/plain'));
		
						$mailer->send($message, $mailTema, sfConfig::get('app_default_from_email'));
						$mailer->disconnect();		
					}
				}
			}
		$this->redirect('documentacion_organismos/show?id='.$documentacion_organismo->getId());	
     }	
		
  }
  
  /* Metodos para busqueda y ordenamiento */
  
  protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->categoriaBsq = $this->getRequestParameter('documentacion_organismo[categoria_organismo_id]');
		$this->subcategoriaBsq = $this->getRequestParameter('documentacion_organismo[subcategoria_organismo_id]');
		$this->organismoBsq = $this->getRequestParameter('documentacion_organismo[organismo_id]');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda');
		$this->estadoBsq = $this->getRequestParameter('estado_busqueda');

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->categoriaBsq)) {
			$parcial .= " AND categoria_organismo_id =".$this->categoriaBsq ;
			$this->getUser()->setAttribute($modulo.'_nowcategoria', $this->categoriaBsq);
		}
		if (!empty($this->subcategoriaBsq)) {
			$parcial .= " AND subcategoria_organismo_id =".$this->subcategoriaBsq ;
			$this->getUser()->setAttribute($modulo.'_nowsubcategoria', $this->subcategoriaBsq);
		}
		if (!empty($this->organismoBsq)) {
			$parcial .= " AND organismo_id =".$this->organismoBsq ;
			$this->getUser()->setAttribute($modulo.'_noworganismos', $this->organismoBsq);
		}
		if (!empty($this->desdeBsq)) {
			$parcial .= " AND fecha >= '".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowdesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND fecha <= '".format_date($this->hastaBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowhasta', $this->hastaBsq);
		}
		if (!empty($this->estadoBsq)) {
			$parcial .= " AND estado = '$this->estadoBsq' ";
			$this->getUser()->setAttribute($modulo.'_nowestado', $this->estadoBsq);
		}
		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcategoria');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_noworganismos');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowdesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowhasta');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowcategoria');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowsubcategoria');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_noworganismos');
				$this->estadoBsq = $this->getUser()->getAttribute($modulo.'_nowestado');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcategoria');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_noworganismos');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
			$parcial="";
			$this->cajaBsq = "";
			$this->categoriaBsq = '';
			$this->subcategoriaBsq = '';
			$this->organismoBsq = '';
			$this->desdeBsq = '';
			$this->hastaBsq = '';
			$this->estadoBsq = '';
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
  
  //accion que ejecuta el componente de categoria_organismo
  public function executeListByCategoriaOrganismo(sfWebRequest $request)
  {
    return $this->renderComponent('subcategoria_organismos','listasubcategoria',array('name'=>$request->getParameter('name')));
  }
}