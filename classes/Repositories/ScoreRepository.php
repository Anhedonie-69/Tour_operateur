<?php

class ScoreRepository
{
    private PDO $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getScoresByTourOperatorId($id)
    {
        $request = $this->db->prepare('
            SELECT s.*, a.name AS author_name
            FROM score s
            JOIN author a ON s.author_id = a.id
            WHERE s.tour_operator_id = ?
        ');
        $request->execute([$id]);

        $results = $request->fetchAll();

        $scores = [];

        foreach ($results as $row) {
            $scores[] = ScoreMapper::mapToObject($row);
        }

        return $scores;
    }

    public function createScore($value, $toId, $authorId)
    {
        $request = $this->db->prepare('
            INSERT INTO score (value, tour_operator_id, author_id)
            VALUES (:value, :tour_operator_id, :author_id)
        ');
        $request->execute([
            'value' => $value,
            'tour_operator_id' => $toId,
            'author_id' => $authorId
        ]);
    }
}

?>