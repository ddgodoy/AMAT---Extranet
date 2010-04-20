<?php
/**
 * seguridad actions.
 *
 * @package    extranet
 * @subpackage seguridad
 * @author     Matias Gentiletti
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class seguridadActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->forward('seguridad','login');
	}

	public function executeLogin(sfWebRequest $request)
	{
		if ($this->getUser()->getAttribute('userId')) {
			$this->redirect('inicio/index');
		}
		$this->form = new SeguridadForm();
	}
	
	public function executeSeguridad(sfWebRequest $request)
	{
		if ($this->getUser()->getAttribute('userId')) {
			$this->redirect('inicio/index');
		}
		$this->getUser()->setFlash('error', NULL); // fix sesion caducada init message

		$this->form = new SeguridadForm();

		$this->setTemplate('login');
	}
	
	public function executeLogout(sfWebRequest $request)
	{
		$this->getUser()->setAuthenticated(false);
		$this->getUser()->clearCredentials();

		$this->getUser()->getAttributeHolder()->remove('userId');
		$this->getUser()->getAttributeHolder()->remove('mutuaId');
		$this->getUser()->getAttributeHolder()->remove('nombre');
		$this->getUser()->getAttributeHolder()->remove('apellido');
		$this->getUser()->getAttributeHolder()->remove('permisos');
		$this->getUser()->getAttributeHolder()->remove('menu');

		$this->redirect('seguridad/login');
	}
	
	public function executeProcess(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new SeguridadForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('login');
	}
	
	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$this->form->bind($request->getParameter($this->form->getName()));

		if ($this->form->isValid()) {

			$usuario = ServiceSecurity::authenticate($this->form->getValue('login'), $this->form->getValue('password'), false);

			if(is_object($usuario)) {

				## Obtener perfiles (roles)
				$credenciales = array();
				$usuarioRoles = Doctrine::getTable('UsuarioRol')->findByUsuarioId($usuario->getId());

				if (count($usuarioRoles)>0)
				{
					foreach ($usuarioRoles as $rol) {
						$credenciales[] = $rol->getRol()->getCodigo();
					}
					## Autenticado
					$this->getUser()->setAuthenticated(true);
	
					## Datos del usuario
					$this->getUser()->setAttribute('userId'  , $usuario->getId());
					$this->getUser()->setAttribute('mutuaId' , $usuario->getMutuaId());
					$this->getUser()->setAttribute('mutua'   , $usuario->Mutua->getNombre());
					$this->getUser()->setAttribute('nombre'  , $usuario->getNombre());
					$this->getUser()->setAttribute('apellido', $usuario->getApellido());				
					$this->getUser()->setAttribute('permisos', $usuario->getPermisos());
					$this->getUser()->setAttribute('menu'    , $usuario->getMenuUsuario());

					## Crear credenciales
					foreach ($credenciales as $credencial) {
						$this->getUser()->addCredential($credencial);
					}
					$this->redirect('inicio/index');
				}
				else 
				{
					$this->getUser()->setFlash('error', 'Usuario sin perfiles');
					$this->redirect('seguridad/login');
				}
			} else if ($message = $usuario) {
				$this->getUser()->setFlash('error', $message);
			}
		}
	}

	public function executeRestringuido(sfWebRequest $request){}

	## Inicio acciones recordar clave
	public function executeNueva_clave(sfWebRequest $request)
	{
		if ($this->getUser()->getAttribute('userId')) {
			$this->redirect('inicio/index');
		}
		$this->form = new NuevaClaveForm();
	}

	public function executeEnviar_solicitud(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new NuevaClaveForm();
		$this->form->bind($request->getParameter($this->form->getName()));
		
		if ($this->form->isValid()) {
			$email = $this->form->getValue('email');
			$usuario = Doctrine::getTable('Usuario')->findOneByEmail($email);

			if (!empty($usuario)) {
				$userId = $usuario->getId();
				$userLogin = $usuario->getLogin();
				$userUniqKey = uniqid('');

				if ($this->envioMailSolicitud($email, $userLogin, $userUniqKey)) {
					$solicitud = new SolicitudClave();

					$solicitud->setUsuarioId($userId);
					$solicitud->setCodigo($userUniqKey);
					$solicitud->save();

					$this->solicitudEnviada = 1;
				} else {
					$this->renderErrorParticular = 'No fue posible enviar la solicitud.<br />Por favor, intente m&aacute;s tarde.';
				}
			} else {
				$this->renderErrorParticular = 'El email no se encuentra registrado en el sistema';
			}
		}
		$this->setTemplate('nueva_clave');
	}
	
	protected function envioMailSolicitud($to, $login, $key)
	{
		sfLoader::loadHelpers(array('Url', 'Tag', 'Asset'));

		$url = url_for('seguridad/establecer_clave', true).'?key='.$key;
		$iPh = image_path('/images/logo_email.jpg', true);

		$succes  = false;
		$mailer  = new Swift(new Swift_Connection_NativeMail());
		$message = new Swift_Message(sfConfig::get('app_default_name_project').' - Solicitud de Nueva Clave');
		$mailContext = array('login' => $login, 'url' => $url, 'head_image'=>$iPh);

		$message->attach(new Swift_Message_Part($this->getPartial('seguridad/mailHtmlBody', $mailContext), 'text/html'));
		$message->attach(new Swift_Message_Part($this->getPartial('seguridad/mailTextBody', $mailContext), 'text/plain'));

		if ($mailer->send($message, $to, sfConfig::get('app_default_from_email'))) {
			$succes = true;
		}
		$mailer->disconnect();

		return $succes;
	}

	public function executeEstablecer_clave(sfWebRequest $request)
	{
		$this->auxCodigo = $request->getParameter('key');

		if (empty($this->auxCodigo) || $this->getUser()->getAttribute('userId')) {
			$this->redirect('inicio/index');
		}
		$solicitud = Doctrine::getTable('SolicitudClave')->findOneByCodigo($this->auxCodigo);
		if (empty($solicitud)) {
			$this->redirect('inicio/index');
		}

		$this->form = new EstablecerClaveForm();
	}
	
	public function executeUpdate_clave(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->auxCodigo = $request->getParameter('key');

		$this->form = new EstablecerClaveForm();
		$this->form->bind($request->getParameter($this->form->getName()));

		if ($this->form->isValid()) {
			$solicitud = Doctrine::getTable('SolicitudClave')->findOneByCodigo($this->auxCodigo);

			if (empty($solicitud)) {
				$this->redirect('inicio/index');
			}
			$usuario = ServiceSecurity::modifyCredentials($solicitud->getUsuario()->getLogin(), $this->form->getValue('password'));
			$solicitud->delete();

			$this->cambioClaveExitoso = 1;
		}
		$this->setTemplate('establecer_clave');
	}
	## Fin acciones recordar clave
	
	public function executeError(sfWebRequest $request)
          {
              if (sfConfig::get('sf_logging_enabled'))
                {

                  $url = "https://". $_SERVER['SERVER_NAME'] . "/". $_SERVER['REQUEST_URI'];
                  $mensaje = date("F j, Y, g:i a").' - {sfError404Exception} Action "'.$url.'" does not exist.';

                  $this->logError404($mensaje);
                }
                $this->setLayout("layout");
          }
         function logError404($text)
          {
                  $fp = fopen(dirname(__FILE__)."/../../../../../log/error_404.txt","a");
                  fwrite($fp, $text.PHP_EOL);
                  fclose($fp);
                  return true;
          }
}