<?php

class DestinationRepository
{
    private PDO $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getDestinationById($id)
    {
        $request = $this->db->prepare('
            SELECT * FROM destination
            WHERE id = ?
        ');
        $request->execute([$id]);

        $result = $request->fetch();

        $destination = DestinationMapper::mapToObject($result);

        return $destination;
    }

    public function getDestinationsByName($name)
    {
        $request = $this->db->prepare('
            SELECT * FROM destination
            WHERE location = ?
        ');
        $request->execute([$name]);

        $results = $request->fetchAll();

        $destinations = [];

        foreach($results as $row)
            {
                $destinations[] = DestinationMapper::mapToObject($row);
            }

        return $destinations;
    }

    public function getDestinationsByTourOperatoId($id)
    {
        $request = $this->db->prepare('
            SELECT * FROM destination
            WHERE tour_operator_id = ?
        ');
        $request->execute([$id]);

        $results = $request->fetchAll();

        $destinations = [];

        foreach($results as $row)
            {
                $destinations[] = DestinationMapper::mapToObject($row);
            }

        return $destinations;
    }

    public function getDestinations()
    {
        $request = $this->db->prepare('
            SELECT * FROM destination
        ');
        $request->execute();

        $results = $request->fetchAll();

        $destinations = [];

        foreach($results as $row)
            {
                $destinations[] = DestinationMapper::mapToObject($row);
            }

        return $destinations;
    }

    public function CreateDestination($location, $price, $toId)
    {
        $request = $this->db->prepare('
            INSERT INTO destination (location, price, tour_operator_id)
            VALUES (:location, :price, :tour_operator_id)
        ');
        $request->execute([
            'location' => $location,
            'price' => $price,
            'tour_operator_id' => $toId
        ]);
    }
}

?>