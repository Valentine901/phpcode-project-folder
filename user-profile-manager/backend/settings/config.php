<?php 

$envFile = __DIR__ . "/../.env";
$env = parse_ini_file($envFile);

if($env === false) {
    die("Failed to load environment configuration");
}

class Constants{
    public $DB_HOST; 
    public $DB_NAME;
    public $DB_PASS;
    public $DB_USER ;
    public $JWT_SECRET;

    public function __construct($env){
        $this -> DB_HOST = $env["DB_HOST"];
        $this -> DB_NAME = $env["DB_NAME"];
        $this -> DB_USER = $env["DB_USER"];
        $this -> DB_PASS = $env["DB_PASS"];
        $this -> JWT_SECRET = $env["JWT_SECRET"];
    }

}

$constants = new Constants($env);


?>