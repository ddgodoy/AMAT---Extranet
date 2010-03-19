<?php

/**
 * notificaciones components.
 *
 * @package    extranet
 * @subpackage notificaciones
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class notificacionesComponents extends sfComponents
{
	public function executeUltimos_avisos(sfWebRequest $request)
	{   
		$evento = EventoTable::getEventosCaducos();
		
		if(isset($evento))
		{
			foreach ($evento AS $e)
			{
				$avisos = NotificacionTable::getDeleteEntidad2($e->getId(),$e->getTitulo());
			}
		}	
		
		$noticias = NoticiaTable::getNoticiasCaducas();
		if(isset($noticias))
		{
			foreach ($noticias AS $n)
			{
				$avisos = NotificacionTable::getDeleteEntidad2($n->getId(),$n->getTitulo());
			}
		}
		
		$this->ultimos_avisos = Doctrine::getTable('Notificacion')->getUltimasNotificaciones($this->getUser()->getAttribute('userId'), 5);
	}
}
