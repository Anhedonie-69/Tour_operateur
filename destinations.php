<?php
session_start();

include "config/db.php";
include "config/autoloader.php";

$db = new DB();

if(isset($_POST['action']))
{
    if ($_POST['action'] === 'clearSession')
    {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }   
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $name = trim($_POST['name']);
    $location = $_POST['destination'];

    if (!empty($name))
    {
        $authorRepo = new AuthorRepository($db->getDataBase());

        // 1. Vérifier si existe
        $author = $authorRepo->getAuthorByName($name);

        // 2. Sinon créer
        if (!$author)
        {
            $author = $authorRepo->createAuthor($name);
        }

        // 3. Stocker en session
        $_SESSION['author'] = [
            'id' => $author->getId(),
            'name' => $author->getName()
        ];

        // 4. Redirection (important)
        header('Location: destinations.php?name=' . urlencode($location));
        exit;
    }
}

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
    <link href="public/assets/styles/header.css" rel="stylesheet">
    <link href="public/assets/styles/destinations.css" rel="stylesheet">
</head>
<body>
    <header>
        <?php if (!isset($_SESSION['author'])): ?>
            <form method="POST" action="">
                <input type="text" name="name" placeholder="Connexion" required>
                <input type="hidden" name="destination" value="<?= htmlspecialchars($name); ?>">
                <button type="submit">Entrer</button>
            </form>
        <?php else: ?>
            <p id="author"><?= $_SESSION['author']['name'] ?></p>
        <?php endif; ?>
            <a href="index.php">Retour à l'accueil</a>
        <?php if (isset($_SESSION['author'])): ?>
            <form method="POST">
                <button name="action" value="clearSession">Logout</button>
            </form>
        <?php endif; ?>
    </header>
    <h1 class="page-title">Voyages pour <?= htmlspecialchars($name); ?></h1>


     
    <?php foreach ($destinations as $destination): ?>
        <?php $to = $operatorsCache[$destination->getOperatorId()]; ?>

        <div class="to-card">
            <h2><?= htmlspecialchars($destination->getLocation()); ?></h2>
            <p>Prix : <?= $destination->getPrice(); ?> €</p>
            <p>Opérateur : <?= htmlspecialchars($to->getName()); ?></p>

            <?php $avg = $to->getAverageScore(); ?>
            <div class="rating">
                <?php if ($avg): ?>
                    <span class="stars"><?= str_repeat('⭐', round($avg)); ?></span>
                    <span class="score">(<?= $avg ?>/5)</span>
                <?php else: ?>
                    <span class="no-score">Pas encore noté</span>
                <?php endif; ?>
            </div>

            <?php if (isset($_SESSION['author'])): ?>
                <?php if (!$scoreRepo->hasUserAlreadyScored($_SESSION['author']['id'], $to->getId())): ?>
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
                <?php else: ?>
                    <p>✅ Tu as déjà noté</p>
                <?php endif; ?>               
            <?php else: ?>
                <p>👉 Connecte-toi pour noter</p>
            <?php endif; ?>

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

                <?php if (isset($_SESSION['author'])): ?>
                    <?php if (!$reviewRepo->hasUserAlreadyReviewed($_SESSION['author']['id'], $to->getId())): ?>
                        <button onclick="toggleForm(<?= $to->getId(); ?>)">
                            Laisser un avis
                        </button>

                        <div id="form-<?= $to->getId(); ?>" class="review-form" style="display:none;">
                            <form method="POST" action="review.php">
                                <input type="hidden" name="to_id" value="<?= $to->getId(); ?>">
                                <input type="hidden" name="destination" value="<?= htmlspecialchars($name); ?>">

                                <textarea name="message" required></textarea>
                                <button type="submit">Envoyer</button>
                            </form>
                        </div>                 
                    <?php else: ?>
                        <p>✅ Tu as déjà laissé un avis</p>
                    <?php endif; ?>


                <?php else: ?>
                    <p>👉 Connecte-toi pour laisser un avis</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</body>
<script>
    function toggleForm(id) {
        const form = document.getElementById('form-' + id);

        if (form.style.display === "none") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
        }
    }
</script>
</html>