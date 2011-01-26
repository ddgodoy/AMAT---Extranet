<?php 

class ServiceSecurity
{
	public static function authenticate($identifier, $password, $remember_me)
	{	
		if ($identifier != null) {
			$usuario = Usuario::getRepository()->getUsuarioByLogin($identifier);

			if ($usuario == null) {
				$usuario = Usuario::getRepository()->getUsuarioByEmail($identifier);
			}
		} else {
			return 'Ingresa tu nombre de usuario o tu email';
		}
		//
		if ($usuario == null) {
			return 'Usuario no encontrado';
		}
		//si el login del usuario existe y no esta eliminado inicializo la clase usuario
		$usuario = Usuario::getRepository()->findOneById($usuario->getId());

		if (!$usuario->checkCredentials($password)) {
			return 'Tus datos de Usuario son incorrectos';
		}
		if ($usuario->getActivo() == 0) { return 'Usuario no activo'; }
		if ($usuario->getDeleted() != 0) { return 'Usuario no encontrado'; }
		if (Agenda::getRepository()->setEventosForThisUser()) { return ''; }
		if ($remember_me) { $usuario->rememberCredentials(); }

		return $usuario;
	}
//
	public static function modifyCredentials($login, $password,$id)
	{
		$usuario = Usuario::getRepository()->findOneById($id);
		$usuario->modifyCredentials($login, $password);
		$usuario->save();
		
		return $usuario;
	}

} // end class