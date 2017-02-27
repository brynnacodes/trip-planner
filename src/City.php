<?php
    class City {
        private $name;
        private $id;

        function __construct($name, $id)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $exec = $GLOBALS['DB']->prepare("INSERT INTO cities (name) VALUES (:name);");
            $exec->execute(['name' => $this->getName()]);
            $this->id = $GLOBALS['DB']->lastInsertId();
        }


        function update($new_name)
        {
            $exec = $GLOBALS['DB']->prepare("UPDATE cities SET name = :name WHERE id = :id;");
            $exec->execute([':name' => $new_name, ':id' => $this->getId()]);
            $this->setName($new_name);
        }

        function deleteCity()
        {
            $GLOBALS['DB']->exec("DELETE FROM cities WHERE id = {$this->getId()};");
        }

        function addFlight($flight)
        {
            $GLOBALS['DB']->exec("INSERT INTO flights_cities (flight_id, city_id) VALUES ({$this->getId()}, {$flight->getId()});");
        }

        function getFlights()
        {
            $query = $GLOBALS['DB']->query("SELECT flight_id FROM flights_cities WHERE city_id = {$this->getId()};");
            $flight_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $flights = [];
            foreach ($flight_ids as $id) {
                $flight_id = $id['flight_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM flights WHERE id = {$flight_id};");
                $returned_flight = $result->fetchAll(PDO::FETCH_ASSOC);

                $departure_time = $returned_flight[0]['departure_time'];
                $status = $returned_flight[0]['status'];
                $id = $returned_flight[0]['id'];
                $new_flight = new Flight($departure_time, $status, $id);
                array_push($flights, $new_flight);
            }
            return $flights;
        }

        static function find($id)
        {
            $found_city;
            $cities = City::getAll();
            foreach ($cities as $city) {
                if ($city->getId() == $id) {
                    $found_city = $city;
                }
            }
            return $found_city;
        }

        static function getAll()
        {
            $returned_cities = $GLOBALS['DB']->query("SELECT * FROM cities;");
            $cities = [];

            foreach($returned_cities as $city) {
                $name = $city['name'];
                $id = $city['id'];
                $new_city = new City($name, $id);
                array_push($cities, $new_city);
            }
            return $cities;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cities;");
        }

    }
?>
