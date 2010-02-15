<?php 

class ServiceNotificacion
{
	/**
	 * Envía las notificaciones a los usuarios
	 *
	 * @param string $accion
	 * @param string $entidad
	 * @param integer $id
	 */
	public static function send($accion, $entidad, $id, $titulo,$DAtos='',$grupo='')
	{
		## Contenido de la notificación
		$contenidoNotificacion = ContenidoNotificacionTable::getOneByAccionAndEntidad($accion, $entidad);
		
		## Obtengo los usuarios y la url a la que se redireccionará
		
		$data = self::getData($accion, $entidad, $id, $DAtos ,$grupo);
		
		## Si la data es verdadera recorre los usuarios y les envía una notificación por la acción
		if($data) {
				
			foreach ($data['usuarios'] as $usuario) {
				   
				$notificacion = new Notificacion();
                if($DAtos=='')
                {
				$notificacion->setUsuarioId($usuario->getId());
                }
                else 
                {
                $notificacion->setUsuarioId($usuario->Usuario->getId());	
                }
				$notificacion->setEntidadId($id);
				$notificacion->setUrl($data['url']);
				$notificacion->setNombre($titulo);
				$notificacion->setContenidoNotificacionId($contenidoNotificacion->getId());
				$notificacion->setEstado('noleido');
				$notificacion->setVisto('0');

				$notificacion->save();
			}
		}
	}
	
	/**
	 * Método intermedio entre la data y el envío
	 *
	 * @param string $accion
	 * @param string $entidad
	 * @param integer $id
	 * @return unknown
	 */
	protected static function getData($accion, $entidad, $id, $DAtos='',$grupo='')
	{
		switch ($entidad) {
			case 'Evento': return self::entEvento($accion, $id); break;
			case 'Noticia': return self::entNoticia($accion, $id); break;
			case 'Asamblea': return self::entAsamblea($accion, $id, $DAtos); break;
			case 'Grupo': return self::entDocumentacion($accion, $id, $grupo); break;
			case 'Consejo': return self::entDocumentacionCon($accion, $id, $grupo); break;
			case 'Organismo': return self::entDocumentacionOrg($accion, $id, $grupo); break;
			default: return false;
		}
	}
	
	/**
	 * Método específico para los eventos
	 *
	 * @param string $accion
	 * @param integer $id
	 * @return data
	 */
	private static function entEvento($accion, $id)
	{
		$data = array();
		$data['url'] = 'eventos/show?id=' . $id;
		$data['usuarios'] = Doctrine::getTable('Usuario')->findAll();
		
		return $data;
	}
	
	
	/**
	 * Método específico para los noticias
	 *
	 * @param string $accion
	 * @param integer $id
	 * @return data
	 */
	private static function entNoticia($accion, $id)
	{
		$data = array();
		$data['url'] = 'noticias/show?id=' . $id;
		$data['usuarios'] = Doctrine::getTable('Usuario')->findAll();
		
		return $data;
	}
	
	
	/**
	 * Método específico para asamblea
	 *
	 * @param string $accion
	 * @param integer $id
	 * @return data
	 */
	private static function entAsamblea($accion, $id, $DAtos)
	{
		$asamblea = Doctrine::getTable('Asamblea')->find($id);
		
		$data = array();
		$data['url'] = 'asambleas/ver?id='.$id.'&'.$DAtos['get'];
		$data['usuarios'] = $DAtos['usuarios'];
		
		return $data;
	}
	
	
	/**
	 * Método específico para documenatcion
	 *
	 * @param string $accion
	 * @param integer $id
	 * @return data
	 */
	private static function entDocumentacion($accion, $id, $grupo)
	{   
				
		$data = array();
		$data['url'] = 'documentacion_grupos/show?id='.$id;
		$data['usuarios'] = UsuarioTable::getUsuariosByGrupoTrabajo($grupo);
		
		return $data;
	}
	
	/**
	 * Método específico para documenatcion_consejo
	 *
	 * @param string $accion
	 * @param integer $id
	 * @return data
	 */
	private static function entDocumentacionCon($accion, $id, $grupo)
	{   
				
		$data = array();
		$data['url'] = 'documentacion_consejos/show?id='.$id;
		$data['usuarios'] = UsuarioTable::getUsuariosByConsejoTerritorial($grupo);
		
		return $data;
	}
	
	/**
	 * Método específico para documenatcion_organismo
	 *
	 * @param string $accion
	 * @param integer $id
	 * @return data
	 */
	private static function entDocumentacionOrg($accion, $id, $grupo)
	{   
				
		$data = array();
		$data['url'] = 'documentacion_organismos/show?id='.$id;
		$data['usuarios'] = UsuarioTable::getUsuarioByOrganismo($grupo);
		
		return $data;
	}
	
	
	
	
}