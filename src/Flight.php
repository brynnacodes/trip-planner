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
    }

?>
