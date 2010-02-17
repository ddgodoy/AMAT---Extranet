<?php
/**
 * eventos actions.
 *
 * @package    extranet
 * @subpackage eventos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class eventosActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	$this->pager = new sfDoctrinePager('Evento', 10);
		$this->pager->getQuery()->from('Evento')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->evento_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
  }

	public function executeShow(sfWebRequest $request)
	{
		$this->evento = Doctrine::getTable('Evento')->find($request->getParameter('id'));
		$this->forward404Unless($this->evento);
	}

	public function executeNuevo(sfWebRequest $request)
	{
		$this->form = new EventoForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new EventoForm();

		$this->processForm($request, $this->form, 'creado');
		
		$this->setTemplate('nuevo');
	}

	public function executeEditar(sfWebRequest $request)
	{
		$this->forward404Unless($evento = Doctrine::getTable('Evento')->find($request->getParameter('id')), sprintf('Object evento does not exist (%s).', $request->getParameter('id')));
		$this->form = new EventoForm($evento);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($evento = Doctrine::getTable('Evento')->find($request->getParameter('id')), sprintf('Object evento does not exist (%s).', $request->getParameter('id')));
		$this->form = new EventoForm($evento);
		
		$this->processForm($request, $this->form, 'actualizado');
		
		$this->setTemplate('editar');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		
		$this->forward404Unless($evento = Doctrine::getTable('Evento')->find($request->getParameter('id')), sprintf('Object evento does not exist (%s).', $request->getParameter('id')));
		
		$aviso = NotificacionTable::getDeleteEntidad($evento->getId(),$evento->getTitulo ());
		
		sfLoader::loadHelpers('Security'); // para usar el helper
	    if (!validate_action('baja')) $this->redirect('seguridad/restringuido');
	    $aviso->delete();
		$evento->delete();
		
		$this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");

		$this->redirect('eventos/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
	{
		$enviar = false;
		$estado = $request->getParameter($form->getName());
		
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		
		if ($form->isValid()) {
			$evento = $form->save();
			$strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';

			## Notificar y enviar email a los destinatarios 
			if(!isset($_POST['sf_method']) && $evento->getEstado() == 'publicado') {
				if (!empty($estado['usuarios_list'])) {
					$enviar = true;
					$email = UsuarioTable::getEmailEvento($estado['usuarios_list']);
					$tema = 'Evento publicado';
				}
				ServiceNotificacion::send('creacion', 'Evento', $evento->getId(), $evento->getTitulo());
			}
			##enviar email a los responsables 
			if ($estado['estado'] == 'pendiente')
			{ 
				$enviar = true;
				$email = AplicacionRolTable::getEmailPublicar(2);
				$tema = 'Evento pendiente de publicar';
			}	
			## envia el email
			if ($enviar) {
				foreach ($email AS $emailPublic) {
					if ($emailPublic->getEmail()) {
				    $mailTema = $emailPublic->getEmail();
				    $temaTi   = $tema;
    		    $nombreEvento = $estado['titulo'];
    		    $organizador  = $estado['organizador'];
    		    $descripcion  = $estado['descripcion'];

						$mailer  = new Swift(new Swift_Connection_NativeMail());
						$message = new Swift_Message('Contacto desde Extranet de Asociados AMAT');
		
						$mailContext = array('tema'   => $temaTi,
						                     'evento' => $nombreEvento,
						                     'organizador' => $organizador,    
																 'descripcio'  => $descripcion,
																);
						$message->attach(new Swift_Message_Part($this->getPartial('eventos/mailHtmlBody', $mailContext), 'text/html'));
						$message->attach(new Swift_Message_Part($this->getPartial('eventos/mailTextBody', $mailContext), 'text/plain'));
		
						$mailer->send($message, $mailTema, sfConfig::get('app_default_from_email'));
						$mailer->disconnect();		
					}
				}
			}
			$this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");

			$this->redirect('eventos/index'.$strPaginaVolver);
		}
	}
	
	public function executePublicar(sfWebRequest $request)
	{
		## Obtener el id del evento
		if(!$this->eventoId = $this->getRequestParameter('id'))
			$this->forward404('El evento solicitado no existe');
		
		$evento = Doctrine::getTable('Evento')->find($this->eventoId);
		
		sfLoader::loadHelpers('Security'); // para usar el helper
		if (!validate_action('publicar')) $this->redirect('seguridad/restringuido');	
		
		$evento->setEstado('publicado');
		$evento->save();
		## Notificar
		ServiceNotificacion::send('creacion', 'Evento', $evento->getId(), $evento->getTitulo());
		
		$email = UsuarioTable::getUsuarioByEventos($evento->getId());
		
		if($email)	
			{
				foreach ($email AS $emailPublic)
				{
						
					if($emailPublic->getEmail())
					{
					    $mailTema = $emailPublic->getEmail();
					    $temaTi ='Evento publicado'; ;
		    		    $nombreEvento = $evento->getTitulo();
		    		    $organizador = $evento->getOrganizador();
		    		    $descripcion = $evento->getDescripcion();
						$mailer = new Swift(new Swift_Connection_NativeMail());
						$message = new Swift_Message('Contacto desde Extranet de Asociados AMAT');
		
						$mailContext = array(                   'tema' => $temaTi,
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
		$this->getUser()->setFlash('notice', 'El evento ha sido publicado correctamente');
		$this->redirect(str_replace('|', '/', $this->getRequestParameter('goto', 'eventos/index')));
	}
	
	public function executeDelete_selected(sfWebRequest $request)
	{
		if($this->getRequestParameter('checks')){
			foreach ($this->getRequestParameter('checks') as $name => $value) {
				$aux = explode('_', $name);
				$evento = Doctrine::getTable('Evento')->find($aux[1]);
				$evento->delete();
			}
			
			$this->getUser()->setFlash('notice', 'Los eventos seleccionados se han eliminado correctamente');
		} else {
			$this->getUser()->setFlash('error', 'Debes seleccionar al menos un evento');
		}
		$this->redirect($this->getRequestParameter('goto'));
	}
	
	public function executeVer(sfWebRequest $request)
	{
		if(!$this->eventoId = $this->getRequestParameter('id'))
			$this->forward404('El evento solicitado no existe');
			
		$this->evento = Doctrine::getTable('Evento')->find($this->eventoId);
	}
	
	protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');

  	$parcial = '';
  	$modulo = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda');
		$this->ambitoBQ = $this->getRequestParameter('ambito');
		$this->estadoBq = $this->getRequestParameter('estado');

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND titulo LIKE '%$this->cajaBsq%'";
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
		if (!empty($this->ambitoBQ)) {
			$parcial .= " AND ambito = '".$this->ambitoBQ."'";
			$this->getUser()->setAttribute($modulo.'_nowambito', $this->ambitoBQ);
		}
		if (!empty($this->estadoBq)) {
			$parcial .= " AND estado = '".$this->estadoBq."'";
			$this->getUser()->setAttribute($modulo.'_nowestado', $this->estadoBq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowambito');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowdesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowhasta');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowambito');
				$this->estadoBq = $this->getUser()->getAttribute($modulo.'_nowestado');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowambito');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
			$parcial="";
			$this->cajaBsq = "";
			$this->desdeBsq = '';
			$this->hastaBsq = '';
			$this->ambitoBQ = '';
			$this->estadoBq = '';
		}
		return 'deleted=0'.$parcial;
  }
  
  protected function setOrdenamiento()
  {
		$this->orderBy = 'fecha';
		$this->sortType = 'desc';

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }
}
