<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Noticia extends BaseNoticia
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
}