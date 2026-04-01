<?php

function testDisplayOperator($id, $service)
{
    $TO = $service->getFullTourOperator($id);

    echo "Opérateur : " . $TO->getName();
    echo "<br><br>";
    echo "Lien : " . $TO->getLink();
    echo "<br><br>";
    echo "Certificat expire le : " . $TO->getCertificate()->getExpiresAt() . "<br>";
    echo "Signataire : " . $TO->getCertificate()->getSignatory();
    echo "<br><br>";
    echo "Destinations :" . "<br>";
    $destinations = $TO->getDestinations();
    foreach($destinations as $destination)
    {
        echo $destination->getLocation() . ". Prix : " . $destination->getPrice() . "€.<br>";
    }
    echo "<br><br>";
    $reviews = $TO->getReviews();
    echo "Commentaires :<br>";
    foreach($reviews as $review)
    {
        echo $review->getauthor() . " : " . $review->getMessage() . "<br>";
    }
    echo "<br><br>";
    $scores = $TO->getScores();
    echo "Notes :<br>";
    foreach($scores as $score)
    {
        echo $score->getAuthor() . " : " . $score->getValue() . ".<br>";
    }
}

?>