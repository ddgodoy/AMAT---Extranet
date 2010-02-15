<?php
/**
 * noticias actions.
 *
 * @package    extranet
 * @subpackage noticias
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class noticiasActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	$this->pager = new sfDoctrinePager('Noticia', 10);  	    
		$this->pager->getQuery()->from('Noticia')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->noticia_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
	}
	
	public function executeShow(sfWebRequest $request)
	{
		$this->noticia = Doctrine::getTable('Noticia')->find($request->getParameter('id'));
		$this->forward404Unless($this->noticia);
	}

	public function executeNueva(sfWebRequest $request)
	{
		$this->form = new NoticiaForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new NoticiaForm();
		$this->processForm($request, $this->form);

		$this->setTemplate('nueva');
	}

	public function executeEditar(sfWebRequest $request)
	{
		$this->forward404Unless($noticia = Doctrine::getTable('Noticia')->find($request->getParameter('id')), sprintf('Object noticia does not exist (%s).', $request->getParameter('id')));
		$this->form = new NoticiaForm($noticia);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($noticia = Doctrine::getTable('Noticia')->find($request->getParameter('id')), sprintf('Object noticia does not exist (%s).', $request->getParameter('id')));
		$this->form = new NoticiaForm($noticia);
		
		$this->processForm($request, $this->form);
		
		$this->setTemplate('editar');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		
		$this->forward404Unless($noticia = Doctrine::getTable('Noticia')->find($request->getParameter('id')), sprintf('Object noticia does not exist (%s).', $request->getParameter('id')));
		
		$aviso = NotificacionTable::getDeleteEntidad($noticia->getId(),$noticia->getTitulo ());
		
		sfLoader::loadHelpers('Security'); // para usar el helper
	    if (!validate_action('baja')) $this->redirect('seguridad/restringuido');
		$aviso->delete();
		$noticia->delete();
		
		$this->redirect('noticias/index');
	}
	
	public function executePublicar(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		
		$clase = 'Noticia';
		$modulo = 'noticias';
		
		$this->forward404Unless($objeto = Doctrine::getTable($clase)->find($request->getParameter('id')), sprintf('Object '.$clase.' does not exist (%s).', $request->getParameter('id')));
		
		sfLoader::loadHelpers('Security'); // para usar el helper
		if (!validate_action('publicar')) $this->redirect('seguridad/restringuido');		
		
		$objeto->setEstado('publicado');
		$objeto->save();
		
		## Notificar
		ServiceNotificacion::send('creacion', 'Noticia', $objeto->getId(), $objeto->getTitulo());
		
		## envio el email por eso digo que tendria que haber echo un servicio
	    $email = UsuarioTable::getEmailEvento($objeto->getOwnerId());
		$tema = 'Novedad publicada';
		
		foreach ($email AS $emailPublic)
				{
					if($emailPublic->getEmail())
					{
					    $mailTema = $emailPublic->getEmail();
					    $temaTi = $tema ;
		    		    $nombreEvento = $objeto->getTitulo();
		    		    $organizador = $objeto->getAutor();
		    		    $descripcion = $objeto->getEntradilla();
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
		
		
		$this->getUser()->setFlash('notice', "El registro ha sido publicado correctamente");
		
		$this->redirect($modulo.'/show?id='.$objeto->getId());
	}
	

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$enviar = false;
		$estado = $request->getParameter($form->getName());
		
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		
		if ($form->isValid())
		{
			## Files
			if ($form->getValue('imagen')) {
				$file     = $this->form->getValue('imagen');
				$filename = 'uploaded_'.sha1($file->getOriginalName());
				$extension= $file->getExtension($file->getOriginalExtension());

				$file->save(sfConfig::get('sf_upload_dir').'/noticias/images/'.$filename.$extension);
			}
			$noticia = $form->save();
			
			## Notificar
			if($estado['estado'] == 'publicado') {
				$enviar = true;
				$email = UsuarioTable::getEmailEvento($noticia->getOwnerId());
				$tema = 'Novedad publicada';
				ServiceNotificacion::send('creacion', 'Noticia', $noticia->getId(), $noticia->getTitulo());
			}
            
			if($estado['estado'] == 'pendiente')
			{ 
				$enviar = true;
				$email = AplicacionRolTable::getEmailPublicar(1);
				$tema = 'Novedad pendiente de publicar';
			}	
			##enviar email a los responsables 
			if($enviar)	
			{
				foreach ($email AS $emailPublic)
				{
					if($emailPublic->getEmail())
					{
					    $mailTema = $emailPublic->getEmail();
					    $temaTi = $tema ;
		    		    $nombreEvento = $estado['titulo'];
		    		    $organizador = $estado['autor'];
		    		    $descripcion = $estado['entradilla'];
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
		
			$this->getUser()->setFlash('notice', 'La noticia ha sido actualizada correctamente');
			$this->redirect('noticias/show?id='.$noticia->getId());
		}
	}
	
	public function executeVer(sfWebRequest $request)
	{
		$id = $this->getRequestParameter('id');
		$this->noticia = Doctrine::getTable('Noticia')->find($id);
	}
	
	protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');

  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq  = $this->getRequestParameter('caja_busqueda');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda');
		$this->destacadaBsq = $this->getRequestParameter('destacadas_busqueda');
    $this->ambitoBsq = $this->getRequestParameter('ambito_busqueda');
    $this->estadoBsq = $this->getRequestParameter('estado_busqueda');

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
		if (!empty($this->destacadaBsq)) {
			$parcial .= " AND destacada = 1 ";
			$this->getUser()->setAttribute($modulo.'_nowdestacada', $this->destacadaBsq);
		}
		if (!empty($this->ambitoBsq)) {
			$parcial .= " AND ambito = '$this->ambitoBsq'";
			$this->getUser()->setAttribute($modulo.'_nowambito', $this->ambitoBsq);
		}
		if (!empty($this->estadoBsq)) {
			$parcial .= " AND estado = '$this->estadoBsq'";
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
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdestacada');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowambito');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq  = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowdesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowhasta');
				$this->destacadaBsq = $this->getUser()->getAttribute($modulo.'_nowdestacada');
				$this->ambitoBsq = $this->getUser()->getAttribute($modulo.'_nowambito');
				$this->estadoBsq = $this->getUser()->getAttribute($modulo.'_nowestado');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdestacada');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowambito');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
			$parcial="";
			$this->cajaBsq = "";
			$this->desdeBsq = '';
			$this->hastaBsq = '';
			$this->destacadaBsq = '';
			$this->ambitoBsq = '';
			$this->estadoBsq = '';
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