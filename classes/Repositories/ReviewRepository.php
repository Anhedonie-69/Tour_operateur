<?php

class ReviewRepository
{
    private PDO $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getReviewsByTourOperatorId($id)
    {
        $request = $this->db->prepare('
            SELECT r.*, a.name AS author_name
            FROM review r
            JOIN author a ON r.author_id = a.id
            WHERE r.tour_operator_id = ?
        ');
        $request->execute([$id]);

        $results = $request->fetchAll();

        $reviews = [];

        foreach ($results as $row) {
            $reviews[] = ReviewMapper::mapToObject($row);
        }

        return $reviews;
    }

    public function createReview($message, $toId, $authorId)
    {
        $request = $this->db->prepare('
            INSERT INTO review (message, tour_operator_id, author_id)
            VALUES (:message, :tour_operator_id, :author_id)
        ');
        $request->execute([
            'message' => $message,
            'tour_operator_id' => $toId,
            'author_id' => $authorId
        ]);
    }

    public function hasUserAlreadyReviewed($authorId, $toId)
    {
        $request = $this->db->prepare('
            SELECT id FROM review
            WHERE author_id = ? AND tour_operator_id = ?
        ');
        
        $request->execute([$authorId, $toId]);
    
        return $request->fetch() !== false;
    }
}

?>