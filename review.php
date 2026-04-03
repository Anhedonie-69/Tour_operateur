<?php
session_start();

include "config/db.php";
include "config/autoloader.php";

$db = new DB();
$reviewRepo = new ReviewRepository($db->getDataBase());
$destination = $_POST['destination'] ?? 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

    $value = trim($_POST['message'] ?? '');
    $toId = $_POST['to_id'] ?? null;
    $authorId = $_SESSION['author']['id'];

    if ($value && $toId)
    {
        if (!$reviewRepo->hasUserAlreadyReviewed($authorId, $toId))
        {
            $reviewRepo->createReview($value, $toId, $authorId);
        }
    }
}

header('Location: destinations.php?name=' . urlencode($destination));
exit;

?>