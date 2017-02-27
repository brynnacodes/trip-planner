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

        function find($id)
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

        function update($new_name)
        {
            $exec = $GLOBALS['DB']->prepare("UPDATE cities SET name = :name WHERE id = :id;");
            $exec->execute([':name' => $new_name, ':id' => $this->getId()]);
            $this->setName($new_name);
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
