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

}

?>