<?php

    $DB = new PDO('pgsql:host=localhost;dbname=food_test');

    class Restaurant
    {
        private $name;
        private $cuisine_id;
        private $id;

        function __construct($name, $id = null, $cuisine_id)
        {
            $this->name = $name;
            $this->cuisine = $cuisine_id;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function setCuisineId($new_cuisine_id);
        {
            $this->cuisine_id = (int) $new_cuisine_id;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO restaurants (name, cuisine_id) VALUES ('{$this->getName()}', {$this->getCuisineId()}) RETURN id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }
    }
?>
