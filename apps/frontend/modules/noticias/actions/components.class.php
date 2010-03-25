<?php
/**
 * noticias components.
 *
 * @package    extranet
 * @subpackage notificaciones
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class noticiasComponents extends sfComponents
{
	public function executeUltimas_noticias(sfWebRequest $request)
	{
		$rolTrue = UsuarioRol::getRepository()->getRoAndUsurio($this->getUser()->getAttribute('userId'), '(1,2)');
		if( count($rolTrue) >= 1)
		{
			$rol = 1;
		}
		else 
		{
			$rol = '';
		}
		
		$this->ultimas_noticias = NoticiaTable::getUltimasNoticias(5,$rol);
		
	}
}