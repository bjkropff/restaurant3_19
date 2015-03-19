<?php

    $DB = new PDO('pgsql:host=localhost;dbname=food');

    class Cuisine
    {
        private $type;
        private $id;

        function __construct($type, $id = null)
        {
            $this->type = $type;
            $this->id = $id;
        }

        function getType()
        {
            return $this->type;
        }

        function setType($new_type)
        {
            $this->type = (string) $new_type;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function save()
        {
            $statement = $GLOBALS ['DB']->query("INSERT INTO cuisine (type) VALUES ('{$this->getType()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_cuisine = $GLOBALS['DB']->query("SELECT * FROM cuisine;");
            $cuisine = array();
            foreach ($returned_cuisine as $current_cuisine){
                $type = $current_cuisine['type'];
                $id = $current_cuisine['id'];
                $new_cuisine = new Cuisine($type, $id);
                array_push($cuisine, $new_cuisine);
            }
            return $cuisine;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM cuisine *;');
        }

        static function findCuisine($search_id)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach($cuisines as $cuisine){
                $cuisine_id = $cuisine->getId();
                if($cuisine_id == $search_id){
                    $found_cuisine = $cuisine;
                }
            }
            return $found_cuisine;
        }

        function getRestaurants()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant WHERE cuisine_id = {$this->getId()};");
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

        function update($new_type)
        {
            $GLOBALS['DB']->exec("UPDATE cuisine SET type = '{$new_type}' WHERE id = {$this->getId()}");
            $this->setType($new_type);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisine WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM restaurant WHERE cuisine_id = {$this->getId()}");
        }

    }
?>
