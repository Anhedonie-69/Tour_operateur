<?php

class TourOperatorRepository
{
    private PDO $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getTourOperatorById($id)
    {
        $request = $this->db->prepare('
            SELECT * FROM tour_operator
            WHERE id = ?
        ');
        $request->execute([$id]);

        $result = $request->fetch();

        $TO = TourOperatorMapper::mapToObject($result);

        return $TO;
    }

    public function getTourOperatorsByDestinationName($name)
    {
        $request = $this->db->prepare('
            SELECT * FROM destination d
            JOIN tour_operator t 
                ON d.tour_operator_id = t.id
            WHERE d.location = ?
        ');

        $request->execute([$name]);

        $results = $request->fetchAll();

        return $results;
    }

    public function getAll()
    {
        $request = $this->db->prepare('
            SELECT * FROM tour_operator
        ');
        $request->execute();

        $results = $request->fetchAll();

        $allTo = [];

        foreach($results as $row)
        {
            $allTo[] = TourOperatorMapper::mapToObject($row);
        }

        return $allTo;

    }

    public function createTourOperator($name, $link)
    {
        $request = $this->db->prepare('
            INSERT INTO tour_operator (name, link)
            VALUES (:name, :link)
        ');
        $request->execute([
            'name' => $name,
            'link' => $link
        ]);
    }

}

?>