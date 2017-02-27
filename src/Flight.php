<?php
    class Flight
    {
        private $departure_time;
        private $status;
        private $id;

        function __construct($departure_time, $status, $id = null)
        {
            $this->departure_time = $departure_time;
            $this->status = $status;
            $this->id = $id;
        }

        function setDepartureTime($new_departure_time)
        {
            $this->departure_time = $new_departure_time;
        }

        function getDepartureTime()
        {
            return $this->departure_time;
        }

        function setStatus($new_status)
        {
            $this->status = $new_status;
        }

        function getStatus()
        {
            return $this->status;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $exec = $GLOBALS['DB']->prepare("INSERT INTO flights (departure_time, status) VALUES (:departure_time, :status);");
            $exec->execute([':departure_time' => $this->getDepartureTime(), ':status' => $this->getStatus()]);
            $this->id = $GLOBALS['DB']->lastInsertId();
        }


        function updateStatus($new_status)
        {
            $exec = $GLOBALS['DB']->prepare("UPDATE flights SET status = :status WHERE id = :id;");
            $exec->execute([':status' => $new_status, ':id' => $this->getId()]);
            $this->setStatus($new_status);
        }

        function updateDepartureTime($new_departure_time)
        {
            $exec = $GLOBALS['DB']->prepare("UPDATE flights SET departure_time = :departure_time WHERE id = :id;");
            $exec->execute([':departure_time' => $new_departure_time, ':id' => $this->getId()]);
            $this->setDepartureTime($new_departure_time);
        }

        function deleteFlight()
        {
            $GLOBALS["DB"]->exec("DELETE FROM flights WHERE id = {$this->getId()};");
        }

        static function find($id)
        {
            $found_flight;
            $flights = Flight::getAll();
            foreach ($flights as $flight) {
                if ($flight->getId() == $id) {
                    $found_flight = $flight;
                }
            }
            return $found_flight;
        }

        function addCity($city)
        {
            $GLOBALS['DB']->exec("INSERT INTO flights_cities (flight_id, city_id) VALUES ({$this->getId()}, {$city->getId()});");
        }

        function getCities()
        {
            $query = $GLOBALS['DB']->query("SELECT city_id FROM flights_cities WHERE flight_id = {$this->getId()};");
            $city_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $cities = [];
            foreach ($city_ids as $id) {
                $city_id = $id['city_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM cities WHERE id = {$city_id};");
                $returned_city = $result->fetchAll(PDO::FETCH_ASSOC);

                $name = $returned_city[0]['name'];
                $id = $returned_city[0]['id'];
                $new_city = new City($name, $id);
                array_push($cities, $new_city);
            }
            return $cities;
        }

        static function getAll()
        {
            $returned_flights = $GLOBALS['DB']->query("SELECT * FROM flights;");
            $flights = [];
            foreach($returned_flights as $flight) {
                $departure_time = $flight['departure_time'];
                $status = $flight['status'];
                $id = $flight['id'];
                $new_flight = new Flight($departure_time, $status, $id);
                array_push($flights, $new_flight);
            }
            return $flights;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM flights");
        }
    }

?>
