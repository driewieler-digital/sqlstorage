<?php

class sql_server
{
var $host = 	'172.16.52.13';
#var $host = '172.16.52.7';
var $user = 	'u1002498_dd';
var $pwd = 	'6MQK/u+8bv';
#var $pwd = 'F~CdE7mm]w~(3';
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
			$mysqli = new mysqli($host, $user, $password, $database);

			if ($mysqli->connect_errno) {
				echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			    	return false;
			}

			$res = $mysqli->query($query);
			/*if (!$res) {
				//echo "MySQL query error: ". $mysqli->errno . ", " . $mysqli->error;
				return $res;
			}*/

			if ( is_bool($res) ) { return $res; }
			$res->data_seek(0);

			# Als er een rij wordt teruggegeven als gevolg van een data query ipv 
			# een update/insert, stop die dan in een array en geef hem terug
			# Hierbij is de return array[]
			 if ( strncmp ("SELECT *", $query, 8) == 0 && $all == FALSE or strncmp ("select *", $query, 8) == 0 && $all == FALSE )
				{			
					$row = $res->fetch_row();

					return $row;
				}
			# Hierbij is de return array[][]
			else if ( strncmp ("SELECT", $query, 6) == 0 or strncmp ("select", $query, 6) == 0 || $all == TRUE )
				{			
					$i=0;
					while ( $row[$i] = $res->fetch_row() )
							{
								++$i;
							}
					return $row;
				}
			else
				{
					$row = $res->fetch_row();
					return $row;
				}
			return $res;

		}

} 



?>
