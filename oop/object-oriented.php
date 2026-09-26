<?php 

class Fruit {
    public $name;
    public $color;

    public function __construct($name, $color)
    {
        $this -> name = $name;
        $this -> color = $color;
    }

    protected function intro() {
        echo "The fruit is " . $this -> name . " and the color is " . $this -> color;
    }

    function get_details(){
        echo "Name: ". $this -> name . ". Color: ". $this ->color . ".<br>";
    }

}

class Strawberry extends Fruit {
    public function message() {
        echo "Am i a fruit or a berry? ";
        $this -> intro();
    }
}

$strawberry = new Strawberry("Strawberry", "Red");
$strawberry -> message();



?>