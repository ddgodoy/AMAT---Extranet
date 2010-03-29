<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EnvioComunicado extends BaseEnvioComunicado
{
  	
	public function enviarMails()
	{
		$usuarios = Doctrine::getTable('EnvioComunicado')->getUsuariosDeListas($this->getId());	
		$contUsu = 0;
		$ListEmails="";	

		foreach ($usuarios as $usuario)
		{
			if ($usuario->getEmail())
			{ 				
				if ($this->envioMail($usuario->getEmail(), $this->getTipoComunicado()->getImagen(), $this->getComunicado()->getDetalle(), $this->getComunicado()->getNombre(),$this->getId(),$usuario->getId())) {  
					//echo "<br />email enviado a: ".$usuario;
				} else {
					//echo "<br />ERROR email: ".$usuario;
				}
				$ListEmails ="";
				$contUsu = 0;
			}			
		}
	}
	
	public static  function ReenviarMail($Id_Envio_comunicado, $Id_usuario)
	{
		$EnvioComunicado = Doctrine::getTable('EnvioComunicado')->find($Id_Envio_comunicado);	
		$Usuario = Usuario::getRepository()->find($Id_usuario);	

		if ($Usuario->getEmail()) {
			if (self::envioMail($Usuario->getEmail(), $EnvioComunicado->getTipoComunicado()->getImagen(), $EnvioComunicado->getComunicado()->getDetalle(), $EnvioComunicado->getComunicado()->getNombre(),$EnvioComunicado->getId(),$Usuario->getId()))
			{
				//echo "<br />email enviado a: ".$usuario;
			} else {
				//echo "<br />ERROR email: ".$usuario;
			}
			$ListEmails = "";
			$contUsu = 0;
		}
	}
	
	protected function envioMail($to, $header_image, $body, $titulo, $idenvio, $idusuario)
	{
		sfLoader::loadHelpers(array('Url', 'Tag', 'Asset'));
		$iPh = image_path('/images/mail_head.jpg', true);
		$cPh = public_path('uploads/tipo_comunicado/images/'.$header_image, true);

		$succes  = false;
		$mailer  = new Swift(new Swift_Connection_NativeMail());
		$message = new Swift_Message(sfConfig::get('app_default_name_project').' - '.$titulo);

		$mailContext = array('imagen' => $cPh,
												 'cuerpo' => $body,
										 		 'head_image' => $iPh
		);
		$message->attach(new Swift_Message_Part($this->getPartial('comunicados/mailHtmlBody', $mailContext), 'text/html'));
		$message->attach(new Swift_Message_Part($this->getPartial('comunicados/mailTextBody', $mailContext), 'text/plain'));

		if ($mailer->send($message, $to, sfConfig::get('app_default_from_email_comunicados'), $idenvio, $idusuario)) {	
			$succes = true;
		}
		$mailer->disconnect();

		return $succes;
	}
}