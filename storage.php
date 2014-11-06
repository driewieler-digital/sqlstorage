<?php

// Storage class. Handles installation, addition, and removal of data, to one table.

include_once ('./lib_db_manager.php');

class storage {

	// on construction, set the variable names and table name we use.
	function __construct($table, $varnames) {
		$this->table = $table;
		$this->varnames = $varnames;
		//echo 'Store constructed, for table '.$table.'<br>';

	}

	// install the table.
	function install() {
		// check if stuff exists, testing 1 2 3
		$dbm = new db_manager();

		$r = $dbm->table_exists($this->table);

		if ( $r ) { echo 'Table exists: '.$this->table.'<br>'; }
		else { echo 'Table does not exist, creating '.$this->table.'...<br>'; 
			$dbm->create_table($this->table);
		}

		$i = 0;
		$n = count($this->varnames);
		for ( $i=0; $i < $n; $i++ ) {
			$r = $dbm->column_exists($this->table, $this->varnames[$i]);

			if ( $r ) { echo 'Column exists: '.$this->varnames[$i].'<br>'; }
			else { echo 'Column does not exist, creating: '.$this->varnames[$i].'...<br>'; 
				$dbm->add_column($this->table, $this->varnames[$i]);
			}
		}
		echo 'Installation complete. You may want to adjust column attributes, like AUTO INC. ;-)';
	}

	// add one row of data to the table.
	function add($vars) {
		$dbm = new db_manager();
		$r = $dbm->add_row($this->table, $vars, $this->varnames);
		echo $r;
	}
	
	function get($key, $value) {
		$dbm = new db_manager();	
		$r = $dbm->get_row($this->table, $key, $value);	
		return $r;
	}
	function get_list($key, $value) {
		$dbm = new db_manager();	
		// set all to true
		$r = $dbm->get_row($this->table, $key, $value, true);	
		return $r;
	}	
	//	function change_row($table, $this->varnames, $varnames, $id, $value)
	function change_row($vars, $id, $value) {
		$dbm = new db_manager();	
		// set all to true
		$r = change_row($table, $vars, $this->varnames, $id, $value);
		return $r;
	}
}




?>
