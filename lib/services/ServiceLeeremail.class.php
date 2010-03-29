<?php 

/**
 * Compara los email enviados con los email error *
 * Autor: Mauro garcia
 * Fecha: 26/02/2010  
 * */


class ServiceLeeremail
{
   static protected $socket;
   static protected $connect; 
  	
 public static function saveLeeremails()
  {
	  $arraEnvios = array();
	  $arraEmailError = array();
	  
	  $envios = Envios::getRepository()->getAll();
	  if($envios->count()>0)
	  {
		  foreach ($envios as $e)
		  {
		  	 $id = $e->getId();
		     $arraEnvios[$id]['id'] = $e->getId();	
		     $arraEnvios[$id]['envio_id'] = $e->getEnvioId();	
		     $arraEnvios[$id]['usuario_id'] = $e->getUsuarioId();	
		     $arraEnvios[$id]['message_id'] = $e->getMessageId();	
		  }
		  
		  
		  $pop = self::pop3php('comunicados.extranet.amat.es','fD)yLt6)w@Xi');
		  
		  if ($pop) 
		  {
			  	$totla_email = self::get_total_msg();
			  			  	
			  	if($totla_email > 0)
			  	{	   
				  	for ($i=1;$i<=$totla_email;$i++)
				  	{
				  		
				  		$arraEmailError[$i]['id'] =	$i;
						$arraEmailError[$i]['Subject']   =	self::get_msg($i,'Subject').'<br>'.self::get_msgCuer($i);
						$arraEmailError[$i]['MessageID'] =	self::get_msg($i,'Message-ID');  			
				  	}
				  	
			  	}  	
		  }  		 
		   
		   if(count($arraEmailError)>0)
		   {
		   	
		   	 foreach ($arraEnvios AS $ae )
		  		{
		  			
		  			foreach ($arraEmailError as $aer)
		  			{		  					
		  				if($ae['message_id'] === htmlspecialchars_decode($aer['MessageID']))
		  				{
		  					
		  					if(EnvioError::saveEnvioerror($ae['envio_id'], $ae['usuario_id'], $aer['Subject']))
		  					{
		  						$delete = Envios::getRepository()->getDeleteById($ae['id']);
		  						
		  						self::delete_msg($aer['id']);
		  						
		  					}
	
		  				}
		 	
		  			}
		  			
		  			
				  	
		  		} 	
		  	   		   	
		     }
		 self::pop3_quit();  		   
	  }   
   }

 protected static function pop3php($username, $password)
    {
        self::pop3_connect();

        if(self::$socket)
        {    
            $username = $username;
            if(self::validate_user($username))
            {
                if(self::validate_pass($password))
                {
                    self::$connect = 1;
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

 protected static  function pop3_connect()
    {
        //$this->socket = fsockopen("10.100.101.119", "110");
        self::$socket = fsockopen("217.116.20.132", "110");
            
        if(!self::$socket)
        {
            echo "Socket connection fail<br/>";
            exit();
        }
        else
        {
            $line = self::pop3_reply();
            $status = self::is_ok($line);

            if(!$status)
            {
                fclose(self::$socket);
                self::$socket = -1;
                echo "Socket connection fail<br/>";
                exit();
            }
        }
    }
 
 protected static  function pop3_command($command)
    {
        fputs(self::$socket, $command);

        $line = self::pop3_reply();

        return $line;
    }

 protected static  function pop3_reply()
    {
        $line = fgets(self::$socket, 1024);

        return $line;
    }

 protected static function is_ok($cmd)
    {	
        $status = substr($cmd, 0, 1);

        if($status != "+")
        {
            return 0;
        }
        
        return 1;
    }

 protected static function validate_user($username)
    {
        $command = "USER ".$username."\r\n";
        $reply = self::pop3_command($command);
        $rtn = self::is_ok($reply);
        
        if(!$rtn)
        {
            fclose(self::$socket);
            self::$socket = -1;
        }
        
        return $rtn;
    }

 protected static function validate_pass($password)
    {
        $command = "PASS ".$password."\r\n";
        $reply = self::pop3_command($command);
        $rcc = self::is_ok($reply);
        
        if(!$rcc)
        {
            fclose(self::$socket);
            self::$socket = -1;
        }
    
        return $rcc;
    }

 protected static function is_connect()
    {
        return self::$connect;
    }

 protected static function get_total_msg()
    {
        $reply = self::pop3_command("STAT\r\n");

        $mail = explode(" ", $reply);
        $total = $mail[1];

        return $total;
    }

 protected static function get_msg($msgNum,$etiqueta)
    {	
        $command = "RETR ".$msgNum."\r\n";
        $reply = self::pop3_command($command);
        $rtn = self::is_ok($reply);
 
        if($rtn)
        {
        	$subject = '';
            $count = 0;
            $header = array();

            while(!ereg("^\.\r\n", $reply))
            {
                $reply = self::pop3_reply();
                $header[$count] = $reply;
                $count++;
            }	
            
            while(list($lineNum, $line) = each($header))
            {	
                if(eregi("^$etiqueta:(.*)", $line, $match))
                {
                    if($etiqueta=='Subject')
                    {
                    	$subject .=trim($match[1]).'  ';
	                    $subject = htmlspecialchars($subject);        				
                    }
                	else 
                	{
	                    $subject = trim($match[1]);
	                    $subject = htmlspecialchars($subject);
                	}    
                }
            }
            if($subject=='')
            {
                $subject = "None";
            }
        }
        
    
        return $subject;
    }
    
  protected  static  function get_msgCuer($msgNum)
    {
    	$temp = '';
        $command = "RETR ".$msgNum."\r\n";
        $reply = self::pop3_command($command);
        $rtn = self::is_ok($reply);

        if($rtn)
        {
            $count = 0;
            $msg = array();
            $temp = '';

            while(!ereg("^\.\r\n", $reply))
            {
                $reply = self::pop3_reply();
                if($count >= 39 && $count <= 49 )
                {
	                $temp .= $reply.'<br>';
                }    
	             $count++;
	                
            }
        }
        return $temp;
    }      
    
    
 protected static function delete_msg($msgNum)
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
            $reply = self::pop3_command($command);
            $status = self::is_ok($reply);

            if(!$status)
            {
                fclose(self::$socket);
                self::$socket = -1;
                $sessid = session_id();
                echo "$sessid";
                exit();
            }
        }
    }

 protected static function pop3_quit()
    {
        $reply = self::pop3_command("QUIT\r\n");
        $rtn = self::is_ok($reply);

        if($rtn)
        {
            fclose(self::$socket);
            self::$socket = -1;
        }
    } 
   	
}