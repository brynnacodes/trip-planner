<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/City.php";
    require_once "src/Flight.php";

    $server = 'mysql:host=localhost:8889;dbname=trip_planner_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CityTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          City::deleteAll();
          Flight::deleteAll();
        }

        function testGetName()
        {
            //Arrange
            $name = "Portland";
            $id = null;
            $test_city = new City($name, $id);
            //Act
            $result = $test_city->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            //Arrange
            $name = "Portland";
            $id = null;
            $test_city = new City($name, $id);
            //Act
            $test_city->setName("San Francisco");
            $result = $test_city->getName();
            //Assert
            $this->assertEquals("San Francisco", $result);
        }

        function testGetId()
        {
            //Arrange
            $name = "Portland";
            $id = 2;
            $test_city = new City($name, $id);
            //Act
            $result = $test_city->getId();
            //Assert
            $this->assertEquals(2, $result);
        }

        function testSave()
        {
            //Arrange
            $name = "Portland";
            $id = 2;
            $test_city = new City($name, $id);
            $test_city->save();
            //Act
            $result = $test_city->getAll();
            //Assert
            $this->assertEquals($test_city, $result[0]);
        }

        function testUpdate()
        {
            //Arrange
            $name = "Portland";
            $id = 2;
            $test_city = new City($name, $id);
            $test_city->save();

            $new_name = "Seattle";
            //Act
            $test_city->update($new_name);
            //Assert
            $this->assertEquals("Seattle", $test_city->getName());
        }

        function testGetAll()
        {
            //Arrange
            $name = "Portland";
            $id = 2;
            $test_city = new City($name, $id);
            $test_city->save();

            $name2 = "San Francisco";
            $id2 = 4;
            $test_city2 = new City($name2, $id2);
            $test_city2->save();

            //Act
            $result = City::getAll();

            //Assert
            $this->assertEquals([$test_city, $test_city2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Portland";
            $id = 2;
            $test_city = new City($name, $id);
            $test_city->save();

            //Act
            City::deleteAll();
            $result = City::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

    }



?>
