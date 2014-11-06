<?php

include_once ('./lib_sqli.php');

class db_manager
{

var $server;

	// intializes the server.
	function init()
		{
			$this->server = new sql_server();
		}

	// check if table exists, returns a boolean
	function table_exists($table)
		{
			$qu = 'SHOW TABLES LIKE "'.$table.'";';
			$this->init();
			$result = $this->server->query($qu);
			if ( $result[0] ) {
				echo $result[0];
				return true;
			}
			else { return false; }

		}

	// check if table column exists, returns a boolean
	function column_exists($table, $column)
		{
			$qu = 'SHOW COLUMNS FROM `'.$table.'` LIKE "'.$column.'";';
			$this->init();
			$result = $this->server->query($qu);
			if ( $result[0] ) {
				return true;
			}
			else { return false; }

		}

	// adds a table column with the name col, defaulting to a text of 100 chars. (extend when needed)
	function add_column($table, $col) 
		{

			$qu = 'ALTER TABLE '.$table.' ADD '.$col.' VARCHAR(100);';
			echo $qu;
			$this->init();
			$result = $this->server->query($qu);
			return $result;
		
		}

	// creates a table, with an auto_increment int called id.
	function create_table($table)
		{

			$qu = 'CREATE TABLE  '.$table.' ( `id` int(11) NOT NULL );';
			echo $qu;
			$this->init();
			$result = $this->server->query($qu);
			return $result;

		}
		

	// check which variables are strings and return a boolean array matching index.
	function check_sqlstrvars($vars)
		{

		$var_n = count($vars);
		$strvars = array();

		// first check which ones of the variables are strings.
		for ($q=0; $q<$var_n; ++$q)
			{
			  if ( is_string($vars[$q]) )
				{ $strvars[$q] = 1;}
			  else
				{ $strvars[$q] = 0;}
			}

		return $strvars;

		}

	// adds a row to a table consisting of vars.
	function add_row($table, $vars, $varnames)
		{

		$strvars = array();
		$strvars = $this->check_sqlstrvars($vars);

		$this->init();
			
		$qu ='insert into '.$table .'(';

		$var_n = count($vars);

		for ( $q=0; $q<$var_n-1; ++$q )
			{
			  $qu .= $varnames[$q].', ';
			}
		$qu .= $varnames[$q].') ';

		$qu .= 'values (';
		// add basic syntax for strings in the sql request.
		for ( $q=0; $q<$var_n-1; ++$q)
			{
			if ( $strvars[$q] == 0 )
				{ $qu .= $vars[$q].', '; }
			else
				{ $qu .= '"'.$vars[$q].'", '; }
			}
		// do the last one without a comma.
		if ( $strvars[$q] == 0 )
			{ $qu .= $vars[$q].') '; }
		else
			{ $qu .= '"'.$vars[$q].'");'; }

		$this->server->query($qu);
		//echo $qu;
		return $qu;

		}
	// as called somewhere:
	// $r = $dbm->get_row('offertes', 'id', $_GET['o_id']);
	// Gets one row. Nothing more. Packaging into specific variables is left to the calling
	// object.
	function get_row($table, $id, $value, $all=false)
		{
		$this->init();

		// check the strings. in this case there is only one, but the function accepts only arrays.
		$strvars = array($value);
		$strvars = $this->check_sqlstrvars($strvars);

		// if it's a string
		if ( $strvars[0] == 0 )
			{
			$qu = 'select * from '.$table.' where '.$id.'='.$value.';';
			}
		else
			{
			$qu = 'select * from '.$table.' where '.$id.'="'.$value.'";';
			}

		if ( $all ) {
			$r = $this->server->query($qu, true);		
		}
		else {	
			$r = $this->server->query($qu);
		}

		return $r;
	
		}
		

	// changes a row.
	// vars = variable values, varnames = names of variables, id = id of the row
	// aaaand value = value of id.
	function change_row($table, $vars, $varnames, $id, $value)
		{

		// first recognize the strings for what they are
		$strvars = array();
		$strvars = $this->check_sqlstrvars($vars);

		$this->init();
			
		$qu ='update '.$table .' set ';

		$var_n = count($vars);

		// add basic syntax for strings in the sql request.
		for ( $q=0; $q<$var_n-1; ++$q)
			{
			if ( $strvars[$q] == 0 )
				{ $qu .= '`'.$varnames[$q].'`='. $vars[$q].', '; }
			else
				{ $qu .= '`'.$varnames[$q].'`="'. $vars[$q].'", '; }
			}
		// do the last one without a comma.
		if ( $strvars[$q] == 0 )
			{ $qu .= '`'.$varnames[$q].'`='. $vars[$q].' '; }
		else
			{ $qu .= '`'.$varnames[$q].'`="'. $vars[$q].'" '; }

		// check the value for being a string or not too. it's one value but function accepts 			array.
		$strvars = array($value);
		$strvars = $this->check_sqlstrvars($strvars);

		if ( $strvars[0] == 0 )
		{ $qu .= 'where '.$id.'='.$value.';'; }
		else
		{ $qu .= 'where '.$id.'="'.$value.'";'; }
		//echo $qu;

		$this->server->query($qu);

		return $qu;


		}

	function get_max($something, $table)
		{

		$this->init();
			
		$qu ='select max('.$something.') from '.$table.';';
		$r = $this->server->query($qu);
		$n = $r[0][0];
		return $n;

		}

	function get_min($something, $table)
		{

		$this->init();
			
		$qu ='select max('.$something.') from '.$table.';';
		$r = $this->server->query($qu);
		$n = $r[0][0];
		return $n;

		}

}
