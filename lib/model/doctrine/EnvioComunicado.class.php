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
				if ($this->envioMail($usuario->getEmail(), $this->getTipoComunicado()->getImagen(), $this->getComunicado()->getDetalle(), $this->getComunicado()->getNombre(),$this->getId(),$usuario->getId()))
				{  
					//echo "<br />email enviado a: ".$usuario;
				}
				else 
				{
					//echo "<br />ERROR email: ".$usuario;
				}
				
				$ListEmails ="";
				$contUsu = 0;
			}			
		}
		
	}
	
	protected function envioMail($to, $header_image, $body, $titulo,$idenvio,$idusuario)
	{
		$succes  = false;
		$mailer  = new Swift(new Swift_Connection_NativeMail());
		$message = new Swift_Message(sfConfig::get('app_default_name_project').' - '.$titulo);
		

		$message->attach(new Swift_Message_Part('
		<html>
			<head>
				<title>Comunicado</title>
			</head>
			<table>
				<tr>
					<td>
						<img src="http://www.intranet.amat.es/uploads/tipo_comunicado/images/'.$header_image.'">
					</td>
				</tr>
				<tr>
					<td>
						'.$body.'
					</td>
				</tr>
			</table>
		</html>
		', 'text/html'));
		
			
		if ($mailer->send($message, $to, sfConfig::get('app_default_from_email'),$idenvio, $idusuario)) {	
			$succes = true;
		}
		$mailer->disconnect();

		return $succes;
	}
	
}