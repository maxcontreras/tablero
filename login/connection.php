<?php
//include connection to data base
//$connection = new mysqli("localhost", "iieggob_pruebas", "pru3b4S", "iieggob_iiegpruebas");


$connection = new mysqli("localhost", "root", "iieg", "tablero"); 

if ($connection->connect_error) {
  trigger_error('Database connection failed: '  . $connection->connect_error, E_USER_ERROR);
}

?>