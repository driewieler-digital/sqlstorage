* Example

// set up storage object
$table = 'your_table';
$varnames = array();
$varnames[0] = 'var_1';      
$varnames[1] = 'var_2';      
$varnames[2] = 'var_3';      

$vars = array();

// create storage object for table
$store = new storage($table, $varnames);


* Methods

// install database table if it doesn't exist
$store->install();

// add one row of data to the table.
$store->add($vars);

// get one row where key equals value
$store->get($key, $value);

// get all rows where key equals value
$store->get_list($key, $value);

// change a row where key equals value
$store->change_row($vars, $key, $value);

$vars = array of variables corresponding to $varnames
