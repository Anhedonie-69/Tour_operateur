<?php

class Destination
{
    private $id;
    private $location;
    private $price;
    private $tourOperatorId;

    public function __construct($id, $location, $price, $tourOperatorId)
    {
        $this->id = $id;
        $this->location = $location;
        $this->price = $price;
        $this->tourOperatorId = $tourOperatorId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getOperatorId()
    {
        return $this->tourOperatorId;
    }
}

?>