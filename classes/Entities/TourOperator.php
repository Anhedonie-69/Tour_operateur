<?php

class TourOperator
{
    private $id;
    private $name;
    private $link;
    private $certificate;
    private $reviews;
    private $scores;

    public function __construct($id, $name, $link)
    {
        $this->id = $id;
        $this->name = $name;
        $this->link = $link;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setCertificate($certificate)
    {
        $this->certificate = $certificate;
    }

    public function getCertificate()
    {
        return $this->certificate;
    }

    public function setReviews($reviews)
    {
        $this->reviews = $reviews;
    }

    public function getReviews()
    {
        return $this->reviews;
    }

    public function setScores($scores)
    {
        $this->scores = $scores;
    }

    public function getScores()
    {
        return $this->scores;
    }
    
    public function getAverageScore()
    {
        if (empty($this->scores)) {
            return null;
        }

        $total = 0;
        $count = count($this->getScores());

        foreach ($this->getScores() as $score)
        {
            $total += $score->getValue();
        }

        return round($total /  $count, 1);
    }

    public function isPrenium(){}
}

?>