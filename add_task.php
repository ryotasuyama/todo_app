<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $due_date = $_POST['due_date'] ?? null;
    $tag = $_POST['tag'];

    if ($due_date) {
        $stmt = $pdo->prepare('INSERT INTO tasks (title, due_date, tag) VALUES (?, ?, ?)');
        $stmt->execute([$title, $due_date, $tag]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO tasks (title) VALUES (?)');
        $stmt->execute([$title]);
    }
}
header('Location: index.php');
exit;