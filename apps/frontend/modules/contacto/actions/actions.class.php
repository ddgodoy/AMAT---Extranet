<?php
/**
 * contacto actions.
 *
 * @package    extranet
 * @subpackage contacto
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class contactoActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->form = new ContactoForm();
	}

	public function executeProcess(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new ContactoForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()));

		if ($form->isValid()) {
			try {
				sfLoader::loadHelpers(array('Tag', 'Asset'));
				$iPh = image_path('/images/Logo_AMAT.jpg', true);

				$objCatAsunto = Doctrine::getTable('CategoriaAsunto')->find($form->getValue('tema'));
				$mailTema   = $objCatAsunto->getActivo_1() == 1 ? $objCatAsunto->getEmail_1() : $objCatAsunto->getEmail_2();
				$usuario    = $this->getUser()->getAttribute('apellido').', '.$this->getUser()->getAttribute('nombre');
				$organismos = $this->getUser()->getAttribute('mutua');

				$mailer = new Swift(new Swift_Connection_NativeMail());
				$message = new Swift_Message('Contacto desde Extranet de Asociados AMAT');

				$mailContext = array('usuario' => $usuario,
														 'tema'    => $objCatAsunto->getNombre(),
														 'asunto'  => $form->getValue('asunto'),
														 'organizacion' => $organismos,
														 'head_image' => $iPh,
				);
				$message->attach(new Swift_Message_Part($this->getPartial('contacto/mailHtmlBody', $mailContext), 'text/html'));
				$message->attach(new Swift_Message_Part($this->getPartial('contacto/mailTextBody', $mailContext), 'text/plain'));

				$mailer->send($message, $mailTema, sfConfig::get('app_default_from_email'));
				$mailer->disconnect();

				$this->getUser()->setFlash('notice', "El correo ha sido enviado correctamente.<br />Nos pondremos en contacto con usted lo antes posible.");

				$this->redirect('contacto/index');
			} catch (Exception $e) {
				$mailer->disconnect();
				$this->mensajeError = 'No fue posible enviar su mensaje.<br />Por favor, intente m&aacute;s tarde.';
			}
		}
	}
}