<?php 

class ServiceAgenda
{
	public static function AgendaSave($fecha, $titluo, $organi='', $url, $evento= '', $convocatoria = '', $usuario)
	{		
		
		$registro = Agenda::getRepository()->getEventoByUsuario($evento,$convocatoria,$usuario);
		 if($registro->count() == 0)
		 {	
			$agenda = new Agenda();
			$agenda->setFecha($fecha);
			$agenda->setTitulo($titluo);
			$agenda->setOrganizador($organi);
			$agenda->setUrl($url);
			$agenda->setEventoId($evento);
			$agenda->setConvocatoriaId($convocatoria);
			$agenda->setUsuarioId($usuario);
			
			$agenda->save();
		 }	
		
		return true;
		
	}
	
}