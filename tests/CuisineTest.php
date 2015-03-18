<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    require_once "src/Restaurant.php";

    $DB = new PDO('pgsql:host=localhost;dbname=food_test');

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        function test_getType()
        {
            //Arrange
            $type = "tuff";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);

            //Act
            $result = $test_cuisine->getType();

            //Assert
            $this->assertEquals($type, $result);
        }

        function test_getId()
        {
            //Arrange
            $type = "tuff";
            $id = 1;
            $test_cuisine = new Cuisine($type, $id);

            //Act
            $result = $test_cuisine->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_save()
        {
            //Arrange
            $type = "tuff";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals($test_cuisine, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $type = "tuff";
            $id = null;
            $type2 = "twuff";
            $id2 = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();
            $test_cuisine2 = new Cuisine($type2, $id2);
            $test_cuisine2->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([$test_cuisine, $test_cuisine2], $result);

        }







    }
?>
