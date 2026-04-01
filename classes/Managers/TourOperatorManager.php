<?php

class TourOperatorManager
{
    private $db;
    private $tourOperatorRepo;
    private $certificateRepo;
    private $destinationRepo;
    private $reviewRepo;
    private $scoreRepo;

    public function __construct($db, $toRepo, $certificateRepo, $destinationRepo, $reviewRepo, $scoreRepo)
    {
        $this->db = $db;
        $this->tourOperatorRepo = $toRepo;
        $this->certificateRepo = $certificateRepo;
        $this->destinationRepo = $destinationRepo;
        $this->reviewRepo = $reviewRepo;
        $this->scoreRepo = $scoreRepo;
    }

    /* PUBLIC */

    public function getAllDestination()
    {
        return DestinationData::getAll();
    }

    public function getOperatorById($id)
    {
        return $this->tourOperatorRepo->getTourOperatorById($id);
    }

    public function createReview($message, $toId, $authorId)
    {
        
    }

    public function getReviewByOperatorId(){}

    /* PRIVATE */

    private function getAllOperator(){}

    private function updateOperatorToPrenium(){}

    private function createTourOperator(){}

    private function createDestination(){}
}

?>