<?php
    class Car
    {
        private $make_model;
        private $price;
        private $miles;
        private $picture;

        function __construct($make_model, $price, $miles, $picture)
        {
            $this->make_model = $make_model;
            $this->price = $price;
            $this->miles = $miles;
            $this->picture = $picture;
        }

        function saveCar()
        {
            push_array($_SESSION['inventory'], $this);
        }

        function getCarDetail($fieldNo)
        {
            if ($fieldNo == 1) {
                return $this->make_model;
            } elseif ($fieldNo == 2) {
                return $this->price;
            } elseif ($fieldNo == 3) {
                return $this->miles;
            } else {
                return $this->picture;
            }
        }

        static function getInventory()
        {
            return $_SESSION['inventory'];
        }

        static function clearInventory()
        {
            $_SESSION['inventory'] = array();
        }

        function worthBuyingPrice($max_price)
       {
           return $this->price < ($max_price);
       }
       
       function worthBuyingMiles($max_miles)
       {
           return $this->miles < ($max_miles);
       }
    }

?>
