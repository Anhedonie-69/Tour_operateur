<?php

session_start();

if (!isset($_SESSION['admin'])) {
    die("Non autorisé");
}

include "config/db.php";
include "config/autoloader.php";

$db = new DB();
$repo = new TourOperatorRepository($db->getDataBase());

$name = $_POST['name'] ?? null;
$link = $_POST['link'] ?? null;

if ($name) {
    $repo->createTourOperator($name, $link);
}

header('Location: admin.php');
exit;

?>