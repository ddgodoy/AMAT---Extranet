<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Usuario extends BaseUsuario
{
	public static function getRepository()
	{
		return Doctrine::getTable(__CLASS__);
	}
	
	public function __toString()
	{
		return $this->nombre . ' ' . $this->apellido;
	}
	
	public function checkCredentials($password)
	{
		$salt = $this->getSalt();

		return ($this->getCryptedPassword() == $this->encrypt("--$salt--$password--"));
	}

	public function modifyCredentials($login, $password)
	{
		$timeNow = date(DATE_RFC822);
		$salt = $this->encrypt("--$timeNow--$login--");
		$this->setSalt($salt);
		$this->setLogin($login);
		$this->setCryptedPassword($this->encrypt("--$salt--$password--"));
	}

	public function rememberCredentials()
	{
		$numberDays = 7;
		$rememberTokenExpires = date('Y-m-d H:i:s', mktime(date("H"),date("i"),date("s"),date("m"),date("d")+$numberDays,date("Y")));

		$rememberToken = $this->encodeToken
		(
			serialize(array($rememberTokenExpires, $this->getId()))
		);

		$this->setRememberToken($rememberToken);
		$this->setRememberTokenExpires($rememberTokenExpires);
	}

	public function checkToken($token)
	{
		$values = unserialize(base64_decode($token));
		return ($this->getId() == $values[1]) &&
			($this->getRememberTokenExpires() > time());
	}

	public function forgetCredentials()
	{
		// Delete token expires of the database
		$this->setRememberToken(null);
		$this->setRememberTokenExpires(null);
	}

	private function encodeToken($token)
	{
		return base64_encode($token);
	}

	private function encrypt($data)
	{
		return sha1($data);
	}
	
	public function rolesDeUsuario()
	{
		return Doctrine::getTable('UsuarioRol')->getRolesByUser($this);
	}
	
	public function UsuariosdeMisGrupos()
	{	
		return Doctrine::getTable('GrupoTrabajo')->getUsuariosDeGrupos($this->getId());
	}
	public function UsuariosdeMisConsejos()
	{	
		return Doctrine::getTable('ConsejoTerritorial')->getUsuariosDeConsejo($this->getId());
	}
	public function UsuariosdeMisOrganismos()
	{	
		return Doctrine::getTable('Organismo')->getUsuariosDeOrganismos($this->getId());
	}
	
	public function getPermisos()
	{
		return Doctrine::getTable('Usuario')->getPermisosByUsuario($this->getId());
	}
	
	public static function datosUsuario($idUser)
	{
		$s=Doctrine_Query::create()
		->from('Usuario')
		->where('id ='.$idUser);
		$nombreusuario = $s->fetchOne();
		
		return $nombreusuario; 
	}
  
	public function getMenuUsuario()
	{		
		return MenuTable::getArrayMenuHijo(0, 0);
	}
	
	public static  function getArrayUsuarioDir()
	{
		$directore = UsuarioTable::getDirectoresGerntes();
		$arrayDirector = array();
		foreach ($directore AS $dir)
		{
			$arrayDirector[$dir->Usuario->getId()] = $dir->Usuario->getNombre().','.$dir->Usuario->getApellido();
		}
		
		return $arrayDirector;
	}

        public static function getArrayUsuario ()
        {
            $usuariosActivos= Usuario::getRepository()->getUsuariosActivos();

            $arrUsuarios = array();
	    foreach ($usuariosActivos as $r) {
	    $arrUsuarios[$r->getId()] = $r->getApellido().", ".$r->getNombre();
	    }

            return $arrUsuarios;
        }

}