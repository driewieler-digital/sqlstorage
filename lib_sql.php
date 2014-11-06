<?php

class sql_server
{



var $host = 	'172.16.52.13';
var $user = 	'u1002498_dd';
var $pwd = 	'6MQK/u+8bv';
var $db = 	'db1002498_dd1';
	// initializes server object, sets data used to create connection.
	function init($host, $user, $pwd, $db) 
		{ 
			$this->path = 	$new_path;  
			$this->host = 	$host;
			$this->user = 	$user;
			$this->pwd  = 	$pwd;
			$this->db =	$db;	
	 	}

	// sends a query to server.
  	function query($query, $all = FALSE)
		{

			$database = $this->db;
			$host = $this->host;
			$user = $this->user;
			$password = $this->pwd;

			if (!$connection = mysql_connect($host,$user,$password))
			      {
				  $message = mysql_error();
				  echo "$message<br>";
				  return $message;
//				  die();
			      }


			 mysql_select_db($database, $connection);
			 $result = mysql_query($query);

			if ( is_bool($result) ) { return $result; }

			# Als er een rij wordt teruggegeven als gevolg van een data query ipv 
			# een update/insert, stop die dan in een array en geef hem terug
			# Hierbij is de return array[]
			 if ( strncmp ("SELECT *", $query, 8) == 0 && $all == FALSE or strncmp ("select *", $query, 8) == 0 && $all == FALSE )
				{			
					$row = mysql_fetch_array($result);
					return $row;
				}
			# Hierbij is de return array[][]
			else  if ( strncmp ("SELECT", $query, 6) == 0 or strncmp ("select", $query, 6) == 0 || $all == TRUE )
				{			
					$i=0;
					while ( $row[$i] = mysql_fetch_array($result) )
							{
								++$i;
							}
					return $row;
				}
			else
				{
					$row = mysql_fetch_array($result);
					return $row;
					//return mysql_error();
				}
			return $result;

		}

} 



?>
