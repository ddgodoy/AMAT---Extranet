<?php 

class ServiceSecurity
{
	public static function authenticate($identifier, $password, $remember_me)
	{	
		if ($identifier != null) {
			$usuario = Usuario::getRepository()->findOneByLogin($identifier);
			if ($usuario == null) {
				$usuario = Usuario::getRepository()->findOneByEmail($identifier);
			}
		} else {
			return 'Ingresa tu nombre de usuario o tu email';
			//throw new Exception("Ingresa tu nombre de usuario o tu email");
		}
		
		if ($usuario == null) {
			return 'Usuario no encontrado';
			//throw new Exception('Usuario no encontrado');
		}
		
		if (!$usuario->checkCredentials($password)) {
			return 'Tus datos de Usuario son incorrectos';
			//throw new Exception('Tus datos de logueo son incorrectos');
		}
		if($usuario->getActivo() == 0)
		{
            return 'Usuario no activo';			
		}
		if($usuario->getDeleted() != 0)
		{
            return 'Usuario no encontrado';			
		}
		if ($remember_me) {
			$usuario->rememberCredentials();
	    }
	    
		return $usuario;
	}
	
	/*
	public static function clearAuthentication($id)
	{
		if ($id != null) {
			$usuario = Usuario::getRepository()->findOneById($id);	
			if ($usuario) {
				$usuario->forgetCredentials();		
			}
		}
	}
	*/
	
	public static function modifyCredentials($login, $password,$id)
	{
                echo $login.'<br>'.$password;
		$usuario = Usuario::getRepository()->findOneById($id);
                echo '<pre>';
                print_r($usuario);
                echo '</pre>';
                exit ();
		$usuario->modifyCredentials($login, $password);
		$usuario->save();
		
		return $usuario;
	}
}