<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Evento extends BaseEvento
{
	public function __toString()
	{
		return $this->titulo;
	}
	
  public function save(Doctrine_Connection $conn = null)
  {        
  	
 								$request  = sfContext::getInstance()->getRequest();
                $stAction = $request->getParameter('action'); 	
                $userid = sfContext::getInstance()->getUser()->getAttribute('userId'); 	
                if ($this->isNew())
                {
                        $this->setUserIdCreador($userid);
                }
                else 
                {
                	      $this->setUserIdModificado($userid) ;
                	
                }
                if($stAction == 'publicar') 
                
                {
                	       $this->setUserIdPublicado($userid);
                	       $this->setFechaPublicado(date('Y-m-d H:i:s'));
                }
                                
                return parent::save($conn);
    }
    
    public static function getEventoCaducados()
    {
    	$arrayEventos = EventoTable::getEventosCaducos();
    	
    	$armado = '(';
    	
    	$rt = 0;

    	if (count($arrayEventos)) {
			foreach ( $arrayEventos AS $eventos ) {
				$rt++;
				if($rt != count($arrayEventos)) {
				  $armado .= "'".$eventos->getId()."',";
				} else {
				  $armado .= "'".$eventos->getId()."')";
				}
			}
    	}	
    	else
    	{
    		$armado = '';
    	}
    	 	
    	
    	return $armado;
    }
    
	
}