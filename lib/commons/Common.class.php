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
			
			if(!validate_action('publicar',$modulo) || !validate_action('modificar',$modulo) || !validate_action('baja',$modulo))
			{
				$q->Where("e.estado != 'publicado'");
			}
			else 
			{
			    $q->where("e.estado = 'guardado'");	
			}
			$q->andWhere("e.user_id_creador != ".$usuario);
		}
		else 
		{
			if(!validate_action('publicar',$modulo) || !validate_action('modificar',$modulo) || !validate_action('baja',$modulo))
			{
				$q->Where("estado != 'publicado'");
			}
			else 
			{
			    $q->where("estado = 'guardado'");	
			}
			$q->andWhere("user_id_creador != ".$usuario);
		}	
		if($filtro != '')
		{
		 $q->andWhere($filtro);	
		}
		
		return $q->execute();
	}

   public static function setOderBYAction($modulo,$sortType,$orderBy,$orden = '',$ordenes = '')
   {
       if ($orden!='') {
                $this->orderBy = $this->getRequestParameter('sort');
                $this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
                $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
        }else {
            if($ordenes!='')
            {
               $this->orderBYSql = $ordenes;
               $ordenacion = explode(' ', $this->orderBYSql);
               $this->orderBy = $ordenacion[0];
               $this->sortType = $ordenacion[1];
            }
            else
            {
                $this->orderBy = $orderBy;
                $this->sortType = $sortType;
                $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
            }

        }

        return $this->orderBYSql;
   }
}
?>