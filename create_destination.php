<?php

session_start();

if (!isset($_SESSION['admin'])) {
    die("Non autorisé");
}

include "config/db.php";
include "config/autoloader.php";

$db = new DB();
$repo = new DestinationRepository($db->getDataBase());

$toId = $_POST['tour_operator_id'];
$location = $_POST['location'];
$price = $_POST['price'];

if ($toId && $location && $price) {
    $repo->createDestination($location, $price, $toId);
}

header('Location: admin.php');
exit;

?>