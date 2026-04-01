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
        header('Location: index.php');
        exit;
    }
}

$tourOperatorRepo = new TourOperatorRepository($db->getDataBase());
$certificateRepo = new CertificateRepository($db->getDataBase());
$destinationRepo = new DestinationRepository($db->getDataBase());
$reviewRepo = new ReviewRepository($db->getDataBase());
$scoreRepo = new ScoreRepository($db->getDataBase());

$tourOperatorManager = new TourOperatorManager(
    $db->getDataBase(),
    $tourOperatorRepo,
    $certificateRepo,
    $destinationRepo,
    $reviewRepo,
    $scoreRepo
);

$user = isset($_SESSION['author']) ? $_SESSION['author']['name'] : "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link href="public/assets/styles/home.css" rel="stylesheet">
</head>
<body>
    <header>
        <p id="author"><?= $user ?></p>
    </header>
    
    <?php if (!isset($_SESSION['author'])): ?>

        <h2>Entre ton nom pour continuer</h2>

        <form method="POST" action="">
            <input type="text" name="name" placeholder="Ton nom" required>
            <button type="submit">Entrer</button>
        </form>

    <?php else: ?>

    <h1>Destinations</h1>

    <ul class="destinations">
    <?php foreach ($tourOperatorManager->getAllDestination() as $destination): ?>
        <li>
            <a class="card" href="destinations.php?name=<?= urlencode($destination['name']); ?>">
                <img src="<?= $destination['image']; ?>" alt="<?= $destination['name']; ?>">
                <span><?= htmlspecialchars($destination['name']); ?></span>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>

    <?php endif; ?>

    <form method="POST" action="">
        <button name="action" value="clearSession">Clear session</button>
    </form>

</body>
</html>