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
    		$objCatAsunto = Doctrine::getTable('CategoriaAsunto')->find($form->getValue('tema'));

    		if($objCatAsunto->getActivo_1() == 1)
    		{
    		   $mailTema = $objCatAsunto->getEmail_1();
    		}
    		else 
    		{
                $mailTema = $objCatAsunto->getEmail_2();    		   	
    		}   
    		$nombreTema = $objCatAsunto->getNombre();
    		$usuario = $this->getUser()->getAttribute('nombre').' '.$this->getUser()->getAttribute('apellido');
    		$organismos = $this->getUser()->getAttribute('mutua');
    		 
				$mailer = new Swift(new Swift_Connection_NativeMail());
				$message = new Swift_Message('Contacto desde Extranet de Asociados AMAT');

				$mailContext = array(                   'usuario' => $usuario,
				                                        'organización' => $organismos,    
														'tema' => $nombreTema,
														'asunto' => $form->getValue('asunto')
														);
				$message->attach(new Swift_Message_Part($this->getPartial('contacto/mailHtmlBody', $mailContext), 'text/html'));
				$message->attach(new Swift_Message_Part($this->getPartial('contacto/mailTextBody', $mailContext), 'text/plain'));

				$mailer->send($message, $mailTema, sfConfig::get('app_default_from_email'));
				$mailer->disconnect();

				$this->getUser()->setFlash('notice', "El email ha sido enviado correctamente.<br />Nos comunicaremos con Ud. a la brevedad.");

				$this->redirect('contacto/index');
			}
			catch (Exception $e) {
				$mailer->disconnect();
				$this->mensajeError = 'No fue posible enviar su mensaje.<br />Por favor, intente m&aacute;s tarde.';
			}
    }
	}
}