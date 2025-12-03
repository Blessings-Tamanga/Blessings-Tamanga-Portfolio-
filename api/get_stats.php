<?php
session_start();
include_once '../config/database.php';
include_once '../models/Dashboard.php';

// Check if admin is logged in (optional for stats)
if (!isset($_SESSION['admin_logged_in'])) {
    header('HTTP/1.1 403 Forbidden');
    exit();
}

$database = new Database();
$db = $database->getConnection();

$dashboard = new Dashboard($db);
$stats = $dashboard->getStats();

header('Content-Type: application/json');
echo json_encode($stats);
?>