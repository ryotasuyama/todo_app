<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_name = $_POST['company_name'];
    $job_title = $_POST['job_title'];
    $status = $_POST['status'];
    $apply_date = $_POST['apply_date'] !== '未定' ? $_POST['apply_date'] : NULL;
    $interview_date = $_POST['interview_date'] !== '未定' ? $_POST['interview_date'] : NULL;
    $notes = $_POST['notes'];

    $stmt = $pdo->prepare('INSERT INTO applications (company_name, job_title, status, apply_date, interview_date, notes) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$company_name, $job_title, $status, $apply_date, $interview_date, $notes]);

    header('Location: application.php');
    exit;
}
