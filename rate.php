<?php
session_start();

include "config/db.php";
include "config/autoloader.php";

$db = new DB();
$scoreRepo = new ScoreRepository($db->getDataBase());
$destination = $_POST['destination'] ?? 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

    $value = $_POST['score'] ?? null;
    $toId = $_POST['to_id'] ?? null;
    $authorId = $_SESSION['author']['id'];

    if ($value && $toId)
    {
        if (!$scoreRepo->hasUserAlreadyScored($authorId, $toId))
        {
            $scoreRepo->createScore($value, $toId, $authorId);
        }
    }
}

header('Location: destinations.php?name=' . urlencode($destination));
exit;

?>