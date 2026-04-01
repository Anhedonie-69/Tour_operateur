<?php
session_start();

include "config/db.php";
include "config/autoloader.php";

$db = new DB();

$tourOperatorRepo = new TourOperatorRepository($db->getDataBase());
$certificateRepo = new CertificateRepository($db->getDataBase());
$destinationRepo = new DestinationRepository($db->getDataBase());
$reviewRepo = new ReviewRepository($db->getDataBase());
$scoreRepo = new ScoreRepository($db->getDataBase());

$service = new TourOperatorService(
    $tourOperatorRepo,
    $certificateRepo,
    $reviewRepo,
    $scoreRepo
);

$tourOperatorManager = new TourOperatorManager(
    $db->getDataBase(),
    $tourOperatorRepo,
    $certificateRepo,
    $destinationRepo,
    $reviewRepo,
    $scoreRepo
);

$user = isset($_SESSION['author']) ? $_SESSION['author']['name'] : "";

$name = $_GET['name'] ?? null;

if (!$name) {
    die('Destination introuvable');
}

$destinations = $destinationRepo->getDestinationsByName($name);
$operatorsCache = [];

foreach ($destinations as $destination)
{
    $operatorId = $destination->getOperatorId();

    if (!isset($operatorsCache[$operatorId])) {
        $to = $service->getFullTourOperator($operatorId);     
        $operatorsCache[$operatorId] = $to;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations</title>
    <link href="public/assets/styles/destinations.css" rel="stylesheet">
</head>
<body>
    <header>
        <p id="author"><?= $user ?></p>
        <a href="index.php">Retour à l'accueil</a>
    </header>

    <?php foreach ($destinations as $destination): ?>
        <?php $to = $operatorsCache[$destination->getOperatorId()]; ?>

        <div class="to-card">
            <h2><?= htmlspecialchars($destination->getLocation()); ?></h2>
            <p>Prix : <?= $destination->getPrice(); ?> €</p>
            <p>Opérateur : <?= htmlspecialchars($to->getName()); ?></p>

            <?php $avg = $to->getAverageScore(); ?>
            <p>
                Note :
                <?php if ($avg): ?>
                    <?= str_repeat('⭐', round($avg)); ?>
                    (<?= $avg ?>/5)
                <?php else: ?>
                    Pas encore noté
                <?php endif; ?>
            </p>

            <form method="POST" action="rate.php">
                <input type="hidden" name="to_id" value="<?= $to->getId(); ?>">
                <input type="hidden" name="destination" value="<?= htmlspecialchars($name); ?>">      
                <select name="score">
                    <option value="1">1 ⭐</option>
                    <option value="2">2 ⭐</option>
                    <option value="3">3 ⭐</option>
                    <option value="4">4 ⭐</option>
                    <option value="5">5 ⭐</option>
                </select>

                <button type="submit">Noter</button>
            </form>

            <div class="reviews">
                <h4>Avis :</h4>

                <?php $reviews = $to->getReviews(); ?>

                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review">
                            <strong><?= htmlspecialchars($review->getAuthor()); ?></strong>
                            <p><?= htmlspecialchars($review->getMessage()); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun avis pour le moment.</p>
                <?php endif; ?>
                <button onclick="toggleForm(<?= $to->getId(); ?>)">
                    Laisser un avis
                </button>

                <div id="form-<?= $to->getId(); ?>" class="review-form" style="display:none;">
                    <form method="POST" action="review.php">
                        <input type="hidden" name="to_id" value="<?= $to->getId(); ?>">

                        <textarea name="message" required></textarea>
                        <button type="submit">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>