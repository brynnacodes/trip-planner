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

    class FlightTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          City::deleteAll();
          Flight::deleteAll();
        }

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
            $this->assertEquals(2, $result);
        }

        function testSave()
        {
            //Arrange
            $departure_time = "1:30";
            $status = "on time";
            $id = 2;
            $test_flight = new Flight($departure_time, $status, $id);
            $test_flight->save();

            //Act
            $result = Flight::getAll();

            //Assert
            $this->assertEquals($test_flight, $result[0]);
        }

        function testUpdateDepartureTime()
        {
            //Arrange
            $departure_time = "1:30";
            $status = "on time";
            $id = 2;
            $test_flight = new Flight($departure_time, $status, $id);
            $test_flight->save();

            $new_departure_time = "1:50";

            //Act
            $test_flight->updateDepartureTime($new_departure_time);

            //Assert
            $this->assertEquals("1:50", $test_flight->getDepartureTime());

        }

        function testUpdateStatus()
        {
            //Arrange
            $departure_time = "1:30";
            $status = "on time";
            $id = 2;
            $test_flight = new Flight($departure_time, $status, $id);
            $test_flight->save();

            $new_status = "late";

            //Act
            $test_flight->updateStatus($new_status);

            //Assert
            $this->assertEquals("late", $test_flight->getStatus());

        }



        function testGetAll()
        {
            //Arrange
            $departure_time = "1:30";
            $status = "on time";
            $id = 2;
            $test_flight = new Flight($departure_time, $status, $id);
            $test_flight->save();

            $departure_time2 = "5:30";
            $status2 = "late";
            $id2 = 4;
            $test_flight2 = new Flight($departure_time, $status, $id);
            $test_flight2->save();


            //Act
            $result = Flight::getAll();

            //Assert
            $this->assertEquals([$test_flight, $test_flight2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $departure_time = "1:30";
            $status = "on time";
            $id = 2;
            $test_flight = new Flight($departure_time, $status, $id);
            $test_flight->save();

            //Act
            Flight::deleteAll();
            $result = Flight::getAll();

            //Assert
            $this->assertEquals([], $result);
        }
    }
?>
