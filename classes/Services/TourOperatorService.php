<?php

class TourOperatorService
{
    private $toRepository;
    private $certificateRepository;
    private $reviewRepository;
    private $scoreRepository;

    public function __construct(
        $toRepo,
        $certificateRepo,
        $reviewRepo,
        $scoreRepository
    )
    {
        $this->toRepository = $toRepo;
        $this->certificateRepository = $certificateRepo;
        $this->reviewRepository = $reviewRepo;
        $this->scoreRepository = $scoreRepository;
    }

    public function getFullTourOperator($id)
    {
        $TO = $this->toRepository->getTourOperatorById($id);

        $certificate = $this->certificateRepository->getCertificateByTourOperatorId($id);
        $reviews = $this->reviewRepository->getReviewsByTourOperatorId($id);
        $scores = $this->scoreRepository->getScoresByTourOperatorId($id);

        $TO->setCertificate($certificate);
        $TO->setReviews($reviews);
        $TO->setScores($scores);

        return $TO;
    }
}

?>