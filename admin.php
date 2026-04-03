<?php

session_start();

$adminPassword = "admin123"; // simple pour le TP

include "config/db.php";
include "config/autoloader.php";

$db = new DB();
$tourOperatorRepo = new TourOperatorRepository($db->getDataBase());
$allDestinations = DestinationData::getAll();

if (isset($_POST['admin_password'])) {
    if ($_POST['admin_password'] === $adminPassword) {
        $_SESSION['admin'] = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrateur</title>
</head>
<body>
    <?php if (!isset($_SESSION['admin'])):?>
        <form method="POST">
            <input type="password" name="admin_password" placeholder="Mot de passe admin">
            <button type="submit">Connexion</button>
        </form>
    <?php else: ?>
        <h2>Ajouter un Tour Operator</h2>

        <form method="POST" action="create_to.php">
            <input type="text" name="name" placeholder="Nom" required>
            <input type="text" name="link" placeholder="Lien">

            <button type="submit">Ajouter</button>
        </form>

        <h2>Associer une destination</h2>

        <form method="POST" action="create_destination.php">

            <select name="tour_operator_id">
                <?php foreach ($tourOperatorRepo->getAll() as $to): ?>
                    <option value="<?= $to->getId(); ?>">
                        <?= htmlspecialchars($to->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
                
            <select name="location">
                <?php foreach ($allDestinations as $Destination): ?>
                    <option value="<?= $Destination['name'] ?>">
                        <?= htmlspecialchars($Destination['name']) ?></option>
                <?php endforeach; ?>
            </select>
                
            <input type="number" name="price" placeholder="Prix" required>
                
            <button type="submit">Ajouter</button>
        </form>
    <?php endif; ?>
</body>
</html>