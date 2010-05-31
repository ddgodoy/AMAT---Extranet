<?php 

class ServiceAgenda
{
	public static function AgendaSave($fecha, $titluo, $organi='', $url, $evento= '', $convocatoria = '', $usuario, $publico = '')
	{		
		
		$registro = Agenda::getRepository()->getEventoByUsuario($evento,$convocatoria,$usuario);
		 if($registro->count() == 0)
		 {
                     if($publico == 0)
                       {
			$agenda = new Agenda();
			$agenda->setFecha($fecha);
			$agenda->setTitulo($titluo);
			$agenda->setOrganizador($organi);
			$agenda->setUrl($url);
			$agenda->setEventoId($evento);
                        $agenda->setPublico('0');
			$agenda->setConvocatoriaId($convocatoria);
			$agenda->setUsuarioId($usuario);
			
			$agenda->save();
                       }
                     else
                       {
			$agenda = new Agenda();
			$agenda->setFecha($fecha);
			$agenda->setTitulo($titluo);
			$agenda->setOrganizador($organi);
			$agenda->setUrl($url);
			$agenda->setEventoId($evento);
                        $agenda->setPublico('1');
			$agenda->setConvocatoriaId($convocatoria);
			$agenda->setUsuarioId('0');

			$agenda->save();
                       }

		 }


                
		return true;
		
	}
	
}