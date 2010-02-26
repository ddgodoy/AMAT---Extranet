<?php 

/**
 * Compara los email enviados con los email error *
 * @param string $accion
 * @param string $entidad
 * @param integer $id
 */


class ServiceLeeremail
{
	
 public static function saveLeeremails()
  {
	  $socket = '';
	  $connect = '';
	  $arraEnvios = array();
	  $arraEmailError = array();
	  
	  $envios = Envios::getRepository()->getAll();
	  if($envios->count()>0)
	  {
		  foreach ($envios as $e)
		  {
		  	 $id = $e->getId();
		     $arraEnvios[$id]['envio_id'] = $e->getEnvioId();	
		     $arraEnvios[$id]['usuario_id'] = $e->getUsuarioId();	
		     $arraEnvios[$id]['message_id'] = $e->getMessageId();	
		  }
		  
		  
		  $pop = $this->pop3php('info.intranet.amat.es','Th6ds2b7');
		  
		  if ($pop) 
		  {
			  	$totla_email = $this->get_total_msg();		  	
			  	if($totla_email > 0)
			  	{	   
				  	for ($i=1;$i<=$totla_email;$i++)
				  	{
				  		$arraEmailError[$i]['id'] =	$i;
						//$arraEmailError[$i]['To'] =	$this->get_msg($i,'To');
						$arraEmailError[$i]['Subject'] =	$this->get_msg($i,'Subject');
						$arraEmailError[$i]['MessageID'] =	$this->get_msg($i,'Message-ID');  			
				  	}
			  	}  	
			  		 
		   }
		   
		   if(count($arraEmailError)>0)
		   {
		   	 foreach ($arraEnvios AS $ae )
		  		{
		  			
		  			foreach ($arraEmailError as $aer)
		  			{ 			
		  				if($ae['message_id'] == $aer['MessageID'])
		  				{
		  					if(EnvioError::saveEnvioerror($ae['envio_id'], $ae['usuario_id'], $aer['Subject']))
		  					{
		  						$delete = Envios::getRepository()->findOneByMessageId($ae['message_id']);
		  						$delete->delete();
		  						
		  						$this->delete_msg($aer['id']);
		  						
		  					}
	
		  				}
		 	
		  			}   
				  	
		  		} 		   	
		   	
		   }
		 $this->pop3_quit();  		   
	  }   
   }

 protected  function pop3php($username, $password)
    {
        $this->pop3_connect();

        if($this->socket)
        {    
            $username = $username;
            if($this->validate_user($username))
            {
                if($this->validate_pass($password))
                {
                    $this->connect = 1;
                    return true;
                }
                else
                {
                    echo "pass fail";
                    exit();
                }
            }
            else
            {
                echo "user fail";
                exit();
            }
        }
    }

 protected function pop3_connect()
    {
        //$this->socket = fsockopen("10.100.101.119", "110");
        $this->socket = fsockopen("217.116.20.132", "110");
            
        if(!$this->socket)
        {
            echo "Socket connection fail<br/>";
            exit();
        }
        else
        {
            $line = $this->pop3_reply();
            $status = $this->is_ok($line);

            if(!$status)
            {
                fclose($this->socket);
                $this->socket = -1;
                echo "Socket connection fail<br/>";
                exit();
            }
        }
    }

 protected function pop3_command($command)
    {
        fputs($this->socket, $command);

        $line = $this->pop3_reply();

        return $line;
    }

 protected function pop3_reply()
    {
        $line = fgets($this->socket, 1024);

        return $line;
    }

 protected function is_ok($cmd)
    {	
        $status = substr($cmd, 0, 1);

        if($status != "+")
        {
            return 0;
        }
        
        return 1;
    }

 protected function validate_user($username)
    {
        $command = "USER ".$username."\r\n";
        $reply = $this->pop3_command($command);
        $rtn = $this->is_ok($reply);
        
        if(!$rtn)
        {
            fclose($this->socket);
            $this->socket = -1;
        }
        
        return $rtn;
    }

 protected function validate_pass($password)
    {
        $command = "PASS ".$password."\r\n";
        //    echo "$command<br/>";
        $reply = $this->pop3_command($command);
        $rcc = $this->is_ok($reply);
        
        if(!$rcc)
        {
            fclose($this->socket);
            $this->socket = -1;
        }
    
        return $rcc;
    }

 protected function is_connect()
    {
        return $this->connect;
    }

 protected function get_total_msg()
    {
        $reply = $this->pop3_command("STAT\r\n");

        $mail = explode(" ", $reply);
        $this->total = $mail[1];

        return $this->total;
    }

 protected function get_msg($msgNum,$etiqueta)
    {	
        $command = "RETR ".$msgNum."\r\n";
        $reply = $this->pop3_command($command);
        $rtn = $this->is_ok($reply);
 
        if($rtn)
        {
            $count = 0;
            $header = array();

            while(!ereg("^\.\r\n", $reply))
            {
                $reply = $this->pop3_reply();
                $header[$count] = $reply;
                $count++;
            }	
            
            while(list($lineNum, $line) = each($header))
            {	
                if(eregi("^$etiqueta:(.*)", $line, $match))
                {
                    $subject = trim($match[1]);
                    $subject = htmlspecialchars($subject);
                }
            }
            if(empty($subject))
            {
                $subject = "None";
            }
        }
    
        return $subject;
    }
    
 protected function delete_msg($msgNum)
    {
        if(empty($msgNum))
        {
            $sessid = session_id();
            echo "$sessid";
            exit();        
        }
        else
        {
            $command = "DELE ".$msgNum."\r\n";
            $reply = $this->pop3_command($command);
            $status = $this->is_ok($reply);

            if(!$status)
            {
                fclose($this->socket);
                $this->socket = -1;
                $sessid = session_id();
                echo "$sessid";
                exit();
            }
        }
    }

 protected function pop3_quit()
    {
        $reply = $this->pop3_command("QUIT\r\n");
        $rtn = $this->is_ok($reply);

        if($rtn)
        {
            fclose($this->socket);
            $this->socket = -1;
        }
    } 
   	
}