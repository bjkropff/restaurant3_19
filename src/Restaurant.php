<?php

    $DB = new PDO('pgsql:host=localhost;dbname=food');

    class Restaurant
    {
        private $name;
        private $location;
        private $id;
        private $cuisine_id;

        function __construct($name, $location, $id = null, $cuisine_id)
        {
            $this->name = $name;
            $this->location = $location;
            $this->id = $id;
            $this->cuisine_id = $cuisine_id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }
        function setLocation()
        {
            $this->location = (string) $new_location;
        }

        function getLocation()
        {
            return $this->location;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function getId()
        {
            return $this->id;
        }

        function setCuisineId($new_cuisine_id)
        {
            $this->cuisine_id = (int) $new_cuisine_id;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO restaurant (name, location, cuisine_id) VALUES ('{$this->getName()}', '{$this->getLocation()}', {$this->getCuisineId()}) RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query('SELECT * FROM restaurant;');

            $restaurants = array();
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $location = $restaurant['location'];
                $id = $restaurant['id'];
                $cuisine_id = $restaurant['cuisine_id'];
                $new_restaurant = new Restaurant($name, $location, $id, $cuisine_id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM restaurant *;');
        }

        static function findRestaurant($search_id)
        {
            $found_restaurant = null;
            $restaurants = Restaurant::getAll();
            foreach($restaurants as $restaurant) {
                $restaurant_id = $restaurant->getId();
                if ($restaurant_id == $search_id) {
                    $found_restaurant = $restaurant;
                }
            }
            return $found_restaurant;
        }
    }
?>
