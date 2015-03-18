<?php

    $DB = new PDO('pgsql:host=localhost;dbname=food_test');

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
            foreach ($returned_cuisine as $cuisine){
                $type = $cuisine['type'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine($type, $id);
                array_push($cuisine, $new_cuisine);
            }
            return $cuisine;
        }

        
    }

?>
