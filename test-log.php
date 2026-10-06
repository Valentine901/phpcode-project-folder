<?php
require_once 'config.php';

// This variable doesn't exist, so it will break silently
echo $make_an_error; 

echo "Check your php_errors.log file now!";
