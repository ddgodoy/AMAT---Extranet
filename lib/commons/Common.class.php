<?php
/**
 * Funciones comunes.
 * Estas funciones se ejecutan así: Common::funcionEjemplo()
 */
class Common
{
	public static function makeCamelCalse($cadena = '')
	{
		$newCadena = '';
		$aPalabras = array();
		$separadores = array("-", "_");
		$cadena = trim($cadena);

		//reemplazar por espacios
		$cadena = str_replace($separadores, " ", $cadena);

		//obtener palabras entre espacios
		$aPalabras = explode(' ', $cadena); 

		//por cada palabra, si no esta vacia, poner primer caracter en mayusculas
		foreach ($aPalabras as $vPalabra) {
			if (!empty($vPalabra)) {$newCadena .= ucfirst($vPalabra);}
		}
		return $newCadena;
	}

	public static function parseCamelCase($string, $separador='_')
	{
	    return strtolower(preg_replace('/(?<=[a-z])(?=[A-Z])/', $separador, $string));
	}
	
	public static function array_in_array($needles, $haystack) 
	{

	    foreach ($needles as $needle) {
	
	        if ( key_exists($needle, $haystack) ) {
	            return true;
	        }
	    }
	
	    return false;
    }  
		
    public static function getListFechas($modulo)
	  {    
	  	    $FEcha_circulares = Circular::getRanfoDEfechas($modulo);
	  	    
	  	    return $FEcha_circulares;
	  }   
	  
	public static function getListCategoria($tabla)
	{
		$arrayCategoriasTema = CircularTable::doSelectAllCategorias($tabla);

		return $arrayCategoriasTema;
	}  
	
	public static  function getCantidaDEguardados($clase,$usuario, $filtro='',$modulo)
	{
		sfLoader::loadHelpers('Security');
		$q = Doctrine_Query::create()
		->from($clase);
		if($clase == 'Evento e')
		{
			$q->leftJoin('e.UsuarioEvento ue');
			$q->where("e.estado = 'guardado'");
			if(validate_action('publicar',$modulo) || validate_action('modificar',$modulo) || validate_action('baja',$modulo))
			{
				$q->orWhere("e.estado = 'pendiente'");
			}	
			$q->andWhere("e.user_id_creador != ".$usuario);
		}
		else 
		{
			$q->where("estado = 'guardado'");
			if(validate_action('publicar',$modulo) || validate_action('modificar',$modulo) || validate_action('baja',$modulo))
			{
				$q->orWhere("estado = 'pendiente'");
			}	
			$q->andWhere("user_id_creador != ".$usuario);
		}	
		if($filtro != '')
		{
		 $q->andWhere($filtro);	
		}
		
		return $q->execute();
	}
}
?>