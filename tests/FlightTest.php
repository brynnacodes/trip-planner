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

    class FlightTest extends PHPUnit_Framework_TestCase
    {
        function testGetDepartureTime()
        {
        //Arrange
        $departure_time = "1:30";
        $status = "on time";
        $id = null;
        $test_flight = new Flight($departure_time, $status, $id);

        //Act
        $result = $test_flight->getDepartureTime();

        //Assert
        $this->assertEquals($departure_time, $result);
        }

        function testSetDepartureTime()
        {
            //Arrange
            $departure_time = "1:30";
            $status = "on time";
            $id = null;
            $test_flight = new Flight($departure_time, $status, $id);

            //Act
            $test_flight->setDepartureTime("3:45");
            $result = $test_flight->getDepartureTime();

            //Assert
            $this->assertEquals("3:45", $result);
        }

        function testGetId()
        {
            //Arrange
            $departure_time = "1:30";
            $status = "on time";
            $id = 2;
            $test_flight = new Flight($departure_time, $status, $id);

            //Act
            $result = $test_flight->getId();

            //Assert
            $this->assertEquals($id, $result);
        }
    }
?>
