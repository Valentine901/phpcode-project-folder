<?php 

// catch every single mistake
error_reporting(E_ALL);

// hide errors from browser screen
ini_set("display_errors", 0);
ini_set("display_startup_errors", 0);

// turn on logging 
ini_set("log_errors", 1);

// automatically find my window path and log the error there.
ini_set("error_log", __DIR__ . "/php_errors.log");


?>