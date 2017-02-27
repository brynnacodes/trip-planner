<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/City.php";
    require_once "src/Flight.php";

    $server = 'mysql:host=localhost:8889;dbname=trip_planner';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CityTest extends PHPUnit_Framework_TestCase
    {
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
    }



?>
