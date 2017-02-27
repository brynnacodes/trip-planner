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
