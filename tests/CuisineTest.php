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
        protected function tearDown()
        {
            Cuisine::deleteAll();
        }

        function test_getType()
        {
            //Arrange
            $type = "foodtype";
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
            $type = "foodtype";
            $id = 1;
            $test_cuisine = new Cuisine($type, $id);

            //Act
            $result = $test_cuisine->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Arrange
            $type = "foodtype";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);

            //Act
            $test_cuisine->setId(2);

            //Assert
            $result = $test_cuisine->getId();
            $this->assertEquals(2, $result);
        }

        function test_save()
        {
            //Arrange
            $type = "foodtype";
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
            $type = "foodtype";
            $id = null;
            $type2 = "foodtype2";
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

        function test_deleteAll()
        {
            //Arrange
            $type = "foodtype";
            $id = null;
            $type2 = "foodtype2";
            $id2 = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();
            $test_cuisine2 = new Cuisine($type2, $id2);
            $test_cuisine2->save();

            //Act
            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([], $result);

        }

        function test_findCuisine()
        {
            //Arrange
            $type = "foodtype";
            $id = 1;
            $type2 = "foodtype2";
            $id2 = 2;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();
            $test_cuisine2 = new Cuisine($type2, $id2);
            $test_cuisine2->save();

            //Act
            $result = Cuisine::findCuisine($test_cuisine->getId());

            //Assert
            $this->assertEquals($test_cuisine, $result);
        }

        function test_getRestaurants()
        {
            //Arrange
            $type = "foodtype";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $test_cuisine_id = $test_cuisine->getId();

            $name = "resname";
            $test_restaurant = new Restaurant($name, $id, $test_cuisine_id);
            $test_restaurant->save();

            $name2 = "resname2";
            $test_restaurant2 = new Restaurant($name2, $id, $test_cuisine_id);
            $test_restaurant2->save();

            //Act
            $result = $test_cuisine->getRestaurants();

            //Assert
            $this->assertEquals(['test_restaurant, $test_restaurant2'], $result);
        }
    }
?>
